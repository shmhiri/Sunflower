<?php

namespace CommandeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Commande
 *
 * @ORM\Table(name="commande", indexes={@ORM\Index(name="id_user", columns={"id_client"})})
 * @ORM\Entity
 */
class Commande
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_cmd", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idCmd;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_client", type="integer", nullable=true)
     */
    private $idClient;

    /**
     * @var string
     *
     * @ORM\Column(name="etat_cmd", type="string", length=255, nullable=false)
     */
    private $etatCmd;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_cmd", type="datetime", nullable=false)
     */
    private $dateCmd;

    /**
     * @var string
     *
     * @ORM\Column(name="mode_p", type="string", length=255, nullable=true)
     */
    private $modeP;

    /**
     * @var string
     *
     * @ORM\Column(name="lieu_liv", type="string", length=255, nullable=true)
     */
    private $lieuLiv;

    /**
     * @var float
     *
     * @ORM\Column(name="montant", type="float", precision=10, scale=0, nullable=false)
     */
    private $montant;


}

