<?php

namespace CommandeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LigneCmd
 *
 * @ORM\Table(name="ligne_cmd", indexes={@ORM\Index(name="id_produit", columns={"id_produit"}), @ORM\Index(name="id_client", columns={"id_client"})})
 * @ORM\Entity(repositoryClass="CommandeBundle\Repository\CommandeRepository")
 *
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

    /**
     * @var integer
     *
     * @ORM\ManyToOne(targetEntity="Produit")
     * @ORM\Column(name="id_produit", type="integer", nullable=false)
     */
    private $idProduit;

    /**
     * @return int
     */
    public function getIdLigneCmd()
    {
        return $this->idLigneCmd;
    }

    /**
     * @param int $idLigneCmd
     */
    public function setIdLigneCmd($idLigneCmd)
    {
        $this->idLigneCmd = $idLigneCmd;
    }

    /**
     * @return int
     */
    public function getQuantite()
    {
        return $this->quantite;
    }

    /**
     * @param int $quantite
     */
    public function setQuantite($quantite)
    {
        $this->quantite = $quantite;
    }

    /**
     * @return int
     */
    public function getIdClient()
    {
        return $this->idClient;
    }

    /**
     * @param int $idClient
     */
    public function setIdClient($idClient)
    {
        $this->idClient = $idClient;
    }

    /**
     * @return float
     */
    public function getMontant()
    {
        return $this->montant;
    }

    /**
     * @param float $montant
     */
    public function setMontant($montant)
    {
        $this->montant = $montant;
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


}

