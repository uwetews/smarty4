<?php
namespace Smarty\Parser\Source\Language\Smarty\Node\Value;

use Smarty\Node;

/**
 * Class DoubleQuoted
 *
 * @package Smarty\Parser\Source\Language\Smarty\Node\Value
 */
class DoubleQuoted extends Node
{
    /**
     * Node name
     *
     * @var string
     */
    public $name = 'DoubleQuoted';
    /**
     * Rule name
     *
     * @var string
     */
    public $ruleName = 'DoubleQuoted';
    /**
     * Parser node name (defaults to node name)
     *
     * @var string
     */
    public $parserNode = 'Expression';

    /**
     * Compiler class name (defaults to node name)
     *
     * @var string
     */
    public $compilerClass = 'DoubleQuoted';

    /**
     * Array of text segments
     *
     * @var array
     */
    public $textSegments = array();

    /**
     * add array with text Segments
     *
     * @param $textSegments
     */
    public function setTextSegmentsNodes($textSegments)
    {
        $this->textSegments = $textSegments;
    }
}