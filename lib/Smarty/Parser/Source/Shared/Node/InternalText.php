<?php
/**
 * Smarty Compiler Template Node Text
 *
 * @package Smarty\Compiler
 * @author  Uwe Tews
 */
namespace Smarty\Parser\Source\Shared\Node;

use Smarty\Node;

/**
 * Class InternalText
 *
 * @package Smarty\Parser\Source\Shared\Node
 */
class InternalText extends Node
{
    /**
     * Node name
     *
     * @var string
     */
    public $name = 'InternalText';
    /**
     * Rule name
     *
     * @var string
     */
    public $ruleName = 'Text';

    /**
     * @param $text
     *
     * @return $this
     */
    public function addText($text)
    {
        $this->value .= $text;
        return $this;
    }

    /**
     * @return $this
     */
    public function stripText()
    {
        $this->value = preg_replace('![\t ]*[\r\n]+[\t ]*!', '', $this->value);
        return $this;
    }
}