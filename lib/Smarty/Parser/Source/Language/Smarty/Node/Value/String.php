<?php
namespace Smarty\Parser\Source\Language\Smarty\Node\Value;

use Smarty\Node;
use Smarty\Compiler\Code;

/**
 * Class String
 *
 * @package Smarty\Parser\Source\Language\Smarty\Node\Value
 */
class String extends Node
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
     * Flag that node does not need an external compiler module
     *
     * @var bool
     */
    public $hasLocalCompiler = true;

    /**
     * Cleanup string is a noop
     *
     * @return Node  current node
     */
    public function cleanup()
    {
        return $this;
    }

    /**
     * Compile string and move compiled code into target node if specified
     *
     * @param Code $codeTargetObj
     * @param bool $delete
     *
     * @return Node  current node
     */
    public function compile(Code $codeTargetObj = null, $delete = true)
    {
        if ($this->compileAsValue) {
            $codeTargetObj->raw($this->value);
        } else {
            $codeTargetObj->raw("'" . $this->value . "'");
        }
        return $this;
    }

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
            $this->compileAsValue = true;
        }
        if ($trim === true && in_array($value[0], array('"', "'") )) {
            $this->value =substr($value, 1, strlen($value) - 2 );
        } else {
            $this->value = $value;
        }
        return $this;
    }
}