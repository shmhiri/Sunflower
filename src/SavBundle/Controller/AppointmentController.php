<?php

namespace SavBundle\Controller;

use SavBundle\Entity\Appointment;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\Date;
class AppointmentController extends Controller
{
    public function indexAction()
    {   /**##############"Firas gazzah###################*/
        $em = $this->getDoctrine()->getManager();
        $user = $this->get('security.token_storage')->getToken()->getUser();
        if ($user=="anon.")
        {
            $count=$em->getRepository('CommandeBundle:LigneCmd')->contano();
            $countf=$em->getRepository('ProduitBundle:Favoris')->count(0);

        }else {
            $idU=$user->getId();
            $count=$em->getRepository('CommandeBundle:LigneCmd')->cont($idU);
            $countf=$em->getRepository('ProduitBundle:Favoris')->count($idU);

        }
        /*##########################################################################################*/
        return $this->render('@Sav/Reclamation_front/Appointment_front.html.twig',array('count'=>$count,'countf'=>$countf));
    }

    public function ajoutappAction(Request $request)
    {
        /**##############"Firas gazzah###################*/
        $em = $this->getDoctrine()->getManager();
        $user = $this->get('security.token_storage')->getToken()->getUser();
        if ($user=="anon.")
        {
            $count=$em->getRepository('CommandeBundle:LigneCmd')->contano();
            $countf=$em->getRepository('ProduitBundle:Favoris')->count(0);

        }else {
            $idU=$user->getId();
            $count=$em->getRepository('CommandeBundle:LigneCmd')->cont($idU);
            $countf=$em->getRepository('ProduitBundle:Favoris')->count($idU);

        }
        /*##########################################################################################*/
        $model = new Appointment();
        if ($request->isMethod('POST')) {



            $model->setAppointmentuserid($request->get('app_userid'));
            $model->setAppointmentusername($request->get('app_username'));
            $model->setAppointmenttime($request->get('app_time'));
            $model->setAppointmentdate(new \DateTime($request->get('app_date')));
            $model->setAppointmentetat($request->get('app_etat'));
            $model->setAppointmentmotif($request->get('app_pat'));
            $model->setAppointmentemail($request->get('app_email'));


            $em = $this->getDoctrine()->getManager();
            $em->persist($model);
            $em->flush();


        }
        return $this->render('@Sav/Reclamation_front/Appointment_front.html.twig',array('model'=>$model,'count'=>$count,'countf'=>$countf));
    }


    public function listAction()
    {
        $em=$this->getDoctrine();
        $Appointment=$em->getRepository(@"SavBundle:Appointment")->findAll();
        /**##############"Firas gazzah###################*/
        $em = $this->getDoctrine()->getManager();
        $user = $this->get('security.token_storage')->getToken()->getUser();
        if ($user=="anon.")
        {
            $count=$em->getRepository('CommandeBundle:LigneCmd')->contano();
            $countf=$em->getRepository('ProduitBundle:Favoris')->count(0);

        }else {
            $idU=$user->getId();
            $count=$em->getRepository('CommandeBundle:LigneCmd')->cont($idU);
            $countf=$em->getRepository('ProduitBundle:Favoris')->count($idU);

        }
        /*##########################################################################################*/

        return $this->render('@Sav/Reclamation_front/Appointment_list.html.twig',array('Appointment'=>$Appointment,'count'=>$count,'countf'=>$countf));
    }


    public function suppappAction(Request $request, $id)
    {
        $Appointment= new Appointment();
        $em=$this->getDoctrine()->getManager();
        $Appointment=$em->getRepository(@"SavBundle:Appointment")->find($id);
        $em->remove($Appointment);
        $em->flush();
        return $this->redirectToRoute('front_reclamation_front_applist');
    }

}