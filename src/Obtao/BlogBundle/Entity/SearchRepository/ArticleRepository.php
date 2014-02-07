<?php

namespace Obtao\BlogBundle\Entity\SearchRepository;

use FOS\ElasticaBundle\Repository;
use Obtao\BlogBundle\Model\ArticleSearch;

class ArticleRepository extends Repository
{
    public function search(ArticleSearch $articleSearch)
    {
        // we create a query to return all the articles
        // but if the criteria title is specified, we use it
        if ($articleSearch->getTitle() != null && $articleSearch != '') {
            $query = new \Elastica\Query\Match();
            $query->setFieldQuery('article.title', $articleSearch->getTitle());
            $query->setFieldFuzziness('article.title', 0.7);
            $query->setFieldMinimumShouldMatch('article.title', '80%');
            //
        } else {
            $query = new \Elastica\Query\MatchAll();
        }
         $baseQuery = $query;

        // then we create filters depending on the chosen criterias
        $boolFilter = new \Elastica\Filter\Bool();

        /*
            Dates filter
            We add this filter only the getIspublished filter is not at "false"
        */
        if("false" != $articleSearch->getIsPublished()
           && null !== $articleSearch->getDateFrom()
           && null !== $articleSearch->getDateTo())
        {
            $boolFilter->addMust(new \Elastica\Filter\Range('publishedAt',
                array(
                    'gte' => \Elastica\Util::convertDate($articleSearch->getDateFrom()->getTimestamp()),
                    'lte' => \Elastica\Util::convertDate($articleSearch->getDateTo()->getTimestamp())
                )
            ));
        }

        // Published or not filter
        if($articleSearch->getIsPublished() !== null){
            $boolFilter->addMust(
                new \Elastica\Filter\Terms('published', array($articleSearch->getIsPublished()))
            );
        }

        $filtered = new \Elastica\Query\Filtered($baseQuery, $boolFilter);

        $query = \Elastica\Query::create($filtered);

        return $this->find($query);
    }

}