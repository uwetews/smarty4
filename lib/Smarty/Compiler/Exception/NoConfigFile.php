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
class NoConfigFile extends Exception
{
    /**
     * Constructor
     *
     * @param string $class configuration file name
     */
    public function __construct($file)
    {
        parent::__construct("Compiler: Can not read configuration file '{$file}'", 0);
    }
}
