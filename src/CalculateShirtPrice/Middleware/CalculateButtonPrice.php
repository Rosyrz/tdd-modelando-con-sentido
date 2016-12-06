<?php


namespace rosyrz\Mcs\CalculateShirtPrice\Middleware;

use League\Container\Container;
use League\Tactician\Middleware;
use rosyrz\Mcs\CalculateShirtPrice\Repositories\ButtonsRepositoryInterface;

/**
 * Class CalculateButtonPrice
 * @package rosyrz\Mcs\CalculateShirtPrice\Middleware
 */
class CalculateButtonPrice implements Middleware
{
    /**
     * button price
     * @var int
     */
    protected $buttonPrice = 0;

    /**
     * DI container
     * @var Container
     */
    protected $container;

    /**
     * Buttons repository
     * @var mixed|object
     */
    protected $repository;

    /**
     * CalculateButtonPrice constructor.
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
        $this->repository = $this->container->get(ButtonsRepositoryInterface::class);
    }

    /**
     * Calculate buttons price using repository
     * @param object $command
     * @param callable $next
     * @return mixed
     */
    public function execute($command, callable $next)
    {
        $this->getButtonPricefromRepository($command);
        $command->buttonsPrice = $command->buttons * $this->buttonPrice;
       return $next($command);
    }

    /**
     * Get button price from repository
     * @param $command
     */
    public function getButtonPricefromRepository($command)
    {
        $this->buttonPrice = $this->repository->getButtonPriceBySku($command->buttonSku);
    }

}