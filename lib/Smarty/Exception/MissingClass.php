<?php

/**
 * Smarty Exception Plugin
 *
 * @package Smarty\Exception
 */
namespace Smarty\Exception;



/**
 * Smarty compiled language not found exception
 *
 * @package Smarty\Exception
 */
class MissingClass extends \Exception
{
    /**
     * Constructor
     *
     * @param string $class class name
     */
    public function __construct($class, $location = null)
    {
        $location = isset($location) ? $location . ': ' : '';
        parent::__construct("{$location}Missing class '{$class}'", 0);
    }
}
