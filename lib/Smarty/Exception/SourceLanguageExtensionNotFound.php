<?php

/**
 * Smarty Exception Plugin
 *
 * @package Smarty\Exception
 */
namespace Smarty\Exception;

/**
 * Smarty compiler source language extension not found exception
 *
 * @package Smarty\Exception
 */
class SourceLanguageExtensionNotFound extends Runtime
{
    /**
     * Constructor
     *
     * @param string $class    class name
     * @param string $language source language name
     */
    public function __construct($class, $language)
    {
        parent::__construct("Compiler: Can not find extension class '{$class}' for source language '{$language}'", 0);
    }
}
