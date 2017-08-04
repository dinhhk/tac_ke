<?php

namespace AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Product
 *
 * @ORM\Table(name="product")
 * @ORM\Entity(repositoryClass="AdminBundle\Repository\ProductRepository")
 * @UniqueEntity("name")
 * @ORM\HasLifecycleCallbacks()
 */
class Product
{
    /**
     * @ORM\OneToMany(targetEntity="Core", mappedBy="product")
     */
    private $cores;

    /**
     * @ORM\OneToMany(targetEntity="ImportDetail", mappedBy="product")
     */
    private $import_details;

    /**
     * @ORM\OneToMany(targetEntity="BillDetail", mappedBy="product")
     */
    private $bill_details;

    /**
     * @ORM\ManyToOne(targetEntity="Size", inversedBy="products")
     * @ORM\JoinColumn(name="id_size", referencedColumnName="id")
     * @Assert\NotBlank()
     */
    private $size;

    /**
     * @ORM\ManyToOne(targetEntity="Type", inversedBy="products")
     * @ORM\JoinColumn(name="id_type", referencedColumnName="id")
     * @Assert\NotBlank()
     */
    private $type;

    /**
     * @ORM\ManyToOne(targetEntity="Unit", inversedBy="products")
     * @ORM\JoinColumn(name="id_unit", referencedColumnName="id")
     * @Assert\NotBlank()
     */
    private $unit;

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
     * @ORM\Column(name="name", type="string", length=100)
     * @Assert\NotBlank()
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=255, nullable=true)
     */
    private $image;

    /**
     * @var float
     *
     * @ORM\Column(name="price", type="float")
     * @Assert\NotBlank()
     * @Assert\GreaterThan(
     *     value = 0
     * )
     */
    private $price;

    /**
     * @var float
     *
     * @ORM\Column(name="promo_price", type="float", nullable=true)
     */
    private $promoPrice;

    /**
     * @var float
     *
     * @ORM\Column(name="cost_price", type="float", nullable=true)
     */
    private $costPrice;

    /**
     * @var float
     *
     * @ORM\Column(name="inventory", type="float", nullable=true)
     */
    private $inventory;

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

    /*
     * @Assert\File(
     *     maxSize = "5M",
     *     mimeTypes = {
     *         "image/jpeg",
     *         "image/png",
     *     }
     * )
     */
    private $file;

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
     * Set name
     *
     * @param string $name
     *
     * @return Product
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Product
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set image
     *
     * @param string $image
     *
     * @return Product
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set price
     *
     * @param float $price
     *
     * @return Product
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set promoPrice
     *
     * @param float $promoPrice
     *
     * @return Product
     */
    public function setPromoPrice($promoPrice)
    {
        $this->promoPrice = $promoPrice;

        return $this;
    }

    /**
     * Get promoPrice
     *
     * @return float
     */
    public function getPromoPrice()
    {
        return $this->promoPrice;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Product
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
     * @return Product
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
     * Constructor
     */
    public function __construct()
    {
        $this->cores = new \Doctrine\Common\Collections\ArrayCollection();
        $this->import_details = new \Doctrine\Common\Collections\ArrayCollection();
        $this->bill_details = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add core
     *
     * @param \AdminBundle\Entity\Core $core
     *
     * @return Product
     */
    public function addCore(\AdminBundle\Entity\Core $core)
    {
        $this->cores[] = $core;

        return $this;
    }

    /**
     * Remove core
     *
     * @param \AdminBundle\Entity\Core $core
     */
    public function removeCore(\AdminBundle\Entity\Core $core)
    {
        $this->cores->removeElement($core);
    }

    /**
     * Get cores
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCores()
    {
        return $this->cores;
    }

    /**
     * Add importDetail
     *
     * @param \AdminBundle\Entity\ImportDetail $importDetail
     *
     * @return Product
     */
    public function addImportDetail(\AdminBundle\Entity\ImportDetail $importDetail)
    {
        $this->import_details[] = $importDetail;

        return $this;
    }

    /**
     * Remove importDetail
     *
     * @param \AdminBundle\Entity\ImportDetail $importDetail
     */
    public function removeImportDetail(\AdminBundle\Entity\ImportDetail $importDetail)
    {
        $this->import_details->removeElement($importDetail);
    }

    /**
     * Get importDetails
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getImportDetails()
    {
        return $this->import_details;
    }

    /**
     * Add billDetail
     *
     * @param \AdminBundle\Entity\BillDetail $billDetail
     *
     * @return Product
     */
    public function addBillDetail(\AdminBundle\Entity\BillDetail $billDetail)
    {
        $this->bill_details[] = $billDetail;

        return $this;
    }

    /**
     * Remove billDetail
     *
     * @param \AdminBundle\Entity\BillDetail $billDetail
     */
    public function removeBillDetail(\AdminBundle\Entity\BillDetail $billDetail)
    {
        $this->bill_details->removeElement($billDetail);
    }

    /**
     * Get billDetails
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getBillDetails()
    {
        return $this->bill_details;
    }

    /**
     * Set size
     *
     * @param \AdminBundle\Entity\Size $size
     *
     * @return Product
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
     * Set type
     *
     * @param \AdminBundle\Entity\Type $type
     *
     * @return Product
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

    /**
     * Set unit
     *
     * @param \AdminBundle\Entity\Unit $unit
     *
     * @return Product
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
    
    /**
     * Set file
     *
     * @param string $file
     * @return TypeProduct
     */
    public function setFile(UploadedFile $file)
    {
        $this->file = $file;

        return $this;
    }

    /**
     * Get file
     *
     * @return string 
     */
    public function getFile()
    {
        return $this->file;
    }

    public function getUploadDir() {
        return 'public/uploads/products/';
    }

    public function getUploadRoot() {
        return __DIR__ . '/../../../web/' . $this->getUploadDir() . '/';
    }

    public function getWebPath() {
        return $this->getUploadDir() . $this->image;
    }

    public function getAbsoluteRoot() {
        return $this->getUploadRoot() . $this->image;
    }

    public function upload() {
        if(empty($this->file)) {
            return;
        }

        $this->image = $this->getUploadDir() . $this->file->getClientOriginalName();
        if(!is_dir($this->getUploadRoot())) {
            mkdir($this->getUploadRoot(), '0777', true);
        }

        $this->file->move($this->getUploadRoot(), $this->file->getClientOriginalName());
        unset($this->file);
    }

    public function removeFile($fileName)
    {
        $file_path = $fileName;
        if(file_exists($file_path)) unlink($file_path);
    }

    /**
     * Set costPrice
     *
     * @param float $costPrice
     *
     * @return Product
     */
    public function setCostPrice($costPrice)
    {
        $this->costPrice = $costPrice;

        return $this;
    }

    /**
     * Get costPrice
     *
     * @return float
     */
    public function getCostPrice()
    {
        return $this->costPrice;
    }

    /**
     * Set inventory
     *
     * @param float $inventory
     *
     * @return Product
     */
    public function setInventory($inventory)
    {
        $this->inventory = $inventory;

        return $this;
    }

    /**
     * Get inventory
     *
     * @return float
     */
    public function getInventory()
    {
        return $this->inventory;
    }
}
