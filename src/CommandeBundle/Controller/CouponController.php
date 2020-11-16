<?php

namespace CommandeBundle\Controller;

use CommandeBundle\Entity\Coupon;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\PieChart;

/**
 * Coupon controller.
 *
 */
class CouponController extends Controller
{

    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $coupons = $em->getRepository('CommandeBundle:Coupon')->findAll();

        return $this->render('@Commande/coupon/index.html.twig', array(
            'coupons' => $coupons,
        ));
    }

    /**
     * Stat Sujet back
     *
     */
    public function statbackAction()
    {
        $em = $this->getDoctrine()->getManager();
        $nbrcmdLiv=$em->getRepository('CommandeBundle:Commande')->listcmdlivre();
        $nbrcmdenatten=$em->getRepository('CommandeBundle:Commande')->listcmdenattent();
        $nbrcmdannuler=$em->getRepository('CommandeBundle:Commande')->listcmdannuler();
        $nbrcmdencour=$em->getRepository('CommandeBundle:Commande')->listcmdencour();
        $allcmd=$em->getRepository('CommandeBundle:Commande')->listAllcmd();
        $pieChart = new PieChart();
        $em = $this->getDoctrine();


        $nbrE =0;// sizeof($em->getRepository(Sujet::class)->findByType('Entretien'));
        $nbrC =0;// sizeof($em->getRepository(Sujet::class)->findByType('Conseils'));
        $nbrP =0; //sizeof($em->getRepository(Sujet::class)->findByType('Plantation'));

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
        $nbrtotalSujet=$em->getRepository('CommandeBundle:Sujet')->countSujetTotal();
        $nbrtotalEntretien=$em->getRepository('CommandeBundle:Sujet')->countliststypeentretien();
        $nbrtotalPlantation=$em->getRepository('CommandeBundle:Sujet')->countliststypeplantation();
        $nbrtotalConseils=$em->getRepository('CommandeBundle:Sujet')->countliststypeconseils();
        $nbrtotalVueSujet=$em->getRepository('CommandeBundle:Sujet')->countNbrVueSujetTotal();
        $nomSujetMaxnbrVue=$em->getRepository('CommandeBundle:Sujet')->affichNomSujetMaxnbrVue();
        $nomSujetMinnbrVue=$em->getRepository('CommandeBundle:Sujet')->affichNomSujetMinnbrVue();

        return $this->render('@Commande/coupon/stat.html.twig', array
        (
            'piechart' => $pieChart,
            'nbrtotalEntretien' => $nbrtotalEntretien,
            'nbrtotalPlantation' => $nbrtotalPlantation,
            'nbrtotalConseils' => $nbrtotalConseils,
            'nbrtotalSujet'=> $nbrtotalSujet,
            'nbrtotalVueSujet'=> $nbrtotalVueSujet,
            'nomSujetMaxnbrVue'=> $nomSujetMaxnbrVue,
            'nomSujetMinnbrVue' => $nomSujetMinnbrVue,
            'nbrcmdLiv' => $nbrcmdLiv,
            'nbrcmdenatten' => $nbrcmdenatten,
            'nbrcmdannuler' => $nbrcmdannuler,
            'nbrcmdencour'=> $nbrcmdencour,
            'allcmd'=> $allcmd,
        ));

    }


    public function newAction(Request $request)
    {
        $coupon = new Coupon();
        $form = $this->createForm('CommandeBundle\Form\CouponType', $coupon);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($coupon);
            $em->flush();

            return $this->redirectToRoute('coupon_index', array('id' => $coupon->getId()));
        }
        if ($request->isMethod('POST')) {
            $em = $this->getDoctrine()->getManager();
            $coupon->setCode($request->get('code'));
            $coupon->setRemise($request->get('remise'));

            $em->persist($coupon);
            $em->flush();
            return $this->redirectToRoute('coupon_index', array('id' => $coupon->getId()));
        }

        return $this->render('@Commande/coupon/new.html.twig', array(
            'coupon' => $coupon,
            'form' => $form->createView(),
        ));
    }


    public function showAction(Coupon $coupon)
    {
        $deleteForm = $this->createDeleteForm($coupon);

        return $this->render('@Commande/coupon/show.html.twig', array(
            'coupon' => $coupon,
            'delete_form' => $deleteForm->createView(),
        ));
    }


    public function editAction(Request $request, Coupon $coupon)
    {
        $deleteForm = $this->createDeleteForm($coupon);
        $editForm = $this->createForm('CommandeBundle\Form\CouponType', $coupon);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('coupon_edit', array('id' => $coupon->getId()));
        }

        return $this->render('@Commande/coupon/edit.html.twig', array(
            'coupon' => $coupon,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }


    public function deleteAction(Request $request, Coupon $coupon)
    {
        $form = $this->createDeleteForm($coupon);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($coupon);
            $em->flush();
        }

        return $this->redirectToRoute('coupon_index');
    }

    /**
     * Creates a form to delete a coupon entity.
     *
     * @param Coupon $coupon The coupon entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Coupon $coupon)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('coupon_delete', array('id' => $coupon->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
