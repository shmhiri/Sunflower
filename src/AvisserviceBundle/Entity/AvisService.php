<?php

namespace AvisserviceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
/**
 * AvisService
 *
 * @ORM\Table(name="avis_service", indexes={@ORM\Index(name="id_client", columns={"id_user"}), @ORM\Index(name="id_service", columns={"id_service"})})
 * @ORM\Entity
 */
class AvisService
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_avis", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idAvis;

    /**
     * @return int
     */
    public function getIdAvis()
    {
        return $this->idAvis;
    }

    /**
     * @param int $idAvis
     */
    public function setIdAvis($idAvis)
    {
        $this->idAvis = $idAvis;
    }

    /**
     * @return int
     */
    public function getIdUser()
    {
        return $this->idUser;
    }

    /**
     * @param int $idUser
     */
    public function setIdUser($idUser)
    {
        $this->idUser = $idUser;
    }

    /**
     * @return int
     */
    public function getIdService()
    {
        return $this->idService;
    }

    /**
     * @param int $idService
     */
    public function setIdService($idService)
    {
        $this->idService = $idService;
    }

    /**
     * @return string
     */
    public function getNomAvis()
    {
        return $this->nomAvis;
    }

    /**
     * @param string $nomAvis
     */
    public function setNomAvis($nomAvis)
    {
        $this->nomAvis = $nomAvis;
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
    public function getNomService()
    {
        return $this->nomService;
    }

    /**
     * @param string $nomService
     */
    public function setNomService($nomService)
    {
        $this->nomService = $nomService;
    }

    /**
     * @return string
     */
    public function getCommentaire()
    {
        return $this->commentaire;
    }

    /**
     * @param string $commentaire
     */
    public function setCommentaire($commentaire)
    {
        $this->commentaire = $commentaire;
    }

    /**
     * @return string
     */
    public function getRating()
    {
        return $this->rating;
    }

    /**
     * @param string $rating
     */
    public function setRating($rating)
    {
        $this->rating = $rating;
    }

    /**
     * @var integer
     *
     * @ORM\Column(name="id_user", type="integer", nullable=false)
     */
    private $idUser;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_service", type="integer", nullable=false)
     */
    private $idService;

    /**
     * @var string
     *
     * @ORM\Column(name="nom_avis", type="string", length=255, nullable=true)
     */
    private $nomAvis;

    /**
     * @var string
     *
     * @ORM\Column(name="nom_client", type="string", length=255, nullable=true)
     */
    private $nomClient;

    /**
     * @var string
     *
     * @ORM\Column(name="nom_service", type="string", length=255, nullable=true)
     */
    private $nomService;

    /**
     * @var string
     *
     * @ORM\Column(name="commentaire", type="string", length=500, nullable=true)
     */
    private $commentaire;

    /**
     * @var string
     *
     * @ORM\Column(name="rating", type="string", length=255, nullable=true)
     */
    private $rating;


}

