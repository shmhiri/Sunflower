<?php
/**
 * Created by PhpStorm.
 * User: gazzah
 * Date: 4/5/2019
 * Time: 11:00 AM
 */

namespace CommandeBundle\Repository;
use Doctrine\ORM\EntityRepository;



class CommandeRepository extends EntityRepository
{
    public function listProductById($idcmd)
    {
        $query = $this->getEntityManager()->createQuery("select p.nomProduit, p.prix ,p.description, p.image, c.qte,p.idProduit from CommandeBundle:Commande c, CommandeBundle:Produit p where p.idProduit = c.idProduit AND c.idCmd=$idcmd");
        return $query->getResult();
    }

    public function getIdclient($idcmd)
    {
        $query = $this->getEntityManager()->createQuery("select u.nom, u.prenom, u.email, u.sexe from CommandeBundle:User u where u.id in (select c.idClient from CommandeBundle:Commande c where c.idCmd='$idcmd')");
        return $query->getResult();
    }

    public function setQte($idcmd)
    {
        $query = $this->getEntityManager()->createQuery("update CommandeBundle:Produit p set p.quantite=p.quantite-1 where p.idProduit in (select c.idProduit from CommandeBundle:Commande c where c.idCmd='$idcmd')");
        return $query->getResult();
    }

    public function contano()
    {
        $query = $this->getEntityManager()->createQuery("SELECT COUNT(l.idLigneCmd) FROM CommandeBundle:LigneCmd l where l.idClient=0");
        return $query->getSingleScalarResult();
    }

    public function cont($id)
    {
        $query = $this->getEntityManager()->createQuery("SELECT COUNT(l.idLigneCmd) FROM CommandeBundle:LigneCmd l where l.idClient='$id'");
        return $query->getSingleScalarResult();
    }

    public function listProductPanier($id)
    {
        $query = $this->getEntityManager()->createQuery("select p.nomProduit, p.prix ,p.description, p.image, c.quantite,c.idLigneCmd,c.idProduit from CommandeBundle:LigneCmd c, CommandeBundle:Produit p where p.idProduit = c.idProduit and c.idClient='$id'");
        return $query->getResult();
    }

    public function listProductPanieranon()
    {
        $query = $this->getEntityManager()->createQuery("select p.nomProduit, p.prix ,p.description, p.image, c.quantite,c.idLigneCmd,c.idProduit from CommandeBundle:LigneCmd c, CommandeBundle:Produit p where p.idProduit = c.idProduit and c.idClient=0");
        return $query->getResult();
    }


    public function prodInfo($idProduit)
    {
        $query = $this->getEntityManager()->createQuery("select p from CommandeBundle:Produit p where p.idProduit ='$idProduit'");
        return $query->getResult();
    }

    public function idUser($email)
    {
        $query = $this->getEntityManager()->createQuery("select id from CommandeBundle:User where email ='$email'");
        return $query->getSingleScalarResult();
    }

    public function checkcmd($idproduit,$idU)
    {
        $query = $this->getEntityManager()->createQuery("select lcmd from CommandeBundle:LigneCmd lcmd where lcmd.idProduit='$idproduit' and lcmd.idClient='$idU'");
        return $query->getResult();
    }

    public function updatelcmd($idproduit)
    {
        $query = $this->getEntityManager()->createQuery("
update CommandeBundle:LigneCmd lcmd ,CommandeBundle:Produit p set lcmd.quantite=lcmd.quantite+1 where lcmd.idProduit='$idproduit';
update CommandeBundle:LigneCmd lcmd ,CommandeBundle:Produit p set lcmd.montant=p.prix*lcmd.quantite  where p.idProduit='$idproduit'");
        return $query->execute();
    }

    public function getQte($idProduit)
    {
        $query = $this->getEntityManager()->createQuery("select lcmd.quantite from CommandeBundle:LigneCmd lcmd where lcmd.idProduit='$idProduit'");
        return $query->getSingleScalarResult();
    }

    public function getQteprod($idProduit)
    {
        $query = $this->getEntityManager()->createQuery("select lcmd.quantite from CommandeBundle:Produit lcmd where lcmd.idProduit='$idProduit'");
        return $query->getSingleScalarResult();
    }
    public function getprix($idProduit)
    {
        $query = $this->getEntityManager()->createQuery("select p.prix from CommandeBundle:Produit p where p.idProduit ='$idProduit'");
        return $query->getSingleScalarResult();
    }

    public function coupon($coupon)
    {
        $query = $this->getEntityManager()->createQuery("select c.code,c.remise,c.used from CommandeBundle:Coupon c where c.code ='$coupon'");
        return $query->getResult();
    }

    public function getTot($idClient)
    {
        $query = $this->getEntityManager()->createQuery("select sum(lcmd.montant) from CommandeBundle:LigneCmd lcmd where lcmd.idClient='$idClient'");
        return $query->getSingleScalarResult();
    }


    public function listcmdlivre()
    {
        $query = $this->getEntityManager()->createQuery("select count(c) from CommandeBundle:Commande c  where c.etatCmd='Livrés' ");
        return $query->getSingleScalarResult();
    }

    public function listcmdenattent()
    {
        $query = $this->getEntityManager()->createQuery("select count(c) from CommandeBundle:Commande c  where c.etatCmd='En attente' ");
        return $query->getSingleScalarResult();
    }

    public function listcmdannuler()
    {
        $query = $this->getEntityManager()->createQuery("select count(c) from CommandeBundle:Commande c  where c.etatCmd='Annuler' ");
        return $query->getSingleScalarResult();
    }

    public function listcmdencour()
    {
        $query = $this->getEntityManager()->createQuery("select count(c) from CommandeBundle:Commande c  where c.etatCmd='En cours' ");
        return $query->getSingleScalarResult();
    }
    public function listAllcmd()
    {
        $query = $this->getEntityManager()->createQuery("select count(c) from CommandeBundle:Commande c ");
        return $query->getSingleScalarResult();
    }
}