<?php

namespace EventBundle\Event\Dispatcher;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use EventBundle\ModelEvents;
use EventBundle\Event\ModelEvent;

/**
 * Log domain events
 */
class Logger implements EventSubscriberInterface
{
    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return [
            ModelEvents::CREATED => 'log',
            ModelEvents::UPDATED => 'log',
            ModelEvents::DELETED => 'log',
        ];
    }

    /**
     * Log events
     *
     * @param ModelEvent $event
     */
    public function log(ModelEvent $event)
    {
        dump($event);
    }
}
