<?php
namespace Smarty;

use Smarty\Exception\Magic;
use Smarty\Compiler\Format;
use Smarty\Compiler\Code;

/**
 * Class Node
 *
 * @package Smarty
 */
class Node// extends Magic
{
    /**
     * Node name
     *
     * @var string
     */
    public $name = null;
    /**
     * Rule name
     *
     * @var string
     */
    public $ruleName = null;
    /**
     * Parser node name (defaults to node name)
     *
     * @var string
     */
    public $parserNode = null;

    /**
     * Compiler class name (defaults to node name)
     *
     * @var string
     */
    public $compilerClass = null;
    /**
     * node type
     *
     * @var string
     */
    public $nodeType = 'node';

    /**
     * Array of node attributes
     *
     * @var array
     */
    public $nodeAttributes = array();

    /**
     * Array of internal node trees
     *
     * @var array
     */
    public $internalNodeTrees = array();

    /**
     * Current source line number
     *
     * @var int
     */
    public $sourceLineNo = null;

    /**
     * Current source line number
     *
     * @var int
     */
    public $sourceStartPos = null;

    /**
     * Current source line number
     *
     * @var int
     */
    public $sourceEndPos = null;

    /**
     * Current source line number
     *
     * @var int
     */
    public $sourceText = null;

    /**
     * node value
     * var mixed
     */
    public $value;

    /**
     * Code generator object
     *
     * @var Code
     */
    public $codeObj = null;

    // TODO if this is needed
    /**
     * Flag that node is parsed
     *
     * @var bool
     */
    public $isParsed = false;

    /**
     * Parser object
     *
     * @var Parser
     */
    public $parser = null;

    public $errors = array();

    /**
     * Constructor
     *
     * @param \Smarty\Parser $parser parser context object
     * @param string|null    $name
     */
    function __construct(Parser $parser, $name = null)
    {
        $this->name = isset($name) ? $name : $this->name;
        $this->parser = $parser;
        $this->ruleName = isset($this->ruleName) ? $this->ruleName : $this->name;
        $this->parserNode = isset($this->parserNode) ? $this->parserNode : $this->name;
        $this->compilerClass = isset($this->compilerClass) ? $this->compilerClass : $this->name;
        $this->setNodeAttributes($this->parser->getNodeAttributes($this->ruleName));
        $this->sourceLineNo = $parser->line;
        $this->sourceStartPos = $parser->pos;
    }

    /**
     * Set all node attributes
     *
     * @param array $attributes
     */
    public function setNodeAttributes($attributes)
    {
        if (isset($attributes)) {
            $this->nodeAttributes = $attributes;
        }
    }

    /**
     * Get node attribute by it's name
     *
     * @param string $attributeName
     *
     * @return bool
     */
    public function getNodeAttribute($attributeName)
    {
        return isset($this->nodeAttributes['attributes'][$attributeName]) ? $this->nodeAttributes['attributes'][$attributeName] : false;
    }

    /**
     * Set node value
     *
     * @param mixed $value
     *
     * @return $this
     */
    public function setValue($value)
    {
        $this->value = $value;
        return $this;
    }

    /**
     * Set trace info
     *
     * @param int|null    $line
     * @param string|null $text
     * @param int|null    $startPos
     * @param int|null    $endPos
     *
     * @return Node  $this
     */
    public function setTraceInfo($line = null, $text = null, $startPos = null, $endPos = null)
    {
        $this->sourceLineNo = $line;
        $this->sourceText = $text;
        $this->sourceStartPos = $startPos;
        $this->sourceEndPos = $endPos;
        return $this;
    }

    /**
     * Add subtree node
     *
     * @param Node        $node Node object or array of objects
     * @param string|null $name if set name of subtree
     * @param bool        $multiple
     *
     * @return Node  $this
     */
    public function addSubTree($node, $name = null, $multiple = false)
    {
        if (isset($name)) {
            if (!isset($this->internalNodeTrees[$name])) {
                $this->internalNodeTrees[$name] = $multiple ? array($node) : $node;
            } else {
                $this->internalNodeTrees[$name][] = $node;
            }
            return $this;
        }
        $this->internalNodeTrees[] = $node;
        return $this;
    }

    /**
     * Return node subtree of given name
     *
     * @param $name
     *
     * @return bool|mixed
     */
    public function getSubTree($name)
    {
        return isset($this->internalNodeTrees[$name]) ? $this->internalNodeTrees[$name] : false;
    }

    /**
     * Load source into parser
     *
     * @param string $source
     *
     * @return $this
     */
    public function setSource($source)
    {
        $this->parser->setSource($source);
        return $this;
    }

    public function addError($error)
    {
        $this->errors = array_merge($this->errors, $error);
    }

    /**
     * Call parser
     *
     * @return $this
     */
    public function parse()
    {
        $this->parser->parse($this->parserNode, $this);
        $this->isParsed = true;
        return $this;
    }

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

    /**
     * Remove all sub nodes from current node
     *
     * @return Node  current node
     */
    public function cleanup()
    {
        if (isset($this->codeObj)) {
            $this->codeObj->node = null;
            $this->codeObj = null;
        }
        return $this;
    }


    /**
     * The follow section contains the methods for precompiled code
     */

    /**
     * Remove all nodes from array
     *
     * @param array $nodesArray node array
     *
     * @return Node  current node
     */
    public function cleanupNodeArray(&$nodesArray)
    {
        foreach ($nodesArray as $key => $n) {
            if (isset($n)) {
                if (is_object($nodesArray[$key])) {
                    $nodesArray[$key]->cleanup();
                }
            }
            unset($n);
            unset($nodesArray[$key]);
        }
        return $this;
    }
}
