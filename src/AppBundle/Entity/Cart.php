<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Cart
 *
 * @ORM\Table(name="cart")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CartRepository")
 */
class Cart
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
    * @ORM\ManyToMany(targetEntity="Order")
    */
    private $order;

    /**
    * @ORM\ManyToOne(targetEntity="Book")
    * @ORM\JoinColumn(name="book_id", referencedColumnName="id")
    */
    private $book;

    private $amount;

    private $totalPrice;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    public function getBook()
    {
      return $this->book;
    }

    public function setTotalPrice($totalPrice)
    {
      $this->totalPrice = $totalPrice;
    }

    public function getTotalPrice($totalPrice)
    {
      return $this->totalPrice;
    }

    public function setAmount($amount)
    {
      $this->amount = $amount;
    }

    public function getAmount($amount)
    {
      return $this->amount;
    }

}
