<?php

/**
 * Smarty Exception Plugin
 *
 * @package Smarty\Exception
 */
namespace Smarty\Parser\Exception;

use Smarty\Exception\Runtime;
use Smarty\Template\Context;

/**
 * Smarty parser not found exception
 *
 * @package Smarty\Exception
 */
class ForSourceLanguage extends Runtime
{
    /**
     * Constructor
     *
     * @param string  $message
     * @param int     $code
     * @param Context $context
     *
     * @internal param string $class class name
     * @internal param null $language source language name
     */
    public function __construct($message, $code = 0, Context $context)
    {
        $message .= " for source language '{$context->getSourceLanguage()}'";
        parent::__construct($message, $code);
    }
}
