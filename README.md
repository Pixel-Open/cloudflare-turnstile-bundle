A simple package to help integrate Cloudflare Turnstile on Symfony Form.
======================

[![Minimum PHP Version](https://img.shields.io/badge/php-%3E%3D%207.4-green)](https://php.net/)
[![Minimum Symfony Version](https://img.shields.io/badge/symfony-%3E%3D%205.4-green)](https://symfony.com)
[![GitHub release](https://img.shields.io/github/v/release/Pixel-Open/cloudflare-turnstile-bundle)](https://github.com/Pixel-Open/cloudflare-turnstile-bundle/releases)
[![Codacy Badge](https://app.codacy.com/project/badge/Grade/ddb39773b71a4ad2ac4bd08fbb7b09e3)](https://www.codacy.com/gh/Pixel-Open/cloudflare-turnstile-bundle/dashboard?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=Pixel-Open/cloudflare-turnstile-bundle&amp;utm_campaign=Badge_Grade)

This packages provides helper for setting up and validating Cloudflare Turnstile CAPTCHA responses.

![Cloudflare Turnstile for Symfony Form](screenshot.png)

## Installation

You can install the package via Composer:

```bash
composer require pixelopen/cloudflare-turnstile-bundle
```

Add bundle into config/bundles.php file :

```php
PixelOpen\CloudflareTurnstileBundle\PixelOpenCloudflareTurnstileBundle::class => ['all' => true]
```
Add a config file into config/packages/pixel_open_cloudflare_turnstile.yaml : 

```yaml
pixel_open_cloudflare_turnstile:
  key: '%env(TURNSTILE_KEY)%'
  secret: '%env(TURNSTILE_SECRET)%'
```

Visit Cloudflare to create your site key and secret key and add them to your `.env` file.

```
TURNSTILE_KEY="1x00000000000000000000AA"
TURNSTILE_SECRET="2x0000000000000000000000000000000AA"
```

### Use with your Symfony Form

Create a form type and insert an Turnstile Type to add a Cloudflare Turnstile : 

```php
<?php

namespace App\Form;

use App\Entity\Contact;
use PixelOpen\CloudflareTurnstileBundle\Type\TurnstileType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, ['label' => false, 'attr' => ['placeholder' => 'name']])
            ->add('message', TextareaType::class, ['label' => false, 'attr' => ['placeholder' => 'message']])
            ->add('security', TurnstileType::class, ['attr' => ['data-action' => 'contact', 'data-theme' => 'dark'], 'label' => false])
            ->add('submit', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}
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