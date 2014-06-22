<?php
/**
 * Smarty Compiler Template Node Expression Value Object
 *
 * @package Smarty\Compiler
 * @author  Uwe Tews
 */

/**
 * Object Value Node
 *
 * @package Smarty\Compiler
 */
namespace Smarty\Nodes\Value;

use Smarty\Nodes\Node;

/**
 * Class Static_
 *
 * @package Smarty\Nodes\Value
 */
class Static_ extends Value
{
    /**
     * Node compiler class name
     *
     * @var string
     */
    public $compiler_class = 'Value_Static';
}