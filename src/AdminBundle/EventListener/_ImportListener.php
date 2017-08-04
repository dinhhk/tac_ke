<?php 

namespace AdminBundle\EventListener;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use AdminBundle\Entity\Import;
use AdminBundle\Entity\ImportDetail;
use Symfony\Component\HttpFoundation\Response;

class ImportListener
{
	/**
     * @var ContainerInterface
     */
    private $_container;

    /**
     * DoctrineListener constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->_container = $container;
    }

    /**
     * @param LifecycleEventArgs $args
     */
    public function preUpdate(LifecycleEventArgs $args)
    {
    	$entity = $args->getEntity();
    	if ($entity instanceof ImportDetail) {
    		$entity->getImport()->setTotal(10000);

	    	// $entityManager = $args->getEntityManager();
	    	// $entityManager->merge($entity->getImport());
	    	// $entityManager->flush();
    	} 
    	
        // // perhaps you only want to act on some "Product" entity
        // if ($entity instanceof ImportDetail) {
        //     $entityManager = $args->getEntityManager();
       		  
        // }
    }


}