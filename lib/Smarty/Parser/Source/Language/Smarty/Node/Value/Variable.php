<?php
namespace Smarty\Parser\Source\Language\Smarty\Node\Value;

use Smarty\Node;
class Variable extends Node
{
    /**
     * Node name
     *
     * @var string
     */
    public $name = 'Variable';
    /**
     * Rule name
     *
     * @var string
     */
    public $ruleName = 'Variable';
    /**
     * Parser node name (defaults to node name)
     *
     * @var string
     */
    public $parserNode = 'Variable';

    /**
     * Compiler class name (defaults to node name)
     *
     * @var string
     */
    public $compilerClass = 'Variable';



}