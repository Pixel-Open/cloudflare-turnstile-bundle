<?php

declare(strict_types=1);
namespace PixelDev\CloudflareTurnstileBundle;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class PixelDevCloudflareTurnstileBundle extends Bundle
{
    public function build(ContainerBuilder $container): void
    {
        parent::build($container);
        $container->addCompilerPass(new PixelDevCloudflareTurnstileCompilerPass());
    }
}
