<?php

namespace Obtao\BlogBundle\Controller;

use Obtao\BlogBundle\Model\ArticleSearch;
use Pagerfanta\Adapter\ArrayAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ArticleController extends Controller
{
    public function exportAction(Request $request)
    {
        // get the Article index to send the query on the Article type
        $articleIndex = $this->get('fos_elastica.index.obtao_blog.article');

        // build the query in the searchRepository, here we pass an empty ArticleSearch object
        // since we do not need particular filter
        $articleQuery = $this->getSearchRepository()->getQueryForSearch(new ArticleSearch());

        // init and configure the scan function
        $exportScan = $articleIndex->search($articleQuery, array(
            \Elastica\Search::OPTION_SEARCH_TYPE => \Elastica\Search::OPTION_SEARCH_TYPE_SCAN,
            \Elastica\Search::OPTION_SCROLL => '30s',
            \Elastica\Search::OPTION_SIZE => '50',
        ));

        $em = $this->get('doctrine.orm.entity_manager');
        $elasticaIndex = $this->get('fos_elastica.index');
        $articleTransformer = $this->get('obtao.transformers.elastica.article');

        $response = new StreamedResponse(function () use ($exportScan, $em, $elasticaIndex, $articleTransformer) {
            $total = $exportScan->getTotalHits();
            $countArticles = 0;

            // get the first scroll id
            $scrollId = $exportScan->getResponse()->getScrollId();

            $handle = fopen('php://output', 'r+');

            while ($countArticles <= $total) {
                // get the set of results for the given scroll id
                $response = $elasticaIndex->search(null, array(
                    \Elastica\Search::OPTION_SCROLL_ID => $scrollId,
                    \Elastica\Search::OPTION_SCROLL => '30s'
                ));
                // and get the scroll id for the next set of results
                $scrollId = $response->getResponse()->getScrollId();

                $articles = $response->getResults();
                // if there are no more articles to get
                if (count($articles) == 0) {
                    break;
                }

                // transform the results in Doctrine objects (optional)
                $articles = $articleTransformer->transform($articles);

                // insert the objects in the csv file
                foreach ($articles as $article) {
                    $a = array(
                        'id' => $article->getId(),
                        'title' => $article->getTitle(),
                        'content' => substr($article->getContent(), 0, 50).'...',
                        'publishedAt' => $article->getPublishedAt()->format('Y-m-d'),
                    );
                    fputcsv($handle, $a);
                    $countArticles++;
                }
                // clear the entity manager to keep the memory consumption under control
                $em->clear();
            }

            fclose($handle);
        });

        $response->headers->set('Content-Type', 'application/force-download');
        $response->headers->set('Content-Disposition', 'attachment; filename="export.csv"');

        return $response;
    }

    public function listAction(Request $request, $page)
    {
        $articleSearch = new ArticleSearch();
        $articleSearch->handleRequest($request);

        // we create an "anonym" form to pass parameters in GET and have a nice url
        $articleSearchForm = $this->get('form.factory')
            ->createNamed(
                '',
                'article_search_type',
                $articleSearch,
                array(
                    'action' => $this->generateUrl('obtao-article-search'),
                    'method' => 'GET'
                )
            );
        $articleSearchForm->handleRequest($request);
        $articleSearch = $articleSearchForm->getData();

        // we pass our search object to the search repository
        $results = $this->getSearchRepository()->searchArticles($articleSearch);

        $adapter = new ArrayAdapter($results);
        $pager = new Pagerfanta($adapter);
        $pager->setMaxPerPage($articleSearch->getPerPage());
        $pager->setCurrentPage($page);

        return $this->render('ObtaoBlogBundle:Article:list.html.twig', array(
            'results' => $pager->getCurrentPageResults(),
            'pager' => $pager,
            'articleSearchForm' => $articleSearchForm->createView(),
        ));
    }

    public function statsAction(Request $request)
    {
        $articleSearch = new ArticleSearch();

        // we create an "anonym" form to pass parameters in GET and have a nice url
        $articleSearchForm = $this->get('form.factory')
            ->createNamed(
                '',
                'article_search_type',
                $articleSearch,
                array(
                    'action' => $this->generateUrl('obtao-article-stats'),
                    'method' => 'GET'
                )
            );
        $articleSearchForm->handleRequest($request);
        $articleSearch = $articleSearchForm->getData();

        $query = $this->getSearchRepository()->getStatsQuery($articleSearch);
        $results = $this->get('fos_elastica.index.obtao_blog.article')->search($query);

        return $this->render('ObtaoBlogBundle:Article:stats.html.twig', array(
            'aggs' => $results->getAggregations(),
            'articleSearchForm' => $articleSearchForm->createView()
        ));
    }

    protected function getSearchRepository()
    {
        return $this->container
            ->get('fos_elastica.manager')
            ->getRepository('ObtaoBlogBundle:Article')
        ;
    }
}
