<?php
/**
 * Created by PhpStorm.
 * User: starmedia
 * Date: 09/04/2019
 * Time: 13:33
 */

namespace EvenementBundle\Repository;


use Doctrine\ORM\EntityRepository;

class ParticiperRepository extends EntityRepository
{

    public function rechercheparticiper($id)
    {
        $query = $this->getEntityManager()->createQuery("select count(e.idParticiper) from EvenementBundle:Participer e where e.idUser='$id'  ");
        return $query->getSingleScalarResult();
    }
    public function rechercheparticiperideve($id)
    {
        $query = $this->getEntityManager()->createQuery("select count(e.idParticiper) from EvenementBundle:Participer e where e.idEvenement='$id'  ");
        return $query->getSingleScalarResult();
    }
    public function rechercheparticiperid($id,$iduser)
    {
        $query = $this->getEntityManager()->createQuery("select count(e.idParticiper) from EvenementBundle:Participer e where e.idUser='$id' and e.idEvenement='$iduser'  ");
        return $query->getSingleScalarResult();
    }
    public function rechercheparticiperidd($iduser,$ideve)
    {
        $query = $this->getEntityManager()->createQuery("select e.idParticiper as idParticiper  from EvenementBundle:Participer e where e.idUser='$iduser' and e.idEvenement='$ideve'  ");
        return $query->getSingleScalarResult();
    }

    public function joinparticiper($idEvenement)
    {
        $query = $this->getEntityManager()->createQuery("select e.nom  as nom,e.prenom as prenom,e.sexe as sexe,e.dateDeNaissance as dateDeNaissance,e.adresse as adresse,e.email as email  from EvenementBundle:User e where e.id in(select  IDENTITY(p.idUser) from EvenementBundle:Participer p where p.idEvenement='$idEvenement'  ) ");
        return $query->getResult();
    }


}