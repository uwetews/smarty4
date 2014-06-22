<?php

/**
 * Smarty Exception Plugin
 *
 * @package Smarty\Exception
 */
namespace Smarty\Parser\Exception;

use Smarty\Template\Context;

/**
 * Smarty compiled language not found exception
 *
 * @package Smarty\Exception
 */
class NoRuleClass extends ForSourceLanguage
{
    /**
     * Constructor
     *
     * @param string  $type
     * @param mixed   $code
     * @param string  $className
     * @param Context $context
     */
    public function __construct($type, $code = 0, $className, Context $context)
    {
        parent::__construct("PEG Parser: No rule class '{$className}' for rule type '{$type}'", $code, $context);
    }
}
