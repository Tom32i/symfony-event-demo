<?php

namespace EventBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * Event Bundle Extension
 */
class EventExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));

        $loader->load('services.yml');

        if ($container->getParameter('kernel.debug')) {
            $loader->load('debug.yml');

            $definition = $container->findDefinition('delayed_event_dispatcher');
            //$definition->setPublic(false);
            $container->setDefinition('debug.delayed_event_dispatcher.parent', $definition);
            $container->setAlias('delayed_event_dispatcher', 'debug.delayed_event_dispatcher');
        }

        $loader->load('doctrine.yml');
    }
}
