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
class IllegalRelativePath extends Runtime
{
    /**
     * @param string   $file
     * @param int|null $type
     */
    public function __construct($file, $type)
    {
        $message = sprintf("Template '%s' cannot be relative to template of resource type '%s'", $file, $type);
        parent::__construct($message, 0);
    }
}
