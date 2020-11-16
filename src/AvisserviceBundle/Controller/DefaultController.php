<?php

namespace AvisserviceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('AvisserviceBundle:Default:index.html.twig');
    }
}
