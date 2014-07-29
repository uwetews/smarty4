<?php
namespace Smarty\Parser\Source\Language\Smarty\Node\Value;

use Smarty\Node;
use Smarty\Parser;
use Smarty\Compiler\Code;

/**
 * Class Subexpression
 *
 * @package Smarty\Parser\Source\Language\Smarty\Node\Value
 */
class Subexpression extends Node
{

    /**
     * This node has internal compiler code
     *
     * @var bool
     */
    public $hasLocalCompiler = true;

    /**
     * Constructor
     *
     * @param Parser    $parser parser object
     * @param null|Node $node   optional
     *
     * @internal param string $type dummy parameter
     */
    public function __construct(Parser $parser, Node $node = null)
    {
        parent::__construct($parser);
        if ($node !== null) {
            $this->internalNodeTrees = array_merge($this->internalNodeTrees, (array) $node);
        }
    }

    /**
     * Compile sub expression and move compiled code into target node if specified
     *
     * @param Code $codeTargetObj
     * @param bool $delete flag if compiled nodes shall be deleted
     *
     * @return Node  current node
     */
    public function compile(Code $codeTargetObj, $delete = true)
    {
        if (!empty($this->internalNodeTrees)) {
            $codeTargetObj->raw('(')
                ->compileNodeArray($this->internalNodeTrees, $codeTargetObj, $delete)
                ->raw(')');
        }
        return $this;
    }
}