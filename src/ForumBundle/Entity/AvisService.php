<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AvisService
 *
 * @ORM\Table(name="avis_service", indexes={@ORM\Index(name="id_client", columns={"id_client"}), @ORM\Index(name="id_service", columns={"id_service"})})
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
     * @var integer
     *
     * @ORM\Column(name="id_client", type="integer", nullable=false)
     */
    private $idClient;

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

