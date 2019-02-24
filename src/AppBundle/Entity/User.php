<?php
// src/AppBundle/Entity/User.php

namespace AppBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Ticket" , mappedBy= "recepteur")
     */
    private $rec_tickets;
    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Ticket" , mappedBy= "emeteur")
     */
    private $em_tickets;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Message" , mappedBy= "user")
     */
    private $user_messages;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Produit" , mappedBy= "user")
     */
    private $produits;

    public function __construct()
    {
            parent::__construct();

    }

    /**
     * @return mixed
     */
    public function getRecTickets()
    {
        return $this->rec_tickets;
    }

    /**
     * @param mixed $rec_tickets
     */
    public function setRecTickets($rec_tickets)
    {
        $this->rec_tickets = $rec_tickets;
    }

    /**
     * Add recTicket
     *
     * @param \AppBundle\Entity\Ticket $recTicket
     *
     * @return User
     */
    public function addRecTicket(\AppBundle\Entity\Ticket $recTicket)
    {
        $this->rec_tickets[] = $recTicket;

        return $this;
    }

    /**
     * Remove recTicket
     *
     * @param \AppBundle\Entity\Ticket $recTicket
     */
    public function removeRecTicket(\AppBundle\Entity\Ticket $recTicket)
    {
        $this->rec_tickets->removeElement($recTicket);
    }

    /**
     * Add emTicket
     *
     * @param \AppBundle\Entity\Ticket $emTicket
     *
     * @return User
     */
    public function addEmTicket(\AppBundle\Entity\Ticket $emTicket)
    {
        $this->em_tickets[] = $emTicket;

        return $this;
    }

    /**
     * Remove emTicket
     *
     * @param \AppBundle\Entity\Ticket $emTicket
     */
    public function removeEmTicket(\AppBundle\Entity\Ticket $emTicket)
    {
        $this->em_tickets->removeElement($emTicket);
    }

    /**
     * Get emTickets
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEmTickets()
    {
        return $this->em_tickets;
    }

    /**
     * Add userMessage
     *
     * @param \AppBundle\Entity\Message $userMessage
     *
     * @return User
     */
    public function addUserMessage(\AppBundle\Entity\Message $userMessage)
    {
        $this->user_messages[] = $userMessage;

        return $this;
    }

    /**
     * Remove userMessage
     *
     * @param \AppBundle\Entity\Message $userMessage
     */
    public function removeUserMessage(\AppBundle\Entity\Message $userMessage)
    {
        $this->user_messages->removeElement($userMessage);
    }

    /**
     * Get userMessages
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUserMessages()
    {
        return $this->user_messages;
    }

    /**
     * Add produit
     *
     * @param \AppBundle\Entity\Produit $produit
     *
     * @return User
     */
    public function addProduit(\AppBundle\Entity\Produit $produit)
    {
        $this->produits[] = $produit;

        return $this;
    }

    /**
     * Remove produit
     *
     * @param \AppBundle\Entity\Produit $produit
     */
    public function removeProduit(\AppBundle\Entity\Produit $produit)
    {
        $this->produits->removeElement($produit);
    }

    /**
     * Get produits
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProduits()
    {
        return $this->produits;
    }
}
