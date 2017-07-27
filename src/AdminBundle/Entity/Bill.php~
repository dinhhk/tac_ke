<?php

namespace AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Bill
 *
 * @ORM\Table(name="bill")
 * @ORM\Entity(repositoryClass="AdminBundle\Repository\BillRepository")
 */
class Bill
{
    /**
     * @ORM\OneToMany(targetEntity="BillDetail", mappedBy="bill")
     */
    private $bill_details;

    /**
     * @ORM\ManyToOne(targetEntity="Customer", inversedBy="bills")
     * @ORM\JoinColumn(name="id_customer", referencedColumnName="id")
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
     */
    private $total;

    /**
     * @var string
     *
     * @ORM\Column(name="payment", type="string", length=200, nullable=true)
     */
    private $payment;

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
}
