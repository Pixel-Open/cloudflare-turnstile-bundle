<?php

declare(strict_types=1);

namespace PixelOpen\CloudflareTurnstileBundle;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

final class PixelOpenCloudflareTurnstileCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        if ($container->hasParameter('twig.form.resources')) {
            /** @var array<int, string> $resources */
            $resources = $container->getParameter('twig.form.resources') ?: [];
            array_unshift($resources, '@PixelOpenCloudflareTurnstile/fields.html.twig');
            $container->setParameter('twig.form.resources', $resources);
        }
    }
}
