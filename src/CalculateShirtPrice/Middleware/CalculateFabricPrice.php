<?php

namespace rosyrz\Mcs\CalculateShirtPrice\Middleware;

use league\Tactician\Middleware;
use rosyrz\Mcs\CalculateShirtPrice\Repositories\FabricRepositoryInterface;

/**
 * Class CalculateFabricPrice
 * @package rosyrz\Mcs\CalculateShirtPrice\Middleware
 */
class CalculateFabricPrice implements Middleware{

    /**
     * Precio de la tela del fabricante
     * @var
     */
    protected $fabricVendorPrice;
    /**
     * contenedor de dependencias
     * @var
     */
    protected $container;

    /**
     * CalculateFabricPrice constructor.
     * @param $container
     */
    public function __construct($container)
    {
         $this->container = $container;
    }

    /**
     * obtener el precio de la tela por fabrica usando el repositorio
     * @param $command
     */
    protected function getFabricVendorPrice($command)
    {
        $repository = $this->container->get(FabricRepositoryInterface::class);
        $this->fabricVendorPrice = $repository->getFabricPrice($command->fabricSku);
    }

    /**
     * @param object $command
     * @param callable $next
     *
     * @return mixed
     */
    public function execute($command, callable $next)
    {
        $this->getFabricVendorPrice($command);
        $command->fabricPrice = $this->fabricVendorPrice * $command->mts;
        return $next($command);
    }
}