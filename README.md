A simple package to help integrate Cloudflare Turnstile on Symfony Form.
======================

This packages provides helper for setting up and validating Cloudflare Turnstile CAPTCHA responses.

## Installation

You can install the package via Composer:

```bash
composer require pixeldev/cloudflare-turnstile-bundle
```

Visit Cloudflare to create your site key and secret key and add them to your `.env` file.

```
TURNSTILE_KEY="1x00000000000000000000AA"
TURNSTILE_SECRET="2x0000000000000000000000000000000AA"
```

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.