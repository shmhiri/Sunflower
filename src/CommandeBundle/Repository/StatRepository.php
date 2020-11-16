<?php
/**
 * Created by PhpStorm.
 * User: gazzah
 * Date: 4/16/2019
 * Time: 5:03 PM
 */

namespace CommandeBundle\Repository;


class StatRepository
{
    public function listcmdlivre()
    {
        $query = $this->getEntityManager()->createQuery("select count(c.etat) from CommandeBundle:Commande c  where c.etat='En attente' ");
        return $query->getResult();
    }

    public function listcmdenattent()
    {
        $query = $this->getEntityManager()->createQuery("select count(c.etat) from CommandeBundle:Commande c  where c.etat='En attente' ");
        return $query->getResult();
    }

    public function listcmdannuler()
    {
        $query = $this->getEntityManager()->createQuery("select count(c.etat) from CommandeBundle:Commande c  where c.etat='En attente' ");
        return $query->getResult();
    }

    public function listcmdencour()
    {
        $query = $this->getEntityManager()->createQuery("select count(c.etat) from CommandeBundle:Commande c  where c.etat='En attente' ");
        return $query->getResult();
    }
}