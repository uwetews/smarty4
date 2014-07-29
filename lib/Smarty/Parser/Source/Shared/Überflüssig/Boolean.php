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
namespace Smarty\Parser\Source\Shared\Nodes;

use Smarty\Compiler\Nodes\Value;

/**
 * Class Boolean
 *
 * @package Smarty\Nodes\Value
 */
class Boolean extends Value
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