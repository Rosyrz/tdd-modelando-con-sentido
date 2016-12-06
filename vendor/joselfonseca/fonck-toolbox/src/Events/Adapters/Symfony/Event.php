<?php

namespace Joselfonseca\FonckToolbox\Events\Adapters\Symfony;

use Joselfonseca\FonckToolbox\Events\EventObjectInterface;
use Symfony\Component\EventDispatcher\Event as SymfonyEvent;

/**
 * Class Event
 * @package Joselfonseca\FonckToolbox\Events\Adapters\Symfony
 */
class Event extends SymfonyEvent implements EventObjectInterface
{
    /**
     * Data passed to the Event
     * @var
     */
    protected $eventData;

    /**
     * Get the data passed to the Event
     * @return mixed
     */
    public function getEventData()
    {
        return $this->eventData;
    }

    /**
     * Set the data passed to the Event
     * @param mixed $data
     */
    public function setEventData($data)
    {
        $this->eventData = $data;
    }
}
