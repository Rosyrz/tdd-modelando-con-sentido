<?php

namespace Joselfonseca\FonckToolbox\Bus;

use League\Container\Container;
use League\Tactician\Handler\Locator\HandlerLocator;
use League\Tactician\Handler\Locator\InMemoryLocator;
use League\Tactician\Handler\MethodNameInflector\HandleInflector;
use League\Tactician\Handler\MethodNameInflector\MethodNameInflector;
use League\Tactician\Handler\CommandNameExtractor\ClassNameExtractor;
use League\Tactician\Handler\CommandNameExtractor\CommandNameExtractor;

/**
 * Class CommandBusFactory
 * @package Joselfonseca\FonckToolbox\Bus
 */
class CommandBusFactory
{

    /**
     * @var Container
     */
    protected $container;
    /**
     * CommandBusFactory constructor.
     * @param Container $container the DI Container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
        $this->make();
    }

    /**
     * Binds the interfaces and implementations of the Tactician Command Bus
     */
    public function make()
    {
        $this->container->add(HandlerLocator::class, InMemoryLocator::class);
        $this->container->add(MethodNameInflector::class, HandleInflector::class);
        $this->container->add(CommandNameExtractor::class, ClassNameExtractor::class);
        $this->container->add(CommandBusInterface::class, CommandBus::class)
            ->withArgument(MethodNameInflector::class)
            ->withArgument(CommandNameExtractor::class)
            ->withArgument(HandlerLocator::class)
            ->withArgument($this->container);
    }
}
