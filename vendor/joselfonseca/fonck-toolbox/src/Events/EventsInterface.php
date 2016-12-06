<?php

namespace Joselfonseca\FonckToolbox\Events;

/**
 * Events
 *
 * @author joselfonseca
 */
interface EventsInterface
{
    /**
     * @param $event
     * @param null $data
     */
    public function fire($event, $data = null);

    /**
     * @param $event
     * @param $listener
     */
    public function listen($event, $listener);
}
