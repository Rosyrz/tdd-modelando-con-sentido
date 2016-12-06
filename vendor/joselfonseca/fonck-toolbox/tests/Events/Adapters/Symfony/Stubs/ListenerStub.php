<?php

namespace Joselfonseca\FonckToolbox\Test\Events\Adapters\Symfony\Stubs;

use InvalidArgumentException;
use Joselfonseca\FonckToolbox\Events\EventObjectInterface;
use Joselfonseca\FonckToolbox\Events\ListenerInterface;

class ListenerStub implements ListenerInterface
{
    public function handle(EventObjectInterface $event)
    {
        throw new InvalidArgumentException('Event Handled!');
    }
}