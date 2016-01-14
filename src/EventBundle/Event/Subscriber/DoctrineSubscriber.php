<?php

namespace EventBundle\Event\Subscriber;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use EventBundle\Event\ModelEvent;
use EventBundle\Event\ModelChangedEvent;
use EventBundle\Event\ModelDeletedEvent;
use EventBundle\ModelEvents;
use EventBundle\Utils\Inventory;
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
     * Store entities change set and identifiers
     *
     * @var Inventory
     */
    private $inventory;

    /**
     * Constructor
     *
     * @param EventDispatcherInterface $dispatcher
     */
    public function __construct(EventDispatcherInterface $dispatcher)
    {
        $this->dispatcher = $dispatcher;
        $this->inventory  = new Inventory();
    }

    /**
     * {@inheritdoc}
     */
    public function getSubscribedEvents()
    {
        return [
            'postPersist',
            'preUpdate',
            'postUpdate',
            'preRemove',
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
     * Store change set for the entity
     *
     * @param PreUpdateEventArgs $args
     */
    public function preUpdate(PreUpdateEventArgs $args)
    {
        $this->inventory->setChangeSet($args->getEntity(), $args->getEntityChangeSet());
    }

    /**
     * Retrieve change set and dispatch an Updated event
     *
     * @param LifecycleEventArgs $args
     */
    public function postUpdate(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        $event  = new ModelChangedEvent($entity, $this->inventory->getChangeSet($entity));

        $this->dispatcher->dispatch(ModelEvents::UPDATED, $event);
    }

    /**
     * Pre remove event handler
     *
     * @param LifecycleEventArgs $args
     */
    public function preRemove(LifecycleEventArgs $args)
    {
        $entity        = $args->getEntity();
        $classMetadata = $args->getEntityManager()->getClassMetadata(get_class($entity));
        $identifiers   = $classMetadata->getIdentifierValues($entity);

        $this->inventory->setIdentifiers($entity, $identifiers);
    }

    /**
     * Post remove event handler
     *
     * @param LifecycleEventArgs $args
     */
    public function postRemove(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        $event  = new ModelDeletedEvent($entity, $this->inventory->getIdentifiers($entity));

        $this->dispatcher->dispatch(ModelEvents::DELETED, $event);
    }
}
