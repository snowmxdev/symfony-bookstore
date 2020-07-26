<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Books
 *
 * @ORM\Table(name="books")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\BookRepository")
 */
class Book
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
     * @ORM\Column(name="name", type="string", length=100)
     */
    private $name;

    /**
     * @var int
     *
     * @ORM\Column(name="id_author", type="integer")
     */
    private $idAuthor;

    /**
     * @var int
     *
     * @ORM\Column(name="id_publisher", type="integer")
     */
    private $idPublisher;

    /**
     * @var string
     *
     * @ORM\Column(name="binding", type="string", length=20)
     */
    private $binding;

    /**
     * @var string
     *
     * @ORM\Column(name="price", type="decimal", precision=7, scale=2)
     */
    private $price;

    /**
     * @var int
     *
     * @ORM\Column(name="pages", type="integer")
     */
    private $pages;

    /**
     * @var int
     *
     * @ORM\Column(name="year_publishing", type="integer")
     */
    private $yearPublishing;

    /**
     * @var int
     *
     * @ORM\Column(name="isbn", type="string", unique=true)
     */
    private $isbn;

    /**
     * @var string
     *
     * @ORM\Column(name="availability", type="string", length=30)
     */
    private $availability;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @var int
     *
     * @ORM\Column(name="id_category", type="integer")
     */
    private $idCategory;

    /**
     * @var string
     *
     * @ORM\Column(name="special_offer", type="string", length=10, nullable=true)
     */
    private $specialOffer;


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
     * Set name
     *
     * @param string $name
     *
     * @return Books
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set idAuthor
     *
     * @param integer $idAuthor
     *
     * @return Books
     */
    public function setIdAuthor($idAuthor)
    {
        $this->idAuthor = $idAuthor;

        return $this;
    }

    /**
     * Get idAuthor
     *
     * @return int
     */
    public function getIdAuthor()
    {
        return $this->idAuthor;
    }

    /**
     * Set idPublisher
     *
     * @param integer $idPublisher
     *
     * @return Books
     */
    public function setIdPublisher($idPublisher)
    {
        $this->idPublisher = $idPublisher;

        return $this;
    }

    /**
     * Get idPublisher
     *
     * @return int
     */
    public function getIdPublisher()
    {
        return $this->idPublisher;
    }

    /**
     * Set binding
     *
     * @param string $binding
     *
     * @return Books
     */
    public function setBinding($binding)
    {
        $this->binding = $binding;

        return $this;
    }

    /**
     * Get binding
     *
     * @return string
     */
    public function getBinding()
    {
        return $this->binding;
    }

    /**
     * Set price
     *
     * @param string $price
     *
     * @return Books
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return string
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set pages
     *
     * @param integer $pages
     *
     * @return Books
     */
    public function setPages($pages)
    {
        $this->pages = $pages;

        return $this;
    }

    /**
     * Get pages
     *
     * @return int
     */
    public function getPages()
    {
        return $this->pages;
    }

    /**
     * Set yearPublishing
     *
     * @param integer $yearPublishing
     *
     * @return Books
     */
    public function setYearPublishing($yearPublishing)
    {
        $this->yearPublishing = $yearPublishing;

        return $this;
    }

    /**
     * Get yearPublishing
     *
     * @return int
     */
    public function getYearPublishing()
    {
        return $this->yearPublishing;
    }

    /**
     * Set isbn
     *
     * @param integer $isbn
     *
     * @return Books
     */
    public function setIsbn($isbn)
    {
        $this->isbn = $isbn;

        return $this;
    }

    /**
     * Get isbn
     *
     * @return int
     */
    public function getIsbn()
    {
        return $this->isbn;
    }

    /**
     * Set availability
     *
     * @param string $availability
     *
     * @return Books
     */
    public function setAvailability($availability)
    {
        $this->availability = $availability;

        return $this;
    }

    /**
     * Get availability
     *
     * @return string
     */
    public function getAvailability()
    {
        return $this->availability;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Books
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
     * Set idCategory
     *
     * @param integer $idCategory
     *
     * @return Books
     */
    public function setIdCategory($idCategory)
    {
        $this->idCategory = $idCategory;

        return $this;
    }

    /**
     * Get idCategory
     *
     * @return int
     */
    public function getIdCategory()
    {
        return $this->idCategory;
    }

    /**
     * Set specialOffer
     *
     * @param string $specialOffer
     *
     * @return Books
     */
    public function setSpecialOffer($specialOffer)
    {
        $this->specialOffer = $specialOffer;

        return $this;
    }

    /**
     * Get specialOffer
     *
     * @return string
     */
    public function getSpecialOffer()
    {
        return $this->specialOffer;
    }

    // cover samo odaberemo, zatim sliku prebacimo u folder di su coveri(rijesavamo u controlleru)
    // a dohvacamo je za prikaz priko naziva
    public function getBookCover()
    {
        return $this->bookCover;
    }

    public function setBookCover($bookCover)
    {
      $this->bookCover = $bookCover;
    }
}
