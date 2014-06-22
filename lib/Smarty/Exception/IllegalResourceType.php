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
class IllegalInheritanceResourceType extends Runtime
{
    /**
     * @param string $type
     */
    public function __construct($type)
    {
        $message = sprintf("Illegal use of source resource type '%s' for template inheritance", $type);
        parent::__construct($message, 0);
    }
}
