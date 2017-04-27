<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="products")
 */
class Product
{
  /**
  * @ORM\Colum(type="integer")
  * @ORM\id
  * @ORM\GeneratedValue(strategy="AUTO")
  */
    private $id;

    /**
    * @ORM\Colum(type="string", length=100)
    */
    private $reference;

    /**
    * @ORM\Colum(type="decimal", scale=2)
    */
    private $price;


}
