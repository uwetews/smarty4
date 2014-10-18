<?php
namespace Smarty\Parser\Source\Language\Smarty\Node\Tag;

use Smarty\Node\Tag;

/**
 * Class TagWhile
 *
 * @package Smarty\Parser\Source\Language\Smarty\Node\Tag
 */
class TagWhile extends Tag
{
    /**
     * Node name
     *
     * @var string
     */
    public $name = 'TagWhile';
    /**
     * Rule name
     *
     * @var string
     */
    public $ruleName = 'TagWhile';
    /**
     * Parser node name (defaults to node name)
     *
     * @var string
     */
    public $parserNode = 'TagWhile';

    /**
     * Compiler class name (defaults to node name)
     *
     * @var string
     */
    public $compilerClass = 'TagWhile';

}