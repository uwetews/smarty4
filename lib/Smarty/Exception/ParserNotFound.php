<?php

/**
 * Smarty Exception Plugin
 *
 * @package Smarty\Exception
 */
namespace Smarty\Exception;

/**
 * Smarty parser not found exception
 *
 * @package Smarty\Exception
 */
class ParserNotFound extends Runtime
{
    /**
     * Constructor
     *
     * @param string $class    class name
     * @param null   $language source language name
     */
    public function __construct($class, $language = null)
    {
        $message = "Compiler: Can not find parser class '{$class}'";
        if (isset($language)) {
            $message .= " for source language '{$language}'";
        }
        parent::__construct($message, 0);
    }
}
