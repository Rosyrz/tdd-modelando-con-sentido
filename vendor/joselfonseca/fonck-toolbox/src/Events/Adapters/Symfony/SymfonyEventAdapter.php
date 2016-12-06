<?php

namespace Joselfonseca\FonckToolbox\Events\Adapters\Symfony;

use League\Container\Container;
use Joselfonseca\FonckToolbox\Events\EventsInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;

/**
 * Class SymfonyEventAdapter
 * @package Joselfonseca\FonckToolbox\Events\Adapters\Symfony
 */
class SymfonyEventAdapter implements EventsInterface
{
    /**
     * @var EventDispatcher
     */
    public $dispatcher;

    /**
     * @var Container
     */
    public $container;

    /**
     * SymfonyEventAdapter constructor.
     */
    public function __construct(Container $container)
    {
        $this->dispatcher = new EventDispatcher;
        $this->container = $container;
    }


    /**
     * @param $event
     * @param null $data
     * @return mixed
     */
    public function fire($event, $data = null)
    {
        $symfonyEventObject = new Event();
        $symfonyEventObject->setEventData($data);
        return $this->dispatcher->dispatch($event, $symfonyEventObject);
    }

    /**
     * @param $event
     * @param $listener
     */
    public function listen($event, $listener)
    {
        if (is_string($listener)) {
            if (class_exists($listener)) {
                $this->dispatcher->addListener($event, [new $listener, 'handle']);
            }
        } else {
            $this->dispatcher->addListener($event, [$listener, 'handle']);
        }
    }
}
