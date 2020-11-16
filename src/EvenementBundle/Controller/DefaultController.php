<?php

namespace EvenementBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {

        $em = $this->getDoctrine()->getManager();
        $nbrC=$em->getRepository('EvenementBundle:Evenement')->countlists();


        return $this->render('@Evenement/Default/index.html.twig', array('id' => $nbrC));
    }
}
