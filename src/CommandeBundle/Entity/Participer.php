<?php

namespace CommandeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Participer
 *
 * @ORM\Table(name="participer", indexes={@ORM\Index(name="id_evenement", columns={"id_evenement"}), @ORM\Index(name="id_user", columns={"id"})})
 * @ORM\Entity
 */
class Participer
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_participer", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idParticiper;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_evenement", type="integer", nullable=false)
     */
    private $idEvenement;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_user", type="integer", nullable=false)
     */
    private $idUser;


}

