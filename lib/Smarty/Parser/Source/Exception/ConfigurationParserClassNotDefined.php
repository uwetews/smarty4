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
class Smarty_Source_Exception_ConfigurationParserClassNotDefined extends Smarty_Exception_ForSourceLanguage
{
    /**
     * Constructor
     *
     * @param string  $dummy
     * @param mixed   $code
     * @param Context $context
     */
    public function __construct($dummy, $code = 0, Context $context)
    {
        parent::__construct("Source Configuration: Parser class not defined", $code, $context);
    }
}
