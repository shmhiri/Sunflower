<?php

namespace ProduitBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LigneCmd
 *
 * @ORM\Table(name="ligne_cmd", indexes={@ORM\Index(name="id_produit", columns={"id_produit"}), @ORM\Index(name="id_client", columns={"id_client"})})
 * @ORM\Entity
 */
class LigneCmd
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_ligne_cmd", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idLigneCmd;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_produit", type="integer", nullable=false)
     */
    private $idProduit;

    /**
     * @var integer
     *
     * @ORM\Column(name="quantite", type="integer", nullable=false)
     */
    private $quantite;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_client", type="integer", nullable=false)
     */
    private $idClient;

    /**
     * @var float
     *
     * @ORM\Column(name="montant", type="float", precision=10, scale=0, nullable=true)
     */
    private $montant;


}

