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
class NoRule extends ForSourceLanguage
{
    /**
     * Constructor
     *
     * @param string  $node node name
     * @param mixed   $code
     * @param Context $context
     */
    public function __construct($node, $code = 0, Context $context)
    {
        parent::__construct("PEG Parser: No rule defined for node '{$node}'", $code, $context);
    }
}
