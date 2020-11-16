<?php

namespace EvenementBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Sujet
 *
 * @ORM\Table(name="sujet", indexes={@ORM\Index(name="id_categorie_sujet", columns={"id_categorie_sujet"}), @ORM\Index(name="id_agent", columns={"id_agent"})})
 * @ORM\Entity
 */
class Sujet
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_sujet", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idSujet;

    /**
     * @var string
     *
     * @ORM\Column(name="nom_sujet", type="string", length=255, nullable=true)
     */
    private $nomSujet;

    /**
     * @var string
     *
     * @ORM\Column(name="nom_categorie_sujet", type="string", length=255, nullable=true)
     */
    private $nomCategorieSujet;

    /**
     * @var string
     *
     * @ORM\Column(name="nom_agent", type="string", length=255, nullable=true)
     */
    private $nomAgent;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_creation", type="datetime", nullable=true)
     */
    private $dateCreation;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255, nullable=true)
     */
    private $type;

    /**
     * @var \CategorieSujet
     *
     * @ORM\ManyToOne(targetEntity="CategorieSujet")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_categorie_sujet", referencedColumnName="id_categorie_sujet")
     * })
     */
    private $idCategorieSujet;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_agent", referencedColumnName="id")
     * })
     */
    private $idAgent;


}

