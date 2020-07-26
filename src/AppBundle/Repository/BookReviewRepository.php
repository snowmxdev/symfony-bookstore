<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;


class BookReviewRepository extends EntityRepository
{
  public function findReviewByBook($id)
   {
       $dql = 'SELECT b FROM AppBundle:BookReview AS b WHERE b.idBook = :id';

       return $this->getEntityManager()
           ->createQuery($dql)
           ->setParameter('id', $id)
           ->getOneOrNullResult();
   }

   public function isUserReviewedBook($idBook, $idUser)
   {
    $dql = 'SELECT b FROM AppBundle:BookReview AS b WHERE b.idBook = :idBook AND (b.idUser = :idUser)';

    return $this->getEntityManager()
        ->createQuery($dql)
        ->setParameter('idUser', $idUser)
        ->setParameter('idBook', $idBook)
        ->getOneOrNullResult();
   }

   public function findReviewsForBook($idBook)
   {
     $dql = 'SELECT AVG(b.review) as avg_rating FROM AppBundle:BookReview AS b WHERE b.idBook = :idBook';

     return $this->getEntityManager()
         ->createQuery($dql)
         ->setParameter('idBook', $idBook)
         ->getScalarResult();
   }
 }
