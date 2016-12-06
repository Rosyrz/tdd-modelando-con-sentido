<?php

namespace Joselfonseca\FonckToolbox\Test\Bus;

use Joselfonseca\FonckToolbox\Test\TestCase;

/**
 * Testing Command bus implementation
 *
 * @author josefonseca
 */
class BusTest extends TestCase
{
    /**
     * @test
     */
    public function it_can_be_resolved_from_container()
    {
        $this->assertInstanceOf('Joselfonseca\FonckToolbox\Bus\CommandBus',
            $this->factory->bus);
    }

    /**
     * @test
     */
    public function it_dispatches_commands()
    {
        $data = [
            'name' => 'Jhon',
            'lastName' => 'Doe'
        ];
        $bus = $this->factory->bus;
        $result = $bus->dispatch(\Joselfonseca\FonckToolbox\Test\Bus\Stubs\Command::class, $data);
        $this->assertInstanceOf('Joselfonseca\FonckToolbox\Test\Bus\Stubs\Command', $result);
    }

    /**
     * @test
     * @expectedException InvalidArgumentException
     */
    public function it_throws_exception_not_being_able_to_map_input_to_command(){
        $data = [
            'name' => 'Jhon',
            'LastName' => 'Doe'
        ];
        $this->factory->bus->dispatch(\Joselfonseca\FonckToolbox\Test\Bus\Stubs\Command::class, $data);
    }

    /**
     * @test
     */
    public function it_can_add_middleware_and_run_it()
    {
        $data = [
            'name' => 'Jhon',
            'lastName' => 'Doe'
        ];
        $command = $this->factory->bus->dispatch(\Joselfonseca\FonckToolbox\Test\Bus\Stubs\Command::class, $data, [
            \Joselfonseca\FonckToolbox\Test\Bus\Stubs\AddPropertyMiddleware::class
        ]);
        $this->assertEquals('Added', $command->newProperty);
    }

    /**
     * @test
     * @expectedException Joselfonseca\FonckToolbox\Bus\HandlerNotFoundException
     */
    public function it_trows_exception_if_handler_does_not_exists()
    {
        $this->factory->bus->dispatch(\Joselfonseca\FonckToolbox\Test\Bus\Stubs\CommandNoHandler::class, []);
    }

    /**
     * @test
     * @expectedException InvalidArgumentException
     */
    public function it_trows_exception_if_middleware_does_not_exists()
    {
        $data = [
            'name' => 'Jhon',
            'lastName' => 'ThisIsNoCorrect'
        ];
        $this->factory->bus->dispatch(\Joselfonseca\FonckToolbox\Test\Bus\Stubs\Command::class, $data, [
            'SomeMiddleware'
        ]);
    }

    /**
     * @test
     */
    public function it_uses_a_handler_provided_and_no_auto_resolution()
    {
        $data = [
            'name' => 'Jhon',
            'lastName' => 'Doe'
        ];
        $result = $this->factory->bus->dispatch(
            \Joselfonseca\FonckToolbox\Test\Bus\Stubs\Command::class,
            $data,
            [],
            \Joselfonseca\FonckToolbox\Test\Bus\Stubs\IndependentHandler::class
        );
        $this->assertEquals('New Handler!', $result);
    }

}