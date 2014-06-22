<?php
/**
 * Smarty Compiler Template Node Expression Value Number
 *
 * @package Smarty\Compiler
 * @author  Uwe Tews
 */

/**
 * Number Value Node
 *
 * @package Smarty\Compiler
 */

namespace Smarty\Nodes;

use Smarty\Nodes\Value;
use Smarty\Nodes\Node;

/**
 * Class Number
 *
 * @package Smarty\Nodes\Value
 */
class Number extends Value
{
    /**
     * Compiled output
     *
     * @var int
     */
    public $code = null;

    /**
     * Compiled output
     *
     * @var int
     */
    public $value = null;

    /**
     * Set value and code
     *
     * @param number $value
     *
     * @return Node  $this
     */
    public function setValue($value)
    {
        $this->code = $this->value = $value;
        return $this;
    }

    /**
     * Cleanup Number is a noop
     *
     * @return Node  $this
     */
    public function cleanup()
    {
        return $this;
    }
}