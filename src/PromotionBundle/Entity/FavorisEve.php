<?php

namespace PromotionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FavorisEve
 *
 * @ORM\Table(name="favoris_eve", indexes={@ORM\Index(name="id_evenement", columns={"id_evenement"}), @ORM\Index(name="id_user", columns={"id_user"})})
 * @ORM\Entity
 */
class FavorisEve
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
     * @var \Evenement
     *
     * @ORM\ManyToOne(targetEntity="Evenement")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_evenement", referencedColumnName="id_evenement")
     * })
     */
    private $idEvenement;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_user", referencedColumnName="id")
     * })
     */
    private $idUser;


}

