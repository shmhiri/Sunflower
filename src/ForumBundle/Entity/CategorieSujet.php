<?php

namespace ForumBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CategorieSujet
 *
 * @ORM\Table(name="categorie_sujet")
 * @ORM\Entity(repositoryClass="ForumBundle\Repository\SujetRepository") */
class CategorieSujet
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_categorie_sujet", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idCategorieSujet;

    /**
     * @var string
     *
     * @ORM\Column(name="nom_categorie_sujet", type="string", length=255, nullable=true)
     */
    private $nomCategorieSujet;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255, nullable=true)
     */
    private $type;

    /**
     * @return int
     */
    public function getIdCategorieSujet()
    {
        return $this->idCategorieSujet;
    }

    /**
     * @param int $idCategorieSujet
     */
    public function setIdCategorieSujet($idCategorieSujet)
    {
        $this->idCategorieSujet = $idCategorieSujet;
    }

    /**
     * @return string
     */
    public function getNomCategorieSujet()
    {
        return $this->nomCategorieSujet;
    }

    /**
     * @param string $nomCategorieSujet
     */
    public function setNomCategorieSujet($nomCategorieSujet)
    {
        $this->nomCategorieSujet = $nomCategorieSujet;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    public function __toString()
    {
        return (string)$this->getIdCategorieSujet();
    }

}

