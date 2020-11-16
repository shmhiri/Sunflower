<?php
/**
 * Created by PhpStorm.
 * User: achraf
 * Date: 07/04/2019
 * Time: 21:09
 */

namespace CommandeBundle\Repository;
use Doctrine\ORM\EntityRepository;



class SujetRepository extends EntityRepository
{
    public function listCommentBySujet($idSuj)
    {
        $query = $this->getEntityManager()->createQuery("select c from ForumBundle:Commentaire c where c.idSujet=$idSuj");
        return $query->getResult();
    }

    public function getSujetById($idSuj)
    {

        $query = $this->getEntityManager()->createQuery("select s from ForumBundle:Sujet s where s.idSujet=$idSuj");
        return $query->getResult();
    }

    public function recupNbrVueById($idSujet)
    {
        $query = $this->getEntityManager()->createQuery("select s.nbrVue from ForumBundle:Sujet s where s.idSujet='$idSujet'");
        return $query->getResult();
    }

    public function listSujetByCategorie($idCat)
    {
        $query = $this->getEntityManager()->createQuery("select s from ForumBundle:Sujet s where s.idCategorieSujet=$idCat");
        return $query->getResult();
    }

    public function recupCategById($nomCat)
    {
        $query = $this->getEntityManager()->createQuery("select c.idCategorieSujet from ForumBundle:CategorieSujet c where c.nomCategorieSujet='$nomCat'");
        return $query->getResult();
    }


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////Partie Statistique//////////////////////////////////////////////////////////////
/// //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function countSujetTotal()
    {
        $query = $this->getEntityManager()->createQuery("SELECT COUNT(s.idSujet) FROM ForumBundle:Sujet s ");
        return $query->getSingleScalarResult();
    }
    public function countliststypeentretien()
    {
        $query = $this->getEntityManager()->createQuery("select count(s.idSujet) from ForumBundle:Sujet s where s.type= 'Entretien' ");
        return $query->getSingleScalarResult();
    }

    public function countliststypeplantation()
    {
        $query = $this->getEntityManager()->createQuery("select count(s.idSujet) from ForumBundle:Sujet s where s.type= 'Plantation' ");
        return $query->getSingleScalarResult();
    }

    public function countliststypeconseils()
    {
        $query = $this->getEntityManager()->createQuery("select count(s.idSujet) from ForumBundle:Sujet s where s.type= 'Conseils' ");
        return $query->getSingleScalarResult();
    }


    public function countNbrVueSujetTotal()
    {
        $query = $this->getEntityManager()->createQuery("SELECT SUM(s.nbrVue) FROM ForumBundle:Sujet s ");
        return $query->getSingleScalarResult();
    }

    public function affichNomSujetMaxnbrVue()
    {
        $query = $this->getEntityManager()
                      ->createQuery
("SELECT s.nomSujet,s.nbrVue FROM ForumBundle:Sujet s WHERE s.nbrVue=(SELECT MAX(sm.nbrVue) FROM ForumBundle:Sujet sm )");

        return $query->getResult();
    }

    public function affichNomSujetMinnbrVue()
    {
        $query = $this->getEntityManager()
            ->createQuery
            ("SELECT s.nomSujet,s.nbrVue FROM ForumBundle:Sujet s WHERE s.nbrVue=(SELECT MIN(sm.nbrVue) FROM ForumBundle:Sujet sm )");

        return $query->getResult();
    }



///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////Partie Tri//////////////////////////////////////////////////////////////
/// //////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    public function triNomASC()
    {
        $query=$this->getEntityManager()->createQuery("SELECT s FROM ForumBundle:Sujet s ORDER BY s.nomSujet ");
        return $query->getResult();
    }
    public function triNomDSC()
    {
        $query=$this->getEntityManager()->createQuery("SELECT s FROM ForumBundle:Sujet s ORDER BY s.nomSujet DESC");
        return $query->getResult();
    }
    public function trinbrVASC()
    {
        $query=$this->getEntityManager()->createQuery("SELECT s FROM ForumBundle:Sujet s ORDER BY s.nbrVue ");
        return $query->getResult();
    }
    public function trinbrVDSC()
    {
        $query=$this->getEntityManager()->createQuery("SELECT s FROM ForumBundle:Sujet s ORDER BY s.nbrVue DESC");
        return $query->getResult();
    }











}