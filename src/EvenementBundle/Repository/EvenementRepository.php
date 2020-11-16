<?php
/**
 * Created by PhpStorm.
 * User: starmedia
 * Date: 08/04/2019
 * Time: 16:04
 */

namespace EvenementBundle\Repository;

use Doctrine\ORM\EntityRepository;


class EvenementRepository extends EntityRepository
{

//STAT TOUt LES EVE
    public function countlists()
    {
        $query = $this->getEntityManager()->createQuery("select count(e.idEvenement) from EvenementBundle:Evenement e");
        return $query->getSingleScalarResult();
    }

    public function countliststypeanimation()
    {
        $query = $this->getEntityManager()->createQuery("select count(e.idEvenement) from EvenementBundle:Evenement e where e.type= 'animation' ");
        return $query->getSingleScalarResult();
    }
    public function countliststypecompetition()
    {
        $query = $this->getEntityManager()->createQuery("select count(e.idEvenement) from EvenementBundle:Evenement e where e.type= 'competition' ");
        return $query->getSingleScalarResult();
    }
    public function countliststypevisite()
    {
        $query = $this->getEntityManager()->createQuery("select count(e.idEvenement) from EvenementBundle:Evenement e where e.type= 'visite guide' ");
        return $query->getSingleScalarResult();
    }
    public function countliststypedatecours()
    {
        $query = $this->getEntityManager()->createQuery("select count(e.idEvenement) from EvenementBundle:Evenement e where e.dateDebut < CURRENT_DATE() and e.dateFin > CURRENT_DATE()  ");
        return $query->getSingleScalarResult();
    }
    public function countliststypedateexpirer()
    {
        $query = $this->getEntityManager()->createQuery("select count(e.idEvenement) from EvenementBundle:Evenement e where e.dateFin < CURRENT_DATE()  ");
        return $query->getSingleScalarResult();
    }


//STAT USER CONNECTE EVE
    public function countlistsuser($id)
    {
        $query = $this->getEntityManager()->createQuery("select count(e.idEvenement) from EvenementBundle:Evenement e where e.idAdmin='$id'");
        return $query->getSingleScalarResult();
    }
    public function countliststypeanimationuser($id)
    {
        $query = $this->getEntityManager()->createQuery("select count(e.idEvenement) from EvenementBundle:Evenement e where e.type= 'animation' and e.idAdmin='$id' ");
        return $query->getSingleScalarResult();
    }
    public function countliststypecompetitionuser($id)
    {
        $query = $this->getEntityManager()->createQuery("select count(e.idEvenement) from EvenementBundle:Evenement e where e.type= 'competition' and e.idAdmin='$id' ");
        return $query->getSingleScalarResult();
    }
    public function countliststypevisiteuser($id)
    {
        $query = $this->getEntityManager()->createQuery("select count(e.idEvenement) from EvenementBundle:Evenement e where e.type= 'visite guide' and e.idAdmin='$id' ");
        return $query->getSingleScalarResult();
    }
    public function countliststypedatecoursuser($id)
    {
        $query = $this->getEntityManager()->createQuery("select count(e.idEvenement) from EvenementBundle:Evenement e where e.dateDebut < CURRENT_DATE() and e.dateFin > CURRENT_DATE() and e.idAdmin='$id'  ");
        return $query->getSingleScalarResult();
    }
    public function countliststypedateexpireruser($id)
    {
        $query = $this->getEntityManager()->createQuery("select count(e.idEvenement) from EvenementBundle:Evenement e where e.dateFin < CURRENT_DATE() and e.idAdmin='$id'  ");
        return $query->getSingleScalarResult();
    }


    //STAT TOUT LES PRO
    public function countlistspro()
    {
        $query = $this->getEntityManager()->createQuery("select count(e.idPromotion) from PromotionBundle:Promotion e");
        return $query->getSingleScalarResult();
    }
    public function countliststypedatecourspro()
    {
        $query = $this->getEntityManager()->createQuery("select count(e.idPromotion) from PromotionBundle:Promotion e where e.dateDebut < CURRENT_DATE() and e.dateFin > CURRENT_DATE()  ");
        return $query->getSingleScalarResult();
    }
    public function countliststypedateexpirerpro()
    {
        $query = $this->getEntityManager()->createQuery("select count(e.idPromotion) from PromotionBundle:Promotion e where e.dateFin < CURRENT_DATE()  ");
        return $query->getSingleScalarResult();
    }


    //STAT USER CONNECTE PRO
    public function countlistsuserpro($id)
    {
        $query = $this->getEntityManager()->createQuery("select count(e.idPromotion) from PromotionBundle:Promotion e where e.idAgent='$id'");
        return $query->getSingleScalarResult();
    }
    public function countliststypedatecoursuserpro($id)
    {
        $query = $this->getEntityManager()->createQuery("select count(e.idPromotion) from PromotionBundle:Promotion e where e.dateDebut < CURRENT_DATE() and e.dateFin > CURRENT_DATE() and e.idAgent='$id'  ");
        return $query->getSingleScalarResult();
    }
    public function countliststypedateexpireruserpro($id)
    {
        $query = $this->getEntityManager()->createQuery("select count(e.idPromotion) from PromotionBundle:Promotion e where e.dateFin < CURRENT_DATE() and e.idAgent='$id'  ");
        return $query->getSingleScalarResult();
    }

    //select tout les eve d'un user connecte
    public function listeve($id)
    {
        $query = $this->getEntityManager()->createQuery("select e from EvenementBundle:Evenement e where e.idAdmin='$id'  ");
        return $query->getResult();
    }


}
