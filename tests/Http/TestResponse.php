<?php

declare(strict_types=1);

namespace PixelOpen\CloudflareTurnstileBundle\Http;

use Symfony\Component\HttpClient\Exception\JsonException;
use Symfony\Contracts\HttpClient\ResponseInterface;

final class TestResponse implements ResponseInterface
{
    private string $content;

    private array $contentAsArray;

    public function __construct(array $contentAsArray = [], string $content = '')
    {
        $this->content = $content;
        $this->contentAsArray = $contentAsArray;
    }

    public function getStatusCode(): int
    {
        return 200;
    }

    public function getHeaders(bool $throw = true): array
    {
        return [];
    }

    public function getContent(bool $throw = true): string
    {
        return $this->content;
    }

    public function cancel(): void
    {
        // do nothing
    }

    public function getInfo(?string $type = null): mixed
    {
        return [];
    }

    public function toArray(bool $throw = true): array
    {
        if ($throw && $this->content === 'throwException') {
            throw new JsonException('test error');
        }

        return $this->contentAsArray;
    }
}
