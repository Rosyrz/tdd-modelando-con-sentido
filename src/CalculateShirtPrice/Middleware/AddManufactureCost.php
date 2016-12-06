<?php

namespace rosyrz\Mcs\CalculateShirtPrice\Middleware;


use League\Container\Container;
use League\Tactician\Middleware;
use rosyrz\Mcs\CalculateShirtPrice\Repositories\ManufactureRepositoryInterface;

class AddManufactureCost implements Middleware
{

    protected $manufactureCost = 2500;
    protected $cutCost = 500;
    protected $container;
    protected $repository;

    public function __construct(Container $container)
    {
        $this->container = $container;
        $this->repository = $this->container->get(ManufactureRepositoryInterface::class);
    }

    public function execute($command, callable $next)
    {
        $this->getManufactureCost($command)->getCuteCost($command);
        $command->manufactureCost = $this->manufactureCost;
        $command->cutCost = $this->cutCost;
        return $command;
    }

    public function getManufactureCost($command)
    {
        $this->ManufactureCost = $this->repository->getManufactureCost($command->shirtSku);
        return $this;
    }
    public function getCuteCost($command)
    {
        $this->cutCost = $this->repository->getCutCost($command->shirtSku);
        return $this;
    }
}