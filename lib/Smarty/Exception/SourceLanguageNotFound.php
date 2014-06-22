<?php

/**
 * Smarty Exception Plugin
 *
 * @package Smarty\Exception
 */
namespace Smarty\Exception;

/**
 * Smarty source language not found exception
 *
 * @package Smarty\Exception
 */
class SourceLanguageNotFound extends Runtime
{
    /**
     * Constructor
     *
     * @param string $language source language name
     */
    public function __construct($language)
    {
        parent::__construct("Compiler: Can not find source language '{$language}'", 0);
    }
}
