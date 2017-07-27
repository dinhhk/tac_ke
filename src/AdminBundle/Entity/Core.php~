<?php

namespace AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Core
 *
 * @ORM\Table(name="core")
 * @ORM\Entity(repositoryClass="AdminBundle\Repository\CoreRepository")
 */
class Core
{
    /**
     * @ORM\ManyToOne(targetEntity="Product", inversedBy="cores")
     * @ORM\JoinColumn(name="id_product", referencedColumnName="id")
     */
    private $product;

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
     * @ORM\Column(name="year", type="integer")
     */
    private $year;

    /**
     * @var int
     *
     * @ORM\Column(name="month", type="integer")
     */
    private $month;

    /**
     * @var int
     *
     * @ORM\Column(name="day", type="integer")
     */
    private $day;

    /**
     * @var float
     *
     * @ORM\Column(name="tondk", type="float")
     */
    private $tondk;

    /**
     * @var float
     *
     * @ORM\Column(name="nhaptk", type="float")
     */
    private $nhaptk;

    /**
     * @var string
     *
     * @ORM\Column(name="xuattk", type="float")
     */
    private $xuattk;

    /**
     * @var float
     *
     * @ORM\Column(name="tonck", type="float")
     */
    private $tonck;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * Set year
     *
     * @param integer $year
     *
     * @return Core
     */
    public function setYear($year)
    {
        $this->year = $year;

        return $this;
    }

    /**
     * Get year
     *
     * @return int
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * Set month
     *
     * @param integer $month
     *
     * @return Core
     */
    public function setMonth($month)
    {
        $this->month = $month;

        return $this;
    }

    /**
     * Get month
     *
     * @return int
     */
    public function getMonth()
    {
        return $this->month;
    }

    /**
     * Set day
     *
     * @param integer $day
     *
     * @return Core
     */
    public function setDay($day)
    {
        $this->day = $day;

        return $this;
    }

    /**
     * Get day
     *
     * @return int
     */
    public function getDay()
    {
        return $this->day;
    }

    /**
     * Set tondk
     *
     * @param float $tondk
     *
     * @return Core
     */
    public function setTondk($tondk)
    {
        $this->tondk = $tondk;

        return $this;
    }

    /**
     * Get tondk
     *
     * @return float
     */
    public function getTondk()
    {
        return $this->tondk;
    }

    /**
     * Set nhaptk
     *
     * @param float $nhaptk
     *
     * @return Core
     */
    public function setNhaptk($nhaptk)
    {
        $this->nhaptk = $nhaptk;

        return $this;
    }

    /**
     * Get nhaptk
     *
     * @return float
     */
    public function getNhaptk()
    {
        return $this->nhaptk;
    }

    /**
     * Set xuattk
     *
     * @param string $xuattk
     *
     * @return Core
     */
    public function setXuattk($xuattk)
    {
        $this->xuattk = $xuattk;

        return $this;
    }

    /**
     * Get xuattk
     *
     * @return string
     */
    public function getXuattk()
    {
        return $this->xuattk;
    }

    /**
     * Set tonck
     *
     * @param float $tonck
     *
     * @return Core
     */
    public function setTonck($tonck)
    {
        $this->tonck = $tonck;

        return $this;
    }

    /**
     * Get tonck
     *
     * @return float
     */
    public function getTonck()
    {
        return $this->tonck;
    }

    /**
     * Set product
     *
     * @param \AdminBundle\Entity\Product $product
     *
     * @return Core
     */
    public function setProduct(\AdminBundle\Entity\Product $product = null)
    {
        $this->product = $product;

        return $this;
    }

    /**
     * Get product
     *
     * @return \AdminBundle\Entity\Product
     */
    public function getProduct()
    {
        return $this->product;
    }
}
