<?php

namespace EventBundle;

/**
 * Model event directory
 */
class ModelEvents
{
    /**
     * A new model has been created
     */
    const CREATED = 'created';

    /**
     * An existing model has been changed
     */
    const UPDATED = 'updated';

    /**
     * An existing model has been deleted
     */
    const DELETED = 'deleted';
}
