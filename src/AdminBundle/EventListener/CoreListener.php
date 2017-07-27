<?php
namespace AdminBundle\EventListener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\HttpFoundation\Response;
use AdminBundle\Entity\ImportDetail;
use AdminBundle\Entity\Import;
use AdminBundle\Entity\Core;

class CoreListener {

    private $em;
    private $id_core; 
    private $day;
    private $month; 
    private $year;  
    private $id_product;
    private $product;
    private $quantity;
    private $total_quantity;

    /**
     * Hook postPersists
     */
    public function postPersist(LifecycleEventArgs $args)
    {
        $this->prepareDataImport($args);
    }

    /**
     * Hook postUpdate
     */
    public function postUpdate(LifecycleEventArgs $args)
    {
        $this->prepareDataImport($args);
    }

    public function postRemove(LifecycleEventArgs $args) {
        $this->prepareDataImport($args);
    }
    
    /**
     * Prepare data import to insert or update to core
     */
    public function prepareDataImport($args)
    {   
        $entity = $args->getEntity();
        $this->em = $args->getEntityManager();

        if ($entity instanceof ImportDetail) {
            $import = $entity->getImport();

            $created_at = $import->getCreatedAt();
            $updated_at = $import->getUpdatedAt();

            $this->year = $updated_at->format('Y');
            $this->month = $updated_at->format('m');
            $this->day = $updated_at->format('d'); 

            $created_at_month = $created_at->format('m');
            $updated_at_month = $updated_at->format('m');
            $current_month = date("m");

            if($current_month == $created_at_month && $current_month == $updated_at_month) {
                $this->id_product = $entity->getProduct()->getId();
                $this->product = $entity->getProduct();
                $this->quantity = $entity->getQuantity();
                $this->total_quantity = $this->getTotalQuantity();

                $this->processDataImport();
            }
        } 
    }

    /**
     * Get total quantity in month with id_product
     */
    public function getTotalQuantity() {
        $month_start = date('Y-m-d h:i:j', strtotime('first day of this month', mktime(0,0,0)));
        return $this->em->getRepository('AdminBundle:ImportDetail')->getTotalQuantityByDateProductId($month_start, $this->id_product);
    }

    /**
     * Process data import
     */
    public function processDataImport() {
        $core = $this->em->getRepository('AdminBundle:Core')->getCoreByYMDProductId(
            $this->year,
            $this->month,
            $this->day,
            $this->id_product
        );

        if($core) {
            $this->updateImportToCore($core);
        } else {
            $this->addImportToCore();
        }
    }

    /**
     * Add total import to core
     */
    public function addImportToCore() {
        $_em = $this->em;
        $core = new Core();
        $core->setYear($this->year);
        $core->setMonth($this->month);
        $core->setDay($this->day);
        $core->setProduct($this->product);
        $core->setTondk(0);
        $core->setNhaptk($this->quantity);
        $core->setXuattk(0);
        $core->setTonck($this->quantity);
        $_em->persist($core);
        $_em->flush();

        //return new Response('Core id ' . $notification->getId() . ' successfully added');
    }

    /**
     * Update total import in core
     */
    public function updateImportToCore(Core $core)
    {
        if($core) {
            $tondk = $core->getTondk();
            $old_nhaptk = $core->getNhaptk();
            $xuattk = $core->getXuattk();

            $new_nhaptk = $this->total_quantity;
            $new_tonck = ($tondk + $new_nhaptk) - $xuattk;

            $core->setNhaptk($new_nhaptk);
            $core->setTonck($new_tonck);
            $this->em->flush();   
        }
    }
}