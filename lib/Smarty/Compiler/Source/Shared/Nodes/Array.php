<?php
/**
 * Smarty Compiler Template Node Expression Value Array
 *
 * @package Smarty\Compiler
 * @author  Uwe Tews
 */

/**
 * Subexpression Value Node
 *
 * @package Smarty\Compiler
 */
namespace Smarty\Nodes\Value;

use Smarty\Nodes\Node;

/**
 * Class Array_
 *
 * @package Smarty\Nodes\Value
 */
class Array_ extends Value
{
    /**
     * Node compiler class name
     *
     * @var string
     */
    public $compiler_class = 'Value_Array';
}