<?php

namespace SavBundle\Controller;
use SavBundle\Entity\Claims;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ReclamationController extends Controller
{
    public function indexAction()
    {/**##############"Firas gazzah###################*/
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

    public function Reclamation_frontAction()
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
        return $this->render('@Sav/Reclamation_front/Reclamation_front.html.twig',array('count'=>$count));
    }


    public function ReclamationajoutAction(Request $request)
    {    /**##############"Firas gazzah###################*/
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
        $model=new Claims();
        if ($request->isMethod('POST'))
        {
            $model->setClaimUsername($request->get('claim_username'));
            $model->setClaimLastname($request->get('claim_lastname'));
            $model->setClaimEmail($request->get('claim_email'));
            $model->setClaimProductref($request->get('claim_productref'));
            $model->setClaimCodepostal($request->get('claim_codepostal'));
            $model->setClaimCountry($request->get('claim_country'));
            $model->setPhone($request->get('phone'));
            $model->setClaimCountry($request->get('claim_country'));
            $model->setClaimIduser($request->get('claim_iduser'));
            $model->setClaimProductid($request->get('ClaimProductid'));
            $model->setClaimDesc($request->get('claim_desc'));
            $model->setClaimEtat($request->get('claim_etat'));
            $model->setClaimDate(new \DateTime('now'));



            $em=$this->getDoctrine()->getManager();
            $em->persist($model);
            $em->flush();

        }
        return $this->render('@Sav/Reclamation_front/Reclamation_front.html.twig',array('model'=>$model,'count'=>$count));
    }



    public function listAction()
    {/**##############"Firas gazzah###################*/
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
        $claim=$em->getRepository(@"SavBundle:Claims")->findAll();

        return $this->render('@Sav/Reclamation_front/Reclamation_list.html.twig',array('claim'=>$claim,'count'=>$count));
    }

    public function suppclaimAction(Request $request, $id)
    {
        $model= new Claims();
        $em=$this->getDoctrine()->getManager();
        $model=$em->getRepository(@"SavBundle:Claims")->find($id);
        $em->remove($model);
        $em->flush();
        return $this->redirectToRoute('front_reclamation_list');
    }



}
