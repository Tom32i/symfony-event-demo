<?php

namespace EventBundle\Event\Subscriber;

use EventBundle\Event\ModelEvent;
use EventBundle\ModelEvents;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Doctrine subscriber
 */
class DoctrineSubscriber implements EventSubscriber
{
    /**
     *  Event Dispatcher
     *
     * @var EventDispatcherInterface
     */
    private $dispatcher;

    /**
     * Constructor
     *
     * @param EventDispatcherInterface $dispatcher
     */
    public function __construct(EventDispatcherInterface $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    /**
     * {@inheritdoc}
     */
    public function getSubscribedEvents()
    {
        return [
            'postPersist',
            'postUpdate',
            'postRemove',
        ];
    }

    /**
     * Post persist event handler
     *
     * @param LifecycleEventArgs $args
     */
    public function postPersist(LifecycleEventArgs $args)
    {
        $event = new ModelEvent($args->getEntity());

        $this->dispatcher->dispatch(ModelEvents::CREATED, $event);
    }

    /**
     * Post update event handler
     *
     * @param LifecycleEventArgs $args
     */
    public function postUpdate(LifecycleEventArgs $args)
    {
        $event = new ModelEvent($args->getEntity());

        $this->dispatcher->dispatch(ModelEvents::UPDATED, $event);
    }

    /**
     * Post remove event handler
     *
     * @param LifecycleEventArgs $args
     */
    public function postRemove(LifecycleEventArgs $args)
    {
        $event = new ModelEvent($args->getEntity());

        $this->dispatcher->dispatch(ModelEvents::DELETED, $event);
    }
}
