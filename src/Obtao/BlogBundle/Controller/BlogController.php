<?php

namespace Obtao\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BlogController extends Controller
{
    public function indexAction()
    {
        return $this->render('ObtaoBlogBundle::index.html.twig');
    }
}
