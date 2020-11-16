<?php

namespace CommandeBundle\Controller;

use CommandeBundle\Entity\Commande;
use CommandeBundle\Entity\Coupon;
use CommandeBundle\Entity\LigneCmd;
use CommandeBundle\Entity\Produit;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Mysqli;



/**
 * Commande controller.
 *
 */
class CommandeController extends Controller
{

    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery('
           SELECT DISTINCT c.idCmd,c.modeP,c.lieuLiv,c.montant, c.etatCmd  FROM CommandeBundle:Commande c');

        $commandes = $query->getResult();

        return $this->render('@Commande/commande/index.html.twig', array(
            'commandes' => $commandes,
        ));
    }

    public function CmdAction()
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
        $produit = $em->getRepository('CommandeBundle:Produit')->findAll();

        return $this->render('@Commande/commande/Cmd.html.twig', array(
            'produit' => $produit,'count' => $count,'countf'=>$countf,
        ));
        
    }


    public function newAction()
    {

        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "pepiniere";
        $em = $this->getDoctrine()->getManager();
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $adrr=$user->getAdresse();
        if ($user=="anon.")
        {}
        else {
            $idU=$user->getId();
            // Create connection
            $conn = new mysqli($servername, $username, $password, $dbname);
             // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
            $idcmd = 0;
            $sql2 = "SELECT MAX(id_cmd) FROM commande";
            $result2 = $conn->query($sql2);
            while ($row = $result2->fetch_assoc()) {
                $idcmd = 1 + $row["MAX(id_cmd)"];
            }

            $sql = "insert into commande (`lieu_liv`,`id_cmd`,`id_produit`,`id_client`,`montant`,`qte`) 
                    select '$adrr','$idcmd',id_produit,id_client,montant,quantite from ligne_cmd l where l.id_client='$idU'";
            $sql3=" update commande set montant=(select SUM(montant) from ligne_cmd where id_client='$idU') WHERE `id_cmd`='$idcmd'";



            $idU=$user->getId();
            $lcmd=$em->getRepository('CommandeBundle:LigneCmd')->listProductPanier($idU);

            $message =  \Swift_Message::newInstance('Confirmation de votre commande')
                ->setFrom('sunflower.thesquad@gmail.com')
                ->setTo($user->getEmail())
                ->setBody(  $this->renderView('@Commande/commande/email.html.twig',['user' => $user, 'lcmd'=>$lcmd]),'text/html');
            $this->get('mailer')->send($message);

            if ($conn->query($sql) === TRUE) {
                echo "New record created successfully";
                $conn->query($sql3);
                $sql3=" delete from ligne_cmd  where id_client='$idU'";
                $conn->query($sql3);
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }
        $conn->close();





         return $this->redirectToRoute('produit_indexfront');
        //return $this->render('@Commande/commande/new.html.twig');
    }


    public function showAction(Commande $commande)
    {
        $em  = $this->getDoctrine()->getManager();


        $nbrP=$em->getRepository('CommandeBundle:Produit')->listProductById($commande->getIdCmd());
        $client=$em->getRepository('CommandeBundle:Produit')->getIdclient($commande->getIdCmd());

        $user = $this->get('security.token_storage')->getToken()->getUser();
        $idU=$user->getId();
        if ($user=="anon.")
        {$idU=0;
            $lcmd=$em->getRepository('CommandeBundle:LigneCmd')->listProductPanieranon();
            $count=$em->getRepository('CommandeBundle:LigneCmd')->contano();
            $countf=$em->getRepository('ProduitBundle:Favoris')->count($idU);
        }else {
            $idU=$user->getId();
            $lcmd=$em->getRepository('CommandeBundle:LigneCmd')->listProductPanier($idU);
            $count=$em->getRepository('CommandeBundle:LigneCmd')->cont($idU);
            $countf=$em->getRepository('ProduitBundle:Favoris')->count($idU);
        }

        return $this->render('@Commande/commande/showuser.html.twig', array(
            'commande' => $commande,'nbrP0'=>$nbrP,'client'=>$client,'count'=>$count,'countf'=>$countf,
        ));

    }

    public function listcmdAction()
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->get('security.token_storage')->getToken()->getUser();



        if ($user=="anon.")
        {   $idU=0;
            $lcmd=$em->getRepository('CommandeBundle:LigneCmd')->listProductPanieranon();
            $count=$em->getRepository('CommandeBundle:LigneCmd')->contano();
            $countf=$em->getRepository('ProduitBundle:Favoris')->count($idU);
            $query = $em->createQuery("
            SELECT DISTINCT c.idCmd,c.modeP,c.lieuLiv,c.montant, c.etatCmd  FROM CommandeBundle:Commande c where c.idClient='$idU'");
            $commandes = $query->getResult();
        }else {
            $idU=$user->getId();
            $lcmd=$em->getRepository('CommandeBundle:LigneCmd')->listProductPanier($idU);
            $count=$em->getRepository('CommandeBundle:LigneCmd')->cont($idU);
            $countf=$em->getRepository('ProduitBundle:Favoris')->count($idU);
           $commandes =null;
            $query = $em->createQuery("
            SELECT DISTINCT c.idCmd,c.modeP,c.lieuLiv,c.montant, c.etatCmd  FROM CommandeBundle:Commande c where c.idClient='$idU'");
            $commandes = $query->getResult();
        }

        return $this->render('@Commande/commande/listcmd.html.twig', array(
            'commandes' => $commandes,'count'=>$count,'countf'=>$countf
        ));
    }

    public function showppAction(Commande $commande)
    {

        $em  = $this->getDoctrine()->getManager();


        $nbrP=$em->getRepository('CommandeBundle:Produit')->listProductById($commande->getIdCmd());



        $client=$em->getRepository('CommandeBundle:Produit')->getIdclient($commande->getIdCmd());


        return $this->render('@Commande/commande/show.html.twig', array(
            'commande' => $commande,'nbrP0'=>$nbrP,'client'=>$client
           ));

    }

    public function invoiceAction(Commande $commande)
    {

        $em  = $this->getDoctrine()->getManager();


        $nbrP=$em->getRepository('CommandeBundle:Produit')->listProductById($commande->getIdCmd());



        $client=$em->getRepository('CommandeBundle:Produit')->getIdclient($commande->getIdCmd());

        $html = $this->renderView('@Commande/commande/invoice.html.twig', array(
           'commande' => $commande,'nbrP0'=>$nbrP,'client'=>$client
        ));

        return new PdfResponse(
            $this->get('knp_snappy.pdf')->getOutputFromHtml($html),
            'file.pdf'
        );

    }

    public function panierAction()
    {

        $em  = $this->getDoctrine()->getManager();

        $user = $this->get('security.token_storage')->getToken()->getUser();

        if ($user=="anon.")
        {$idU=0;
            $lcmd=$em->getRepository('CommandeBundle:LigneCmd')->listProductPanieranon();
            $count=$em->getRepository('CommandeBundle:LigneCmd')->contano();
            $countf=$em->getRepository('ProduitBundle:Favoris')->count($idU);
        }else {
            $idU=$user->getId();
            $lcmd=$em->getRepository('CommandeBundle:LigneCmd')->listProductPanier($idU);
            $count=$em->getRepository('CommandeBundle:LigneCmd')->cont($idU);
            $countf=$em->getRepository('ProduitBundle:Favoris')->count($idU);
        }
        return $this->render('@Commande/commande/panier.html.twig', array(
           'lcmd'=>$lcmd,'count'=>$count,'id'=>$idU,'countf'=>$countf
            ));

    }

    /**
     * @Security("has_role('ROLE_USER')")
     */
    public function finalAction(Request $request)
    {$em  = $this->getDoctrine()->getManager();


        $user = $this->get('security.token_storage')->getToken()->getUser();

        if ($user=="anon.")
        {
        }
        else {
            $idU=$user->getId();
            $lcmd=$em->getRepository('CommandeBundle:LigneCmd')->listProductPanier($idU);
            $count=$em->getRepository('CommandeBundle:LigneCmd')->cont($idU);
            $tot=$em->getRepository('CommandeBundle:LigneCmd')->getTot($idU);
            $countf=$em->getRepository('ProduitBundle:Favoris')->count($idU);

        }

        if ($request->isMethod('POST')) {

            $user->setAdresse($request->get('adresse'));
            $user->setSexe($request->get('sexe'));
            $em->persist($user);
            $em->flush();
        }
        $remise=0;

        return $this->render('@Commande/commande/finaliser.html.twig', array(
            'lcmd'=>$lcmd,'count'=>$count,'id'=>$idU,'user'=>$user, 'tot'=>$tot,'remise'=>$remise,'countf'=>$countf
        ));


    }

    public function couponAction(Request $request)
    {
        $em  = $this->getDoctrine()->getManager();

        $user = $this->get('security.token_storage')->getToken()->getUser();


            $idU=$user->getId();
            $lcmd=$em->getRepository('CommandeBundle:LigneCmd')->listProductPanier($idU);
            $count=$em->getRepository('CommandeBundle:LigneCmd')->cont($idU);
            $tot=$em->getRepository('CommandeBundle:LigneCmd')->getTot($idU);
            $countf=$em->getRepository('ProduitBundle:Favoris')->count($idU);



        if ($request->isMethod('POST')) {
            $coupon=$request->get('coupon');
            $idU=$user->getId();
            $exist=$em->getRepository('CommandeBundle:Coupon')->coupon($coupon);
            $remise = 0;
            if($exist) {
                $used = $exist[0]['used'];
                if ($used == 0) {
                    $remise = $exist[0]['remise'];
                    $q = $em->createQuery('
                  UPDATE CommandeBundle:LigneCmd lcm
                SET lcm.montant=lcm.montant-( :remise * lcm.montant)
                WHERE lcm.idClient = :idClient')
                        ->setParameter('remise', $remise)
                        ->setParameter('idClient', $idU);
                    $p = $q->execute();

                    /***/
                    $servername = "localhost";
                    $username = "root";
                    $password = "";
                    $dbname = "pepiniere";
                    $conn = new mysqli($servername, $username, $password, $dbname);
                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }

                    $sql3 = " UPDATE ligne_cmd lcm SET lcm.montant= TRUNCATE(lcm.montant,3) WHERE id_client='$idU'";
                    $conn->query($sql3);
                    $conn->close();
                    /*****/

                    $code = $exist[0]['code'];
                    $q1 = $em->createQuery('
                UPDATE CommandeBundle:Coupon coup
                SET coup.used=1 WHERE coup.code = :code')
                        ->setParameter('code', $code);
                    $p2 = $q1->execute();
                    $tot = $em->getRepository('CommandeBundle:LigneCmd')->getTot($idU);
                }
            }
            //$tot=$em->getRepository('CommandeBundle:LigneCmd')->getTot($idU);

        }
        return $this->render('@Commande/commande/finaliser.html.twig', array(
            'lcmd'=>$lcmd,'count'=>$count,'id'=>$idU,'user'=>$user, 'tot'=>$tot,'remise'=>$remise,'countf'=>$countf
        ));
    }

    public function delpanierAction( LigneCmd $ligneCmd)
    {

            $em = $this->getDoctrine()->getManager();

            $em->remove($ligneCmd);
            $em->flush();


        return $this->redirectToRoute('commande_panier');
    }

    public function ajouterAction( $idProduit)
    {  $em = $this->getDoctrine()->getManager();
        $lcmd= new LigneCmd();
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $prix = $em->getRepository('CommandeBundle:Produit')->getprix($idProduit);
        if ($user=="anon.")
        { $exist = $em->getRepository('CommandeBundle:LigneCmd')->checkcmd($idProduit, 0);

            if (!$exist) {

                $lcmd->setIdProduit($idProduit);
                $lcmd->setMontant($prix);
                $lcmd->setQuantite(1);
                $lcmd->setIdClient(0);
                $em->persist($lcmd);
                $em->flush();
                $q3 = $em->createQuery('
                UPDATE CommandeBundle:Produit p
                SET p.quantite=p.quantite-1
                WHERE p.idProduit = :idProduit')
                    ->setParameter('idProduit',$idProduit);
                $q3->execute();
            }
            else {
                $q = $em->createQuery('
                UPDATE CommandeBundle:LigneCmd lcm
                SET lcm.quantite=lcm.quantite+1
                WHERE lcm.idProduit = :idProduit')
                    ->setParameter('idProduit', $idProduit);
                $p = $q->execute();
                $q2 = $em->createQuery('
                UPDATE CommandeBundle:LigneCmd as lcmd  
                SET lcmd.montant=lcmd.quantite * :prix WHERE lcmd.idProduit = :idProduit
                ')
                    ->setParameter('prix',$prix)
                    ->setParameter('idProduit',$idProduit);
                $p2 = $q2->execute();
                $q3 = $em->createQuery('
                UPDATE CommandeBundle:Produit p
                SET p.quantite=p.quantite-1
                WHERE p.idProduit = :idProduit')
                    ->setParameter('idProduit',$idProduit);
                $q3->execute();

            }

        }
        else {
            $idU = $user->getId();
            $exist = $em->getRepository('CommandeBundle:LigneCmd')->checkcmd($idProduit, $idU);
            if (!$exist) {

                $lcmd->setIdProduit($idProduit);
                $lcmd->setMontant($prix);
                $lcmd->setQuantite(1);
                $lcmd->setIdClient($idU);
                $em->persist($lcmd);
                $em->flush();

            } else {
                $q = $em->createQuery('
                UPDATE CommandeBundle:LigneCmd lcm
                SET lcm.quantite=lcm.quantite+1
                WHERE lcm.idProduit = :idProduit')
                    ->setParameter('idProduit', $idProduit);


                $p = $q->execute();
                $q2 = $em->createQuery('
                UPDATE CommandeBundle:LigneCmd as lcmd  
                SET lcmd.montant=lcmd.quantite * :prix WHERE lcmd.idProduit = :idProduit
                ')
                    ->setParameter('prix',$prix)
                    ->setParameter('idProduit',$idProduit);
                $p2 = $q2->execute();

                $p2 = $q2->execute();
                $q3 = $em->createQuery('
                UPDATE CommandeBundle:Produit p
                SET p.quantite=p.quantite-1
                WHERE p.idProduit = :idProduit')
                    ->setParameter('idProduit',$idProduit);
                $q3->execute();

            }
        }

        return $this->redirectToRoute('produit_indexfront');
        //return $this->render('@Commande/commande/new.html.twig');

    }

    public function addqteAction($idProduit)
    {
        $em = $this->getDoctrine()->getManager();
        $quantite=$em->getRepository('CommandeBundle:Produit')->getQteprod($idProduit);
        $quantitel=$em->getRepository('CommandeBundle:Produit')->getQte($idProduit);
        if ($quantite>=1 && $quantitel<=$quantite)
        {
        $q = $em->createQuery('
                UPDATE CommandeBundle:LigneCmd lcm
                SET lcm.quantite=lcm.quantite+1
                WHERE lcm.idProduit = :idProduit')
            ->setParameter('idProduit',$idProduit);
        $p = $q->execute();

        $prix=$em->getRepository('CommandeBundle:Produit')->getprix($idProduit);
        $q2 = $em->createQuery('
                UPDATE CommandeBundle:LigneCmd as lcmd  
                SET lcmd.montant=lcmd.quantite * :prix WHERE lcmd.idProduit = :idProduit
                ')
            ->setParameter('prix',$prix)
            ->setParameter('idProduit',$idProduit);
        $p2 = $q2->execute();

        $q3 = $em->createQuery('
                UPDATE CommandeBundle:Produit p
                SET p.quantite=p.quantite-1
                WHERE p.idProduit = :idProduit')
            ->setParameter('idProduit',$idProduit);
       $q3->execute();
        }


        return $this->redirectToRoute('commande_panier');

    }

    public function delqteAction($idProduit)
    {
        $em = $this->getDoctrine()->getManager();
        $qte=$em->getRepository('CommandeBundle:LigneCmd')->getQte($idProduit);
        if ($qte>1){
        $q = $em->createQuery('
                UPDATE CommandeBundle:LigneCmd lcm
                SET lcm.quantite=lcm.quantite-1
                WHERE lcm.idProduit = :idProduit')
            ->setParameter('idProduit',$idProduit);

        $p = $q->execute();

            $prix=$em->getRepository('CommandeBundle:Produit')->getprix($idProduit);
            echo $prix."";
            $q2 = $em->createQuery('
                UPDATE CommandeBundle:LigneCmd as lcmd  
                SET lcmd.montant=lcmd.quantite * :prix WHERE lcmd.idProduit = :idProduit
                ')
                ->setParameter('prix',$prix)
                ->setParameter('idProduit',$idProduit);
            $p2 = $q2->execute();

            $q3 = $em->createQuery('
                UPDATE CommandeBundle:Produit p
                SET p.quantite=p.quantite+1
                WHERE p.idProduit = :idProduit')
                ->setParameter('idProduit',$idProduit);
            $q3->execute();
        }


        return $this->redirectToRoute('commande_panier');

    }


    public function editAction(Request $request, Commande $commande)
    {
        $deleteForm = $this->createDeleteForm($commande);
        $em  = $this->getDoctrine()->getManager();
        $editForm = $this->createForm('CommandeBundle\Form\CommandeType', $commande);
        $editForm->handleRequest($request);

        $qte=$em->getRepository('CommandeBundle:Produit')->setQte($commande->getIdCmd());

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            if($commande->getEtatCmd()=='Livrés')
            {
                $idU=$commande->getIdClient();
                $user = $em->getRepository('CommandeBundle:User')->find($idU);


                $message =  \Swift_Message::newInstance('Votre commande et Livrés')
                    ->setFrom('sunflower.thesquad@gmail.com')
                    ->setTo($user->getEmail())
                    ->setBody(  $this->renderView('@Commande/commande/emailliv.html.twig',['user' => $user]),'text/html');
                $this->get('mailer')->send($message);


            }
            elseif ($commande->getEtatCmd()=='Annuler')
            {
                    $idU=$commande->getIdClient();
                    $user = $em->getRepository('CommandeBundle:User')->find($idU);

                    $message =  \Swift_Message::newInstance('Annulation du commande')
                        ->setFrom('sunflower.thesquad@gmail.com')
                        //->setTo($user->getEmail())
                        ->setTo($user->getEmail())
                        ->setBody(  $this->renderView('@Commande/commande/emailannuler.html.twig',['user' => $user]),'text/html');
                    $this->get('mailer')->send($message);

            }
            elseif ($commande->getEtatCmd()=='En cours')
            {
                $idU=$commande->getIdClient();
                $user = $em->getRepository('CommandeBundle:User')->find($idU);

                $message =  \Swift_Message::newInstance('Votre commande est en cours de livraison')
                    ->setFrom('sunflower.thesquad@gmail.com')
                    //->setTo($user->getEmail())
                    ->setTo($user->getEmail())
                    ->setBody(  $this->renderView('@Commande/commande/emailconf.html.twig',['user' => $user]),'text/html');
                $this->get('mailer')->send($message);

            }

            return $this->redirectToRoute('commande_edit', array('idCmd' => $commande->getIdcmd()));
        }

        return $this->render('@Commande/commande/edit.html.twig', array(
            'commande' => $commande,'qte'=>$qte,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }


    public function deleteAction(Request $request, Commande $commande)
    {
        $form = $this->createDeleteForm($commande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($commande);
            $em->flush();
        }

        return $this->redirectToRoute('commande_index');
    }

    public function deletePAction(Request $request, LigneCmd $commande)
    {
        $form = $this->createDeleteForm($commande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($commande);
            $em->flush();
        }

        return $this->redirectToRoute('commande_panier');
    }



    /**
     * Creates a form to delete a commande entity.
     *
     * @param Commande $commande The commande entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Commande $commande)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('commande_delete', array('idCmd' => $commande->getIdcmd())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

}
