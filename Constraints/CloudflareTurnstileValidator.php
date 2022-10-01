<?php

namespace PixelDev\CloudflareTurnstileBundle\Constraints;


use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Contracts\HttpClient\HttpClientInterface;


class CloudflareTurnstileValidator extends ConstraintValidator
{

    /**
     * @var string
     */
    private $secret;

    /**
     * @var RequestStack
     */
    private $requestStack;

    /**
     * @var HttpClientInterface
     */
    private $httpClient;


    /**
     * @param string $secret
     * @param RequestStack $requestStack
     * @param HttpClientInterface $httpClient
     */
    public function __construct(string $secret, RequestStack $requestStack, HttpClientInterface $httpClient)
    {
        $this->secret = $secret;
        $this->requestStack = $requestStack;
        $this->httpClient = $httpClient;
    }

    /**
     * Checks if the passed value is valid.
     *
     * @param mixed $value The value that should be validated
     * @param Constraint $constraint The constraint for the validation
     */
    public function validate($value, Constraint $constraint): void
    {
        $request = $this->requestStack->getCurrentRequest();
        $turnstileResponse = $request->request->get('cf-turnstile-response');

        if (empty($turnstileResponse)) {
            $this->addviolation($constraint);
            return;
        }

        $response = $this->httpClient->request(
            'POST',
            'https://challenges.cloudflare.com/turnstile/v0/siteverify',
            ['body' => ['response' => $turnstileResponse, 'secret' => $this->secret]]
        );
        $content = $response->toArray();

        if (!$content['success']) {
            $this->addviolation($constraint);
            return;
        }

    }

    private function addViolation(Constraint $constraint): void
    {
        $this->context->buildViolation($constraint->message)->addViolation();
    }
}
