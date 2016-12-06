<?php

namespace rosyrz\Mcs\Test\CalculateShirtPriceTest;

use rosyrz\Mcs\Tests\TestCase;
use rosyrz\Mcs\CalculateShirtPrice\Repositories\FabricArrayRepository;
use rosyrz\Mcs\CalculateShirtPrice\Repositories\ButtonsArrayRepository;
use rosyrz\Mcs\CalculateShirtPrice\Repositories\ManufactureCostArrayRepository;

class CalculateShirtPriceTest extends TestCase
{

    /**
     *@test
     */
    public function it_calculates_fabric_price()
    {
        $command = $this->services->bus->dispatch(\rosyrz\Mcs\CalculateShirtPrice\CalculateShirtPriceCommand::class,[
            'mts' => 1.5,
            'fabricSku' => 'RET490'
        ], [
            \rosyrz\Mcs\CalculateShirtPrice\Middleware\CalculateFabricPrice::class
        ]);
        $this->assertEquals(3750, $command->fabricPrice);
    }

    /**
     * @test
     * @expectedException rosyrz\Mcs\CalculateShirtPrice\Exceptions\FabricNotFoundException
     */
    public function it_trows_exception_when_fabric_not_found()
    {
        $repository = new FabricArrayRepository();
        $repository->getFabricPrice('TEST234');
    }

    /**
     * @test
     */
    public function it_calculates_shirt_buttons_price()
    {
        $command = $this->services->bus->dispatch(\rosyrz\Mcs\CalculateShirtPrice\CalculateShirtPriceCommand::class,[
            'mts' => 1.5,
            'fabricSku' => 'RET490',
            'buttons' => 10,
            'buttonSku' => 'BUT78'
        ], [
            \rosyrz\Mcs\CalculateShirtPrice\Middleware\CalculateFabricPrice::class,
            \rosyrz\Mcs\CalculateShirtPrice\Middleware\CalculateButtonPrice::class
        ]);
        $this->assertEquals(1000, $command->buttonsPrice);
    }

    /**
     * @test
     * @expectedException rosyrz\Mcs\CalculateShirtPrice\Exceptions\ButtonNotFoundException
     */
    public function it_throws_exception_when_button_skau_not_found()
    {
        $buttonRepository = new ButtonsArrayRepository();
        $buttonRepository->getButtonPriceBySku('HHREGEG');
    }

    /**
     * @test
     */
    public function it_adds_manufacture_costs_to_the_shirt()
    {
        $command = $this->services->bus->dispatch(\rosyrz\Mcs\CalculateShirtPrice\CalculateShirtPriceCommand::class,[
            'mts' => 1.5,
            'fabricSku' => 'RET490',
            'buttons' => 10,
            'buttonSku' => 'BUT78',
            'shirtSku' => 'COP567'
        ], [
            \rosyrz\Mcs\CalculateShirtPrice\Middleware\CalculateFabricPrice::class,
            \rosyrz\Mcs\CalculateShirtPrice\Middleware\CalculateButtonPrice::class,
            \rosyrz\Mcs\CalculateShirtPrice\Middleware\AddManufactureCost::class
        ]);
        $this->assertEquals(2500, $command->manufactureCost);
    }

    /**
     * @test
     */
    public function it_adds_cut_costs_to_the_shirt()
    {
        $command = $this->services->bus->dispatch(\rosyrz\Mcs\CalculateShirtPrice\CalculateShirtPriceCommand::class,[
            'mts' => 1.5,
            'fabricSku' => 'RET490',
            'buttons' => 10,
            'buttonSku' => 'BUT78',
            'shirtSku' => 'COP567'
        ], [
            \rosyrz\Mcs\CalculateShirtPrice\Middleware\CalculateFabricPrice::class,
            \rosyrz\Mcs\CalculateShirtPrice\Middleware\CalculateButtonPrice::class,
            \rosyrz\Mcs\CalculateShirtPrice\Middleware\AddManufactureCost::class
        ]);
        $this->assertEquals(500, $command->cutCost);
    }

    /**
     * @test
     * @expectedException rosyrz\Mcs\CalculateShirtPrice\Exceptions\ManufactureCostNotFoundException
     */
    public function it_throws_exception_if_no_cost_found_in_repositoru()
    {
        $repository = new ManufactureCostArrayRepository();
        $repository->getCutCost('HHEHEG');
    }
    
    /**
     * @test
     * @expectedException rosyrz\Mcs\CalculateShirtPrice\Exceptions\ManufactureCostNotFoundException
     */
    public function it_throws_exception_if_no_ManufactureCost_found_in_repositoru()
    {
        $repository = new ManufactureCostArrayRepository();
        $repository->getManufactureCost('HHEHEG');
    }
}