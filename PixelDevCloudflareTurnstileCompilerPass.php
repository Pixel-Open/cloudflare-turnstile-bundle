<?php
namespace PixelDev\CloudflareTurnstileBundle;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class PixelDevCloudflareTurnstileCompilerPass implements CompilerPassInterface {

    /**
     * You can modify the container here before it is dumped to PHP code.
     */
    public function process(ContainerBuilder $container)
    {
        if ($container->hasParameter('twig.form.resources')) {
            $resources = $container->getParameter('twig.form.resources') ?: [];
            array_unshift($resources, '@PixelDevCloudflareTurnstile/fields.html.twig');
            $container->setParameter('twig.form.resources', $resources);
        }
    }
}
