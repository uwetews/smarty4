<?php

/**
 * Smarty Exception Plugin
 *
 * @package Smarty\Exception
 */
namespace Smarty\Compiler\Exception;

use Smarty\Template;
use Smarty\Parser\Exception\ForSourceLanguage;

/**
 * Smarty compiled language not found exception
 *
 * @package Smarty\Exception
 */
class ParserClassNotFound extends ForSourceLanguage
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
