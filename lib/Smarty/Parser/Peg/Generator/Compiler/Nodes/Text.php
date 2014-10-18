<?php

Namespace Smarty\Parser\Peg\Generator\Compiler\Nodes;

use Smarty\Exception\Magic;
use Smarty\Compiler\Format;

/**
 * Class Text
 * Compile none PEG parser text section
 *
 * @package Smarty\Parser\Peg\Generator\Compiler\Nodes
 */
class Text extends Magic
{
    /**
     * Text string
     *
     * @var string
     */
    public $text = '';

    /**
     * Add text string
     *
     * @param $text
     */
    public function addText($text)
    {
        $this->text .= $text;
    }

    /**
     * Return false for text section
     *
     * @return false
     */
    public function getRuleArray()
    {
        return false;
    }

    /**
     * Compile plain text
     *
     * @param Format $target
     */
    public function compileRuleArray(Format $target)
    {
        $target->raw($this->text);
    }

    /**
     * Compile plain text
     *
     * @param Format $target
     */
    public function compile(Format $target)
    {
        $target->raw($this->text);
    }
}

