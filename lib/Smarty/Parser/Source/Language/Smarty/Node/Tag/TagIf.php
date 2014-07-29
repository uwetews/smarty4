<?php
namespace Smarty\Parser\Source\Language\Smarty\Node\Tag;

use Smarty\Node\Tag;

/**
 * Class TagIf
 *
 * @package Smarty\Parser\Source\Language\Smarty\Node\Tag
 */
class TagIf extends Tag
{
    /**
     * Node name
     *
     * @var string
     */
    public $name = 'TagIf';
    /**
     * Rule name
     *
     * @var string
     */
    public $ruleName = 'TagIf';
    /**
     * Parser node name (defaults to node name)
     *
     * @var string
     */
    public $parserNode = 'TagIf';

    /**
     * Compiler class name (defaults to node name)
     *
     * @var string
     */
    public $compilerClass = 'TagIf';

}