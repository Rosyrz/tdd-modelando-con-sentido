<?php

namespace Joselfonseca\FonckToolbox\Bus;

use League\Container\Container;
use League\Tactician\Middleware as TacticianMiddleware;

/**
 * Interface Middleware
 * @package Joselfonseca\FonckToolbox\Bus
 */
interface MiddlewareInterface extends TacticianMiddleware
{
    /**
     * The League Container
     * @param Container $container
     */
    public function __construct(Container $container);
}
