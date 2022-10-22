<?php

declare(strict_types=1);
namespace PixelOpen\CloudflareTurnstileBundle\Constraints;

use Symfony\Component\Validator\Constraint;

class CloudflareTurnstile extends Constraint
{
    /**
     * @var string
     */
    public $message = 'invalid_turnstile';
}
