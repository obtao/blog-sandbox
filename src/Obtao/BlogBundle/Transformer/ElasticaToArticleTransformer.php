<?php

namespace Obtao\BlogBundle\Transformer;

use FOS\ElasticaBundle\Doctrine\AbstractElasticaToModelTransformer;
use Doctrine\ORM\Query;

class ElasticaToArticleTransformer extends AbstractElasticaToModelTransformer
{
    /**
     * Fetch Article from Doctrine for the given Elasticsearch identifiers
     *
     * @param array $identifierValues ids values
     * @param Boolean $hydrate whether or not to hydrate the objects, false returns arrays
     * @return array of objects or arrays
     */
    protected function findByIdentifiers(array $identifierValues, $hydrate)
    {
        if (empty($identifierValues)) {
            return array();
        }

        $hydrationMode = $hydrate ? Query::HYDRATE_OBJECT : Query::HYDRATE_ARRAY;
        $qb = $this->registry
            ->getManagerForClass('ObtaoBlogBundle:Article')
            ->getRepository('ObtaoBlogBundle:Article')
            ->createQueryBuilder('a');

        $qb
            ->select('a,aut,c')
            ->join('a.authors', 'aut')
            ->join('a.category', 'c')
            ->where($qb->expr()->in('a.'.$this->options['identifier'], ':values'))
            ->setParameter('values', $identifierValues)
        ;

        return $qb->getQuery()->setHydrationMode($hydrationMode)->execute();
    }
}
