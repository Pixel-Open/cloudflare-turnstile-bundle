A simple package to help integrate Cloudflare Turnstile on Symfony Form.
======================

[![Minimum PHP Version](https://img.shields.io/badge/php-%3E%3D%207.4-green)](https://php.net/)
[![Minimum Symfony Version](https://img.shields.io/badge/symfony-%3E%3D%205.4-green)](https://symfony.com)
[![GitHub release](https://img.shields.io/github/v/release/Pixel-Open/cloudflare-turnstile-bundle)](https://github.com/Pixel-Open/cloudflare-turnstile-bundle/releases)

This packages provides helper for setting up and validating Cloudflare Turnstile CAPTCHA responses.

## Installation

You can install the package via Composer:

```bash
composer require pixeldev/cloudflare-turnstile-bundle
```

Add bundle into config/bundles.php file :

```php
PixelDev\CloudflareTurnstileBundle\PixelDevCloudflareTurnstileBundle::class => ['all' => true]
```

Visit Cloudflare to create your site key and secret key and add them to your `.env` file.

```
TURNSTILE_KEY="1x00000000000000000000AA"
TURNSTILE_SECRET="2x0000000000000000000000000000000AA"
```

### Testing

Use the following sitekeys and secret keys for testing purposes:

**Sitekey**

| Sitekey                  | Description                     |
|--------------------------|---------------------------------|
| 1x00000000000000000000AA | Always passes                   |
| 2x00000000000000000000AB | Always blocks                   |
| 3x00000000000000000000FF | Forces an interactive challenge |

**Secret key**

| Secret key                          | Description                          |
|-------------------------------------|--------------------------------------|
| 1x0000000000000000000000000000000AA | Always passes                        |
| 2x0000000000000000000000000000000AA | Always fails                         |
| 3x0000000000000000000000000000000AA | Yields a "token already spent" error |

## Todo

+ Add phpunit to test field and validator

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.