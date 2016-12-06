<?php

namespace Joselfonseca\FonckToolbox\Test;


/**
 * Description of FactoryTest
 *
 * @author jfonseca
 */
class ServiceFactoryTest extends TestCase
{

    /**
     * Test the class can be instantiated
     * @test
     */
    public function it_can_create_factory()
    {
        $this->assertInstanceOf('Joselfonseca\FonckToolbox\ServicesFactory', $this->factory);
    }

    /**
     * It can set the container
     * @test
     * @covers Joselfonseca\FonckToolbox\ServicesFactory::setContainer
     */
    public function it_can_set_container()
    {
        $this->assertInstanceOf('League\Container\Container', $this->factory->container);
    }

    /**
     * @test
     * @expectedException InvalidArgumentException
     * @covers Joselfonseca\FonckToolbox\ServicesFactory::__get
     */
    public function it_throws_exception_when_no_service_located()
    {
        $this->factory->SomeServiceDoesNotExists;
    }
}