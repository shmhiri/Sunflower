<?php

namespace PromotionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 * Promotion
 *
 * @ORM\Table(name="promotion", indexes={@ORM\Index(name="id_agent", columns={"id_agent"}), @ORM\Index(name="id_produit", columns={"id_produit"})})
 * @ORM\Entity(repositoryClass="PromotionBundle\Repository\PromotionRepository")
 */
class Promotion
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_promotion", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idPromotion;

    /**
     * @var string
     *
     * @ORM\Column(name="nom_promotion", type="string", length=255, nullable=true)
     */
    private $nomPromotion;

    /**
     * @var string
     *
     * @ORM\Column(name="nom_agent", type="string", length=255, nullable=true)
     */
    private $nomAgent;

    /**
     * @var string
     *
     * @ORM\Column(name="nom_produit", type="string", length=255, nullable=true)
     */
    private $nomProduit;

    /**
     * @var float
     *
     * @ORM\Column(name="prix_hab", type="float", precision=10, scale=2, nullable=true)
     */
    private $prixHab;

    /**
     * @var float
     *
     * @ORM\Column(name="prix_promo", type="float", precision=10, scale=2, nullable=true)
     */
    private $prixPromo;

    /**
     * @var integer
     *
     * @ORM\Column(name="pourcentage", type="integer", nullable=true)
     */
    private $pourcentage;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_debut", type="date", nullable=true)
     */
    private $dateDebut;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_fin", type="date", nullable=true)
     */
    private $dateFin;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @var \Produit
     *
     * @ORM\ManyToOne(targetEntity="Produit")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_produit", referencedColumnName="id_produit")
     * })
     */
    private $idProduit;

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
    public function getIdPromotion()
    {
        return $this->idPromotion;
    }

    /**
     * @param int $idPromotion
     */
    public function setIdPromotion($idPromotion)
    {
        $this->idPromotion = $idPromotion;
    }

    /**
     * @return string
     */
    public function getNomPromotion()
    {
        return $this->nomPromotion;
    }

    /**
     * @param string $nomPromotion
     */
    public function setNomPromotion($nomPromotion)
    {
        $this->nomPromotion = $nomPromotion;
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
     * @return string
     */
    public function getNomProduit()
    {
        return $this->nomProduit;
    }

    /**
     * @param string $nomProduit
     */
    public function setNomProduit($nomProduit)
    {
        $this->nomProduit = $nomProduit;
    }

    /**
     * @return float
     */
    public function getPrixHab()
    {
        return $this->prixHab;
    }

    /**
     * @param float $prixHab
     */
    public function setPrixHab($prixHab)
    {
        $this->prixHab = $prixHab;
    }

    /**
     * @return float
     */
    public function getPrixPromo()
    {
        return $this->prixPromo;
    }

    /**
     * @param float $prixPromo
     */
    public function setPrixPromo($prixPromo)
    {
        $this->prixPromo = $prixPromo;
    }

    /**
     * @return int
     */
    public function getPourcentage()
    {
        return $this->pourcentage;
    }

    /**
     * @param int $pourcentage
     */
    public function setPourcentage($pourcentage)
    {
        $this->pourcentage = $pourcentage;
    }

    /**
     * @return \DateTime
     */
    public function getDateDebut()
    {
        return $this->dateDebut;
    }

    /**
     * @param \DateTime $dateDebut
     */
    public function setDateDebut($dateDebut)
    {
        $this->dateDebut = $dateDebut;
    }

    /**
     * @return \DateTime
     */
    public function getDateFin()
    {
        return $this->dateFin;
    }

    /**
     * @param \DateTime $dateFin
     */
    public function setDateFin($dateFin)
    {
        $this->dateFin = $dateFin;
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
     * @return \Produit
     */
    public function getIdProduit()
    {
        return $this->idProduit;
    }

    /**
     * @param \Produit $idProduit
     */
    public function setIdProduit($idProduit)
    {
        $this->idProduit = $idProduit;
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


    /**
     * @Assert\Callback
     */
    public function validate(ExecutionContextInterface $context, $payload) {
        $time = new \DateTime();
        if (($this->dateDebut > $this->dateFin)||($time >= $this->dateDebut)) {
            $context->buildViolation('Start date must be earlier than end date')
                ->atPath('promotion_new')
                ->addViolation();
        }
    }


}

