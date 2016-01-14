<?php

namespace EventBundle\Utils;

/**
 * Inventory
 */
class Inventory
{
    /**
     *  Entities
     *
     * @var array
     */
    private $entities;

    /**
     *  Change sets
     *
     * @var array
     */
    private $changeSets;

    /**
     * Identifiers
     *
     * @var array
     */
    private $identifiers;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->entities    = [];
        $this->changeSets  = [];
        $this->identifiers = [];
    }

    /**
     * Set change set for the given entity
     *
     * @param mixed $entity
     * @param array $changeSet
     */
    public function setChangeSet($entity, array $changeSet)
    {
        $this->changeSets[$this->index($entity)] = $changeSet;
    }

    /**
     * Get change set for the given entity
     *
     * @param mixed $entity
     *
     * @return array
     */
    public function getChangeSet($entity)
    {
        if (false !== $index = $this->search($entity)) {
            return  $this->changeSets[$index];
        }

        return [];
    }

    /**
     * Set identifier for the given entity
     *
     * @param mixed $entity
     * @param array $identifier
     */
    public function setIdentifiers($entity, array $identifier)
    {
        $this->identifiers[$this->index($entity)] = $identifier;
    }

    /**
     * Get identifier  for the given entity
     *
     * @param mixed $entity
     *
     * @return array
     */
    public function getIdentifiers($entity)
    {
        if (false !== $index = $this->search($entity)) {
            return  $this->identifiers[$index];
        }

        return [];
    }

    /**
     * Store an entity in the list and return its index
     *
     * @param mixed $entity
     *
     * @return integer
     */
    private function index($entity)
    {
        if (!in_array($entity, $this->entities)) {
            $this->entities[] = $entity;
        }

        return $this->search($entity);
    }

    /**
     * Get the index of the given entity in the list
     *
     * @param mixed $entity
     *
     * @return integer
     */
    private function search($entity)
    {
        return array_search($entity, $this->entities);
    }
}
