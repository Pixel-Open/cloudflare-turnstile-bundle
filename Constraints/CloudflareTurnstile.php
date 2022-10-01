<?php

namespace PixelDev\CloudflareTurnstileBundle\Constraints;

use Symfony\Component\Validator\Constraint;

class CloudflareTurnstile extends Constraint
{

    public $message = 'invalid_captcha';

}
