<?php

namespace EventBundle\Event;

/**
 * Model event with changes
 */
class ModelChangedEvent extends ModelEvent
{
    /**
     * Changes made to the model
     *
     * @var array
     */
    private $changes;

    /**
     * Constructor
     *
     * @param mixed $model
     * @param array $changes
     */
    public function __construct($model, array $changes = [])
    {
        parent::__construct($model);

        $this->changes = $changes;
    }

    /**
     * Get changes
     *
     * @return array
     */
    public function getChanges()
    {
        return $this->changes;
    }

    /**
     * Has the given field changed?
     *
     * @param string $field
     *
     * @return boolean
     */
    public function hasChanged($field)
    {
        return isset($this->changes[$field]);
    }
}
