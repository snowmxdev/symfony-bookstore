<?php

namespace AppBundle\Validator\Constraints;

use AppBundle\Repository\BookRepository;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class ConstraintBookNameValidator extends ConstraintValidator
{
    private $booksRepository;

    public function __construct(BookRepository $booksRepository)
    {
        $this->$booksRepository = $booksRepository;
    }

    public function validate($value, Constraint $constraint)
    {
      if (!preg_match('/^[a-zA-Z0-9]+$/', $value, $matches)) {
           $this->context->buildViolation($constraint->message)
               ->setParameter('%string%', $value)
               ->addViolation();
       }
    }
}
