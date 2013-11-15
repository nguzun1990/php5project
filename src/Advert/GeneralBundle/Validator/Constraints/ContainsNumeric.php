<?php
namespace Advert\GeneralBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * ContainsNumeric class - validate if it contains only digits
 *
 * @Annotation
 */
class ContainsNumeric extends Constraint
{
    public $message = 'The string "%string%" contains an illegal character: it can only contain numbers.';
}

