<?php

namespace CommandeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Commande
 *
 * @ORM\Table(name="commande", indexes={@ORM\Index(name="id", columns={"id_client"})})
 * @ORM\Entity(repositoryClass="CommandeBundle\Repository\CommandeRepository")
 *
 */
class Commande
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_cmd", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $idCmd;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_produit", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $idProduit;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_client", type="integer", nullable=false)
     */
    private $idClient;

    /**
     * @var string
     *
     * @ORM\Column(name="etat_cmd", type="string", length=255, nullable=true)
     */
    private $etatCmd;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_cmd", type="datetime", nullable=false)
     */
    private $dateCmd = 'CURRENT_TIMESTAMP';

    /**
     * @var string
     *
     * @ORM\Column(name="mode_p", type="string", length=255, nullable=true)
     */
    private $modeP = 'paiment a la livraison';

    /**
     * @var string
     *
     * @ORM\Column(name="lieu_liv", type="string", length=255, nullable=true)
     */
    private $lieuLiv;

    /**
     * @var float
     *
     * @ORM\Column(name="montant", type="float", precision=10, scale=2, nullable=true)
     */
    private $montant;

    /**
     * @var integer
     *
     * @ORM\Column(name="qte", type="integer", nullable=false)
     */
    private $qte = '1';

    /**
     * @return int
     */
    public function getIdCmd()
    {
        return $this->idCmd;
    }

    /**
     * @param int $idCmd
     */
    public function setIdCmd($idCmd)
    {
        $this->idCmd = $idCmd;
    }

    /**
     * @return int
     */
    public function getIdProduit()
    {
        return $this->idProduit;
    }

    /**
     * @param int $idProduit
     */
    public function setIdProduit($idProduit)
    {
        $this->idProduit = $idProduit;
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
     * @return string
     */
    public function getEtatCmd()
    {
        return $this->etatCmd;
    }

    /**
     * @param string $etatCmd
     */
    public function setEtatCmd($etatCmd)
    {
        $this->etatCmd = $etatCmd;
    }

    /**
     * @return \DateTime
     */
    public function getDateCmd()
    {
        return $this->dateCmd;
    }

    /**
     * @param \DateTime $dateCmd
     */
    public function setDateCmd($dateCmd)
    {
        $this->dateCmd = $dateCmd;
    }

    /**
     * @return string
     */
    public function getModeP()
    {
        return $this->modeP;
    }

    /**
     * @param string $modeP
     */
    public function setModeP($modeP)
    {
        $this->modeP = $modeP;
    }

    /**
     * @return string
     */
    public function getLieuLiv()
    {
        return $this->lieuLiv;
    }

    /**
     * @param string $lieuLiv
     */
    public function setLieuLiv($lieuLiv)
    {
        $this->lieuLiv = $lieuLiv;
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
     * @return int
     */
    public function getQte()
    {
        return $this->qte;
    }

    /**
     * @param int $qte
     */
    public function setQte($qte)
    {
        $this->qte = $qte;
    }


}

