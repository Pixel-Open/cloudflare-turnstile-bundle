<?php

declare(strict_types=1);

namespace PixelOpen\CloudflareTurnstileBundle\Validator;

use Symfony\Component\Validator\Constraint;

#[\Attribute(\Attribute::TARGET_PROPERTY | \Attribute::TARGET_METHOD)]
final class CloudflareTurnstile extends Constraint
{
    public string $message = 'invalid_turnstile';
}
