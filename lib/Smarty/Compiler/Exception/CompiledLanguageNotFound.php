<?php

/**
 * Smarty Exception Plugin
 *
 * @package Smarty\Exception
 */
namespace Smarty\Compiler\Exception;

use Smarty\Template;

/**
 * Smarty compiled language not found exception
 *
 * @package Smarty\Exception
 */
class TargetLanguageNotFound extends \Smarty_Exception_Runtime
{
    /**
     * Constructor
     *
     * @param string $language source language name
     */
    public function __construct($language)
    {
        parent::__construct("Compiler: Can not find compiled language '{$language}'", 0);
    }
}
