<?php
namespace Smarty\Parser\Source\Language\Smarty\Node\Value;

use Smarty\Node;

/**
 * Class Number
 *
 * @package Smarty\Parser\Source\Language\Smarty\Node\Value
 */
class Number extends Node
{
    /**
     * Node name
     *
     * @var string
     */
    public $name = 'Number';

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
     * Cleanup Number is a noop
     *
     * @return Node  $this
     */
    public function cleanup()
    {
        return $this;
    }

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
}