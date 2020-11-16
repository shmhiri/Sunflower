<?php

namespace ProduitBundle\Controller;

use ProduitBundle\Entity\Favoris;
use ProduitBundle\Repository\favorisRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * Favori controller.
 *
 */

class FavorisController extends Controller
{
    /**
     * Lists all favori entities.
     *
     */
    /**
     * @Security("has_role('ROLE_USER')")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->get('security.token_storage')->getToken()->getUser();

        if ($user=="anon.")
        {$count=$em->getRepository('CommandeBundle:LigneCmd')->contano();
            $countf=$em->getRepository('ProduitBundle:Favoris')->count(0);

        }else {
            $idU=$user->getId();
            $count=$em->getRepository('CommandeBundle:LigneCmd')->cont($idU);
            $countf=$em->getRepository('ProduitBundle:Favoris')->count($idU);
        }

        $idddd=$user->getId();
        $favoris = $em->getRepository('ProduitBundle:Favoris')->listFavorisofthisuser($idddd);
        return $this->render('@Produit/favoris/index.html.twig', array(
            'favoris' => $favoris,'count'=>$count,'countf'=>$countf,
        ));
    }

    /**
     * Creates a new favori entity.
     *
     */
    /**
     * @Security("has_role('ROLE_USER')")
     */
    public function newAction($idProduit)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $idddd=$user->getId();

        $favori = new Favoris();
        $em = $this->getDoctrine()->getManager();

            $query = $em->createQuery('SELECT p.nomProduit FROM ProduitBundle:Produit p WHERE p.idProduit = :idProduit')
            ->setParameter('idProduit',$idProduit );
        $nomP = $query->getSingleScalarResult();
        $query2 = $em->createQuery('SELECT p.quantite FROM ProduitBundle:Produit p WHERE p.idProduit = :idProduit')
            ->setParameter('idProduit',$idProduit );
        $qte = $query2->getSingleScalarResult();

            if ($qte>0) {$favori->setDisponibilite("true");}
            else        {$favori->setDisponibilite("false");}
            $favori->setIdProduit($idProduit);
            $favori->setNomProduit($nomP);
            $favori->setIdClient($idddd);

            $exist=$em->getRepository('ProduitBundle:Favoris')->checkfav($idProduit,$idddd);
            if(!$exist){
                $em->persist($favori);
                $em->flush();
                return $this->redirectToRoute('favoris_index');
            }
        return $this->redirectToRoute('produit_indexfront');

    }

    /**
     * Deletes a favori entity.
     *
     */
    public function deleteAction(Favoris $favori)
    {
        $em = $this->getDoctrine()->getManager();

        $em->remove($favori);
        $em->flush();


        return $this->redirectToRoute('favoris_index');
    }

    /**
     * Creates a form to delete a favori entity.
     *
     * @param Favoris $favori The favori entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Favoris $favori)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('favoris_delete', array('idFavoris' => $favori->getIdfavoris())))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }
}
