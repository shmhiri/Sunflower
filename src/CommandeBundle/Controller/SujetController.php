<?php

namespace ForumBundle\Controller;

use ForumBundle\Entity\Sujet;
use ForumBundle\Entity\Commentaire;
use ForumBundle\Entity\CategorieSujet;
use ForumBundle\Form\SujetType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityRepository;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\PieChart;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\Histogram;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;



/**
 * Sujet controller.
 *
 */
class SujetController extends Controller
{
    /**
     * Lists all sujet entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $sujets = $em->getRepository('ForumBundle:Sujet')->findAll();
        return $this->render('@Forum/Sujet/index.html.twig', array(
            'sujets' => $sujets,
        ));
    }

    /**
     * Lists all sujet entities. fil front
     *
     */
    public function indexforumlistfilterAction( CategorieSujet $idcategorieSujet )
    {
        $em = $this->getDoctrine()->getManager();
        $categoriesujet = new CategorieSujet();
        $sujets = $em->getRepository('ForumBundle:CategorieSujet')->listSujetByCategorie($idcategorieSujet);
        $categoriesujet = $em->getRepository('ForumBundle:CategorieSujet')->findAll();
        $idcategorieSujet->getIdCategorieSujet();

        return $this->render('@Forum/Sujet/forumlistfilter.html.twig', array(
            'sujet' => $sujets,
            'categoriesujets' => $idcategorieSujet,
        ));
    }
    /**
     * Lists all sujet entities. fil front
     *
     */
    /**
     * @Security("has_role('ROLE_USER')")
     */
    public function indexforumdetailAction($idSujet,Request $request )
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
       /* if($user == "anon.")
        {
            return $this->redirectToRoute('login');
        }*/
        $em = $this->getDoctrine()->getManager();
        $q = $em->createQuery('
                UPDATE ForumBundle:Sujet suj
                SET suj.nbrVue=suj.nbrVue+1
                WHERE suj.idSujet = :idSujet')
            ->setParameter('idSujet', $idSujet);
        $p = $q->execute();
        $sujets = $em->getRepository('ForumBundle:Sujet')->getSujetById($idSujet);
        $commentaires = $em->getRepository('ForumBundle:Commentaire')->listCommentBySujet($idSujet);
        $categoriesujet = $em->getRepository('ForumBundle:CategorieSujet')->findAll();
        $us = $em->getRepository('ForumBundle:User')->find($user);
        //$sujets->setNbrVue(0);

        return $this->render('@Forum/Sujet/forumdetail.html.twig', array(
            'sujet' => $sujets,
            'commentaires' => $commentaires,
           // 'commentaire' => $commentaire,
            'user' => $us->getId(),
            'user' => $us,
            'idSujet'=>$idSujet,
            'categoriesujets' => $categoriesujet,
            'tri'=>"",
        ));
    }

    /**
     * Lists all sujet entities. fil front
     *
     */
    public function indexforumlistAction( Request $request )
    {

        $em = $this->getDoctrine()->getManager();
        $categoriesujet = new CategorieSujet();
        $sujets = $em->getRepository('ForumBundle:Sujet')->findAll();
        $categoriesujet = $em->getRepository('ForumBundle:CategorieSujet')->findAll();
        $sujet = $em->getRepository('ForumBundle:Sujet')->findAll();


        /**
         * @var $paginator \Knp\Component\Pager\Paginator
         */
        $paginator=$this->get('knp_paginator');
        $suj=$paginator->paginate(
            $sujets,
            $request->query->getInt('page',1),2
        );

        return $this->render('@Forum/Sujet/forumlist.html.twig', array(
            'sujet' => $suj,
            'categoriesujets' => $categoriesujet,
            'tri'=>"",
            'Sujet' => $sujet,

        ));
    }

    public function indexforumlisteAction( Request $request,CategorieSujet $idcategorieSujet  )
    {
        $em = $this->getDoctrine()->getManager();
        $sujets = $em->getRepository('ForumBundle:Sujet')->findAll();
        $sujets = $em->getRepository('ForumBundle:CategorieSujet')->listSujetByCategorie($idcategorieSujet);
        /**
         * @var $paginator \Knp\Component\Pager\Paginator
         */
        $paginator=$this->get('knp_paginator');
        $suj=$paginator->paginate(
            $sujets,
            $request->query->getInt('page',1),2
        );
        $categoriesujet = $em->getRepository('ForumBundle:CategorieSujet')->findAll();
        $idcategorieSujet->getIdCategorieSujet();
        return $this->render('@Forum/Sujet/forumlist.html.twig', array(
            'sujet' => $suj,
            'categoriesujets' => $categoriesujet,
            'tri'=>"",
        ));
    }

    public function afficherTriFrontAction(Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $sujet=$em->getRepository(Sujet::class)->findAll();
        $sujet1=$sujet;
        $categoriesujet=$em->getRepository(CategorieSujet::class)->findAll();

        /**
         * @var $paginator \Knp\Component\Pager\Paginator
         */
        $paginator=$this->get('knp_paginator');
        $suj=$paginator->paginate(
            $sujet1,
            $request->query->getInt('page',1),3
        );
        if (isset($_GET['tri']) )
        {
            if(($request->get("tri")=="nomAsc"))
            {
                $sujet1=$em->getRepository(Sujet::class)->triNomASC();
            }
            elseif (($request->get("tri")=="nomDes"))
            {
                $sujet1=$em->getRepository(Sujet::class)->triNomDSC();
            }
            elseif (($request->get("tri")=="nbrVueAsc"))
            {
                $sujet1=$em->getRepository(Sujet::class)->trinbrVASC();
            }
            elseif (($request->get("tri")=="nbrVueDes"))
            {
                $sujet1=$em->getRepository(Sujet::class)->trinbrVDSC();
            }
            /**
             * @var $paginator \Knp\Component\Pager\Paginator
             */
            $paginator=$this->get('knp_paginator');
            $suj=$paginator->paginate(
                $sujet1,
                $request->query->getInt('page',1),3
            );
            return $this->render("@Forum/Sujet/forumlist.html.twig",array(
                    "sujet"=>$suj,
                    "tri"=>$_GET['tri'],
                    "categoriesujets"=> $categoriesujet
                ));

        }

        return $this->render("@Forum/Sujet/forumlist.html.twig",array(
            "sujet" => $suj,
            "categoriesujets" => $categoriesujet,
            "tri"=>"",
            ));

    }

    /**
     * Creates a new sujet entity.
     *
     */
    public function newAction(Request $request)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $sujet = new Sujet();
        $form = $this->createForm('ForumBundle\Form\SujetType', $sujet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file= $sujet->getImage();
            $fileName =md5(uniqid()).'.'.$file->guessExtension();
            $file->move(
                $this->getParameter('image_directory'),$fileName
            );
            $sujet->setImage($fileName);
            $em = $this->getDoctrine()->getManager();

            $sujet->setNomAgent($user);
            $data=$form["idCategorieSujet"]->getData();
            $sujet->setNomCategorieSujet($data->getNomCategorieSujet());
            $em = $this->getDoctrine()->getManager();
            $us = $em->getRepository('ForumBundle:User')->find($user);

            $sujet->setIdAgent($us);
            $em->persist($sujet);
            $em->flush();
            return $this->redirectToRoute('sujet_show', array('idSujet' => $sujet->getIdsujet()));
        }

        return $this->render('@Forum/Sujet/new.html.twig', array(
            'sujet' => $sujet,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a sujet entity.
     *
     */
    public function showAction(Sujet $sujet)
    {
        $deleteForm = $this->createDeleteForm($sujet);

        return $this->render('@Forum/Sujet/show.html.twig', array(
            'sujet' => $sujet,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing sujet entity.
     *
     */
    public function editAction(Request $request, Sujet $sujet)
    {
        $deleteForm = $this->createDeleteForm($sujet);
        $editForm = $this->createForm('ForumBundle\Form\SujetType', $sujet);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {

            $file= $sujet->getImage();
            $fileName =md5(uniqid()).'.'.$file->guessExtension();
            $file->move(
                $this->getParameter('image_directory'),$fileName
            );
            $sujet->setImage($fileName);

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('sujet_edit', array('idSujet' => $sujet->getIdsujet()));
        }

        return $this->render('@Forum/Sujet/edit.html.twig', array(
            'sujet' => $sujet,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a sujet entity.
     *
     */
    public function deleteAction(Request $request, Sujet $sujet)
    {
        $form = $this->createDeleteForm($sujet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($sujet);
            $em->flush();
        }

        return $this->redirectToRoute('sujet_index');
    }


    /**
     * Stat Sujet back
     *
     */
    public function statbackAction()
    {

        $pieChart = new PieChart();
        $em = $this->getDoctrine();
        $nbrE = sizeof($em->getRepository(Sujet::class)->findByType('Entretien'));
        $nbrC = sizeof($em->getRepository(Sujet::class)->findByType('Conseils'));
        $nbrP = sizeof($em->getRepository(Sujet::class)->findByType('Plantation'));

        $data = array();
        $stat = ['type', 'nbrSujet'];
        $nb = $nbrE ;
        array_push($data, $stat);
        $stat = array();

        array_push($stat, 'Entretien', $nbrE );
        $stat = ['Entretien', $nb];
        array_push($data, $stat);
        $stat = array();

        array_push($stat, 'Conseils', $nbrC );
        $nb1 = $nbrC;
        $stat = ['Conseils', $nb1];
        array_push($data, $stat);

        array_push($stat, 'Plantation', $nbrP );
        $nb2 = $nbrP;
        $stat = ['Plantation', $nb2];
        array_push($data, $stat);

        $pieChart->getData()->setArrayToDataTable(
            $data
        );
        $pieChart->getOptions()->setTitle('Nombre de sujet par TYPE');
        $pieChart->getOptions()->setHeight(500);
        $pieChart->getOptions()->setWidth(900);
        $pieChart->getOptions()->getTitleTextStyle()->setBold(true);
        $pieChart->getOptions()->getTitleTextStyle()->setColor('#009900');
        $pieChart->getOptions()->getTitleTextStyle()->setItalic(true);
        $pieChart->getOptions()->getTitleTextStyle()->setFontName('Arial');
        $pieChart->getOptions()->getTitleTextStyle()->setFontSize(20);


        $em = $this->getDoctrine()->getManager();
        $nbrtotalSujet=$em->getRepository('ForumBundle:Sujet')->countSujetTotal();
        $nbrtotalEntretien=$em->getRepository('ForumBundle:Sujet')->countliststypeentretien();
        $nbrtotalPlantation=$em->getRepository('ForumBundle:Sujet')->countliststypeplantation();
        $nbrtotalConseils=$em->getRepository('ForumBundle:Sujet')->countliststypeconseils();
        $nbrtotalVueSujet=$em->getRepository('ForumBundle:Sujet')->countNbrVueSujetTotal();
        $nomSujetMaxnbrVue=$em->getRepository('ForumBundle:Sujet')->affichNomSujetMaxnbrVue();
        $nomSujetMinnbrVue=$em->getRepository('ForumBundle:Sujet')->affichNomSujetMinnbrVue();

        return $this->render('@Forum/Sujet/stat.html.twig', array
                (
                    'piechart' => $pieChart,
                    'nbrtotalEntretien' => $nbrtotalEntretien,
                    'nbrtotalPlantation' => $nbrtotalPlantation,
                    'nbrtotalConseils' => $nbrtotalConseils,
                    'nbrtotalSujet'=> $nbrtotalSujet,
                    'nbrtotalVueSujet'=> $nbrtotalVueSujet,
                    'nomSujetMaxnbrVue'=> $nomSujetMaxnbrVue,
                    'nomSujetMinnbrVue' => $nomSujetMinnbrVue,
        ));

    }


    /**
     * Creates a form to delete a sujet entity.
     *
     * @param Sujet $sujet The sujet entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Sujet $sujet)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('sujet_delete', array('idSujet' => $sujet->getIdsujet())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
