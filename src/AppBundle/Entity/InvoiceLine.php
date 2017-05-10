<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * InvoiceLine
 *
 * @ORM\Table(name="invoice_line")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\InvoiceLineRepository")
 */
class InvoiceLine
{
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
    private $quantity;

    /**
     * @ORM\ManyToOne(targetEntity="Invoice", inversedBy="invoiceLines")
     * @ORM\JoinColumn(name="invoice_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $invoice;

    /**
     * @ORM\ManyToOne(targetEntity="Product", inversedBy="invoiceLine")
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $products;

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
     * Set quantity
     *
     * @param integer $quantity
     *
     * @return InvoiceLine
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get quantity
     *
     * @return integer
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Get total
     *
     * @return integer
     */
    public function getTotal($quantity, $price)
    {
        return $this->total = $quantity * $price;
    }
}
