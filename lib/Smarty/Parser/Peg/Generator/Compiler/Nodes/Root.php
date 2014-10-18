<?php

Namespace Smarty\Parser\Peg\Generator\Compiler\Nodes;

use Smarty\Compiler\Format;

/**
 * Class Root
 *
 * @package Smarty\Parser\Peg\Generator\Compiler\Nodes
 */
class Root extends Format
{
    /**
     * Array of Text or RuleRoot; nodes
     *
     * @var array
     */
    public $nodes = array();

    /**
     * @var string
     */
    public $filename = '';
    /**
     * @var int
     */
    public $filetime = 0;

    /**
     * Constructor
     */
    public function __construct()
    {
    }

    /**
     * @param int $filetime
     */
    public function setFiletime($filetime)
    {
        $this->filetime = $filetime;
    }

    /**
     * @param string $filename
     */
    public function setFilename($filename)
    {
        $this->filename = $filename;
    }

    /**
     * Add sub node
     *
     * @param $node
     */
    public function addNode($node)
    {
        $this->nodes[] = $node;
    }

    /**
     *
     */
    public function compileParser()
    {
        foreach ($this->nodes as $key => $node) {
            $node->compile($this);
            unset($this->nodes[$key]);
        }
    }

    /**
     * Compile parser in rule array format

     */
    public function compileParserRuleArray()
    {
        foreach ($this->nodes as $key => $node) {
            $node->compileRuleArray($this);
            unset($this->nodes[$key]);
        }
    }

    /**
     * Return parser rule array
     *
     * @return array
     */
    public function getParserRuleArray()
    {
        $ruleArray = array();
        foreach ($this->nodes as $key => $node) {
            if ($array = $node->getRuleArray()) {
                $ruleArray = array_merge($ruleArray, $array);
            }
            unset($this->nodes[$key]);
        }
        return $ruleArray;
    }

    /**
     * Format and add aPHP code block to current buffer.
     *
     * @param  string $value PHP source to format
     *
     * @return object the current instance
     */
    public function formatPHP($value)
    {
        $pos = 0;
        $key = '/(?<string>(\'[^\'\\\\]*(?:\\\\.[^\'\\\\]*)*\'|"[^"\\\\]*(?:\\\\.[^"\\\\]*)*"))|(?<curlo>\r?\n?[\t ]*\{[\t ]*\r?\n?[\t ]*)|(?<curlc>\r?\n?[\t ]*\}[\t ]*\r?\n?[\t ]*)|(?<nl>\r?\n[\t ]*)|(?<semi>;\r?\n?[\t ]*)|(?<other>.*?(?=((\s*(\{|\}))|([\'";{}]))))/Sxs';
        $first = true;
        while (preg_match($key, $value, $matches, PREG_OFFSET_CAPTURE, $pos)) {
            $pos += strlen($matches[0][0]);
            if (isset($matches['curlo']) && strlen($matches['curlo'][0])) {
                $this->code("{\n", 1);
                $first = true;
            } elseif (isset($matches['curlc']) && strlen($matches['curlc'][0])) {
                $this->code("}\n", - 1);
                $first = true;
            } elseif (isset($matches['nl']) && strlen($matches['nl'][0])) {
                $this->newline();
                $first = true;
            } elseif (isset($matches['semi']) && strlen($matches['semi'][0])) {
                $this->raw(";\n");
                $first = true;
            } else {
                if ($first) {
                    $this->code($matches[0][0]);
                    $first = false;
                } else {
                    $this->raw($matches[0][0]);
                }
            }
        }
        return $this;
    }
}

