<?php
/**
 * Smarty Compiler Node
 *
 * @package Smarty\Compiler
 * @author  Uwe Tews
 */

/**
 * Smarty Compiler Node
 * Basic Parent Compiler Node
 *
 * @package Smarty\Compiler
 */
namespace Smarty;

use Smarty\Exception\Magic;
use Smarty\Compiler\Format;
use Smarty\Compiler\Code;

/**
 * Class Node
 *
 * @package Smarty\Nodes
 */
class Node extends Magic
{
    /**
     * Node name
     *
     * @var string
     */
    public $name = null;
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
    public $isParsed = false;
    /**
     * Parser object
     *
     * @var Parser
     */
    public $parser = null;

    /**
     * Constructor
     *
     * @param \Smarty\Parser $parser parser context object
     */
    function __construct(Parser $parser, $name = null, $token = null)
    {
        $this->name = isset($name) ? $name : $this->name;
        if (isset($token)) {
            $this->setNodeAttributes($token);
        }
        $this->parser = $parser;
        $this->parserNode = isset($this->parserNode) ? $this->parserNode : $this->name;
        $this->compilerClass = isset($this->compilerClass) ? $this->compilerClass : $this->name;
    }

    public function setNodeAttributes($token)
    {
        if (isset($token['_attr']['attributes'])) {
            $this->nodeAttributes = $token['_attr']['attributes'];
        }
    }

    public function getNodeAttribute($attribute)
    {
        return isset($this->nodeAttributes[$attribute]) ? $this->nodeAttributes[$attribute] : false;
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
     */public function getSubTree($name)
    {
        return isset($this->internalNodeTrees[$name]) ? $this->internalNodeTrees[$name] : false;
    }

    /**
     * Load source into parser
     *
     * @return mixed
     */
    public function setSource($source)
    {
        $this->parser->setSource($source);
        return $this;
    }

    /**
     * Call parser
     *
     * @return mixed
     */
    public function parse()
    {
        $this->parser->parse($this->parserNode, $this);
        $this->isParsed = true;
        return $this;
    }

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
