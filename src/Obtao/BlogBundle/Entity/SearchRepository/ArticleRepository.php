<?php

namespace Obtao\BlogBundle\Entity\SearchRepository;

use Obtao\BlogBundle\Model\ArticleSearch;

class ArticleRepository
{
    public function search(ArticleSearch $articleSearch)
    {
        $baseQuery = new \Elastica\Query\Bool();
        // we create a query to return all the articles
        // but if the criteria title is specified, we use it
        if ($articleSearch->getTitle() != null && $articleSearch != '') {
            $query = new \Elastica\Query\Match();
            $query->setFieldQuery('article.title', $articleSearch->getTitle());
            $query->setFieldFuzziness('article.title', 0.7);
            $query->setFieldMinimumShouldMatch('article.title', '80%');
            $baseQuery->addMust($query);
            //
        } else {
            $baseQuery->addMust(new \Elastica\Query\QueryString("article.id:*"));
        }

        // then we create filters depending on the chosen criterias
        $boolFilter = new \Elastica\Filter\Bool();

        // Dates filter
        if(null !== $articleSearch->getDateFrom() && null !== $articleSearch->getDateTo()){
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
                new \Elastica\Filter\Terms('isPublished', $articleSearch->getIsPublished())
            );
        }

        $filtered = new \Elastica\Query\Filtered($baseQuery, $boolFilter);

        $query = \Elastica\Query::create($filtered);

        return $query;
    }

}