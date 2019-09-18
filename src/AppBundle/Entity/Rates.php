<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\User;

/**
 * Rates
 *
 * @ORM\Table(name="rates")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\RatesRepository")
 */
class Rates
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
     * @var Users|null
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Users")
     */
    private $user;

    /**
     * @var Lots|null
     *
     * @ORM\ManyToOne(targetEntity="Lots")
     */
    private $lot;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_add", type="datetime")
     */
    private $dateAdd;

    /**
     * @var int
     *
     * @ORM\Column(name="price", type="integer", length=11)
     */
    private $price;


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
     * Set user
     *
     * @param string $user
     *
     * @return Rates
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return Users|null
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set lot
     *
     * @param integer $lot
     *
     * @return Rates
     */
    public function setLot($lot)
    {
        $this->lot = $lot;

        return $this;
    }

    /**
     * Get lot
     *
     * @return Lots|null
     */
    public function getLot()
    {
        return $this->lot;
    }

    /**
     * Set dateAdd
     *
     * @param \DateTime $dateAdd
     *
     * @return Rates
     */
    public function setDateAdd($dateAdd)
    {
        $this->dateAdd = $dateAdd;

        return $this;
    }

    /**
     * Get dateAdd
     *
     * @return \DateTime
     */
    public function getDateAdd()
    {
        return $this->dateAdd;
    }

    /**
     * Set price
     *
     * @param integer $price
     *
     * @return Rates
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return int
     */
    public function getPrice()
    {
        return $this->price;
    }
}

