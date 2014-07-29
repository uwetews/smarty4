<?php

/**
 * Smarty Code generator
 *
 * @package Smarty\Compiler
 * @author  Uwe Tews
 */
namespace Smarty\Compiler;

use Smarty\Node;
use Smarty\Compiler\Code;

/**
 * Smarty Code generator
 * Methods to manage code output buffer
 *
 * @package Smarty\Compiler
 */
class Format extends Code
{

    /**
     * Number of indentation
     *
     * @var int
     */
    public $indentation = 0;

    /**
     * Saved intentation
     *
     * @var int
     */
    public $savedIndentation = 0;

    /**
     * Compiled code
     *
     * @var string
     */
    public $compiled = '';

    /**
     * Compiled code line number
     *
     * @var int
     */
    public $compiledLineNumber = 0;

    /**
     * Array with traceback info
     *
     * @var array
     */
    public $traceback = array();

    /**
     * maximum string line length
     *
     * @var int
     */
    public $string_line_length = 200;

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
        $this->raw($code->precompiled);
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
     * @return string
     */
    public function getFormatted(Code $code = null, $delete = true)
    {
        $code = isset($code) ? $code : $this;
        if (!empty($code->precompiled)) {
            $this->formatCode($code, $delete);
        }
        return $this->compiled;;
    }

    /**
     * @param null $node
     * @param bool $clear
     *
     * @return $this
     * @throws \Smarty_Exception
     */
    public function formatCode(Code $code = null, $delete = true)
    {
        if ($code == null) {
            $code = $this;
        } else {
            if (isset($this->precompiled) && !empty($this->precompiled)) {
                $this->formatCode();
            }
        }
        if (isset($code->precompiled) && !empty($code->precompiled)) {
            foreach ($code->precompiled as $key => $entry) {
                switch ($entry[0]) {
                    case 'raw':
                        $this->compiled .= $entry[1];
                        $this->compiledLineNumber += substr_count($entry[1], "\n");
                        break;
                    case 'addIndentation':
                        $this->compiled .= str_repeat(' ', $this->indentation * 4) . $entry[1];
                        $this->compiledLineNumber += substr_count($entry[1], "\n");
                        break;
                    case 'indent':
                        $this->indentation += $entry[1];
                        break;
                    case 'outdent':
                        // can't outdent by more steps that the current indentation level
                        if ($this->indentation < $entry[1]) {
                            throw new \Smarty_Exception('Unable to call outdent() as the indentation would become negative');
                        }
                        $this->indentation -= $entry[1];
                        break;
                    case 'line':
                        $line = $entry[1];
                        if ($this->lastLineNo != $line) {
                            $this->compiled .= sprintf("\n//line %04d:\n", $line);
                            $this->compiledLineNumber ++;
                            $this->compiledLineNumber ++;
                            $this->lastLineNo = $line;
                            $this->traceback[$this->compiledLineNumber] = $line;
                        }
                        break;
                    case 'newline':
                        $this->compiledLineNumber ++;
                        $this->compiled .= "\n";
                        break;
                    case 'repr':
                        $this->formatRepr($entry[1], $entry[2], $entry[3]);
                        break;
                    case 'string':
                        $this->formatString($entry[1], $entry[2], $entry[3]);
                        break;
                    default:
                        throw new \Smarty_Exception('Illegal buffer code ' . $entry[0]);
                }
            }
            if ($delete) {
                $code->precompiled = array();
                $this->ind_last_raw = - 1;
            }
        }
        return $this;
    }

    /**
     * @param      $value
     * @param      $double_quote
     * @param null $string_length
     */
    public function formatRepr($value, $double_quote, $string_length = null)
    {
        if (is_int($value) || is_float($value)) {
            if (false !== $locale = setlocale(LC_NUMERIC, 0)) {
                setlocale(LC_NUMERIC, 'C');
            }

            $this->compiled .= $value;

            if (false !== $locale) {
                setlocale(LC_NUMERIC, $locale);
            }
        } elseif (null === $value) {
            $this->compiled .= 'null';
        } elseif (is_bool($value)) {
            $this->compiled .= $value ? 'true' : 'false';
        } elseif (is_array($value)) {
            if (empty($value)) {
                $this->compiled .= 'array()';
            } else {
                $this->compiledLineNumber ++;
                $this->indentation += 2;
                $this->compiled .= "array(\n" . str_repeat(' ', $this->indentation * 4);
                $i = 0;
                foreach ($value as $key => $val) {
                    if ($i ++) {
                        $this->compiledLineNumber ++;
                        $this->compiled .= ",\n" . str_repeat(' ', $this->indentation * 4);
                    }
                    $this->formatRepr($key, $double_quote, $string_length);
                    $this->compiled .= ' => ';
                    $this->formatRepr($val, $double_quote, $string_length);
                }
                $this->indentation --;
                $this->compiledLineNumber ++;
                $this->compiled .= "\n" . str_repeat(' ', $this->indentation * 4) . ')';
                $this->indentation --;
            }
        } elseif (is_object($value) && $value instanceof \Smarty_Compiler_Format) {
            $this->compiled .= $value->getFormated();
        } else {
            $this->formatString($value, $double_quote, $string_length);
        }
    }

    /**
     * @param      $value
     * @param      $double_quote
     * @param null $maxlength
     */
    public function formatString($value, $double_quote, $maxlength = null)
    {
        if ($maxlength === null) {
            $maxlength = $this->string_line_length;
        }
        $length = strlen($value);
        if ($length <= $maxlength) {
            if ($double_quote) {
                $this->compiled .= sprintf('"%s"', addcslashes($value, "\0\n\r\t\"\$\\"));
            } else {
                $this->compiled .= "'" . addcslashes($value, "'") . "'";
            }
        } else {
            $i = 0;
            while (true) {
                if ($double_quote) {
                    $this->compiled .= sprintf('"%s"', addcslashes(substr($value, $i, $maxlength), "\0\n\r\t\"\$\\"));
                } else {
                    $this->compiled .= "'" . substr($value, $i, $maxlength) . "'";
                }
                if ($i == 0) {
                    $this->indentation ++;
                }
                $i += $maxlength;
                if ($i >= $length) {
                    $this->indentation --;
                    break;
                }
                $this->compiledLineNumber ++;
                $this->compiled .= "\n" . str_repeat(' ', $this->indentation * 4) . '. ';
            }
        }
    }

    /**
     * @param $node
     */
    public function mergeFormated($code)
    {
        if (!empty($this->precompiled)) {
            $this->formatCode();
        }
        $this->compiled .= $code->getFormated();
        $this->compiledLineNumber += $code->compiledLineNumber;
    }

    /**
     * @param $node
     */
    public function mergeCompiled($code)
    {
        $this->precompiled = array_merge($this->precompiled, $code->precompiled);
        $this->ind_last_raw = - 1;
    }
}
