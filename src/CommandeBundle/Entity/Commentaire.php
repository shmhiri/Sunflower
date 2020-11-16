<?php

namespace CommandeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Commentaire
 *
 * @ORM\Table(name="commentaire", indexes={@ORM\Index(name="id_client", columns={"id_client"}), @ORM\Index(name="id_sujet", columns={"id_sujet"})})
 * @ORM\Entity
 */
class Commentaire
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_commentaire", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idCommentaire;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_client", type="integer", nullable=true)
     */
    private $idClient;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_sujet", type="integer", nullable=true)
     */
    private $idSujet;

    /**
     * @var string
     *
     * @ORM\Column(name="nom_client", type="string", length=255, nullable=true)
     */
    private $nomClient;

    /**
     * @var string
     *
     * @ORM\Column(name="nom_sujet", type="string", length=255, nullable=true)
     */
    private $nomSujet;

    /**
     * @var string
     *
     * @ORM\Column(name="commentaires", type="string", length=255, nullable=true)
     */
    private $commentaires;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_commentaire", type="datetime", nullable=true)
     */
    private $dateCommentaire = 'CURRENT_TIMESTAMP';

    /**
     * @var integer
     *
     * @ORM\Column(name="nbre_signal", type="integer", nullable=true)
     */
    private $nbreSignal = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="likee", type="integer", nullable=true)
     */
    private $likee = '0';


}

