<?php

namespace StoreBundle\Service;

use EventBundle\Event\ModelEvent;
use EventBundle\ModelEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

/**
 * Log domain events
 */
class Logger implements EventSubscriberInterface
{
    /**
     * Session
     *
     * @var SessionInterface
     */
    private $session;

    /**
     * Constructor
     *
     * @param SessionInterface $session
     */
    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

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
        $this->log($event->getModel(), 'created');
    }

    /**
     * On model updated
     *
     * @param ModelEvent $event
     */
    public function onUpdated(ModelEvent $event)
    {
        $this->log($event->getModel(), 'updated');
    }

    /**
     * On model deleted
     *
     * @param ModelEvent $event
     */
    public function onDeleted(ModelEvent $event)
    {
        $this->log($event->getModel(), 'deleted');
    }

    /**
     * Log events
     *
     * @param object $model
     * @param string $verb
     */
    public function log($model, $verb)
    {
        $message = sprintf(
            '%s %s has been %s',
            get_class($model),
            $model->getId(),
            $verb
        );
        dump($message);
        $this->session->getFlashBag()->add('notice', $message);
    }
}
