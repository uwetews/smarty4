<?php
namespace Smarty\Parser\Source\Language\Smarty\Node\Tag;

use Smarty\Node\Tag;

/**
 * Class TagForeach
 *
 * @package Smarty\Parser\Source\Language\Smarty\Node\Tag
 */
class TagForeach extends Tag

{
    /**
     * Node name
     *
     * @var string
     */
    public $name = 'TagForeach';
    /**
     * Rule name
     *
     * @var string
     */
    public $ruleName = 'TagForeach';
    /**
     * Parser node name (defaults to node name)
     *
     * @var string
     */
    public $parserNode = 'TagForeach';

    /**
     * Compiler class name (defaults to node name)
     *
     * @var string
     */
    public $compilerClass = 'TagForeach';
}