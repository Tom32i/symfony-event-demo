<?php

namespace EventBundle\Event;

/**
 * Model event with identifiers
 */
class ModelDeletedEvent extends ModelEvent
{
    /**
     * Identifiers of the model
     *
     * @var array
     */
    private $identifiers;

    /**
     * Constructor
     *
     * @param mixed $model
     * @param array $identifiers
     */
    public function __construct($model, array $identifiers = [])
    {
        parent::__construct($model);

        $this->identifiers = $identifiers;
    }

    /**
     * Get identifiers
     *
     * @return array
     */
    public function getIdentifiers()
    {
        return $this->identifiers;
    }
}
