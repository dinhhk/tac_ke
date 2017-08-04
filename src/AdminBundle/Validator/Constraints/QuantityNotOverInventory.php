<?php
 
namespace AdminBundle\Validator\Constraints;
 
use Symfony\Component\Validator\Constraint;
 
/**
 * @Annotation
 */
class QuantityNotOverInventory extends Constraint
{
    /**
     *
     * @var string
     */
    public $message = 'The quantity should not over inventory.';

    /**
     * 
     * @return string
     */
    public function validatedBy()
    {
        return 'quantity_not_over_inventory';
    }
 
    /**
     * Get class constraints and properties
     * 
     * @return array
     */
    public function getTargets()
    {
        return array(self::CLASS_CONSTRAINT, self::PROPERTY_CONSTRAINT);
    }    
}