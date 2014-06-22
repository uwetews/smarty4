<?php
/**
 * Smarty Compiler Template Node Text
 *
 * @package Smarty\Compiler
 * @author  Uwe Tews
 */
namespace Smarty\Compiler\Source\Shared\Nodes;

use Smarty\Node;

/**
 * Smarty Compiler Template Node Text
 * This is the root node of a resource
 *
 * @package Smarty\Compiler
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