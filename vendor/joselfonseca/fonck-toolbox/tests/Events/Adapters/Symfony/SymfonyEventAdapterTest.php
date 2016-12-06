<?php

namespace Joselfonseca\FonckToolbox\Test\Events\Adapters\Symfony;

use InvalidArgumentException;
use Joselfonseca\FonckToolbox\Test\TestCase;
use Joselfonseca\FonckToolbox\Events\EventObjectInterface;
use Joselfonseca\FonckToolbox\Test\Events\Adapters\Symfony\Stubs\ListenerStub;

class SymfonyEventAdapterTest extends TestCase
{

    /**
     * @test
     */
    public function it_fires_event()
    {
        $event = $this->factory->events->fire('event.test', []);
        $this->assertInstanceOf(EventObjectInterface::class, $event);
    }
    /**
     * @test
     */
    public function it_gets_event_data()
    {
        $event = $this->factory->events->fire('event.test', ['foo' => 'bar']);
        $this->assertArrayHasKey('foo', $event->getEventData());
    }
    /**
     * @test
     */
    public function it_adds_and_runs_listener()
    {
        $this->factory->events->listen('event.test', ListenerStub::class);
        try{
            $this->factory->events->fire('event.test', ['foo' => 'bar']);
            $this->assertFalse(true);
        }catch (InvalidArgumentException $e)
        {
            $this->assertEquals('Event Handled!', $e->getMessage());
        }
    }

    /**
     * @test
     */
    public function it_adds_and_runs_listener_as_object()
    {
        $this->factory->events->listen('event.test', new ListenerStub);
        try{
            $this->factory->events->fire('event.test', ['foo' => 'bar']);
            $this->assertFalse(true);
        }catch (InvalidArgumentException $e)
        {
            $this->assertEquals('Event Handled!', $e->getMessage());
        }
    }

}