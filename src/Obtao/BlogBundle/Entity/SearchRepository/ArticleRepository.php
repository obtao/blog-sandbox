<?php

namespace Obtao\BlogBundle\Entity\SearchRepository;

use FOS\ElasticaBundle\Repository;
use Obtao\BlogBundle\Model\ArticleSearch;

/**
 * This class contains all the elastica queries
 */
class ArticleRepository extends Repository
{
    public function getQueryForSearch(ArticleSearch $articleSearch)
    {
        // we create a query to return all the articles
        // but if the criteria title is specified, we use it
        if ($articleSearch->getTitle() !== null && $articleSearch != '') {
            $query = new \Elastica\Query\Match();
            $query->setFieldQuery('article.title', $articleSearch->getTitle());
            $query->setFieldFuzziness('article.title', 0.7);
            $query->setFieldMinimumShouldMatch('article.title', '80%');
        } else {
            $query = new \Elastica\Query\MatchAll();
        }

        // then we create filters depending on the chosen criterias
        $boolQuery = new \Elastica\Query\Bool();
        $boolQuery->addMust($query);

        /*
            Dates filter
            We add this filter only the ispublished filter is not at "false"
        */
        if("false" != $articleSearch->isPublished()
           && null !== $articleSearch->getDateFrom()
           && null !== $articleSearch->getDateTo())
        {
            $boolQuery->addMust(new \Elastica\Query\Range('publishedAt',
                array(
                    'gte' => \Elastica\Util::convertDate($articleSearch->getDateFrom()->getTimestamp()),
                    'lte' => \Elastica\Util::convertDate($articleSearch->getDateTo()->getTimestamp())
                )
            ));
        }

        // Published or not filter
        if($articleSearch->isPublished() !== null){
            $boolQuery->addMust(
                new \Elastica\Query\Terms('published', array($articleSearch->isPublished()))
            );
        }

        $query = new \Elastica\Query($boolQuery);
        $query->setSort(array(
            $articleSearch->getSort() => array(
                'order' => $articleSearch->getDirection()
            )
        ));

        return $query;
    }

    public function getStatsQuery(ArticleSearch $articleSearch)
    {
        $query = $this->getQueryForSearch($articleSearch);

        //Simple aggregation (based on tags, we will get doc_count for each tag)
        $tagsAggregation = new \Elastica\Aggregation\Terms('tag');
        $tagsAggregation->setField('tags');

        //More complex aggregation. We will get categories for each month
        $dateAggregation = new \Elastica\Aggregation\DateHistogram('dateHistogram','publishedAt','month');
        $dateAggregation->setFormat("dd-MM-YYYY");
        $categoryAggregation = new \Elastica\Aggregation\Terms('category');
        $categoryAggregation->setField("category");

        $dateAggregation->addAggregation($categoryAggregation);


        $query->addAggregation($tagsAggregation);
        $query->addAggregation($dateAggregation);

        //We don't need results, just stats.
        $query->setSize(0);

        return $query;
    }

    public function searchArticles(ArticleSearch $articleSearch)
    {
        $query = $this->getQueryForSearch($articleSearch);

        return $this->find($query);
    }

}
