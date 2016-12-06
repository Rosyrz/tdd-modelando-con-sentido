<?php

namespace Joselfonseca\FonckToolbox\Test\Bus\Stubs;

/**
 * Description of Command
 *
 * @author jfonseca
 */
class Command
{
    public $name;
    public $lastName;
    public $someDefault;

    public function __construct($name, $lastName, $someDefault = 'defautl')
    {
        $this->name = $name;
        $this->lastName = $lastName;
        $this->someDefault = $someDefault;
    }
}