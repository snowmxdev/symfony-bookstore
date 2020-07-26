<?php
namespace AppBundle\Form\Model;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/*
 * @UniqueEntity(fields={"email"}, groups={"registration"}, message="Email je zauzet")
 */
class User
{
    /**
      * @Assert\NotBlank(message="Potrebno je unijeti ime")
      * @Assert\Length(min=3, minMessage="Ime mora imati najmanje 3 slova")
      */
    public $name;
    /**
     * @Assert\NotBlank(message="Potrebno je unijeti prezime")
     * @Assert\Length(min=3, minMessage="Prezime mora imati najmanje 3 slova")
     */
    public $surname;
    /**
     * @Assert\NotBlank(message="Potrebno je unijeti email")
     * @Assert\Email(groups={"registration"})
     */
    public $email;
    /**
    * @Assert\NotBlank(message="Potrebno je unijeti lozinku")
    * @Assert\Regex(
    *      pattern="/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?!.*\s).*$/",
    *      message="Potrebno je 1 veliko slovo, 1 malo slovo, i 1 broj"
    * )
     */
    public $password;

}
