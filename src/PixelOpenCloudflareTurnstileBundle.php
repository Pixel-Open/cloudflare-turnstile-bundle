<?php

declare(strict_types=1);
namespace PixelOpen\CloudflareTurnstileBundle;

use PixelOpen\CloudflareTurnstileBundle\PixelOpenCloudflareTurnstileCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class PixelOpenCloudflareTurnstileBundle extends Bundle
{
    public function build(ContainerBuilder $container): void
    {
        parent::build($container);
        $container->addCompilerPass(new PixelOpenCloudflareTurnstileCompilerPass());
    }
}
