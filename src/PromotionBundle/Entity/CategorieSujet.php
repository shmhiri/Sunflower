<?php

namespace PromotionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CategorieSujet
 *
 * @ORM\Table(name="categorie_sujet")
 * @ORM\Entity
 */
class CategorieSujet
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_categorie_sujet", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idCategorieSujet;

    /**
     * @var string
     *
     * @ORM\Column(name="nom_categorie_sujet", type="string", length=255, nullable=true)
     */
    private $nomCategorieSujet;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255, nullable=true)
     */
    private $type;


}

