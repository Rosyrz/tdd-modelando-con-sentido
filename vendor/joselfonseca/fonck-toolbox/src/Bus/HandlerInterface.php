<?php

namespace Joselfonseca\FonckToolbox\Bus;

use League\Container\Container;

/**
 * Interface HandlerInterface
 * @package Joselfonseca\FonckToolbox\Bus
 */
interface HandlerInterface
{
    /**
     * Constructor that receives the League Container
     * @param Container $container
     */
    public function __construct(Container $container);

    /**
     * Handle the Command
     * @param $command
     * @return mixed
     */
    public function handle($command);
}
