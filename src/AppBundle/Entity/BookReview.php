<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BooksReview
 *
 * @ORM\Table(name="books_review")
 * @ORM\HasLifecycleCallbacks
 * @ORM\Entity(repositoryClass="AppBundle\Repository\BookReviewRepository")
 */
class BookReview
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
     * @var int
     *
     * @ORM\Column(name="id_book", type="integer")
     */
    private $idBook;

    /**
     * @var int
     *
     * @ORM\Column(name="id_user", type="integer")
     */
    private $idUser;

    /**
     * @var int
     *
     * @ORM\Column(name="review", type="integer")
     */
    private $review;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    public function getBookId()
    {
        return $this->idBook;
    }

    public function getUserId()
    {
        return $this->idUser;
    }

    public function setBookId($idBook)
    {
        $this->idBook = $idBook;
    }

    public function setUserId($idUser)
    {
        $this->idUser = $idUser;
    }

    /**
     * Set review
     *
     * @param integer $review
     *
     * @return BooksReview
     */
    public function setReview($review)
    {
        $this->review = $review;

        return $this;
    }

    /**
     * Get review
     *
     * @return int
     */
    public function getReview()
    {
        return $this->review;
    }
}
