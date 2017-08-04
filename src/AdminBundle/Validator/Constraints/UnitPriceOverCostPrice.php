<?php
 
namespace AdminBundle\Validator\Constraints;
 
use Symfony\Component\Validator\Constraint;
 
/**
 * @Annotation
 */
class UnitPriceOverCostPrice extends Constraint
{
    /**
     *
     * @var string
     */
    public $message = 'The unit price should over cost price.';

    /**
     * 
     * @return string
     */
    public function validatedBy()
    {
        return 'unit_price_over_cost_price';
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