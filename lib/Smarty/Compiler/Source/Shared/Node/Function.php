<?php
/**
 * Smarty Compiler Template Node Expression Value Function
 *
 * @package Smarty\Compiler
 * @author  Uwe Tews
 */

/**
 * Function Value Node
 *
 * @package Smarty\Compiler
 */
namespace Smarty\Nodes\Value;

use Smarty\Nodes\Node;

/**
 * Class Function_
 *
 * @package Smarty\Nodes\Value
 */
class Function_ extends Value
{

    /**
     * Flag that this node is for function
     *
     * @var bool
     */
    public $isFunction = true;

}