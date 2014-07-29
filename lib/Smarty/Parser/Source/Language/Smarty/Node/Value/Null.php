<?php
namespace Smarty\Parser\Source\Language\Smarty\Node\Value;

use Smarty\Node;

/**
 * Class Null
 *
 * @package Smarty\Parser\Source\Language\Smarty\Node\Value
 */
class Null extends Node
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
     * Cleanup null is a noop
     *
     * @return Node  $this
     */
    public function cleanup()
    {
        return $this;
    }

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
}