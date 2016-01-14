<?php

namespace StoreBundle\Service;

use EventBundle\Event\ModelEvent;
use EventBundle\Event\ModelChangedEvent;
use EventBundle\Event\ModelDeletedEvent;
use EventBundle\ModelEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

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
            ModelEvents::CREATED => 'onCreated',
            ModelEvents::UPDATED => 'onUpdated',
            ModelEvents::DELETED => 'onDeleted',
        ];
    }

    /**
     * On model created
     *
     * @param ModelEvent $event
     */
    public function onCreated(ModelEvent $event)
    {
        $this->log(sprintf(
            '%s %s has been created.',
            get_class($event->getModel()),
            $event->getModel()->getId()
        ));
    }

    /**
     * On model updated
     *
     * @param ModelEvent $event
     */
    public function onUpdated(ModelChangedEvent $event)
    {
        $this->log(sprintf(
            '%s %s has been modified: [%s].',
            get_class($event->getModel()),
            $event->getModel()->getId(),
            implode(', ', $event->getChanges())
        ));
    }

    /**
     * On model deleted
     *
     * @param ModelEvent $event
     */
    public function onDeleted(ModelDeletedEvent $event)
    {
        $this->log(sprintf(
            '%s %s has been deleted.',
            get_class($event->getModel()),
            implode('-', $event->getIdentifiers())
        ));
    }

    /**
     * Log events
     *
     * @param string $message
     */
    public function log($message)
    {
        dump($message);
    }
}
