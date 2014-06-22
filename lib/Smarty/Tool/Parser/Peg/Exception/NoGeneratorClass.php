<?php
namespace Smarty\Tool\Parser\Peg\Exception;
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
class NoGeneratorClass extends \Exception
{
    /**
     * Constructor
     *
     * @param string  $type
     * @param mixed   $code
     * @param Context $className
     * @param Context $context
     */
    public function __construct($className, $code = 0)
    {
        parent::__construct("Smarty PEG Parser: Configuration error - parser generator class '{$className}' not found");
    }
}
