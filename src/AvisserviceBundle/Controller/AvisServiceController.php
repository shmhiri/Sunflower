<?php

namespace AvisserviceBundle\Controller;

use AvisserviceBundle\Entity\AvisService;
use ServiceBundle\Entity\Service;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * Avisservice controller.
 *
 */
class AvisServiceController extends Controller
{
    /**
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function indexAction(Service $idService)
    {

        $em = $this->getDoctrine()->getManager();

        $avisServices = $em->getRepository('AvisserviceBundle:AvisService')->findBy(array('idService'=>$idService));

        return $this->render('@Avisservice/avisservice/index.html.twig', array(
            'avisServices' => $avisServices,
        ));
    }

    /**
     * @Security("has_role('ROLE_USER')")
     */
    public function newAction(Request $request,Service $idService )
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
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $username = $user->getUsername();
        $userid = $user->getId();
        $avisService = new Avisservice();
        $form = $this->createForm('AvisserviceBundle\Form\AvisServiceType', $avisService);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $avisService->setIdUser($userid);
$avisService->setIdService($idService->getIdService());
            $avisService->setNomClient($username);
            $avisService->setNomService($idService->getNomService());
            $em = $this->getDoctrine()->getManager();
            $em->persist($avisService);
            $em->flush();
            $agent = $this->getDoctrine()->getManager()->getRepository('ForumBundle:User')->find($idService->getIdAgent());

            return $this->redirectToRoute('avisservice_show', array('idAvis' => $avisService->getIdavis()));
        }

        return $this->render('@Avisservice/avisservice/new.html.twig', array(
            'avisService' => $avisService,
            'form' => $form->createView(),'count'=>$count,'countf'=>$countf
        ));
    }


    public function showAction(AvisService $avisService)
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
        $deleteForm = $this->createDeleteForm($avisService);

        return $this->render('@Avisservice/avisservice/show.html.twig', array(
            'avisService' => $avisService,
            'delete_form' => $deleteForm->createView(),'count'=>$count,'countf'=>$countf
        ));
    }

    /**
     * @Security("has_role('ROLE_USER')")
     */
    public function editAction(Request $request, AvisService $avisService)
    {        /**##############"Firas gazzah###################*/
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
        $deleteForm = $this->createDeleteForm($avisService);
        $editForm = $this->createForm('AvisserviceBundle\Form\AvisServiceType', $avisService);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('avisservice_edit', array('idAvis' => $avisService->getIdavis()));
        }

        return $this->render('@Avisservice/avisservice/edit.html.twig', array(
            'avisService' => $avisService,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),'count'=>$count,'countf'=>$countf
        ));
    }

    /**
     * @Security("has_role('ROLE_USER')")
     */
    public function deleteAction(Request $request, AvisService $avisService)
    {
        $form = $this->createDeleteForm($avisService);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($avisService);
            $em->flush();
        }

        return $this->redirectToRoute('service_showfront');
    }

    /**
     * Creates a form to delete a avisService entity.
     *
     * @param AvisService $avisService The avisService entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(AvisService $avisService)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('avisservice_delete', array('idAvis' => $avisService->getIdavis())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }



    /**
     * @Route("/send-notification", name="send_notification")
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */



}
