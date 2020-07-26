<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Country
 *
 * @ORM\Table(name="country")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CountryRepository")
 */
class Country
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
     * @ORM\Column(name="country_name", type="string", length=100)
     */
    private $countryName;

    /**
     * @var int
     *
     * @ORM\Column(name="id_distributor", type="integer")
     */
    private $idDistributor;


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
     * Set countryName
     *
     * @param string $countryName
     *
     * @return Country
     */
    public function setCountryName($countryName)
    {
        $this->countryName = $countryName;

        return $this;
    }

    /**
     * Get countryName
     *
     * @return string
     */
    public function getCountryName()
    {
        return $this->countryName;
    }

    /**
     * Set idDistributor
     *
     * @param integer $idDistributor
     *
     * @return Country
     */
    public function setIdDistributor($idDistributor)
    {
        $this->idDistributor = $idDistributor;

        return $this;
    }

    /**
     * Get idDistributor
     *
     * @return int
     */
    public function getIdDistributor()
    {
        return $this->idDistributor;
    }
}
