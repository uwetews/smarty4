<?php

/**
 * Smarty Exception Plugin
 *
 * @package Smarty\Exception
 */
namespace Smarty\Exception;

/**
 * Smarty illegal resource exception
 *
 * @package Smarty\Exception
 */
class UnknownResourceType extends Runtime
{
    /**
     * @param string $group
     * @param int    $type
     */
    public function __construct($group, $type)
    {
        $foo = explode('_', $group);
        $message = sprintf("Unknown '%s' resource type '%s'", end($foo), $type);
        parent::__construct($message, 0);
    }
}
