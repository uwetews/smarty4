<?php
/**
 * Smarty Compiler Template Node Expression Value String
 *
 * @package Smarty\Compiler
 * @author  Uwe Tews
 */

/**
 * String Value Node
 *
 * @package Smarty\Compiler
 */
namespace Smarty\Parser\Source\Shared\Nodes;

use Smarty\Compiler\Nodes\Value;

/**
 * Class String
 *
 * @package Smarty\Nodes\Value
 */
class String extends Value
{
    /**
     * Node name
     *
     * @var string
     */
    public $name = 'String';

    /**
     * value
     *
     * @var string
     */
    public $value = '';

    /**
     * flag if compile shall return raw string value
     *
     * @var boolean
     */
    public $compileAsValue = false;

    /**
     * Set string value
     *
     * @param string $value          string value
     * @param bool   $compileAsValue flag if raw string value shall be return on compile
     * @param bool   $trim           flag if quotes shall be trimed from value
     *
     * @return $this
     */
    public function setValue($value, $compileAsValue = false, $trim = true)
    {
        if ($compileAsValue == true) {
            $this->compileAsValue = $compileAsValue;
        }
        if ($trim === null || $trim === true) {
            $this->value = trim($value, "'\"");
        } else {
            $this->value = $value;
        }
        return $this;
    }

    /**
     * Compile string and move compiled code into target node if specified
     *
     * @param Node $target optional target node for compiled code
     * @param bool $delete
     *
     * @return Node  current node
     */
    public function compile(Node $target, $delete = true)
    {
        if ($this->compileAsValue) {
            $target->raw($this->value);
        } else {
            $target->raw("'" . $this->value . "'");
        }
        return $this;
    }

    /**
     * Cleanup string is a noop
     *
     * @return Node  current node
     */
    public function cleanup()
    {
        return $this;
    }
}