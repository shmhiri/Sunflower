<?php
/**
 * Created by PhpStorm.
 * User: starmedia
 * Date: 07/04/2019
 * Time: 17:23
 */

namespace PromotionBundle\Repository;
use Doctrine\ORM\EntityRepository;


class PromotionRepository extends EntityRepository
{

    public function listsp($id)
    {
        $query=$this->getEntityManager()->createQuery("select p from PromotionBundle:Promotion p where p.idAgent='$id'");
        return $query->getResult();
    }

    public function lists($id)
    {
        $query=$this->getEntityManager()->createQuery("select p from PromotionBundle:Produit p where p.idAgent='$id'");
        return $query->getResult();
    }

    public function listss($id)
    {
        $query=$this->getEntityManager()->createQuery("select p.idProduit as idProduit from PromotionBundle:Produit p where p.idAgent='$id'");
        return $query->getResult();
    }

    public function rechimg($id)
    {
        $query=$this->getEntityManager()->createQuery("select p.image as image from PromotionBundle:Produit p where p.idProduit='$id'");
        return $query->getSingleScalarResult();
    }



}