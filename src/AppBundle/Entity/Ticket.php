<?php

namespace AppBundle\Entity;
use Carbon\Carbon;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

use Doctrine\ORM\Mapping as ORM;

/**
 * Ticket
 * @ORM\Table(name="ticket")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TicketRepository")
 */
class Ticket
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var bool
     *
     * @ORM\Column(name="statut", type="boolean")
     */
    private $statut;

    /**
     * @var string
     *
     * @ORM\Column(name="sujet", type="string", length=255)
     */
    private $sujet;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="createdat", type="datetime")
     */
    private $createdat;

    /**
     * @return string
     */
    public function getAttachment()
    {
        return $this->attachment;
    }

    /**
     * @param string $attachment
     */
    public function setAttachment($attachment)
    {
        $this->attachment = $attachment;
    }

    /**
     * @var string
     *
     * @ORM\Column(name="attachment", type="string", length=255)
     */
    private $attachment;


    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User" , inversedBy= "rec_tickets")
     */
    private $recepteur;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User" , inversedBy= "em_tickets")
     */
    private $emeteur;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Message" , mappedBy= "ticket")
     */
    private $messages;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Ticket
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set statut
     *
     * @param boolean $statut
     *
     * @return Ticket
     */
    public function setStatut($statut)
    {
        $this->statut = $statut;

        return $this;
    }

    /**
     * Get statut
     *
     * @return bool
     */
    public function getStatut()
    {
        return $this->statut;
    }

    /**
     * Set sujet
     *
     * @param string $sujet
     *
     * @return Ticket
     */
    public function setSujet($sujet)
    {
        $this->sujet = $sujet;

        return $this;
    }

    /**
     * Get sujet
     *
     * @return string
     */
    public function getSujet()
    {
        return $this->sujet;
    }

    /**
     * Set createdat
     *
     * @param \DateTime $createdat
     *
     * @return Ticket
     */
    public function setCreatedat($createdat)
    {
        $this->createdat = $createdat;

        return $this;
    }

    /**
     * Get createdat
     *
     * @return \DateTime
     */
    public function getCreatedat()
    {
        return $this->createdat;
    }

    /**
     * Set recepteur
     *
     * @param \AppBundle\Entity\User $recepteur
     *
     * @return Ticket
     */
    public function setRecepteur(\AppBundle\Entity\User $recepteur = null)
    {
        $this->recepteur = $recepteur;

        return $this;
    }

    /**
     * Get recepteur
     *
     * @return \AppBundle\Entity\User
     */
    public function getRecepteur()
    {
        return $this->recepteur;
    }

    /**
     * Set emeteur
     *
     * @param \AppBundle\Entity\User $emeteur
     *
     * @return Ticket
     */
    public function setEmeteur(\AppBundle\Entity\User $emeteur = null)
    {
        $this->emeteur = $emeteur;

        return $this;
    }

    /**
     * Get emeteur
     *
     * @return \AppBundle\Entity\User
     */
    public function getEmeteur()
    {
        return $this->emeteur;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->messages = new \Doctrine\Common\Collections\ArrayCollection();
        $this->createdat = Carbon::now();

    }

    /**
     * Add message
     *
     * @param \AppBundle\Entity\Message $message
     *
     * @return Ticket
     */
    public function addMessage(\AppBundle\Entity\Message $message)
    {
        $this->messages[] = $message;

        return $this;
    }

    /**
     * Remove message
     *
     * @param \AppBundle\Entity\Message $message
     */
    public function removeMessage(\AppBundle\Entity\Message $message)
    {
        $this->messages->removeElement($message);
    }

    /**
     * Get messages
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMessages()
    {
        return $this->messages;
    }



}
