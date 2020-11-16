<?php

namespace ForumBundle\Controller;

use ForumBundle\Entity\Commentaire;
use ForumBundle\Entity\Sujet;
use ForumBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class CommentaireController extends Controller
{

    /**
     * @Security("has_role('ROLE_USER')")
     */
    public function AjouterCommentaireAction(Request $request,$idSujet)
    {

        $user = $this->get('security.token_storage')->getToken()->getUser();
        $commentaire = new Commentaire();
        $em = $this->get('doctrine.orm.entity_manager');
        $commentaires = $em->getRepository('ForumBundle:Commentaire')->listCommentBySujet($idSujet);
        $sujets = $em->getRepository('ForumBundle:Sujet')->getSujetById($idSujet);
        if ($request->isMethod('POST')) {
            $commentaire->setIdSujet($idSujet);
            $commentaire->setCommentaires($request->get('commentaires'));
            $commentaire->setNomClient($user->getUsername());
            $commentaire->setIdClient($this->getUser());
            $em->persist($commentaire);
            $em->flush($commentaire);
            return $this->redirectToRoute('forum_detail',array('idSujet'=>$idSujet,));
        }
        else
        {
            return $this->render('@Forum/Sujet/forumdetail.html.twig',array(
                'commentaires'=>$commentaires,
                'sujets' => $sujets,
                'users' => $user->getId(),
                'idSujet'=>$idSujet,
                'valider'=>"",
            ));
        }

    }
    public function ModifierCommentaireAction(Request $request,$idCom)
    {
        $em=$this->getDoctrine()->getManager();
        $user=$em->getRepository('ForumBundle:Commentaire')->findAll();
        $commentaire=$em->getRepository('ForumBundle:Commentaire')->find($idCom);
        $sujets = $em->getRepository('ForumBundle:Sujet')->findAll();

        if($request->isMethod('POST'))
        {
            $user=$em->getRepository(User::class)->find($user);
            $commentaire->setId($user);
            $commentaire->setCommentaire($request->get("commentaires"));
            $em=$this->getDoctrine()->getManager();
            $em->flush();
            $this->redirectToRoute('forum_detail');
        }
        return $this->render('@Forum/Sujet/modifierCommentaire.html.twig',array(
                    "user"=>$user,
                    "commentaires"=>$commentaire,
                    "sujet" =>$sujets,
        ));
    }





}
