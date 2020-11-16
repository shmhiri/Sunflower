<?php

namespace ProduitBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Promotion
 *
 * @ORM\Table(name="promotion", indexes={@ORM\Index(name="id_agent", columns={"id_agent"}), @ORM\Index(name="id_produit", columns={"id_produit"})})
 * @ORM\Entity
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
     * @var integer
     *
     * @ORM\Column(name="id_agent", type="integer", nullable=false)
     */
    private $idAgent;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_produit", type="integer", nullable=false)
     */
    private $idProduit;

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
     * @var string
     *
     * @ORM\Column(name="date_debut", type="string", length=255, nullable=true)
     */
    private $dateDebut;

    /**
     * @var string
     *
     * @ORM\Column(name="date_fin", type="string", length=255, nullable=true)
     */
    private $dateFin;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=true)
     */
    private $description;


}

