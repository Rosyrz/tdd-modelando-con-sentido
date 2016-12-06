<?php


namespace rosyrz\Mcs\Tests;

use Joselfonseca\FonckToolbox\ServicesFactory;
use rosyrz\Mcs\CalculateShirtPrice\Repositories\FabricArrayRepository;
use rosyrz\Mcs\CalculateShirtPrice\Repositories\ButtonsArrayRepository;
use rosyrz\Mcs\CalculateShirtPrice\Repositories\FabricRepositoryInterface;
use rosyrz\Mcs\CalculateShirtPrice\Repositories\ButtonsRepositoryInterface;
use rosyrz\Mcs\CalculateShirtPrice\Repositories\ManufactureRepositoryInterface;
use rosyrz\Mcs\CalculateShirtPrice\Repositories\ManufactureCostArrayRepository;
/**
 * Class TestCase
 * @package rosyrz\Mcs\Tests
 */
class TestCase extends \PHPUnit_Framework_TestCase
{
    /**
     * @var
     */
    public $services;

    /**
     *Configurar ambiente
     */
    public function setUp()
    {
        $this->services = new ServicesFactory();
        $this->services->container->add(FabricRepositoryInterface::class,FabricArrayRepository::class);
        $this->services->container->add(ButtonsRepositoryInterface::class,ButtonsArrayRepository::class);
        $this->services->container->add(ManufactureRepositoryInterface::class,ManufactureCostArrayRepository::class);
        parent::setUp();
    }

    /**
     * Get the Services Factory
     */
    public function testGetServicesFactory()
    {
        $this->assertInstanceOf('Joselfonseca\FonckToolbox\ServicesFactory',$this->services);
    }


}