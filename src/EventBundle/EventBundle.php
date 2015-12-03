<?php

namespace EventBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\EventDispatcher\DependencyInjection\RegisterListenersPass;

/**
 * Event bundle
 */
class EventBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new RegisterListenersPass(
            'delayed_event_dispatcher',
            'delayed.event_listener',
            'delayed.event_subscriber'
        ));
    }
}
