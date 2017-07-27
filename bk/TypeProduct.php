<?php

namespace AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * TypeProduct
 *
 * @ORM\Table(name="type_products")
 * @ORM\Entity(repositoryClass="AdminBundle\Repository\TypeProductRepository")
 * @UniqueEntity("type", groups={"create"})
 */
class TypeProduct
{
    /**
     * @ORM\OneToMany(targetEntity="Product", mappedBy="type_product")
     */
    private $products;

    /**
     * @ORM\ManyToOne(targetEntity="Size", inversedBy="type_products")
     * @ORM\JoinColumn(name="id_size", referencedColumnName="id")
     */
    private $size;

    /**
     * @ORM\ManyToOne(targetEntity="Unit", inversedBy="type_products")
     * @ORM\JoinColumn(name="id_unit", referencedColumnName="id")
     * @Assert\NotBlank()
     */
    private $unit;

    /**
     * @ORM\ManyToOne(targetEntity="Type", inversedBy="type_products")
     * @ORM\JoinColumn(name="id_type", referencedColumnName="id")
     * @Assert\NotBlank()
     */
    private $type;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

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
     * Constructor
     */
    public function __construct()
    {
        $this->products = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add product
     *
     * @param \AdminBundle\Entity\Product $product
     *
     * @return TypeProduct
     */
    public function addProduct(\AdminBundle\Entity\Product $product)
    {
        $this->products[] = $product;

        return $this;
    }

    /**
     * Remove product
     *
     * @param \AdminBundle\Entity\Product $product
     */
    public function removeProduct(\AdminBundle\Entity\Product $product)
    {
        $this->products->removeElement($product);
    }

    /**
     * Get products
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProducts()
    {
        return $this->products;
    }

    /**
     * Set size
     *
     * @param \AdminBundle\Entity\Size $size
     *
     * @return TypeProduct
     */
    public function setSize(\AdminBundle\Entity\Size $size = null)
    {
        $this->size = $size;

        return $this;
    }

    /**
     * Get size
     *
     * @return \AdminBundle\Entity\Size
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * Set unit
     *
     * @param \AdminBundle\Entity\Unit $unit
     *
     * @return TypeProduct
     */
    public function setUnit(\AdminBundle\Entity\Unit $unit = null)
    {
        $this->unit = $unit;

        return $this;
    }

    /**
     * Get unit
     *
     * @return \AdminBundle\Entity\Unit
     */
    public function getUnit()
    {
        return $this->unit;
    }

    /**
     * Set type
     *
     * @param \AdminBundle\Entity\Type $type
     *
     * @return TypeProduct
     */
    public function setType(\AdminBundle\Entity\Type $type = null)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return \AdminBundle\Entity\Type
     */
    public function getType()
    {
        return $this->type;
    }
}
