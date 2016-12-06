<?php

namespace Joselfonseca\FonckToolbox\Test\Bus\Stubs;

use League\Container\Container;
use Joselfonseca\FonckToolbox\Bus\MiddlewareInterface as Middleware;

class AddPropertyMiddleware implements Middleware{

    protected $container;

    /**
     * The League Container
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * @param object $command
     * @param callable $next
     *
     * @return mixed
     */
    public function execute($command, callable $next)
    {
        $command->newProperty = "Added";
        return $next($command);
    }

}