<?php

namespace AppBundle\Entity;
use Carbon\Carbon;
use Doctrine\ORM\Mapping as ORM;

/**
 * Message
 *
 * @ORM\Table(name="message")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MessageRepository")
 */
class Message
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
     * @ORM\Column(name="text", type="text")
     */
    private $text;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Ticket" , inversedBy= "messaages")
     */
    private $ticket;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User" , inversedBy= "user_messages")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User" , inversedBy= "rec_messages")
     */
    private $recepteur;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User" , inversedBy= "em_messages")
     */
    private $emeteur;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->created_at = Carbon::now();
    }


    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * @return mixed
     */
    public function getRecepteur()
    {
        return $this->recepteur;
    }

    /**
     * @param mixed $recepteur
     */
    public function setRecepteur($recepteur)
    {
        $this->recepteur = $recepteur;
    }

    /**
     * @return mixed
     */
    public function getEmeteur()
    {
        return $this->emeteur;
    }

    /**
     * @param mixed $emeteur
     */
    public function setEmeteur($emeteur)
    {
        $this->emeteur = $emeteur;
    }

    /**
     * @param \DateTime $created_at
     */
    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;
    }

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $created_at;

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
     * Set text
     *
     * @param string $text
     *
     * @return Message
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Get text
     *
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Set ticket
     *
     * @param \AppBundle\Entity\Ticket $ticket
     *
     * @return Message
     */
    public function setTicket(\AppBundle\Entity\Ticket $ticket = null)
    {
        $this->ticket = $ticket;

        return $this;
    }

    /**
     * Get ticket
     *
     * @return \AppBundle\Entity\Ticket
     */
    public function getTicket()
    {
        return $this->ticket;
    }

    /**
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return Message
     */
    public function setUser(\AppBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \AppBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }
}
