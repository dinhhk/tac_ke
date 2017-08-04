<?php

namespace AdminBundle\Util;
use Doctrine\ORM\EntityManagerInterface;

class ImportUtil {
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function updateTotalPrice($import_id)
    {
        $total = $this->em->getRepository('AdminBundle:ImportDetail')->getTotalPrice($import_id);
        $bill = $this->em->getRepository('AdminBundle:Import')->find($import_id);
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
