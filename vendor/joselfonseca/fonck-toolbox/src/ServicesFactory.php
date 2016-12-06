<?php

namespace Joselfonseca\FonckToolbox;

use League\Container\Container;
use Joselfonseca\FonckToolbox\Bus\CommandBusFactory;
use Joselfonseca\FonckToolbox\Events\EventsInterface;
use Joselfonseca\FonckToolbox\Bus\CommandBusInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Joselfonseca\FonckToolbox\Events\Adapters\Symfony\SymfonyEventAdapter;

/**
 * The Factory will serve as a service locator with the given configuration
 *
 * @author josefonseca
 */
class ServicesFactory
{
    /**
     * @var array Services
     */
    private $services = [];
    /**
     * @var object Container
     */
    public $container;

    /**
     * Default configuration options
     * @var array
     */
    protected $defaultOptions = [
        'bus' => [
            'factory' => CommandBusFactory::class
        ],
        'events' => [
            'adapter' => SymfonyEventAdapter::class
        ]
    ];

    /**
     * The factory options
     * @var
     */
    protected $options;


    /**
     * ServicesFactory constructor.
     * @param array $options
     */
    public function __construct(array $options = array())
    {
        $resolver = new OptionsResolver();
        $resolver->setDefaults($this->defaultOptions);
        $this->options = $resolver->resolve($options);
        $this->setContainer();
        $this->setServices();
    }

    /**
     * Create a container instance and boot the services
     */
    private function setContainer()
    {
        $this->container = new Container;
        $this->bootServices();
        return $this;
    }

    /**
     * Boot the services in the container
     */
    public function bootServices()
    {
        $this->loadCommandBus();
        $this->loadEventAdapter();
    }

    /**
     * Bind the Command bus
     */
    protected function loadCommandBus()
    {
        $class = $this->options['bus']['factory'];
        new $class($this->container);
        return $this;
    }

    /**
     * Register the Event Adapter
     */
    protected function loadEventAdapter()
    {
        $class = $this->options['events']['adapter'];
        $this->container->share(EventsInterface::class, $class)->withArgument($this->container);
    }

    /**
     * Set default services out of the container
     */
    private function setServices()
    {
        $this->services['bus'] = CommandBusInterface::class;
        $this->services['events'] = EventsInterface::class;
        return $this;
    }

    /**
     * Get services as a property
     * @param type $name
     * @return type
     * @throws \Exception
     */
    public function __get($name)
    {
        if (!isset($this->services[$name])) {
            throw new \InvalidArgumentException('Service ' . $name . ' not Registered in the container');
        }

        return $this->container->get($this->services[$name]);
    }
}
