<?php

/**
 * Null Value Node
 *
 * @package Smarty\Compiler
 */
namespace Smarty\Parser\Source\Shared\Nodes;

use Smarty\Compiler\Nodes\Value;

/**
 * Class Null
 *
 * @package Smarty\Nodes\Value
 */
class Null extends Value
{
    /**
     * Compiled output
     *
     * @var string
     */
    public $code = 'null';

    /**
     * value
     *
     * @var null
     */
    public $value = null;

    /**
     * setValue is a noop
     *
     * @param mixed $value
     *
     * @return Node  $this
     */
    public function setValue($value)
    {
        return $this;
    }

    /**
     * Cleanup null is a noop
     *
     * @return Node  $this
     */
    public function cleanup()
    {
        return $this;
    }
}