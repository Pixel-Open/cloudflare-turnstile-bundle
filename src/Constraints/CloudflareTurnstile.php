<?php

declare(strict_types=1);
namespace PixelDev\CloudflareTurnstileBundle\Constraints;

use Symfony\Component\Validator\Constraint;

class CloudflareTurnstile extends Constraint
{
    /**
     * @var string
     */
    public $message = 'invalid_captcha';
}
