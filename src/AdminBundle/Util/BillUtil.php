<?php

namespace AdminBundle\Util;
use Doctrine\ORM\EntityManagerInterface;

class BillUtil {
    private $em;
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function updateTotalPrice($bill_id)
    {
        $total = $this->em->getRepository('AdminBundle:BillDetail')->getTotalPrice($bill_id);
        $bill = $this->em->getRepository('AdminBundle:Bill')->find($bill_id);
        if($bill) {
            $_total = ($total === null) ? 0 : $total;
            $bill->setTotal($_total);
            try {
                $this->em->flush();
                return $_total;
            } catch (\Exception $e) {
                return FALSE;
            }
        }   
    
        return FALSE;
    }

}
