<?php


namespace rosyrz\Mcs\Tests;



/**
 * Class CommandBusTest
 * @package rosyrz\Mcs\Tests
 */
class CommandBusTest extends TestCase
{

    /**
     * Test the comman bus
     */
    public function test_it_gets_the_command_and_gives_it_to_the_bus()
    {
        $this->services->bus->dispatch(\rosyrz\Mcs\CalculateShirtPrice\CalculateShirtPriceCommand::class,[]);
        $this->assertTrue(true);
    }

}