<?php
namespace AppBundle\Form\Model;

use AppBundle\Validator\Constraints as AcmeAssert;

/**
 * @AcmeAssert\ConstraintPrice
 */

class SearchBookParameter
{
  public $priceFrom;

  public $priceTo;

  public $author;

}
