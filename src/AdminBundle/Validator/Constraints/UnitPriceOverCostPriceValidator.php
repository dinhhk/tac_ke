<?php
 
namespace AdminBundle\Validator\Constraints;
 
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
 
class UnitPriceOverCostPriceValidator extends ConstraintValidator
{
    /**
     * Method to validate
     * 
     * @param string                                  $value      Property value    
     * @param \Symfony\Component\Validator\Constraint $constraint All properties
     * 
     * @return boolean
     */
    public function validate($value, Constraint $constraint)
    {
        $cost_price = $this->context->getRoot()->getData()->getTmpCostPrice();

        $message = '';
        if($value < $cost_price) {
            $message = $constraint->message;
        }

        if($message) {
            $this->context->addViolation(
                $message,
                array('%string%' => $value)
            );

            return FALSE;
        }
        
        return TRUE;
    }
}