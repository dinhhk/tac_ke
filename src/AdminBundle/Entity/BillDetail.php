<?php

namespace AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use AdminBundle\Validator\Constraints\QuantityNotOverInventory;
use AdminBundle\Validator\Constraints\UnitPriceOverCostPrice;
/**
 * BillDetail
 *
 * @ORM\Table(name="bill_detail")
 * @ORM\Entity(repositoryClass="AdminBundle\Repository\BillDetailRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class BillDetail
{
    /**
     * @ORM\ManyToOne(targetEntity="Product", inversedBy="bill_details")
     * @ORM\JoinColumn(name="id_product", referencedColumnName="id")
     * @Assert\NotBlank()
     */
    private $product;

    /**
     * @ORM\ManyToOne(targetEntity="Bill", inversedBy="bill_details")
     * @ORM\JoinColumn(name="id_bill", referencedColumnName="id")
     */
    private $bill;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var float
     *
     * @ORM\Column(name="quantity", type="float")
     * @Assert\NotBlank()
     * @QuantityNotOverInventory()
     */
    private $quantity;

    /**
     * @var float
     *
     * @ORM\Column(name="unit_price", type="float")
     * @Assert\NotBlank()
     * @UnitPriceOverCostPrice()
     */
    private $unitPrice;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime")
     */
    private $updatedAt;

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
     * Set quantity
     *
     * @param float $quantity
     *
     * @return BillDetail
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get quantity
     *
     * @return float
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Set unitPrice
     *
     * @param float $unitPrice
     *
     * @return BillDetail
     */
    public function setUnitPrice($unitPrice)
    {
        $this->unitPrice = $unitPrice;

        return $this;
    }

    /**
     * Get unitPrice
     *
     * @return float
     */
    public function getUnitPrice()
    {
        return $this->unitPrice;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return BillDetail
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return BillDetail
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set product
     *
     * @param \AdminBundle\Entity\Product $product
     *
     * @return BillDetail
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

    /**
     * Set bill
     *
     * @param \AdminBundle\Entity\Bill $bill
     *
     * @return BillDetail
     */
    public function setBill(\AdminBundle\Entity\Bill $bill = null)
    {
        $this->bill = $bill;

        return $this;
    }

    /**
     * Get bill
     *
     * @return \AdminBundle\Entity\Bill
     */
    public function getBill()
    {
        return $this->bill;
    }

    /**
     * @ORM\PrePersist
     */
    public function setCreatedAtValue()
    {
        $this->createdAt = new \DateTime();
    }

    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function setUpdatedAtValue()
    {
        $this->updatedAt = new \DateTime();
    }
}
