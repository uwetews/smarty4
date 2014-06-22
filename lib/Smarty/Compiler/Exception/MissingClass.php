<?php

/**
 * Smarty Exception Plugin
 *
 * @package Smarty\Exception
 */
namespace Smarty\Compiler\Exception;

use Exception;

/**
 * Smarty compiled language not found exception
 *
 * @package Smarty\Exception
 */
class MissingClass extends Exception
{
    /**
     * Constructor
     *
     * @param string $class class name
     */
    public function __construct($class)
    {
        parent::__construct("Compiler: Missing class '{$class}'", 0);
    }
}
