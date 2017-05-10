<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Invoice
 *
 * @ORM\Table(name="invoice")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\InvoiceRepository")
 */
class Invoice
{

    const OPENED = 1;
    const CLOSED = 0;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $state;


    /**
     * @ORM\ManyToOne(targetEntity="Client", inversedBy="invoices")
     * @ORM\JoinColumn(name="client_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $client;

    /**
     * @ORM\OneToMany(targetEntity="InvoiceLine", mappedBy="invoice")
     */
    private $invoiceLines;
public function __construct()
{
    $this->invoiceLines = new ArrayCollection();
    $this->state = self::OPENED;
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
     * Set state
     *
     * @param integer $state
     *
     * @return Invoice
     */
    public function setState($state)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * Get state
     *
     * @return integer
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Get designation
     *
     * @return string
     */
    public function getDesignation()
    {
        return "invoice-".str_pad($this->id, 2, '0', STR_PAD_LEFT); // invoice-001
    }

    /**
     * Get total
     *
     * @return float
     */
    public function getTotal()
    {
        return 0;
    }
}
