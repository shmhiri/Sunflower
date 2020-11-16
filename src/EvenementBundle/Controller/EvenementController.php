<?php

namespace EvenementBundle\Controller;



use EvenementBundle\Entity\Evenement;
use EvenementBundle\Entity\Notification;
use EvenementBundle\Entity\Participer;
use EvenementBundle\Entity\User;
use EvenementBundle\Form\RechercheType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Filesystem\Filesystem;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * Evenement controller.
 *
 * @Route("evenement")
 */
class EvenementController extends Controller
{
//Display Bundle extern mrad (front)
    public function displayAction()
    {
        $notifications=$this->getDoctrine()->getManager()->getRepository('EvenementBundle:Notification')->findAll();

        return $this->render("@Evenement/evenement/notifications.html.twig",array('notifications'=>$notifications));
    }

// AFFICHER LES USERS participer a chaque eve (back)
    public function showparAction($idEvenement)
    {
        $em = $this->getDoctrine()->getManager();
        $evenements=$em->getRepository('EvenementBundle:Participer')->joinparticiper($idEvenement);

        return $this->render("@Evenement/evenement/showpar.html.twig",array('evenements'=>$evenements));

    }

// AFFICHER une eve selon leur id et controle du participons (verif bouton)(front)
    public function useraffAction($id)
    {

        $user = $this->get('security.token_storage')->getToken()->getUser();
        $u=$user->getId();

        $em = $this->getDoctrine()->getManager();
        $nbr=$em->getRepository('EvenementBundle:Participer')->rechercheparticiperideve($id);
        $nbrr=$em->getRepository('EvenementBundle:Participer')->rechercheparticiperid($u,$id);
        $evenement=$this->getDoctrine()->getRepository(Evenement::class)->find($id);
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
        $verif="no";
        if(($nbr==$evenement->getMax())){$verif="yes"; }

        return $this->render('@Evenement/evenement/user_eve.html.twig', array('count'=>$count,'countf'=>$countf,'verif'=>$verif,'evenement'=>$evenement,'nbr'=>$nbr,'nbrr'=>$nbrr));


    }

//click participer render a la page tous les eve (front)
    public function userrAction($id)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $u=$user->getId();
        /**##############"Firas gazzah###################*/
        $em = $this->getDoctrine()->getManager();
        $user = $this->get('security.token_storage')->getToken()->getUser();
        if ($user=="anon.")
        {
            $count=$em->getRepository('CommandeBundle:LigneCmd')->contano();
            $countf=$em->getRepository('ProduitBundle:Favoris')->count();

        }else {
            $idU=$user->getId();
            $count=$em->getRepository('CommandeBundle:LigneCmd')->cont($idU);
            $countf=$em->getRepository('ProduitBundle:Favoris')->count($idU);

        }
        /*##########################################################################################*/


        $em = $this->getDoctrine()->getManager();
        $nbr=$em->getRepository('EvenementBundle:Participer')->rechercheparticiperideve($id);//nbr participons a une eve
        $nbrr=$em->getRepository('EvenementBundle:Participer')->rechercheparticiperid($u,$id);//user est participer au eve =1 sinon 0

        $user=$this->getDoctrine()->getRepository(User::class)->find($u);
        $evenement=$this->getDoctrine()->getRepository(Evenement::class)->find($id);

        $participer = new Participer();
        $participer->setIdUser($user);
        $participer->setIdEvenement($evenement);

        if(($nbr==$evenement->getMax())&&($nbrr==0))//le cas ou eve est max et il n est pas participe donc n affiche pa button

        {
            $em = $this->getDoctrine()->getManager();
            $n=$em->getRepository('EvenementBundle:Participer')->rechercheparticiper($u);//nbr eve participer pour user connecte
            $evenemen=$this->getDoctrine()->getManager()->getRepository('EvenementBundle:Evenement')->findAll();//tout les eve

            return $this->render('@Evenement/evenement/user.html.twig', array('evenements'=>$evenemen,'nbr'=>$n,'count'=>$count,'countf'=>$countf));//render page acceuil eve
        }

        if (($nbrr==0))//user n a pas participe au eve

        {
            $em->persist($participer);
            $em->flush();//ajouter

            $em = $this->getDoctrine()->getManager();
            $n=$em->getRepository('EvenementBundle:Participer')->rechercheparticiper($u);
            $evenemen=$this->getDoctrine()->getManager()->getRepository('EvenementBundle:Evenement')->findAll();

            return $this->render('@Evenement/evenement/user.html.twig', array('evenements'=>$evenemen,'nbr'=>$n,'count'=>$count,'countf'=>$countf));


        }
        //user est deja participer, il ne veut pas participe

            $nbrrr=$em->getRepository('EvenementBundle:Participer')->rechercheparticiperidd($u,$id);//recuperer id_par selon id_user et id_eve
            $pa=$this->getDoctrine()->getRepository(Participer::class)->find($nbrrr);//recuperer l objet participer
            $participer->setIdParticiper($nbrrr);

            $em->remove($pa);
            $em->flush();//remove

            $n=$em->getRepository('EvenementBundle:Participer')->rechercheparticiper($u);
            $evenemen=$this->getDoctrine()->getManager()->getRepository('EvenementBundle:Evenement')->findAll();


            return $this->render('@Evenement/evenement/user.html.twig', array('evenements'=>$evenemen,'nbr'=>$n,'count'=>$count,'countf'=>$countf));

    }

    //AFFICHER eve selon id_user(front)

    /**
     * @Security("has_role('ROLE_USER')")
     */
    public function userAction()
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $id=$user->getId();
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

        $em = $this->getDoctrine()->getManager();
        $nbr=$em->getRepository('EvenementBundle:Participer')->rechercheparticiper($id);
        $evenements=$this->getDoctrine()->getManager()->getRepository('EvenementBundle:Evenement')->findAll();

        return $this->render('@Evenement/evenement/user.html.twig', array('evenements'=>$evenements,'nbr'=>$nbr,'count'=>$count,'countf'=>$countf));
    }

    //STAT dashboard (back)
        public function statAction()
    {

        $user = $this->get('security.token_storage')->getToken()->getUser();
        $id=$user->getId();
        $em = $this->getDoctrine()->getManager();

        $nbrtotalpro=$em->getRepository('EvenementBundle:Evenement')->countlistspro();
        $nbrtotaldcpro=$em->getRepository('EvenementBundle:Evenement')->countliststypedatecourspro();
        $nbrtotaldepro=$em->getRepository('EvenementBundle:Evenement')->countliststypedateexpirerpro();

        $nbrtotaluserpro=$em->getRepository('EvenementBundle:Evenement')->countlistsuserpro($id);
        $nbrtotaldcuserpro=$em->getRepository('EvenementBundle:Evenement')->countliststypedatecoursuserpro($id);
        $nbrtotaldeuserpro=$em->getRepository('EvenementBundle:Evenement')->countliststypedateexpireruserpro($id);


        $nbrtotal=$em->getRepository('EvenementBundle:Evenement')->countlists();
        $nbrtotalani=$em->getRepository('EvenementBundle:Evenement')->countliststypeanimation();
        $nbrtotalcom=$em->getRepository('EvenementBundle:Evenement')->countliststypecompetition();
        $nbrtotalvis=$em->getRepository('EvenementBundle:Evenement')->countliststypevisite();
        $nbrtotaldc=$em->getRepository('EvenementBundle:Evenement')->countliststypedatecours();
        $nbrtotalde=$em->getRepository('EvenementBundle:Evenement')->countliststypedateexpirer();


        $nbrtotaluser=$em->getRepository('EvenementBundle:Evenement')->countlistsuser($id);
        $nbrtotalaniuser=$em->getRepository('EvenementBundle:Evenement')->countliststypeanimationuser($id);
        $nbrtotalcomuser=$em->getRepository('EvenementBundle:Evenement')->countliststypecompetitionuser($id);
        $nbrtotalvisuser=$em->getRepository('EvenementBundle:Evenement')->countliststypevisiteuser($id);
        $nbrtotaldcuser=$em->getRepository('EvenementBundle:Evenement')->countliststypedatecoursuser($id);
        $nbrtotaldeuser=$em->getRepository('EvenementBundle:Evenement')->countliststypedateexpireruser($id);

        return $this->render('@Evenement/Default/index.html.twig', array('nbrtotalpro' => $nbrtotalpro,'nbrtotaldcpro' => $nbrtotaldcpro,'nbrtotaldepro' => $nbrtotaldepro,'nbrtotal' => $nbrtotal,'nbrtotalani' => $nbrtotalani,'nbrtotalcom' => $nbrtotalcom,'nbrtotalvis' => $nbrtotalvis,'nbrtotaldc' => $nbrtotaldc,'nbrtotalde' => $nbrtotalde,'nbrtotaluser' => $nbrtotaluser,'nbrtotaluserpro' => $nbrtotaluserpro,'nbrtotalaniuser' => $nbrtotalaniuser,'nbrtotalcomuser' => $nbrtotalcomuser,'nbrtotalvisuser' => $nbrtotalvisuser,'nbrtotaldcuser' => $nbrtotaldcuser,'nbrtotaldeuser' => $nbrtotaldeuser,'nbrtotaldcuserpro' => $nbrtotaldcuserpro,'nbrtotaldeuserpro' => $nbrtotaldeuserpro));
    }

    /**
     * Lists all evenement entities.
     *
     * @Route("/", name="evenement_index")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $u=$user->getId();

        $evenement=new Evenement();
        $form=$this->createForm(RechercheType::class,$evenement);

        $form->handleRequest($request);
        if($form->isSubmitted() ) {


            $evenements=$this->getDoctrine()->getRepository(Evenement::class)->findBy(array('nomEvenement'=>$evenement->getNomEvenement()));

        }else
        {
            $evenements=$this->getDoctrine()->getRepository('EvenementBundle:Evenement')->listeve($u);

        }
        return $this->render("@Evenement/evenement/index.html.twig",array("form"=>$form->createView(),'evenements'=>$evenements));

    }

    /**
     * Creates a new evenement entity.
     *
     * @Route("/new", name="evenement_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $evenement = new Evenement();
        $form = $this->createForm('EvenementBundle\Form\EvenementType', $evenement);
        $form->handleRequest($request);

        $user = $this->get('security.token_storage')->getToken()->getUser();
        $evenement->setIdAdmin($user);

        if ($form->isSubmitted() && $form->isValid()) {
            /**
             * @var UploadedFile $file
             */
            $file=$evenement->getPath();
            $fileName = md5(uniqid()).'.'.$file->guessExtension();
            $file->move($this->getParameter('image_directory'),$fileName);

            $evenement->setPath($fileName);

            $em = $this->getDoctrine()->getManager();


            $em->persist($evenement);
            $em->flush();



            $deleteForm = $this->createDeleteForm($evenement);

            return $this->render('@Evenement/evenement/show.html.twig', array(
                'evenement' => $evenement,'delete_form' => $deleteForm->createView(),

            ));
        }

        return $this->render('@Evenement/evenement/new.html.twig', array(
            'evenement' => $evenement,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a evenement entity.
     *
     * @Route("/{idEvenement}", name="evenement_show")
     * @Method("GET")
     */
    public function showAction(Evenement $evenement)
    {
        $deleteForm = $this->createDeleteForm($evenement);

        return $this->render('@Evenement/evenement/show.html.twig', array(
            'evenement' => $evenement,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing evenement entity.
     *
     * @Route("/{idEvenement}/edit", name="evenement_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Evenement $evenement)
    {
        $deleteForm = $this->createDeleteForm($evenement);
        $editForm = $this->createForm('EvenementBundle\Form\EvenementType', $evenement);
        $editForm->handleRequest($request);

        $user = $this->get('security.token_storage')->getToken()->getUser();

        $evenement->setIdAdmin($user);
        if ($editForm->isSubmitted() && $editForm->isValid()) {

            /**
             * @var UploadedFile $file
             */
            $file=$evenement->getPath();
            $fileName = md5(uniqid()).'.'.$file->guessExtension();
            $file->move($this->getParameter('image_directory'),$fileName);

            $evenement->setPath($fileName);

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('evenement_index');
        }

        return $this->render('@Evenement/evenement/edit.html.twig', array(
            'evenement' => $evenement,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a evenement entity.
     *
     * @Route("/{idEvenement}", name="evenement_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Evenement $evenement)
    {
        $form = $this->createDeleteForm($evenement);
        $image=$evenement->getPath();
        $pa=$this->getParameter('image_directory').'/'.$image;
        //unlink(''.$pa);
        $fs=new Filesystem();
        $fs->remove(array($pa));
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($evenement);
            $em->flush();
        }

        return $this->redirectToRoute('evenement_index');
    }

    /**
     * Creates a form to delete a evenement entity.
     *
     * @param Evenement $evenement The evenement entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Evenement $evenement)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('evenement_delete', array('idEvenement' => $evenement->getIdevenement())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }


















}
