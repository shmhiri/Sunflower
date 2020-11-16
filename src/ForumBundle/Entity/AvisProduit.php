<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AvisProduit
 *
 * @ORM\Table(name="avis_produit", indexes={@ORM\Index(name="id_client", columns={"id_client"}), @ORM\Index(name="id_produit", columns={"id_produit"})})
 * @ORM\Entity
 */
class AvisProduit
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
     * @var integer
     *
     * @ORM\Column(name="id_client", type="integer", nullable=false)
     */
    private $idClient;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_produit", type="integer", nullable=false)
     */
    private $idProduit;

    /**
     * @var string
     *
     * @ORM\Column(name="nom_client", type="string", length=255, nullable=true)
     */
    private $nomClient;

    /**
     * @var string
     *
     * @ORM\Column(name="nom_produit", type="string", length=255, nullable=true)
     */
    private $nomProduit;

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

