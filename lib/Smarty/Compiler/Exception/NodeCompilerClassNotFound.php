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
class NodeCompilerClassNotFound extends ForSourceLanguage
{
    /**
     * Constructor
     *
     * @param string  $nodeName
     * @param mixed   $code
     * @param Context $context
     *
     * @internal param string $paserClass parser class name
     */
    public function __construct($nodeName, $code = 0, Context $context)
    {
        parent::__construct("Compiler: Can not find compiler class for node '{$nodeName}'", $code, $context);
    }
}
