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
class Smarty_Parser_Peg_Exception_PhpPegParserCreationFailed extends \Smarty_Exception_ForSourceLanguage
{
    /**
     * Constructor
     *
     * @param string                   $parserFilePath
     * @param mixed                    $code
     * @param Context                  $context
     * @param                          $rulePath
     *
     * @internal param string $file name of PEG parser rule file
     */
    public function __construct($parserFilePath, $code = 0, Context $context, $rulePath)
    {
        parent::__construct("PEG Parser: Creation of PHP parser file '{$parserFilePath}' from rule file '{$rulePath}' failed", $code, $context, $rulePath);
    }
}
