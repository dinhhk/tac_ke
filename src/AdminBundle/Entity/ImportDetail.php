<?php

namespace AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * ImportDetail
 *
 * @ORM\Table(name="import_detail")
 * @ORM\Entity(repositoryClass="AdminBundle\Repository\ImportDetailRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class ImportDetail
{
    /**
     * @ORM\ManyToOne(targetEntity="Import", inversedBy="import_details")
     * @ORM\JoinColumn(name="id_import", referencedColumnName="id")
     */
    private $import;

    /**
     * @ORM\ManyToOne(targetEntity="Product", inversedBy="import_details")
     * @ORM\JoinColumn(name="id_product", referencedColumnName="id")
     * @Assert\NotBlank()
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
     * @var float
     *
     * @ORM\Column(name="quantity", type="float")
     * @Assert\NotBlank()
     */
    private $quantity;

    /**
     * @var float
     *
     * @ORM\Column(name="unit_price", type="float")
     * @Assert\NotBlank()
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
     * @return ImportDetail
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
     * @return ImportDetail
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
     * @return ImportDetail
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
     * @return ImportDetail
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
     * Set import
     *
     * @param \AdminBundle\Entity\Import $import
     *
     * @return ImportDetail
     */
    public function setImport(\AdminBundle\Entity\Import $import = null)
    {
        $this->import = $import;

        return $this;
    }

    /**
     * Get import
     *
     * @return \AdminBundle\Entity\Import
     */
    public function getImport()
    {
        return $this->import;
    }

    /**
     * Set product
     *
     * @param \AdminBundle\Entity\Product $product
     *
     * @return ImportDetail
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
