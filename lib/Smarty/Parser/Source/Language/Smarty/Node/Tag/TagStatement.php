<?php
namespace Smarty\Parser\Source\Language\Smarty\Node\Tag;

/**
 * Class TagStatement
 *
 * @package Smarty\Parser\Source\Language\Smarty\Node\Tag
 */
class TagStatement extends TagAssign
{
    /**
     * Node name
     *
     * @var string
     */
    public $name = 'TagStatement';
    /**
     * Rule name
     *
     * @var string
     */
    public $ruleName = 'TagStatement';
    /**
     * Parser node name (defaults to node name)
     *
     * @var string
     */
    public $parserNode = 'TagStatement';

    /**
     * Compiler class name (defaults to node name)
     *
     * @var string
     */
    public $compilerClass = 'TagAssign';
}