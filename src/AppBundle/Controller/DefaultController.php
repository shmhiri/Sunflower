<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {
        $securityContext = $this->get('security.authorization_checker');

        if ($this->getUser() != null && $securityContext->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('commande_stat');
        }


         return $this->redirectToRoute('produit_indexfront');
    }


}
