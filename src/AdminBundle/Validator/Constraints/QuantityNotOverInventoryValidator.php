<?php
 
namespace AdminBundle\Validator\Constraints;
 
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\HttpFoundation\RequestStack;

class QuantityNotOverInventoryValidator extends ConstraintValidator
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
        // dump($this->context->getObject()->getQuantity());
        // dump($this->context->getObject());
        // dump($this->requestStack->getCurrentRequest()->request->get('admin_bill')['bill_details']['__name__']);exit;

        $bill_details = $this->requestStack->getCurrentRequest()->request->get('admin_bill')['bill_details'];
        $exists_product_id = $this->context->getObject()->getProduct()->getId();
        $input_product_id = isset($bill_details['__name__']['product']) && !empty($bill_details['__name__']['product']) ? $bill_details['__name__']['product'] : '';
        if($exists_product_id && $input_product_id && $exists_product_id == $input_product_id) {
            $input_quantity = isset($bill_details['__name__']['quantity']) && !empty($bill_details['__name__']['quantity']) ? $bill_details['__name__']['quantity'] : '';
            $exists_quantity = $this->context->getObject()->getQuantity();

            $compare_value = 0;
            if($input_quantity != $exists_quantity) {
                $compare_value = $value;
            } else {
                $inventory_wait = (float) $this->context->getRoot()->getData()->getTmpInventoryWait();
                $compare_value = $inventory_wait + $input_quantity;
            }

            $inventory = (float) $this->context->getRoot()->getData()->getTmpInventory();
            $message = '';
            if($compare_value > $inventory) {
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