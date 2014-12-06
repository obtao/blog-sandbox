<?php

namespace Obtao\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CategoryController extends Controller
{
    public function listActivesAction(Request $request)
    {
        $categories = $this->getSearchRepository()->searchActiveCategories();

        return $this->render('ObtaoBlogBundle:Category:list.html.twig', array(
            'categories' => $categories
        ));
    }

    protected function getSearchRepository()
    {
        return $this->container
            ->get('fos_elastica.manager')
            ->getRepository('ObtaoBlogBundle:Category')
        ;
    }
}
