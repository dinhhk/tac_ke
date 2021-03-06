<?php

namespace AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\Request;

/**
 * Import
 *
 * @ORM\Table(name="import")
 * @ORM\Entity(repositoryClass="AdminBundle\Repository\ImportRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Import
{
    /**
     * @ORM\OneToMany(targetEntity="ImportDetail", mappedBy="import", cascade={"persist", "remove"})
     */
    private $import_details;

    /**
     * @ORM\ManyToOne(targetEntity="Provider", inversedBy="imports")
     * @ORM\JoinColumn(name="id_provider", referencedColumnName="id")
     * @Assert\NotBlank()
     */
    private $provider;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_order", type="datetime")
     */
    private $dateOrder;

    /**
     * @var float
     *
     * @ORM\Column(name="total", type="float")
     * @Assert\NotBlank()
     */
    private $total;

    /**
     * @var string
     *
     * @ORM\Column(name="payment", type="string", length=200, nullable=true)
     */
    private $payment;

    /**
     * @var boolean
     *
     * @ORM\Column(name="verified", type="boolean", options={"default" : 0})
     */
    private $verified;

    /**
     * @var string
     *
     * @ORM\Column(name="note", type="string", length=500, nullable=true)
     */
    private $note;

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
     * @var String
     *
     */
    private $action;

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
     * Set dateOrder
     *
     * @param \DateTime $dateOrder
     *
     * @return Import
     */
    public function setDateOrder($dateOrder)
    {
        $this->dateOrder = $dateOrder;

        return $this;
    }

    /**
     * Get dateOrder
     *
     * @return \DateTime
     */
    public function getDateOrder()
    {
        return $this->dateOrder;
    }

    /**
     * Set total
     *
     * @param float $total
     *
     * @return Import
     */
    public function setTotal($total)
    {
        $this->total = $total;

        return $this;
    }

    /**
     * Get total
     *
     * @return float
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * Set payment
     *
     * @param string $payment
     *
     * @return Import
     */
    public function setPayment($payment)
    {
        $this->payment = $payment;

        return $this;
    }

    /**
     * Get payment
     *
     * @return string
     */
    public function getPayment()
    {
        return $this->payment;
    }

    /**
     * Set note
     *
     * @param string $note
     *
     * @return Import
     */
    public function setNote($note)
    {
        $this->note = $note;

        return $this;
    }

    /**
     * Get note
     *
     * @return string
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Import
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
     * @return Import
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
     * Set action
     *
     * @param string $action
     *
     */
    public function setAction($action)
    {
        $this->action = $action;

        return $this;
    }

    /**
     * Get action
     *
     * @return string
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->import_details = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add importDetail
     *
     * @param \AdminBundle\Entity\ImportDetail $importDetail
     *
     * @return Import
     */
    public function addImportDetail(\AdminBundle\Entity\ImportDetail $importDetail)
    {       
        if(count($this->import_details) > 0) {
            $curr_product_id = ($importDetail->getProduct()) ? $importDetail->getProduct()->getId() : '';
            foreach($this->import_details as $_import_detail) {
                $prev_product_id = $_import_detail->getProduct()->getId();
                if($prev_product_id == $curr_product_id) {
                    $_action = $this->getAction();
                    $sum_quantity = 0;
                    if($_action == 'add') {
                        $sum_quantity = $importDetail->getQuantity() + $_import_detail->getQuantity();
                    } elseif($_action == 'update') {
                        $sum_quantity = $importDetail->getQuantity();
                    }   
                    
                    $_import_detail->setQuantity($sum_quantity);
                    $_import_detail->setUnitPrice($importDetail->getUnitPrice());

                    return;
                }                
            }
        }   
        
        $this->import_details[] = $importDetail;
        
        $importDetail->setImport($this);
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
     * Set provider
     *
     * @param \AdminBundle\Entity\Provider $provider
     *
     * @return Import
     */
    public function setProvider(\AdminBundle\Entity\Provider $provider = null)
    {
        $this->provider = $provider;

        return $this;
    }

    /**
     * Get provider
     *
     * @return \AdminBundle\Entity\Provider
     */
    public function getProvider()
    {
        return $this->provider;
    }

    /**
     * @ORM\PrePersist
     */
    public function setDateOrderValue()
    {
        $this->dateOrder = new \DateTime();
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
     * Set verified
     *
     * @param boolean $verified
     *
     * @return Import
     */
    public function setVerified($verified)
    {
        $this->verified = $verified;

        return $this;
    }

    /**
     * Get verified
     *
     * @return boolean
     */
    public function getVerified()
    {
        return $this->verified;
    }

    /**
     * @ORM\PrePersist
     */
    public function setVerifiedValue()
    {
        $this->verified = 0;
    }
}
