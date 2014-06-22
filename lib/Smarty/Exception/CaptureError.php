<?php

/**
 * Smarty Exception Plugin
 *
 * @package Smarty\Exception
 */
namespace Smarty\Exception;

/**
 * Smarty runtime capture exception
 *
 * @package Smarty\Exception
 */
class CaptureError extends Runtime
{
    /**
     * @param null $message
     * @param int  $code
     */
    public function __construct($message = null, $code = 0)
    {
        if (!isset($message)) {
            $message = "{capture}: Not matching open/close tags";
        }
        parent::__construct($message, $code);
    }
}
