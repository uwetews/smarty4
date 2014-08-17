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
namespace Smarty\Compiler;

use Smarty\Node;
use Smarty\Parser;
use Smarty\Exception\Magic;

/**
 * Class Code
 * This class is an container for precompiled or formatted code blocks
 * and related handling methods
 *
 * @package Smarty\Nodes
 */
class Code extends Magic
{
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
     * Index of last precompiled raw entry
     *
     * @var int
     */
    public $ind_last_raw = - 1;

    /**
     * Precompiled code
     *
     * @var array
     */
    public $precompiled = array();

    /**
     * Last of precompiled code
     *
     * @var int
     */
    public $lastLineNo = 0;
    public $isParsed = false;
    public $isPrecompiled = false;
    public $isFormatted = false;
    public $node = null;
    public $formatter = null;

    const INDENTATION = 0;
    const INDENT = 1;
    const OUTDENT = 2;
    const RAW = 3;
    const STRING = 4;
    const REPR = 5;
    const LINE = 6;

    /**
     * Constructor
     *
     * @param
     */
    function __construct($node = null)
    {
        $this->node = $node;
    }

    /**
     * @param Node $node
     * @param bool $delete
     */
    public function compile(Node $node, $delete = true)
    {
        if (isset($node->code)) {
            $node->raw($this->code);
            return;
        }
    }

    /**
     * Compile an array of nodes and move compiled code into target node if specified
     *
     * @param      array   Node     $nodes
     * @param bool $delete flag if compiled nodes shall be deleted
     *
     * @return $this   current node
     */
    public function compileNodeItems(&$nodes, $delete = true)
    {
        if (is_array($nodes)) {
            foreach ($nodes as $key => $node) {
                $node->compile($this, $delete);
                unset($node);
                if ($delete) {
                    $nodes[$key]->cleanup();
                    unset($nodes[$key]);
                }
            }
        } else {
            $nodes->compile($this, $delete);
            $nodes = null;
        }
        return $this;
    }

    /**
     * Apends a raw string to the compiled code.
     *
     * @param  string $string The string
     *
     * @return $this   current node
     */
    public function raw($string)
    {
        if ($this->ind_last_raw >= 0 && $this->precompiled[$this->ind_last_raw][0] == self::RAW) {
            $this->precompiled[$this->ind_last_raw][1] .= $string;
        } else {
            $this->precompiled[] = array(self::RAW, $string);
            $this->ind_last_raw = count($this->precompiled) - 1;
        }
        return $this;
    }


    /**
     * The follow section contains the methods for precompiled code
     */

    /**
     * Add newline to the current buffer.
     *
     * @return $this   current node
     */
    public function newline()
    {
        $this->raw("\n");
        return $this;
    }

    /**
     * Add a line of PHP code to output.
     *
     * @param  string $value PHP source
     *
     * @return $this   current node
     */
    public function code($value, $indent = 0)
    {
        if ($indent < 0) {
            $this->outdent(- $indent);
        }
        $this->precompiled[] = array(self::INDENTATION, $value);
        if ($indent > 0) {
            $this->indent($indent);
        }
        $this->ind_last_raw = - 1;
        return $this;
    }

    /**
     * Add an indentation to the current buffer.
     *
     * @return $this   current node
     */
    public function addIndentation()
    {
        $this->precompiled[] = array(self::INDENTATION, null);
        $this->ind_last_raw = - 1;
        return $this;
    }

    /**
     * Adds a quoted string to the compiled code.
     *
     * @param string   $value         The string
     * @param bool     $double_quote  flag if double quotes shall be used
     * @param null|int $string_length option string line length
     *
     * @return $this   current node
     */
    public function string($value, $double_quote = true, $string_length = null)
    {
        $this->precompiled[] = array(self::STRING, $value, $double_quote, $string_length);
        $this->ind_last_raw = - 1;
        return $this;
    }

    /**
     * Adds the PHP representation of a given value to the current buffer
     *
     * @param  mixed   $value         The value to convert
     * @param  bool    $double_quote  flag to use double quotes on strings
     * @param null|int $string_length option string line length
     *
     * @return $this   current node
     */
    public function repr($value, $double_quote = true, $string_length = null)
    {
        $this->precompiled[] = array(self::REPR, $value, $double_quote, $string_length);
        $this->ind_last_raw = - 1;
        return $this;
    }

    /**
     * Insert source line number
     *
     * @param  integer $line source line number
     *
     * @return $this   current node
     */
    public function lineNo($line)
    {
        if ($this->lastLineNo != $line) {
            $this->precompiled[] = array(self::LINE, $line);
            $this->lastLineNo = $line;
        }
        return $this;
    }

    /**
     * Outdents the generated code.
     *
     * @param integer $step The number of indentation to remove
     *
     * @return $this   current node
     */
    public function outdent($step = 1)
    {
        $this->precompiled[] = array(self::OUTDENT, $step);
        $this->ind_last_raw = - 1;
        return $this;
    }

    /**
     * Indents the generated code.
     *
     * @param  integer $step The number of indentation to add
     *
     * @return $this   current node
     */
    public function indent($step = 1)
    {
        $this->precompiled[] = array(self::INDENT, $step);
        $this->ind_last_raw = - 1;
        return $this;
    }

    /**
     * inserts curly open bracket generated code.
     *
     * @return $this   current node
     */
    public function openCurly()
    {
        $this->precompiled[] = array(self::RAW, "{\n");
        $this->precompiled[] = array(self::INDENT, 1);
        $this->ind_last_raw = - 1;
        return $this;
    }

    /**
     * inserts curly close bracket generated code.
     *
     * @return $this   current node
     */
    public function closeCurly()
    {
        $this->precompiled[] = array(self::RAW, "\n");
        $this->precompiled[] = array(self::OUTDENT, 1);
        $this->precompiled[] = array(self::INDENTATION, "\n}\n");
        $this->ind_last_raw = - 1;
        return $this;
    }

    public function formatCode()
    {
        if (!isset($this->formatter)) {
            $this->formatter = $this->node->parser->compiler->instanceFormatter();
            $this->formatter->formatCode($this);
        }
    }

    public function getFormatted()
    {
        if (!isset($this->formatter)) {
            $this->formatter = $this->node->parser->compiler->instanceFormatter();
            return $this->formatter->getFormatted($this);
        }
    }

    /**
     * Compile an array of nodes and move compiled code into target node if specified
     *
     * @param  array $nodesArray array of nodes to be compiled
     * @param bool   $delete     flag if compiled nodes shall be deleted
     *
     * @return $this   current node
     */
    public function compileNodeArray(&$nodesArray, Code $codeTargetObj, $delete = true)
    {
        if (is_array($nodesArray)) {
            foreach ($nodesArray as $key => $n) {
                $n->compile($codeTargetObj, $delete);
                unset($n);
            }
        } else {
            $nodesArray->compile($codeTargetObj, $delete);
        }
        if ($delete) {
            if (is_array($nodesArray)) {
                foreach ($nodesArray as $key => $n) {
                    $nodesArray[$key]->cleanup();
                    unset($nodesArray[$key]);
                }
            } else {
                $nodesArray->cleanup();
                unset($nodesArray);
            }
        }
        return $this;
    }

    /**
     * Compile an array of nodes and move compiled code into target node if specified
     *
     * @param  array $nodesArray array of nodes to be compiled
     * @param bool   $delete     flag if compiled nodes shall be deleted
     *
     * @return $this   current node
     */
    public function compileNode($nodes, $delete = true)
    {
        if (is_array($nodes)) {
            foreach ($nodes as $node) {
                $node->compile($this, $delete);
                unset($node);
            }
        } else {
            $nodes->compile($this, $delete);
        }
        if ($delete) {
            if (is_array($nodes)) {
                foreach ($nodes as $node) {
                    $node->cleanup();
                }
            } else {
                $nodes->cleanup();
                unset($nodesArray);
            }
        }
        return $this;
    }

    /**
     * Remove all sub nodes from current node
     *
     * @return $this   current node
     */
    public function cleanup()
    {
        $this->targetNode = null;
        $this->parser = null;
        return $this;
    }
}
