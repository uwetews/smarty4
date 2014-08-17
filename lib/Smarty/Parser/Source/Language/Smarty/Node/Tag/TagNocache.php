<?php
namespace Smarty\Parser\Source\Language\Smarty\Node\Tag;

use Smarty\Node\Tag;
use Smarty\Compiler\Format;

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

    /**
     * Call compiler for this node
     *
     * @param Code $codeTargetObj
     * @param bool $delete
     *
     * @return Code
     * @throws Exception
     * @throws NodeCompilerClassNotFound
     * @throws \Exception
     */
    public function compile(Code $codeTargetObj = null, $delete = true)
    {
        if (!isset($codeTargetObj) && !isset($this->codeObj)) {
            $this->codeObj = new Format($this);
        }
        $codeTargetObj = isset($codeTargetObj) ? $codeTargetObj : $this->codeObj;

        $this->parser->compiler->compileNode($this, $codeTargetObj, $delete);
        return $codeTargetObj;
    }
}