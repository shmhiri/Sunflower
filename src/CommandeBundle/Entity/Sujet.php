<?php

namespace CommandeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Sujet
 *
 * @ORM\Table(name="sujet", indexes={@ORM\Index(name="id_categorie_sujet", columns={"id_categorie_sujet"}), @ORM\Index(name="id_agent", columns={"id_agent"})})
 * @ORM\Entity(repositoryClass="CommandeBundle\Repository\SujetRepository")
 */
class Sujet
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_sujet", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idSujet;

    /**
     * @var string
     *
     * @ORM\Column(name="nom_sujet", type="string", length=255, nullable=true)
     */
    private $nomSujet;

    /**
     * @var string
     *
     * @ORM\Column(name="nom_categorie_sujet", type="string", length=255, nullable=true)
     */
    private $nomCategorieSujet;

    /**
     * @var string
     *
     * @ORM\Column(name="nom_agent", type="string", length=255, nullable=true)
     */
    private $nomAgent;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_creation", type="datetime", nullable=true)
     */
    private $dateCreation = 'CURRENT_TIMESTAMP';

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=1000, nullable=true)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255, nullable=true)
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=500, nullable=true)
     */
    private $image;

    /**
     * @var \CategorieSujet
     *
     * @ORM\ManyToOne(targetEntity="CategorieSujet")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_categorie_sujet", referencedColumnName="id_categorie_sujet")
     * })
     */
    private $idCategorieSujet;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_agent", referencedColumnName="id")
     * })
     */
    private $idAgent;

    /**
     * @return int
     */
    public function getIdSujet()
    {
        return $this->idSujet;
    }

    /**
     * @param int $idSujet
     */
    public function setIdSujet($idSujet)
    {
        $this->idSujet = $idSujet;
    }

    /**
     * @return string
     */
    public function getNomSujet()
    {
        return $this->nomSujet;
    }

    /**
     * @param string $nomSujet
     */
    public function setNomSujet($nomSujet)
    {
        $this->nomSujet = $nomSujet;
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
    public function getNomAgent()
    {
        return $this->nomAgent;
    }

    /**
     * @param string $nomAgent
     */
    public function setNomAgent($nomAgent)
    {
        $this->nomAgent = $nomAgent;
    }

    /**
     * @return \DateTime
     */
    public function getDateCreation()
    {
        return $this->dateCreation;
    }

    /**
     * @param \DateTime $dateCreation
     */
    public function setDateCreation($dateCreation)
    {
        $this->dateCreation = $dateCreation;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
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

    /**
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param string $image
     */
    public function setImage($image)
    {
        $this->image = $image;
    }

    /**
     * @return \CategorieSujet
     */
    public function getIdCategorieSujet()
    {
        return $this->idCategorieSujet;
    }

    /**
     * @param \CategorieSujet $idCategorieSujet
     */
    public function setIdCategorieSujet($idCategorieSujet)
    {
        $this->idCategorieSujet = $idCategorieSujet;
    }

    /**
     * @return \User
     */
    public function getIdAgent()
    {
        return $this->idAgent;
    }

    /**
     * @param \User $idAgent
     */
    public function setIdAgent($idAgent)
    {
        $this->idAgent = $idAgent;
    }


}

