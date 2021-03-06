<?php

namespace AdminBundle\Repository;
use Doctrine\ORM\EntityRepository;
/**
 * ImportDetailRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ImportDetailRepository extends EntityRepository
{
	public function getTotalPrice($id) {
		$results = array();
		if($id) {
			$query = $this->createQueryBuilder('ipd')
	            ->select('SUM(ipd.quantity*ipd.unitPrice) as total')
	            ->where('ipd.import = :id')
	            ->setParameter(':id', $id)
	            ->getQuery();

	        $results = $query->getSingleScalarResult();	
		}
		
        return $results;
	}

	public function getTotalQuantityByDateProductId($date, $id_product) {
		$results = array();
		if($date && $id_product) {
			$query = $this->createQueryBuilder('ipd')
	            ->select('SUM(ipd.quantity) as total_quantity')
	            ->where('ipd.createdAt > :date')
	            ->andwhere('ipd.product = :id_product')
	            ->setParameters(
	            	array(
	            		':date' => $date,
	            		':id_product' => $id_product,
	            	)
	            )
	            ->getQuery();

	        $results = $query->getSingleScalarResult();	
		}
		
        return $results;
	}

	public function getCostPriceByProductId($id_product) {
		if($id_product) {
			$query = $this->createQueryBuilder('ipd')
	            ->select('ipd.unitPrice as cost_price')
	            ->andWhere('ipd.product = :id_product')
	            ->setParameters(
	            	array(
	            		':id_product' => $id_product,
	            	)
	            )
	            ->orderBy('ipd.updatedAt', 'DESC')
				->setMaxResults(1)
	            ->getQuery();

	    	return $query->getOneOrNullResult();	
		}
			
		return FALSE;
	}
}
