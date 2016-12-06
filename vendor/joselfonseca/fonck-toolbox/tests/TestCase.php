<?php

namespace Joselfonseca\FonckToolbox\Test;


/**
 * Class TestCase
 * @package Joselfonseca\FonckToolbox\Test
 */
class TestCase extends \PHPUnit_Framework_TestCase
{
    /**
     * The services factory
     * @var
     */
    protected $factory;

    /**
     * Set up the environtment for the tests
     */
    public function setup()
    {
        $this->factory = new \Joselfonseca\FonckToolbox\ServicesFactory;
    }
}