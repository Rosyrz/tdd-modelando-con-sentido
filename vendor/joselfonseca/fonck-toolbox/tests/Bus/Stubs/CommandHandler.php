<?php

namespace Joselfonseca\FonckToolbox\Test\Bus\Stubs;

use Joselfonseca\FonckToolbox\Bus\HandlerInterface;
use League\Container\Container;

/**
 * Description of CommandHandler
 *
 * @author jfonseca
 */
class CommandHandler implements HandlerInterface
{

    /**
     * @var Container
     */
    protected $container;

    /**
     * Constructor that receives the League Container
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * @param $command
     * @return mixed
     */
    public function handle($command)
    {
        return $command;
    }

}