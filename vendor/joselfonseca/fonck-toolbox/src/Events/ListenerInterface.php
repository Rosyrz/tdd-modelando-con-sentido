<?php

namespace Joselfonseca\FonckToolbox\Events;

/**
 * Interface ListenerInterface
 * @package Joselfonseca\FonckToolbox\Events
 */
interface ListenerInterface
{
    /**
     * @param EventObjectInterface $event
     * @return mixed
     */
    public function handle(EventObjectInterface $event);
}
