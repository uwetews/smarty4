<?php
namespace Smarty\Parser\Source\Language\Smarty\Node\Tag;

use Smarty\Node\Tag;

/**
 * Class TagFor
 *
 * @package Smarty\Parser\Source\Language\Smarty\Node\Tag
 */
class TagFor extends Tag
{
    /**
     * Node name
     *
     * @var string
     */
    public $name = 'TagFor';
    /**
     * Rule name
     *
     * @var string
     */
    public $ruleName = 'TagFor';
    /**
     * Parser node name (defaults to node name)
     *
     * @var string
     */
    public $parserNode = 'TagFor';

    /**
     * Compiler class name (defaults to node name)
     *
     * @var string
     */
    public $compilerClass = 'TagFor';

}