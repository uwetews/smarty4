<?php
/**
 * Smarty Compiler Template Node Expression Value Boolean
 *
 * @package Smarty\Compiler
 * @author  Uwe Tews
 */

/**
 * Boolean Value Node
 *
 * @package Smarty\Compiler
 */
namespace Smarty\Node\Value;

use Smarty\Node;

/**
 * Class Boolean
 *
 * @package Smarty\Nodes\Value
 */
class Boolean extends Node
{
    /**
     * Node name
     *
     * @var string
     */
    public $name = 'Boolean';

    /**
     * Compiled output
     *
     * @var string
     */
    public $code = 'false';

    /**
     * value
     *
     * @var boolean
     */
    public $value = false;

    /**
     * Cleanup Number is a noop
     *
     * @return Node  $this
     */
    public function cleanup()
    {
        return $this;
    }

    /**
     * set value and code
     *
     * @param boolen $value
     *
     * @return $this
     */
    public function setValue($value)
    {
        if ($value === true || $value === 'true') {
            $this->value = true;
            $this->code = 'true';
        }
        return $this;
    }
}