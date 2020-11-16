<?php

namespace AdministrationBundle\Controller;

use ForumBundle\Entity\Evenement;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class EvenementController extends Controller
{
    public function indexAction()
    {

        $em = $this->get('doctrine.orm.entity_manager');
        $evenements = $em->getRepository('ForumBundle:Evenement')->findAll();


        return $this->render('@Evenement/Evenement/index.html.twig', ['evenements' => $evenements]);
    }

    public function addAction(Request $request)
    {
        if ($request->getMethod() == "POST") {
            $evenement = new Evenement();
            $evenement->setType($request->get('type'));
            $evenement->setNom($request->get('nom'));
            $evenement->setLieu($request->get('lieu'));
            $evenement->setDescription($request->get('description'));
            $evenement->setAdmin($this->getUser());
            $em = $this->get('doctrine.orm.entity_manager');
            $em->persist($evenement);
            $em->flush($evenement);
            return $this->redirectToRoute('evenement_show');

        } else {
            return $this->render('@Administration/Evenement/add.html.twig');
        }

    }

    public function showAction()
    {
        $em = $this->get('doctrine.orm.entity_manager');
        $evenements = $em->getRepository('ForumBundle:Evenement')->findAll();
        return $this->render('@Administration/Evenement/show.html.twig', ['evenements' => $evenements]);
    }

    public function deleteAction($id)
    {

        $em = $this->get('doctrine.orm.entity_manager');
        $evenement = $em->getRepository('ForumBundle:Evenement')->find($id);

        if ($evenement != null) {
            $em->remove($evenement);
            $em->flush($evenement);
        }

        return $this->redirectToRoute('evenement_show');

    }
}
