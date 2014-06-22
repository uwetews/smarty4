<?php

/**
 * Smarty Exception Plugin
 *
 * @package Smarty\Exception
 */
namespace Smarty\Exception;

/**
 * Smarty relative source not found exception
 *
 * @package Smarty\Exception
 */
class RelativeSourceNotFound extends Runtime
{
    /**
     * @param string   $type
     * @param int|null $name
     */
    public function __construct($type, $name)
    {
        $message = sprintf("Can not find relative source '%s:%s'", $type, $name);
        parent::__construct($message, 0);
    }
}
