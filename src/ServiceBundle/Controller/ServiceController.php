<?php

namespace ServiceBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use ServiceBundle\Entity\Service;
use ServiceBundle\Form\RechercheType;
use ServiceBundle\Form\ServiceType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Service controller.
 *
 */
class ServiceController extends Controller
{
    /**
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function indexAction()
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
        $em = $this->getDoctrine()->getManager();

        $services = $em->getRepository('ServiceBundle:Service')->findAll();

        return $this->render('@Service/service/index.html.twig', array(
            'services' => $services,'count'=>$count,'countf'=>$countf
        ));
    }
    /**
     * @Security("has_role('ROLE_USER')")
     */
    public function rechercheAction(Request $request)
    {

        $service = new Service();
        $form = $this->createForm(RechercheType::class, $service);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {


            $services=$this->getDoctrine()->getRepository(service::class)->findBy(array('nomService'=>$service->getNomService()));

        }else
        {
            $services=$this->getDoctrine()->getManager()->getRepository('ServiceBundle:Service')->findAll();

        }
        return $this->render("@Service/service/recherche.html.twig",array("form"=>$form->createView(),'services' => $services));



    }

    /**
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function newAction(Request $request)

    {/**##############"Firas gazzah###################*/
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
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $username = $user->getUsername();
        $userid = $user->getId();
        $useremail= $user->getEmail();
        $service = new Service();
        $form = $this->createForm('ServiceBundle\Form\ServiceType', $service);
        $form->handleRequest($request);



        if ($form->isSubmitted() && $form->isValid()) {
            $service->setIdAgent($userid);
            $service->setNomAgent($username);
            $service->setContact($useremail);
            $file= $service->getImage();
            $fileName =md5(uniqid()).'.'.$file->guessExtension();
            $file->move(
                $this->getParameter('image_directory'),$fileName

            );
            $service->setImage($fileName);
            $em = $this->getDoctrine()->getManager();
            $em->persist($service);
            $em->flush();

            return $this->redirectToRoute('service_show', array('idService' => $service->getIdservice()));
        }

        return $this->render('@Service/service/new.html.twig', array(
            'service' => $service,
            'form' => $form->createView(),'count'=>$count,'countf'=>$countf
        ));
    }

    /**
     * @Security("has_role('ROLE_USER')")
     */
    public function devisAction(Request $request)
    {
        $form = $this->createForm(ServiceType::class);
        $form->handleRequest($request);
        $DevisFormData = $form->getData();
        $em = $this->getDoctrine()->getManager();
        $services = $em->getRepository('ServiceBundle:Service')->findAll();
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $username = $user->getUsername();
        $userid = $user->getId();
        $useremail= $user->getEmail();
        $this->addFlash('info', 'Some useful info');
        $message =  \Swift_Message::newInstance('devis')
            ->setFrom('sunflower.thesquad@gmail.com')
            ->setTo($useremail)
            ->setBody(
                'text/plain'
            )
        ;
        $this->get('mailer')->send($message);
        $this->addFlash('success', 'It sent!');
        return $this->render('@Service/service/devis.html.twig', array(
            'services' => $services,
        ));

    }
    public function invoiceAction(Service $service)
    {
        $em  = $this->getDoctrine()->getManager();


        $nbrP=$em->getRepository('ServiceBundle:Service')->listProductById($service->getIdCmd());



        $client=$em->getRepository('ServiceBundle:Service')->getIdclient($service->getIdCmd());


        /*  return $this->render('@Commande/commande/invoice.html.twig', array(
              'commande' => $commande,'nbrP0'=>$nbrP,'client'=>$client
          ));*/
        $html = $this->renderView('@Service/service/invoice.html.twig', array(
            'commande' => $service,'nbrP0'=>$nbrP,'client'=>$client
        ));

        return new PdfResponse(
            $this->get('knp_snappy.pdf')->getOutputFromHtml($html),
            'file.pdf'
        );

    }

    /**
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function showAction(Service $service)
    {/**##############"Firas gazzah###################*/
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
        $deleteForm = $this->createDeleteForm($service);

        return $this->render('@Service/service/show.html.twig', array(
            'service' => $service,
            'delete_form' => $deleteForm->createView(),'count'=>$count,'countf'=>$countf
        ));
    }

    /**
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function editAction(Request $request, Service $service)
    {
        $deleteForm = $this->createDeleteForm($service);
        $editForm = $this->createForm('ServiceBundle\Form\ServiceType', $service);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('service_edit', array('idService' => $service->getIdservice()));
        }

        return $this->render('@Service/service/edit.html.twig', array(
            'service' => $service,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function deleteAction(Request $request, Service $service)
    {
        $form = $this->createDeleteForm($service);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($service);
            $em->flush();
        }

        return $this->redirectToRoute('service_index');
    }

    /**
     * Creates a form to delete a service entity.
     *
     * @param Service $service The service entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Service $service)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('service_delete', array('idService' => $service->getIdservice())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    public function ShowfrontAction(Request $request)
    {/**##############"Firas gazzah###################*/
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
        $service = new Service();
        $form = $this->createForm(RechercheType::class, $service);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {


            $services=$this->getDoctrine()->getRepository(service::class)->findBy(array('region'=>$service->getRegion()));

        }else
        {
            $services=$this->getDoctrine()->getManager()->getRepository('ServiceBundle:Service')->findAll();

        }
        return $this->render("@Service/service/showfront.html.twig",array("form"=>$form->createView(),'services' => $services,'count'=>$count,'countf'=>$countf));

    }
    /**
     * @Security("has_role('ROLE_USER')")
     */
    public function ShowuserAction(Service $service)
    {/**##############"Firas gazzah###################*/
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
        $deleteForm = $this->createDeleteForm($service);

        return $this->render('@Service/service/showuser.html.twig', array(
            'service' => $service,'count'=>$count,'countf'=>$countf
        ));
    }
}
