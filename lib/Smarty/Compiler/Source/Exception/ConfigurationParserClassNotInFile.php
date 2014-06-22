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
class Smarty_Source_Exception_ConfigurationParserClassNotInFile extends Smarty_Exception_ForSourceLanguage
{
    /**
     * Constructor
     *
     * @param string                  $parserClass
     * @param mixed                   $code
     * @param Context                 $context
     * @param                         $parserFile
     *
     * @internal param string $dummy
     */
    public function __construct($parserClass, $code = 0, Context $context, $parserFile)
    {
        parent::__construct("Source Configuration: Parser class '{$parserClass}' not in file {$parserFile}", $code, $context);
    }
}
