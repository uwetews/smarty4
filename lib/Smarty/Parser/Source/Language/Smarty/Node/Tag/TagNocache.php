<?php
namespace Smarty\Parser\Source\Language\Smarty\Node\Tag;

use Smarty\Node\Tag;

/**
 * Class TagNocache
 *
 * @package Smarty\Parser\Source\Language\Smarty\Node\Tag
 */
class TagNocache extends Tag

{
    /**
     * Node name
     *
     * @var string
     */
    public $name = 'TagNocache';
    /**
     * Rule name
     *
     * @var string
     */
    public $ruleName = 'TagNocache';
    /**
     * Parser node name (defaults to node name)
     *
     * @var string
     */
    public $parserNode = 'TagNocache';

    /**
     * Compiler class name (defaults to node name)
     *
     * @var string
     */
    public $compilerClass = 'TagNocache';
}