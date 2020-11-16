<?php

namespace SavBundle\Controller;
use SavBundle\Entity\ProduitC;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {  /**##############"Firas gazzah###################*/
        $em = $this->getDoctrine()->getManager();
        $user = $this->get('security.token_storage')->getToken()->getUser();
        if ($user=="anon.")
        {
            $count=$em->getRepository('CommandeBundle:LigneCmd')->contano();
        }else {
            $idU=$user->getId();
            $count=$em->getRepository('CommandeBundle:LigneCmd')->cont($idU);
        }
        /*##########################################################################################*/
        return $this->render('@Sav/Default/index.html.twig',array('count'=>$count));
    }

    public function listAction($id)
    {
        /**##############"Firas gazzah###################*/
        $em = $this->getDoctrine()->getManager();
        $user = $this->get('security.token_storage')->getToken()->getUser();
        if ($user=="anon.")
        {
            $count=$em->getRepository('CommandeBundle:LigneCmd')->contano();
        }else {
            $idU=$user->getId();
            $count=$em->getRepository('CommandeBundle:LigneCmd')->cont($idU);
        }
        /*##########################################################################################*/
        $em=$this->getDoctrine();
        $prod=$em->getRepository(@"SavBundle:ProduitC")->find($id);

        return $this->render('@Sav/Default/index.html.twig',array('prod'=>$prod,'count'=>$count));
    }


}
