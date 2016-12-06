<?php

namespace Joselfonseca\FonckToolbox\Bus;

use ReflectionClass;
use InvalidArgumentException;
use League\Container\Container;
use League\Tactician\CommandBus as TacticianBus;
use League\Tactician\Handler\Locator\HandlerLocator;
use League\Tactician\Handler\CommandHandlerMiddleware;
use League\Tactician\Handler\MethodNameInflector\MethodNameInflector;
use League\Tactician\Handler\CommandNameExtractor\CommandNameExtractor;

/**
 * Class CommandBus
 * @package Joselfonseca\FonckToolbox\Bus
 */
class CommandBus implements CommandBusInterface
{
    /**
     * @var League\Tactician\CommandBus
     */
    protected $bus;

    /**
     * @var League\Tactician\Handler\CommandNameExtractor\CommandNameExtractor
     */
    protected $commandNameExtractor;

    /**
     * @var League\Tactician\Handler\MethodNameInflector\MethodNameInflector
     */
    protected $methodNameInflector;

    /**
     * @var League\Tactician\Handler\Locator\HandlerLocator
     */
    protected $handlerLocator;

    /**
     * @var League\Container\Container
     */
    protected $container;
    /**
     * The Command Validator Middleware
     * @var
     */
    public $commandValidator = [];


    /**
     * CommandBus constructor.
     * @param MethodNameInflector $MethodNameInflector
     * @param CommandNameExtractor $CommandNameExtractor
     * @param HandlerLocator $HandlerLocator
     * @param Container $container
     */
    public function __construct(
        MethodNameInflector $MethodNameInflector,
        CommandNameExtractor $CommandNameExtractor,
        HandlerLocator $HandlerLocator,
        Container $container
    ) {
        $this->methodNameInflector = $MethodNameInflector;
        $this->commandNameExtractor = $CommandNameExtractor;
        $this->handlerLocator = $HandlerLocator;
        $this->container = $container;
    }


    /**
     * @param string $command    Command class name to be dispatched
     * @param array  $input      input to map into the command
     * @param array  $middleware middleware stack classes names to apply to the command
     * @param string  $handler The handler class if no automatic resolution should be apply
     * @return mixed
     */
    public function dispatch(
        $command,
        array $input = [],
        array $middleware = [],
        $handler = null
    ) {
        $this->addHandler($command, $this->guessHandler($command, $handler));
        return $this->handleTheCommand($command, $input, $middleware);
    }


    /**
     * @param string $command    Command class name to be dispatched
     * @param array  $input      input to map into the command
     * @param array  $middleware middleware stack classes names to apply to the command
     * @return mixed
     */
    private function handleTheCommand($command, $input, $middleware)
    {
        $commandHandlerMiddleware = new CommandHandlerMiddleware(
            $this->commandNameExtractor,
            $this->handlerLocator,
            $this->methodNameInflector
        );
        $this->bus = new TacticianBus(
            array_merge(
                $this->resolveMiddleware($middleware),
                [$commandHandlerMiddleware]
            )
        );

        return $this->bus->handle($this->mapInputToCommand($command, $input));
    }


    /**
     * @param string $command Command class name to be dispatched
     * @param object $handler Class to handle the command
     */
    private function addHandler($command, $handler)
    {
        $this->handlerLocator->addHandler($handler, $command);
    }


    /**
     * @param array $middleware Class names of the middleware stack to apply to the command
     * @return array
     */
    private function resolveMiddleware(array $middleware)
    {
        $m = [];
        foreach ($middleware as $class) {
            if (!class_exists($class)) {
                throw new InvalidArgumentException('The class ' . $class . ' does not exists');
            }
            $m[] = new $class($this->container);
        }
        return $m;
    }


    /**
     * @param string $command The command to be excecuted
     * @param string $handler The Handler to be used if no automatic resolution is applied
     * @return mixed
     * @throws HandlerNotFoundException
     */
    private function guessHandler($command, $handler = null)
    {
        if(empty($handler))
        {
            $handler = $command . 'Handler';
        }
        if (!class_exists($handler)) {
            throw new HandlerNotFoundException('The class ' . $handler . ' does not exists');
        }

        return new $handler($this->container);
    }


    /**
     * @param string $command Class name of the command to be handle
     * @param array  $input   Input to be mapped to the command
     * @return object
     */
    private function mapInputToCommand($command, $input)
    {
        $dependencies = [];
        $class = new ReflectionClass($command);
        foreach ($class->getConstructor()->getParameters() as $parameter) {
            $name = $parameter->getName();
            if (array_key_exists($name, $input)) {
                $dependencies[] = $input[$name];
            } elseif ($parameter->isDefaultValueAvailable()) {
                $dependencies[] = $parameter->getDefaultValue();
            } else {
                throw new InvalidArgumentException("Unable to map input to command: {$name}");
            }
        }

        return $class->newInstanceArgs($dependencies);
    }
}
