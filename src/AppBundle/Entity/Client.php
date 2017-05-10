<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Client
 *
 * @ORM\Table(name="client")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ClientRepository")
 */
class Client
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
     * @ORM\Column(type="string", unique=true)
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Assert\NotBlank(message="The designation cannot be blank.")
     */
    private $designation;

    /**
     * @ORM\Column(type="string", unique=true)
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Assert\Email
     * @Assert\NotBlank(message="The email cannot be blank.")
     */
    private $email;

    /**
     * @ORM\Column(type="string", unique=true)
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Assert\Url()
     * @Assert\NotBlank(message="The website cannot be blank.")
     */
    private $website;

    /**
     * @ORM\OneToMany(targetEntity="Invoice", mappedBy="client")
     */
    private $invoices;
public function __construct()
{
    $this->invoices = new ArrayCollection();
}

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
     * Set designation
     *
     * @param string $designation
     *
     * @return Client
     */
    public function setDesignation($designation)
    {
        $this->designation = $designation;

        return $this;
    }

    /**
     * Get designation
     *
     * @return string
     */
    public function getDesignation()
    {
        return $this->designation;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Client
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set website
     *
     * @param string $website
     *
     * @return Client
     */
    public function setWebsite($website)
    {
        $this->website = $website;

        return $this;
    }

    /**
     * Get website
     *
     * @return string
     */
    public function getWebsite()
    {
        return $this->website;
    }

    /**
     * Set facture
     *
     * @param string $facture
     *
     * @return Client
     */
    public function setFacture($facture)
    {
        $this->facture = $facture;

        return $this;
    }

    /**
     * Get Facture
     *
     * @return string
     */
    public function getFacture()
    {
        return $this->facture;
    }
}
