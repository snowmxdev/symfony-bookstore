<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Distributor
 *
 * @ORM\Table(name="distributor")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\DistributorRepository")
 */
class Distributor
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
     * @ORM\Column(name="distributor_name", type="string", length=255)
     */
    private $distributorName;

    /**
     * @var string
     *
     * @ORM\Column(name="tax_rate", type="decimal", precision=5, scale=2, nullable=true)
     */
    private $taxRate;


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
     * Set distributorName
     *
     * @param string $distributorName
     *
     * @return Distributor
     */
    public function setDistributorName($distributorName)
    {
        $this->distributorName = $distributorName;

        return $this;
    }

    /**
     * Get distributorName
     *
     * @return string
     */
    public function getDistributorName()
    {
        return $this->distributorName;
    }

    /**
     * Set taxRate
     *
     * @param string $taxRate
     *
     * @return Distributor
     */
    public function setTaxRate($taxRate)
    {
        $this->taxRate = $taxRate;

        return $this;
    }

    /**
     * Get taxRate
     *
     * @return string
     */
    public function getTaxRate()
    {
        return $this->taxRate;
    }
}
