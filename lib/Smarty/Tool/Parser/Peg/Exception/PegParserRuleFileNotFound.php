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
class Smarty_Parser_Peg_Exception_PegParserRuleFileNotFound extends \Smarty_Exception_ForSourceLanguage
{
    /**
     * Constructor
     *
     * @param string  $file name of PEG parser rule file
     * @param mixed   $code
     * @param Context $context
     */
    public function __construct($file, $code = 0, Context $context)
    {
        parent::__construct("PEG Parser: Can not find rule file '{$file}'", $code, $context);
    }
}
