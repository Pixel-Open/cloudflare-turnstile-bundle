<?php

declare(strict_types=1);

namespace PixelOpen\CloudflareTurnstileBundle\Http;

use PHPUnit\Framework\TestCase;
use Psr\Log\NullLogger;
use Symfony\Contracts\HttpClient\HttpClientInterface;

final class CloudflareTurnstileHttpClientTest extends TestCase
{
    private const DUMMY_SECRET = 'dummy-secret';

    private const DUMMY_TURNSTILE_RESPONSE = 'dummy-response';

    /**
     * @dataProvider provideResponseContents
     */
    public function testShouldVerifyResponse(bool $expectedVerificationResult, array $responseContent): void
    {
        $httpClientMock = $this->createMock(HttpClientInterface::class);
        $httpClientMock
            ->expects(self::once())
            ->method('request')
            ->with(
                'POST',
                'https://challenges.cloudflare.com/turnstile/v0/siteverify',
                [
                    'body' => [
                        'response' => 'dummy-response',
                        'secret' => 'dummy-secret',
                    ],
                ],
            )
            ->willReturn(new TestResponse($responseContent));

        $testLogger = new NullLogger();
        $turnstileHttpClient = new CloudflareTurnstileHttpClient(self::DUMMY_SECRET, $httpClientMock, $testLogger);

        $actualVerificationResult = $turnstileHttpClient->verifyResponse(self::DUMMY_TURNSTILE_RESPONSE);

        self::assertSame($expectedVerificationResult, $actualVerificationResult);
    }

    public static function provideResponseContents(): iterable
    {
        yield 'successful verification' => [
            true, [
                'success' => true,
            ]];
        yield 'failed verification' => [
            false, [
                'success' => false,
            ]];
        yield 'invalid response format' => [
            false, [
                'success' => 'true',
            ]];
        yield 'invalid response format 2' => [
            false, [
                'success' => null,
            ]];
        yield 'invalid response - missing success field' => [
            false, [
                'verified' => true,
            ]];
    }

    public function testShouldFailVerificationWhenHttpExceptionThrown(): void
    {
        $httpClientMock = $this->createMock(HttpClientInterface::class);
        $httpClientMock
            ->expects(self::once())
            ->method('request')
            ->with(
                'POST',
                'https://challenges.cloudflare.com/turnstile/v0/siteverify',
                [
                    'body' => [
                        'response' => 'dummy-response',
                        'secret' => 'dummy-secret',
                    ],
                ],
            )
            ->willReturn(new TestResponse([
                'success' => true,
            ], 'throwException'));

        $testLogger = new NullLogger();
        $turnstileHttpClient = new CloudflareTurnstileHttpClient(self::DUMMY_SECRET, $httpClientMock, $testLogger);

        $verificationResult = $turnstileHttpClient->verifyResponse(self::DUMMY_TURNSTILE_RESPONSE);

        self::assertFalse($verificationResult);
    }
}
