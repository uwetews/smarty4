<?php

/**
 * Smarty Exception Plugin
 *
 * @package Smarty\Exception
 */

/**
 * Smarty compiled language not found exception
 *
 * @package Smarty\Exception
 */
class Smarty_Compiler_Exception_RootNodeNotFound extends \Smarty_Exception_Runtime
{
    /**
     * Constructor
     *
     * @param string $language source language name
     * @param string $code     compiled language name
     */
    public function __construct($language, $code)
    {
        parent::__construct("Compiler: Can not find root node for source language '{$language}' or compiled language '{$code}'", 0);
    }
}
