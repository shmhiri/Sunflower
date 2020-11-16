<?php

namespace ProduitBundle\Controller;

use ProduitBundle\Entity\Produit;
use ProduitBundle\Entity\Sujet;
use ProduitBundle\Entity\User;
use ProduitBundle\Entity\CategorieProduit;
use ProduitBundle\Repository\ProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Produit controller.
 *
 */
class ProduitController extends Controller
{
    /**
     * Lists all produit entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $idddd=$user->getId();

        $produits = $em->getRepository('ProduitBundle:Produit')->listProduitofthisuser($idddd);

        return $this->render('@Produit/produit/index.html.twig', array(
            'produits' => $produits,
        ));
    }



    public function indexfrontAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $produits = $em->getRepository('ProduitBundle:Produit')->findAll();
        $cts = $em->getRepository('ProduitBundle:CategorieProduit')->findAll();
        $sortedprods=$produits;


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


        /**
         * @var $paginator \Knp\Component\Pager\Paginator
         */
        $paginator=$this->get('knp_paginator');
        $result=$paginator->paginate(
            $sortedprods,
            $request->query->getInt('page',1),12
        );
        if (isset($_GET['sorting']))
        {
                if (($request->get("sorting")=="pasc"))
            {$sortedprods=$em->getRepository(Produit::class)->sortbyprixasc();}
            elseif (($request->get("sorting")=="pdsc"))
            {$sortedprods=$em->getRepository(Produit::class)->sortbyprixdsc();}
            elseif (($request->get("sorting")=="nasc"))
            {$sortedprods=$em->getRepository(Produit::class)->sortbynameasc();}
            elseif (($request->get("sorting")=="ndsc"))
            {$sortedprods=$em->getRepository(Produit::class)->sortbynamedsc();}

                /**
                 * @var $paginator \Knp\Component\Pager\Paginator
                 */
                $paginator=$this->get('knp_paginator');
                $result=$paginator->paginate(
                    $sortedprods,
                    $request->query->getInt('page',1),12
                );
                return $this->render("@Produit/produitfront/indexfront.html.twig",array
                ("produits"=>$result,'prod'=>$cts,'sorting'=>$_GET['sorting'],'count' => $count,'countf'=>$countf));

        }

        return $this->render('@Produit/produitfront/indexfront.html.twig', array(
            'produits' => $result,
            'prod'=>$cts,
            'sorting'=>'',
            'count' => $count,
            'countf'=>$countf,
        ));

    }
    public function indexfronteAction(Request $request,$idCategorie)
    {
        $em = $this->getDoctrine()->getManager();
        $cts = $em->getRepository('ProduitBundle:CategorieProduit')->findAll();
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

        $produitsfiltred = $em->getRepository('ProduitBundle:Produit')->listProduitByCategorie($idCategorie);
        /**
         * @var $paginator \Knp\Component\Pager\Paginator
         */
        $paginator=$this->get('knp_paginator');
        $result=$paginator->paginate(
            $produitsfiltred,
            $request->query->getInt('page',1),
            $request->query->getInt('limit',9)
        );

         return $this->render('@Produit/produitfront/indexfront.html.twig', array(
            'produits' => $result,
            'prod'=>$cts,
            'sorting'=>'',
            'count' => $count,
            'countf'=>$countf
        ));
    }

    /**
     * Creates a new produit entity.
     *
     */
    public function newAction(Request $request)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();

        $produit = new Produit();
        $form = $this->createForm('ProduitBundle\Form\ProduitType', $produit);
        $form->handleRequest($request);

        $em = $this->getDoctrine()->getManager();

        if ($request->getMethod() == "POST") {
            $idddd=$user->getId();
            $file= $produit->getImage();
            $file->move($this->getParameter('image_directory'));
            $ct = $em->getRepository('ProduitBundle:CategorieProduit')->getnom_type_categ($request->get('idCategorie'));

            $produit->setIdCategorie($request->get('idCategorie'));
            $produit->setNomCategorie($ct['nomCategorie']);
            $produit->setType($ct['type']);
            $produit->setIdAgent($idddd);
            $produit->setNomAgent($user->getUsername());
            $produit->setNomProduit($request->get('nomProduit'));
            $produit->setPrix($request->get('prix'));
            $produit->setDescription($request->get('descr'));
            $produit->setQuantite($request->get('quantite'));
            $produit->setImage($file->getClientOriginalName());
            $em->persist($produit);
            $em->flush();

            return $this->redirectToRoute('produit_show', array('idProduit' => $produit->getIdproduit()));
        }

        return $this->render('@Produit/produit/new.html.twig', array(
            'produit' => $produit,
            'form' => $form->createView(),
        ));
    }
    /**
     * Displays a form to edit an existing produit entity.
     *
     */


    public function editAction(Request $request, Produit $produit)
    {   $user = $this->get('security.token_storage')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();
        $deleteForm = $this->createDeleteForm($produit);
        $editForm = $this->createForm('ProduitBundle\Form\ProduitType', $produit);
        $editForm->handleRequest($request);
        $thisprod=$produit;

        if ($request->getMethod() == "POST") {
            $idddd=$user->getId();
            $file= $produit->getImage();
            $file->move($this->getParameter('image_directory'));
            $ct = $em->getRepository('ProduitBundle:CategorieProduit')->getnom_type_categ($request->get('idCategorie'));

            $produit->setIdCategorie($request->get('idCategorie'));
            $produit->setNomCategorie($ct['nomCategorie']);
            $produit->setType($ct['type']);
            $produit->setIdAgent($idddd);
            $produit->setNomAgent($user->getUsername());
            $produit->setNomProduit($request->get('nomProduit'));
            $produit->setPrix($request->get('prix'));
            $produit->setDescription($request->get('description'));
            $produit->setQuantite($request->get('quantite'));
            $produit->setImage($file->getClientOriginalName());

            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('produit_show', array('idProduit' => $produit->getIdproduit()));
        }

        return $this->render('@Produit/produit/edit.html.twig', array(
            'thisproduit' => $thisprod,
            'produit' => $produit,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Finds and displays a produit entity.
     *
     */
    public function showAction(Produit $produit)
    {
        $deleteForm = $this->createDeleteForm($produit);


        return $this->render('@Produit/produit/show.html.twig', array(
            'produit' => $produit,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    public function showfrontAction(Produit $produit)
    {
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

        $deleteForm = $this->createDeleteForm($produit);

        return $this->render('@Produit/produitfront/showfront.html.twig', array(
            'produit' => $produit,'count'=>$count,'countf'=>$countf,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a produit entity.
     *
     */
    public function deleteAction(Produit $produit)
    {

            $em = $this->getDoctrine()->getManager();
            $em->remove($produit);
            $em->flush();

        return $this->redirectToRoute('produit_index');
    }

    /**
     * Creates a form to delete a produit entity.
     *
     * @param Produit $produit The produit entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Produit $produit)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('produit_delete', array('idProduit' => $produit->getIdproduit())))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }
}
