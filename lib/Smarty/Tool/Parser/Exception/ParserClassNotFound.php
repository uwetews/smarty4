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
class Smarty_Parser_Exception_ParserClassNotFound extends \Smarty_Exception_ForSourceLanguage
{
    /**
     * Constructor
     *
     * @param string  $parserClass
     * @param mixed   $code
     * @param Context $context
     *
     * @internal param string $paserClass parser class name
     */
    public function __construct($parserClass, $code = 0, Context $context)
    {
        parent::__construct("Parser: Can not find parser class '{$parserClass}'", $code, $context);
    }
}
