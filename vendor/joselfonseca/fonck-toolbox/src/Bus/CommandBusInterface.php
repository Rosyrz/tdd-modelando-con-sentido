<?php

namespace Joselfonseca\FonckToolbox\Bus;

/**
 * Class CommandBus
 * @package Joselfonseca\FonckToolbox\Bus
 */
interface CommandBusInterface
{
    /**
     * @param string $command    Command class name to be dispatched
     * @param array  $input      input to map into the command
     * @param array  $middleware middleware stack classes names to apply to the command
     * @return mixed
     */
    public function dispatch($command, array $input = [], array $middleware = []);
}
