<?php

namespace ForumBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Commentaire
 *
 * @ORM\Table(name="commentaire", indexes={@ORM\Index(name="id_client", columns={"id_client"}), @ORM\Index(name="id_sujet", columns={"id_sujet"})})
 * @ORM\Entity(repositoryClass="ForumBundle\Repository\SujetRepository")
 */

class Commentaire
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_commentaire", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idCommentaire;

    /**
     * @var string
     *
     * @ORM\Column(name="nom_client", type="string", length=255, nullable=true)
     */
    private $nomClient;

    /**
     * @var string
     *
     * @ORM\Column(name="nom_sujet", type="string", length=255, nullable=true)
     */
    private $nomSujet;

    /**
     * @var string
     *
     * @ORM\Column(name="commentaires", type="string", length=255, nullable=true)
     */
    private $commentaires;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_commentaire", type="datetime", nullable=true)
     */
    private $dateCommentaire;

    /**
     * @var integer
     *
     * @ORM\Column(name="nbre_signal", type="integer", nullable=true)
     */
    private $nbreSignal;

    /**
     * @var integer
     *
     * @ORM\Column(name="likee", type="integer", nullable=true)
     */
    private $likee;

    /**
     * @var integer
     *
     * @ORM\ManyToOne(targetEntity="Sujet")
     * @ORM\Column(name="id_sujet", type="integer", nullable=false)
     *
     */
    private $idSujet;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_client", referencedColumnName="id")
     * })
     */
    private $idClient;

    /**
     * @return int
     */
    public function getIdCommentaire()
    {
        return $this->idCommentaire;
    }

    /**
     * @param int $idCommentaire
     */
    public function setIdCommentaire($idCommentaire)
    {
        $this->idCommentaire = $idCommentaire;
    }

    /**
     * @return string
     */
    public function getNomClient()
    {
        return $this->nomClient;
    }

    /**
     * @param string $nomClient
     */
    public function setNomClient($nomClient)
    {
        $this->nomClient = $nomClient;
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
    public function getCommentaires()
    {
        return $this->commentaires;
    }

    /**
     * @param string $commentaires
     */
    public function setCommentaires($commentaires)
    {
        $this->commentaires = $commentaires;
    }

    /**
     * @return \DateTime
     */
    public function getDateCommentaire()
    {
        return $this->dateCommentaire;
    }

    /**
     * @param \DateTime $dateCommentaire
     */
    public function setDateCommentaire($dateCommentaire)
    {
        $this->dateCommentaire = $dateCommentaire;
    }

    /**
     * @return int
     */
    public function getNbreSignal()
    {
        return $this->nbreSignal;
    }

    /**
     * @param int $nbreSignal
     */
    public function setNbreSignal($nbreSignal)
    {
        $this->nbreSignal = $nbreSignal;
    }

    /**
     * @return int
     */
    public function getLikee()
    {
        return $this->likee;
    }

    /**
     * @param int $likee
     */
    public function setLikee($likee)
    {
        $this->likee = $likee;
    }

    /**
     * @return \Sujet
     */
    public function getIdSujet()
    {
        return $this->idSujet;
    }

    /**
     * @param \Sujet $idSujet
     */
    public function setIdSujet($idSujet)
    {
        $this->idSujet = $idSujet;
    }

    /**
     * @return \User
     */
    public function getIdClient()
    {
        return $this->idClient;
    }

    /**
     * @param \User $idClient
     */
    public function setIdClient($idClient)
    {
        $this->idClient = $idClient;
    }


    public function __construct()
    {
        $this->setDateCommentaire(new \DateTime());
    }
    public function __toString()
    {
        return (string)$this->getNomSujet();
    }

}

