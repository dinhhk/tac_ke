<?php
 
namespace AdminBundle\Validator\Constraints;
 
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\HttpFoundation\RequestStack;

class UnitPriceOverCostPriceValidator extends ConstraintValidator
{
    /**
     * RequestStack instance.
     *
     * @var Symfony\Component\HttpFoundation\RequestStack
     */
    protected $requestStack;

    /**
     * dependency injection.
     *
     * @param Symfony\Component\HttpFoundation\RequestStack $requestStack
     */
    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

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
        $bill_details = $this->requestStack->getCurrentRequest()->request->get('admin_bill')['bill_details'];
        $exists_product_id = $this->context->getObject()->getProduct()->getId();
        $input_product_id = isset($bill_details['__name__']['product']) && !empty($bill_details['__name__']['product']) ? $bill_details['__name__']['product'] : '';
        if($exists_product_id && $input_product_id && $exists_product_id == $input_product_id) {
            $input_unit_price = isset($bill_details['__name__']['unitPrice']) && !empty($bill_details['__name__']['unitPrice']) ? $bill_details['__name__']['unitPrice'] : '';
            $cost_price = (float) $this->context->getRoot()->getData()->getTmpCostPrice();
            $message = '';
            if($input_unit_price < $cost_price) {
                $message = $constraint->message;
            }

            if($message) {
                $this->context->addViolation(
                    $message,
                    array('%string%' => $value)
                );

                return FALSE;
            }

        } 
        
        return TRUE;
    }
}