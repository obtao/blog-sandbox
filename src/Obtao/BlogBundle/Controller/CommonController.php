<?php

namespace Obtao\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CommonController extends Controller
{
    public function indexAction(Request $request)
    {
        return $this->render('ObtaoBlogBundle::index.html.twig');
    }
}
