<?php

namespace EvenementBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Participer
 *
 * @ORM\Table(name="participer", indexes={@ORM\Index(name="id_evenement", columns={"id_evenement"}), @ORM\Index(name="id_user", columns={"id_user"})})
 * @ORM\Entity(repositoryClass="EvenementBundle\Repository\ParticiperRepository")
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

    /**
     * @return int
     */
    public function getIdParticiper()
    {
        return $this->idParticiper;
    }

    /**
     * @param int $idParticiper
     */
    public function setIdParticiper($idParticiper)
    {
        $this->idParticiper = $idParticiper;
    }

    /**
     * @return \Evenement
     */
    public function getIdEvenement()
    {
        return $this->idEvenement;
    }

    /**
     * @param \Evenement $idEvenement
     */
    public function setIdEvenement($idEvenement)
    {
        $this->idEvenement = $idEvenement;
    }

    /**
     * @return \User
     */
    public function getIdUser()
    {
        return $this->idUser;
    }

    /**
     * @param \User $idUser
     */
    public function setIdUser($idUser)
    {
        $this->idUser = $idUser;
    }


}

