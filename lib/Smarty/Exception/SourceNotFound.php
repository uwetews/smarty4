<?php

/**
 * Smarty Exception Plugin
 *
 * @package Smarty\Exception
 */
namespace Smarty\Exception;

/**
 * Smarty source not found exception
 *
 * @package Smarty\Exception
 */
class SourceNotFound extends Runtime
{
    /**
     * @param string   $type
     * @param int|null $name
     */
    public function __construct($type, $name)
    {
        $message = sprintf("Can not find source '%s:%s'", $type, $name);
        parent::__construct($message, 0);
    }
}
