<?php

declare(strict_types=1);

namespace PixelOpen\CloudflareTurnstileBundle\Http;

use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\HttpClient\Exception\ExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

final readonly class CloudflareTurnstileHttpClient
{
    private const SITEVERIFY_ENDPOINT = 'https://challenges.cloudflare.com/turnstile/v0/siteverify';

    public function __construct(
        private string $secret,
        private HttpClientInterface $httpClient,
        private LoggerInterface $logger,
    ) {}

    public function verifyResponse(string $turnstileResponse): bool
    {
        $response = $this->httpClient->request(
            Request::METHOD_POST,
            self::SITEVERIFY_ENDPOINT,
            [
                'body' => [
                    'response' => $turnstileResponse,
                    'secret' => $this->secret,
                ],
            ]
        );

        try {
            $content = $response->toArray();
        } catch (ExceptionInterface $e) {
            $this->logger->error(
                \sprintf(
                    'Cloudflare Turnstile HTTP exception (%s) with a message: %s',
                    $e::class,
                    $e->getMessage(),
                ),
            );

            return false;
        }

        return \array_key_exists('success', $content) && $content['success'] === true;
    }
}
