<?php

declare(strict_types=1);

namespace PixelOpen\CloudflareTurnstileBundle\Validator;

use PixelOpen\CloudflareTurnstileBundle\Http\CloudflareTurnstileHttpClient;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

final class CloudflareTurnstileValidator extends ConstraintValidator
{
    private bool $enable;

    private RequestStack $requestStack;

    private CloudflareTurnstileHttpClient $turnstileHttpClient;

    public function __construct(
        bool $enable,
        RequestStack $requestStack,
        CloudflareTurnstileHttpClient $turnstileHttpClient
    ) {
        $this->enable = $enable;
        $this->requestStack = $requestStack;
        $this->turnstileHttpClient = $turnstileHttpClient;
    }

    /**
     * Checks if the passed value is valid.
     *
     * @param mixed $value The value that should be validated
     * @param Constraint $constraint The constraint for the validation
     */
    public function validate($value, Constraint $constraint): void
    {
        if ($this->enable === false) {
            return;
        }

        $request = $this->requestStack->getCurrentRequest();
        \assert($request !== null);
        $turnstileResponse = (string) $request->request->get('cf-turnstile-response');

        if ($turnstileResponse === '') {
            $this->context->buildViolation($constraint->message)
                ->addviolation();

            return;
        }

        if ($this->turnstileHttpClient->verifyResponse($turnstileResponse) === false) {
            $this->context->buildViolation($constraint->message)
                ->addviolation();
        }
    }
}
