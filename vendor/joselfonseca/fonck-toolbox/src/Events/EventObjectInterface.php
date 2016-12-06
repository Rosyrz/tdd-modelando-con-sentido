<?php

namespace Joselfonseca\FonckToolbox\Events;

/**
 * Interface EventObjectInterface
 * @package Joselfonseca\FonckToolbox\Events
 */
interface EventObjectInterface
{
    /**
     * Get the data passed to the Event
     * @return mixed
     */
    public function getEventData();

    /**
     * Set the data passed to the event
     * @param mixed $data
     */
    public function setEventData($data);
}
