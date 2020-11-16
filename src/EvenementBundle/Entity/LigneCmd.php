<?php

namespace EvenementBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LigneCmd
 *
 * @ORM\Table(name="ligne_cmd", indexes={@ORM\Index(name="id_produit", columns={"id_produit"}), @ORM\Index(name="id_cmd", columns={"id_cmd"})})
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
     * @ORM\Column(name="quantite", type="integer", nullable=false)
     */
    private $quantite;

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
     * @var \Commande
     *
     * @ORM\ManyToOne(targetEntity="Commande")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_cmd", referencedColumnName="id_cmd")
     * })
     */
    private $idCmd;


}

