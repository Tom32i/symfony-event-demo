<?php

namespace EventBundle\Event;

use Symfony\Component\EventDispatcher\Event;

/**
 * Model event
 */
class ModelEvent extends Event
{
    /**
     * Model
     *
     * @var mixed
     */
    protected $model;

    /**
     * Constructor
     *
     * @param mixed $model
     */
    public function __construct($model)
    {
        $this->model = $model;
    }

    /**
     * {@inheritdoc}
     */
    public function getModel()
    {
        return $this->model;
    }
}
