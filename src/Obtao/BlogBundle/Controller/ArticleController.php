<?php

namespace Obtao\BlogBundle\Controller;

use Obtao\BlogBundle\Form\Type\ArticleSearchType;
use Obtao\BlogBundle\Model\ArticleSearch;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ArticleController extends Controller
{

    public function listAction(Request $request)
    {
        $articleSearch = new ArticleSearch();

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
        
        $elasticaManager = $this->container->get('fos_elastica.manager');
        $results = $elasticaManager->getRepository('ObtaoBlogBundle:Article')->search($articleSearch);

        return $this->render('ObtaoBlogBundle:Article:list.html.twig',array(
            'results' => $results,
            'articleSearchForm' => $articleSearchForm->createView(),
        ));
    }
}