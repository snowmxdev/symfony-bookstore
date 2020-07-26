<?php

namespace AppBundle\Form\Model;

use Symfony\Component\Validator\Constraints as Assert;


class Book
{
  /**
    * @Assert\NotBlank(message="Ime knjige je potrebno")
    * @Assert\Length(min=1, minMessage="Ime knjige mora imati najmanje 1 slovo")
    */
  public $bookName;

  public $author;

  public $publisher;
  /**
   * @Assert\Choice(choices = {"Meka", "Tvrda"})
   */
  public $binding;

  public $price;
  /**
   * @Assert\Length(min=3, minMessage="Knjiga mora imati najmanje 10 stranica")
   */
  public $pages;

  public $yearPublishing;
  /**
   * @Assert\NotBlank(message = "Neispravna vrijedost - pr: 978-1-56619-909-4")
   */
  public $isbn;
  /**
   * @Assert\Choice(choices = {"Dostupno", "Nedostupno"}, message = "Izaberi jednu od vrijednosti")
   */
  public $availability;

  public $description;

  public $category;
  /**
   * @Assert\Choice(choices = {"Da", "Ne"})
   */
  public $specialOffer;


  public $bookCover;

}
