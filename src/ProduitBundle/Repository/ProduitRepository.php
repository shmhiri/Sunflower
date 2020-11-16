<?php
/**
 * Created by PhpStorm.
 * User: beerus
 * Date: 05/04/2019
 * Time: 23:54
 */

namespace ProduitBundle\Repository;
use Doctrine\ORM\EntityRepository;
use ProduitBundle\Entity\User;

class ProduitRepository extends EntityRepository
{

    public function listProduitByCategorie($idC)
    {
        $query = $this->getEntityManager()->createQuery
        ("select p from ProduitBundle:Produit p where p.idCategorie=$idC");
        return $query->getResult();

    }

    public function listProduitofthisuser($idU)
    {
        $query = $this->getEntityManager()->createQuery
        ("select p from ProduitBundle:Produit p where p.idAgent=$idU");
        return $query->getResult();
    }

    public function getnom_type_categ($idCateg)
    {
        $query = $this->getEntityManager()->createQuery
        ("select c.nomCategorie,c.type from ProduitBundle:CategorieProduit c where c.idCategorie='$idCateg'");
        return $query->getSingleResult();
    }

    public function sortbyprixasc()
    {
        $query = $this->getEntityManager()
            ->createQuery("SELECT p FROM ProduitBundle:Produit p order by p.prix  ");

        return $query->getResult();
    }

    public function sortbyprixdsc()
{
    $query = $this->getEntityManager()
        ->createQuery("SELECT p FROM ProduitBundle:Produit p order by p.prix desc ");

    return $query->getResult();
}

    public function sortbynameasc()
    {
        $query = $this->getEntityManager()
            ->createQuery("SELECT p FROM ProduitBundle:Produit p order by p.nomProduit  ");

        return $query->getResult();
    }

    public function sortbynamedsc()
{
    $query = $this->getEntityManager()
        ->createQuery("SELECT p FROM ProduitBundle:Produit p order by p.nomProduit desc ");

    return $query->getResult();
}





}