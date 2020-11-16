<?php
/**
 * Created by PhpStorm.
 * User: gazzah
 * Date: 4/5/2019
 * Time: 11:00 AM
 */

namespace ServiceBundle\Repository;
use Doctrine\ORM\EntityRepository;



class ServiceRepository extends EntityRepository
{
    public function listServiceById($idservice)
    {
        $query = $this->getEntityManager()->createQuery("select S.nomService, S.prix ,S.description, S.image, S.region,S.idService from ServiceBundle:Service S, CommandeBundle:Produit p where p.idProduit = c.idProduit AND c.idCmd=$idservice");
        return $query->getResult();
    }

    public function getIdclient($idcmd)
    {
        $query = $this->getEntityManager()->createQuery("select u.nom, u.prenom, u.email from CommandeBundle:User u where u.id_user in (select c.idClient from CommandeBundle:Commande c where c.idCmd='$idcmd')");
        return $query->getResult();
    }

    public function setQte($idcmd)
    {
        $query = $this->getEntityManager()->createQuery("update CommandeBundle:Produit p set p.quantite=p.quantite-1 where p.idProduit in (select c.idProduit from CommandeBundle:Commande c where c.idCmd='$idcmd')");
        return $query->getResult();
    }

    public function cont()
    {
        $query = $this->getEntityManager()->createQuery("SELECT COUNT(l.idLigneCmd) FROM CommandeBundle:LigneCmd l");
        return $query->getSingleScalarResult();
    }

    public function listProductPanier()
    {
        $query = $this->getEntityManager()->createQuery("select p.nomProduit, p.prix ,p.description, p.image, c.quantite,c.idLigneCmd from CommandeBundle:LigneCmd c, CommandeBundle:Produit p where p.idProduit = c.idProduit");
        return $query->getResult();
    }
    public function prodInfo($idProduit)
    {
        $query = $this->getEntityManager()->createQuery("select p from CommandeBundle:Produit p where p.idProduit ='$idProduit'");
        return $query->getResult();
    }

    public function idUser($email)
    {
        $query = $this->getEntityManager()->createQuery("select id_user from CommandeBundle:User where email ='$email'");
        return $query->getSingleScalarResult();
    }


}