<?php

namespace PromotionBundle\Controller;

use PromotionBundle\Entity\User;
use PromotionBundle\Entity\Promotion;
use PromotionBundle\Form\PromotionType;
use PromotionBundle\Form\RechercheType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Promotion controller.
 *
 * @Route("promotion")
 */
class PromotionController extends Controller
{

//AFFICHER tout les pro (front)
    public function userAction(Request $request)
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
        $promotions = $this->getDoctrine()->getManager()->getRepository('PromotionBundle:Promotion')->findAll();

        return $this->render('@Promotion/promotion/user.html.twig', array('promotions' => $promotions,'count'=>$count,'countf'=>$countf));

    }


    //AFFICHER un pro
    public function usershowAction($id)
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
        $em = $this->getDoctrine()->getManager();
        $promotion=$this->getDoctrine()->getRepository(Promotion::class)->find($id);

        $img=$em->getRepository('PromotionBundle:Produit')->rechimg($promotion->getIdProduit()->getIdProduit());//rechercher img dans table produit

        return $this->render('@Promotion/promotion/user_show.html.twig', array('img'=>$img,'promotion' => $promotion,'count'=>$count,'countf'=>$countf));
    }
    /**
     * Lists all promotion entities.
     *
     * @Route("/", name="promotion_index")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {

        $promotion=new Promotion();
        $form=$this->createForm(RechercheType::class,$promotion);

        $user = $this->get('security.token_storage')->getToken()->getUser();
        $u=$user->getId();

        $form->handleRequest($request);
        if($form->isSubmitted() ) {


            $promotions=$this->getDoctrine()->getRepository(Promotion::class)->findBy(array('nomPromotion'=>$promotion->getNomPromotion()));

        }else
        {
            $promotions=$this->getDoctrine()->getRepository('PromotionBundle:Promotion')->listsp($u);

        }
        return $this->render("@Promotion/promotion/index.html.twig",array("form"=>$form->createView(),'promotions'=>$promotions));

    }

    /**
     * Creates a new promotion entity.
     *
     * @Route("/new", name="promotion_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $use = $this->get('security.token_storage')->getToken()->getUser();
        $u=$use->getId();

        $user=$this->getDoctrine()->getRepository(\PromotionBundle\Entity\User::class)->find($u);

        $promotion = new Promotion();
        $promotion->setIdAgent($user);

        $nbrC=$em->getRepository('PromotionBundle:Produit')->lists($u);

        $promotion->setIdProduit($nbrC);

        $nbr=$em->getRepository('PromotionBundle:Produit')->listss($promotion->getIdAgent());

        $form = $this->createForm(PromotionType::class, $promotion , array('id'=>$promotion->getIdAgent()) );
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $p=$promotion->getPrixHab();
            $pou=$promotion->getPourcentage();
            $pp=$p-(($p*$pou)/100);
            $promotion->setPrixPromo($pp);

            $em->persist($promotion);
            $em->flush();

            $po=$this->getDoctrine()->getRepository(\PromotionBundle\Entity\Produit::class)->find($promotion->getIdProduit());

            $po->setPrix($pp);

            $em->flush();

            return $this->redirectToRoute('promotion_show', array('idPromotion' => $promotion->getIdpromotion()));
        }

        return $this->render('@Promotion/Promotion/new.html.twig', array(
            'promotion' => $promotion,
            'form' => $form->createView(),'nbrC'=>$nbrC,'nbr'=>$nbr,
        ));
    }

    /**
     * Finds and displays a promotion entity.
     *
     * @Route("/{idPromotion}", name="promotion_show")
     * @Method("GET")
     */
    public function showAction(Promotion $promotion)
    {
        $deleteForm = $this->createDeleteForm($promotion);

        return $this->render('@Promotion/Promotion/show.html.twig', array(
            'promotion' => $promotion,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing promotion entity.
     *
     * @Route("/{idPromotion}/edit", name="promotion_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Promotion $promotion)
    {
        $em = $this->getDoctrine()->getManager();
        $deleteForm = $this->createDeleteForm($promotion);
        $editForm = $this->createForm('PromotionBundle\Form\PromotionType', $promotion);
        $editForm->handleRequest($request);

        $use = $this->get('security.token_storage')->getToken()->getUser();
        $u=$use->getId();

        $user=$this->getDoctrine()->getRepository(\PromotionBundle\Entity\User::class)->find($u);

        $promotion->setIdAgent($user);

        $nbrC=$em->getRepository('PromotionBundle:Produit')->lists($promotion->getIdAgent());

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $p=$promotion->getPrixHab();
            $pou=$promotion->getPourcentage();
            $pp=$p-(($p*$pou)/100);
            $promotion->setPrixPromo($pp);

            $em->persist($promotion);
            $em->flush();

            return $this->redirectToRoute('promotion_edit', array('idPromotion' => $promotion->getIdpromotion()));
        }

        return $this->render('@Promotion/Promotion/edit.html.twig', array(
            'promotion' => $promotion,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'nbrC'=>$nbrC,
        ));
    }

    /**
     * Deletes a promotion entity.
     *
     * @Route("/{idPromotion}", name="promotion_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Promotion $promotion)
    {
        $form = $this->createDeleteForm($promotion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $po=$this->getDoctrine()->getRepository(\PromotionBundle\Entity\Produit::class)->find($promotion->getIdProduit());

            $em = $this->getDoctrine()->getManager();
            $po->setPrix($promotion->getPrixHab());
            $em->persist($po);
            $em->remove($promotion);

            $em->flush();
        }

        return $this->redirectToRoute('promotion_index');
    }

    /**
     * Creates a form to delete a promotion entity.
     *
     * @param Promotion $promotion The promotion entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Promotion $promotion)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('promotion_delete', array('idPromotion' => $promotion->getIdpromotion())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
