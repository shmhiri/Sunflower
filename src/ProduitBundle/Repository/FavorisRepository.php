<?php
/**
 * Created by PhpStorm.
 * User: beerus
 * Date: 13/04/2019
 * Time: 02:12
 */

namespace ProduitBundle\Repository;


use Doctrine\ORM\EntityRepository;

class FavorisRepository extends EntityRepository
{
    public function checkfav($idproduit,$iduser)
    {
        $query = $this->getEntityManager()->createQuery
        ("select f from ProduitBundle:Favoris f where f.idProduit='$idproduit' AND f.idClient='$iduser'");
        return $query->getResult();
    }

    public function listFavorisofthisuser($idU)
    {
        $query = $this->getEntityManager()->createQuery
        ("select p.nomProduit,p.description ,f.disponibilite,f.idFavoris,p.image,p.idProduit from ProduitBundle:Favoris f,ProduitBundle:Produit p where f.idClient=$idU and p.idProduit =f.idProduit");
        return $query->getResult();
    }

    public function count($id)
    {
        $query = $this->getEntityManager()->createQuery
        ("SELECT COUNT(f.idFavoris) FROM ProduitBundle:Favoris f where f.idClient='$id'");
        return $query->getSingleScalarResult();
    }


}
