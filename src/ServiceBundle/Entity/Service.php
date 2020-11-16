<?php

namespace ServiceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 * Service
 *
 * @ORM\Table(name="service", indexes={@ORM\Index(name="id_agent", columns={"id_agent"})})
 * @ORM\Entity
 */
class Service
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_service", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idService;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_agent", type="integer", nullable=true)
     */
    private $idAgent;

    /**
     * @var string
     *
     * @ORM\Column(name="nom_service", type="string", length=255, nullable=true)
     */
    private $nomService;

    /**
     * @var string
     *
     * @ORM\Column(name="nom_agent", type="string", length=255, nullable=true)
     */
    private $nomAgent;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255, nullable=true)
     */
    private $type;

    /**
     * @var float
     *
     * @ORM\Column(name="prix", type="float", precision=10, scale=0, nullable=false)
     */
    private $prix;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="etat", type="string", length=255, nullable=true)
     */
    private $etat;

    /**
     * @var string
     *
     * @ORM\Column(name="contact", type="string", length=255, nullable=true)
     */
    private $contact;

    /**
     * @var string
     *
     * @ORM\Column(name="Region", type="string", length=255, nullable=true)
     */
    private $region;

    /**
     * @var string
     *
     * @ORM\Column(name="Image", type="string", length=255, nullable=false)
     */
    private $image;



    /**
     * @return int
     */
    public function getIdService()
    {
        return $this->idService;
    }

    /**
     * @param int $idService
     */
    public function setIdService($idService)
    {
        $this->idService = $idService;
    }

    /**
     * @return int
     */
    public function getIdAgent()
    {
        return $this->idAgent;
    }

    /**
     * @param int $idAgent
     */
    public function setIdAgent($idAgent)
    {
        $this->idAgent = $idAgent;
    }

    /**
     * @return string
     */
    public function getNomService()
    {
        return $this->nomService;
    }

    /**
     * @param string $nomService
     */
    public function setNomService($nomService)
    {
        $this->nomService = $nomService;
    }

    /**
     * @return string
     */
    public function getNomAgent()
    {
        return $this->nomAgent;
    }

    /**
     * @param string $nomAgent
     */
    public function setNomAgent($nomAgent)
    {
        $this->nomAgent = $nomAgent;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return float
     */
    public function getPrix()
    {
        return $this->prix;
    }

    /**
     * @param float $prix
     */
    public function setPrix($prix)
    {
        $this->prix = $prix;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getEtat()
    {
        return $this->etat;
    }

    /**
     * @param string $etat
     */
    public function setEtat($etat)
    {
        $this->etat = $etat;
    }

    /**
     * @return string
     */
    public function getContact()
    {
        return $this->contact;
    }

    /**
     * @param string $contact
     */
    public function setContact($contact)
    {
        $this->contact = $contact;
    }

    /**
     * @return string
     */
    public function getRegion()
    {
        return $this->region;
    }

    /**
     * @param string $region
     */
    public function setRegion($region)
    {
        $this->region = $region;
    }

    /**
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param string $image
     */
    public function setImage($image)
    {
        $this->image = $image;
    }

    /**
     * @Assert\Callback
     */
    public function isContentValid(ExecutionContextInterface $context)
    {

        // On vérifie que le contenu ne contient pas l'un des mots
        if ($this->prix <= 0) {
            // La règle est violée, on définit l'erreur
            $context
                ->buildViolation('Contenu invalide car il contient un mot interdit.') // message
                ->atPath('service_new')                                                   // attribut de l'objet qui est violé
                ->addViolation() // ceci déclenche l'erreur, ne l'oubliez pas
            ;
        }
        if ($this->nomService ==null) {
        // La règle est violée, on définit l'erreur
        $context
            ->buildViolation('Contenu invalide car il contient un mot interdit.') // message
            ->atPath('service_new')                                                   // attribut de l'objet qui est violé
            ->addViolation() // ceci déclenche l'erreur, ne l'oubliez pas
        ;
    }
        if ($this->region ==null) {
            // La règle est violée, on définit l'erreur
            $context
                ->buildViolation('Contenu invalide car il contient un mot interdit.') // message
                ->atPath('service_new')                                                   // attribut de l'objet qui est violé
                ->addViolation() // ceci déclenche l'erreur, ne l'oubliez pas
            ;
        }
        if ($this->description ==null) {
            // La règle est violée, on définit l'erreur
            $context
                ->buildViolation('Contenu invalide car il contient un mot interdit.') // message
                ->atPath('service_new')                                                   // attribut de l'objet qui est violé
                ->addViolation() // ceci déclenche l'erreur, ne l'oubliez pas
            ;
        }
        if ($this->type ==null) {
            // La règle est violée, on définit l'erreur
            $context
                ->buildViolation('Contenu invalide car il contient un mot interdit.') // message
                ->atPath('service_new')                                                   // attribut de l'objet qui est violé
                ->addViolation() // ceci déclenche l'erreur, ne l'oubliez pas
            ;
        }

    }

}

