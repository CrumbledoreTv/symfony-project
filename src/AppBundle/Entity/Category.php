<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Products
 *
 * @ORM\Table(name="categories")
 * @ORM\Entity
 */
class Category
{
    /**
    * @ORM\Column(type="integer")
    * @ORM\id
    * @ORM\GeneratedValue(strategy="AUTO")
    */
    private $id;


    /**
    * @ORM\Column(type="string", length=100)
    */
    private $designation;

    
    /**
     * Get id
     *
     * @return integer
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
     * @return Category
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
}
