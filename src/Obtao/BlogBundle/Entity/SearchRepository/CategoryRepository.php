<?php

namespace Obtao\BlogBundle\Entity\SearchRepository;

use FOS\ElasticaBundle\Repository;

class CategoryRepository extends Repository
{
    public function searchActiveCategories()
    {
        $query = new \Elastica\Query(new \Elastica\Query\MatchAll());

        $publishedQuery = new \Elastica\Query(new \Elastica\Query\Term(array('published'=>true)));

        $hasChildQuery = new \Elastica\Query\HasChild($publishedQuery);
        $hasChildQuery->setType('article');

        $query->setQuery($hasChildQuery);
        return $this->find($query);
    }
}
