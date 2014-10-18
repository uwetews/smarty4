<?php
namespace Smarty\Compiler;

use Smarty\Node;
use Smarty\Parser;
use Smarty\Exception\Magic;

/**
 * Class Code
 * This class is an container for pre compiled or formatted code blocks
 * and related handling methods
 *
 * @package Smarty\Nodes
 */
class Code //extends Magic
{
    /**
     * Index of last pre compiled raw entry
     *
     * @var int
     */
    public $ind_last_raw = - 1;

    /**
     * Precompiled code
     *
     * @var array
     */
    public $preCompiled = array();

    /**
     * Last line number of pre compiled code
     *
     * @var int
     */
    public $lastLineNo = 0;
    /**
     * @var bool
     */
    public $isParsed = false;
    /**
     * @var bool
     */
    public $isPreCompiled = false;
    /**
     * @var bool
     */
    public $isFormatted = false;
    /**
     * @var null
     */
    public $node = null;
    /**
     * @var null
     */
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
     * Apends a raw string to the compiled code.
     *
     * @param  string $string The string
     *
     * @return $this   current node
     */
    public function raw($string)
    {
        if ($this->ind_last_raw >= 0 && $this->preCompiled[$this->ind_last_raw][0] == self::RAW) {
            $this->preCompiled[$this->ind_last_raw][1] .= $string;
        } else {
            $this->preCompiled[] = array(self::RAW, $string);
            $this->ind_last_raw = count($this->preCompiled) - 1;
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
        $this->preCompiled[] = array(self::INDENTATION, $value);
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
        $this->preCompiled[] = array(self::INDENTATION, null);
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
        $this->preCompiled[] = array(self::STRING, $value, $double_quote, $string_length);
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
        $this->preCompiled[] = array(self::REPR, $value, $double_quote, $string_length);
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
            $this->preCompiled[] = array(self::LINE, $line);
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
        $this->preCompiled[] = array(self::OUTDENT, $step);
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
        $this->preCompiled[] = array(self::INDENT, $step);
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
        $this->preCompiled[] = array(self::RAW, "{\n");
        $this->preCompiled[] = array(self::INDENT, 1);
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
        $this->preCompiled[] = array(self::RAW, "\n");
        $this->preCompiled[] = array(self::OUTDENT, 1);
        $this->preCompiled[] = array(self::INDENTATION, "\n}\n");
        $this->ind_last_raw = - 1;
        return $this;
    }


    /**
     * Merge other code buffer into current
     *
     * @param  \Smarty_Compiler_Code $code
     *
     * @return \Smarty_Compiler_code
     */
    public function mergeCode(Code $code)
    {
        $this->mergeTraceBackInfo($code->traceback);
        $this->preCompiled = array_merge($this->preCompiled, $code->preCompiled);
        $this->ind_last_raw = - 1;
        return $this;
    }

    /**
     * Merge traceback
     *
     * @param  \Smarty_Compiler_Node $node source node
     *
     * @return \Smarty_Compiler_Format
     */
    public function mergeTraceBackInfo(Code $code)
    {
        foreach ($code->traceback as $codeline => $line) {
            $this->traceback[$codeline + $this->compiledLineNumber] = $line;
        }
        return $this;
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
     *
     */
    public function reset() {
        $this->lastLineNo = 0;
        $this->ind_last_raw = - 1;
        $this->preCompiled = array();
        $this->isParsed = false;
        $this->isPreCompiled = false;
        $this->isFormatted = false;
        $this->node = null;
    }

    /**
     * Remove all sub nodes from current node
     *
     * @return $this   current node
     */
    public function cleanup()
    {
        $this->node = null;
        return $this;
    }
}
