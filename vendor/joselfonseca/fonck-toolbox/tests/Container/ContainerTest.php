<?php

namespace Joselfonseca\FonckToolbox\Test\Container;

use Joselfonseca\FonckToolbox\Test\TestCase;

/**
 * Class ContainerTest
 * Test the dependency injection container
 */

/**
 * Class ContainerTest
 * @package Joselfonseca\FonckToolbox\Test
 */
class ContainerTest extends TestCase{

    /**
     * @test
     */
    public function it_resolves_from_container()
    {
        $this->factory->container->add('command.test', 'Joselfonseca\FonckToolbox\Test\Bus\Stubs\Command')
            ->withArgument('Jhon')
            ->withArgument('Doe');
        $this->assertInstanceOf('Joselfonseca\FonckToolbox\Test\Bus\Stubs\Command', $this->factory->container->get('command.test'));
    }

}