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
class MissingCode extends Exception
{
    /**
     * Constructor
     *
     * @param string $class class name
     * @param int    $input
     */
    public function __construct($class, $input)
    {
        parent::__construct("Compiler Internal: Missing code translation in '{$class}' for '$input'", 0);
    }
}
