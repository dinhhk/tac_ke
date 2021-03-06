<?php

namespace AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\Request;

/**
 * Bill
 *
 * @ORM\Table(name="bill")
 * @ORM\Entity(repositoryClass="AdminBundle\Repository\BillRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Bill
{
    /**
     * @ORM\OneToMany(targetEntity="BillDetail", mappedBy="bill", cascade={"persist", "remove"})
     */
    private $bill_details;

    /**
     * @ORM\ManyToOne(targetEntity="Customer", inversedBy="bills")
     * @ORM\JoinColumn(name="id_customer", referencedColumnName="id")
     * @Assert\NotBlank()
     */
    private $customer;

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
     * @ORM\Column(name="note", type="string", length=255, nullable=true)
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
     * @var String
     *
     */
    private $tmpInventory;

    /**
     * @var String
     *
     */
    private $tmpInventoryWait;

    /**
     * @var String
     *
     */
    private $tmpCostPrice;

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
     * @return Bill
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
     * @return Bill
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
     * @return Bill
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
     * @return Bill
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
     * @return Bill
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
     * @return Bill
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
     * Set tmpInventory
     *
     * @param string $tmpInventory
     *
     */
    public function setTmpInventory($tmpInventory)
    {
        $this->tmpInventory = $tmpInventory;

        return $this;
    }

    /**
     * Get tmpInventory
     *
     * @return string
     */
    public function getTmpInventory()
    {
        return $this->tmpInventory;
    }

    /**
     * Set tmpInventoryWait
     *
     * @param string $tmpInventoryWait
     *
     */
    public function setTmpInventoryWait($tmpInventoryWait)
    {
        $this->tmpInventoryWait = $tmpInventoryWait;

        return $this;
    }

    /**
     * Get tmpInventoryWait
     *
     * @return string
     */
    public function getTmpInventoryWait()
    {
        return $this->tmpInventoryWait;
    }

    /**
     * Set tmpCostPrice
     *
     * @param string $tmpCostPrice
     *
     */
    public function setTmpCostPrice($tmpCostPrice)
    {
        $this->tmpCostPrice = $tmpCostPrice;

        return $this;
    }

    /**
     * Get tmpCostPrice
     *
     * @return string
     */
    public function getTmpCostPrice()
    {
        return $this->tmpCostPrice;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->bill_details = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add billDetail
     *
     * @param \AdminBundle\Entity\BillDetail $billDetail
     *
     * @return Bill
     */
    public function addBillDetail(\AdminBundle\Entity\BillDetail $billDetail)
    {
        if(count($this->bill_details) > 0) {
            $curr_product_id = ($billDetail->getProduct()) ? $billDetail->getProduct()->getId() : '';
            foreach($this->bill_details as $_bill_detail) {
                $prev_product_id = $_bill_detail->getProduct()->getId();
                if($prev_product_id == $curr_product_id) {
                    $_action = $this->getAction();
                    $sum_quantity = 0;
                    if($_action == 'add') {
                        $sum_quantity = $billDetail->getQuantity() + $_bill_detail->getQuantity();
                    } elseif($_action == 'update') {
                        $sum_quantity = $billDetail->getQuantity();
                    }   
                    
                    $_bill_detail->setQuantity($sum_quantity);
                    $_bill_detail->setUnitPrice($billDetail->getUnitPrice());

                    return;
                }                
            }
        } 

        $this->bill_details[] = $billDetail;
        $billDetail->setBill($this);
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
     * Set customer
     *
     * @param \AdminBundle\Entity\Customer $customer
     *
     * @return Bill
     */
    public function setCustomer(\AdminBundle\Entity\Customer $customer = null)
    {
        $this->customer = $customer;

        return $this;
    }

    /**
     * Get customer
     *
     * @return \AdminBundle\Entity\Customer
     */
    public function getCustomer()
    {
        return $this->customer;
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
     * @return Bill
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
