<?php

namespace EventBundle\Event\Dispatcher;

use Symfony\Component\EventDispatcher\ContainerAwareEventDispatcher;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * Dispatch events on Kernel Terminate
 */
class DelayedEventDispatcher extends ContainerAwareEventDispatcher implements EventSubscriberInterface
{
    /**
     * Queued events
     *
     * @var array
     */
    private $queue = [];

    /**
     * Is the dispatcher ready to dispatch events?
     *
     * @var boolean
     */
    private $ready = false;

    /**
     * {@inheritdoc}
     */
    public function dispatch($eventName, Event $event = null)
    {
        if (!$this->ready) {
            $this->queue[] = ['name' => $eventName, 'event' => $event];

            return $event;
        }

        return parent::dispatch($eventName, $event);
    }

    /**
     * Set ready
     */
    public function setReady()
    {
        if (!$this->ready) {
            $this->ready = true;

            foreach ($this->queue as $item) {
                $this->dispatch($item['name'], $item['event']);
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return [KernelEvents::TERMINATE => 'setReady'];
    }
}
