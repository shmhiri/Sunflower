<?php

namespace ProduitBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Favoris
 *
 * @ORM\Table(name="favoris", indexes={@ORM\Index(name="id_produit", columns={"id_produit"}), @ORM\Index(name="id_client", columns={"id_client"})})
 * @ORM\Entity(repositoryClass="ProduitBundle\Repository\FavorisRepository")
 */
class Favoris
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_favoris", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idFavoris;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_produit", type="integer", nullable=false)
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
     * @ORM\Column(name="nom_produit", type="string", length=255, nullable=true)
     */
    private $nomProduit;

    /**
     * @var string
     *
     * @ORM\Column(name="disponibilite", type="string", length=255, nullable=false)
     */
    private $disponibilite;

    /**
     * @return int
     */
    public function getIdFavoris()
    {
        return $this->idFavoris;
    }

    /**
     * @param int $idFavoris
     */
    public function setIdFavoris($idFavoris)
    {
        $this->idFavoris = $idFavoris;
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
     * @return string
     */
    public function getDisponibilite()
    {
        return $this->disponibilite;
    }

    /**
     * @param string $disponibilite
     */
    public function setDisponibilite($disponibilite)
    {
        $this->disponibilite = $disponibilite;
    }


}

