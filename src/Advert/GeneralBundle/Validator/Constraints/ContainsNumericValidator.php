<?php
namespace Advert\GeneralBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * ContainsNumericValidator class
 */
class ContainsNumericValidator extends ConstraintValidator
{
    /**
     * validate function for string that contains only digits
     *
     * @param string     $value
     * @param Constraint $constraint
     */
    public function validate($value, Constraint $constraint)
    {
        if (null === $value || '' === $value) {
            return;
        }
        if (!preg_match('/^[0-9]+$/', $value)) {
            $this->context->addViolation($constraint->message, array('%string%' => $value));
        }
    }
}