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
class FileLoadError extends Runtime
{
    /**
     * @param string   $type
     * @param int|null $file
     */
    public function __construct($type, $file)
    {
        $message = sprintf("Unable to load %s file '%s'", $type, $file);
        parent::__construct($message, 0);
    }
}
