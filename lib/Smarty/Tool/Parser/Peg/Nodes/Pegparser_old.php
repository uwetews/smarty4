<?php

Namespace Smarty\Tool\Parser\Peg\Nodes;

/**
 * Class Pegparser
 *
 * @package Smarty\Tool\Parser\Peg\Nodes
 */
class Pegparser
{
    public $_name = 'Parser';
    public $_type = 'parser';
    public $nodes = array();
    public $actions = array();
    public $comments = array();
    public $output = '';
    public $indentation = 1;
    public $saved_indentation = 0;
    public $indent_on = true;
    public $no_indent = false;

    /**
     * @return string
     * @throws SmartyException
     */
    public function compile()
    {
        foreach ($this->nodes as $name => $dummy) {
            if (isset($this->actions[$name])) {
                foreach ($this->actions[$name] as $type => $action) {
                    switch ($type) {
                        case '_finish' :
                            $this->nodes[$name]['_actions']['_finish']["{$name}___FINISH"] = true;
                            break;
                        case '_start':
                            $this->nodes[$name]['_actions']['_start']["{$name}___START"] = true;
                            break;
                        case '_expression':
                            $this->nodes[$name]['_actions']['_expression']["{$name}_EXP_{$action['argument']}"] = true;
                            break;
                        case '_init':
                            $this->nodes[$name]['_actions']['_init']["{$name}_INIT_{$action['argument']}"] = true;
                            break;
                        case '_all':
                            $this->nodes[$name]['_actions']['_all']["{$name}___ALL"] = true;
                            break;
                        default:
                            $this->nodes[$name]['_actions']['_match'][$type]["{$name}_{$type}"] = true;
                            break;
                    }
                }
            }
        }
        $this->newline()
            ->php('public $rules = ')
            ->Repr($this->nodes)
            ->raw(';')
            ->newline();

        foreach ($this->comments as $name => $comment) {
            $this->php("/**")
                ->newline();
            $this->php(" *")
                ->newline();
            $this->php(" * Parser rules and action for node '{$name}'")
                ->newline();
            $this->php(" *")
                ->newline();
            $this->php(" *  Rule: -> {$comment} <-")
                ->newline();
            $this->php(" *")
                ->newline();
            $this->php("*/")
                ->newline();
            if (isset($this->actions[$name])) {
                foreach ($this->actions[$name] as $type => $action) {
                    $func = "public function {$name}";
                    switch ($type) {
                        case '_finish' :
                            $func .= "___FINISH (\$result) ";
                            break;
                        case '_start':
                            $func .= "___START (\$result) ";
                            break;
                        case '_expression':
                            $func .= "_EXP_{$action['argument']} (&\$result) ";
                            break;
                        case '_init':
                            $func .= "_INIT_{$action['argument']} (\$rule) ";
                            break;
                        case '_all':
                            $func .= "___ALL (\$result, \$subres) ";
                            break;
                        default:
                            $func .= "_{$type} (\$result, \$subres) ";
                            break;
                    }
                    $this->formatPHP(trim($func . $action['code']));
                    $this->newline();
                }
            }
            $this->newline();
        }

        return $this->output;
    }

    /**
     * Add newline to the current buffer.
     *
     * @return object the current instance
     */
    public function newline()
    {
        if (!$this->no_indent) {
            $this->output .= "\n";
        }

        return $this;
    }

    /**
     * Add a line of PHP code to output.
     *
     * @param  string $value PHP source
     *
     * @return object the current instance
     */
    public function php($value)
    {
        $this->addIndentation();
        $this->output .= $value;

        return $this;
    }

    /**
     * Add an indentation to the current buffer.
     *
     * @return object the current instance
     */
    public function addIndentation()
    {
        if ($this->indent_on && !$this->no_indent) {
            $this->output .= str_repeat(' ', $this->indentation * 4);
        }

        return $this;
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
        $save = $this->indent_on;
        $this->indent_on = true;
        preg_replace_callback('%(\'[^\'\\\\]*(?:\\\\.[^\'\\\\]*)*\'|"[^"\\\\]*(?:\\\\.[^"\\\\]*)*")|([\r\n\t ]*(\?>|<\?php)[\r\n\t ]*)|(;[\r\n\t ]*)|({[\r\n\t ]*)|([\r\n\t ]*}[\r\n\t ]*)|([\r\n\t ]*)|([\r\n\t ]*/\*(.*)?\*/[\r\n\t ]*)|(.*?(?=[\'";{}/\n]))%', array($this, '_processPHPoutput'), $value);
        $this->output .= "\n";
        $this->indent_on = $save;

        return $this;
    }

    /**
     * Enable indentation
     *
     * @return object the current instance
     */
    public function indent_on()
    {
        $this->indent_on = true;

        return $this;
    }

    /**
     * Enable indentation
     *
     * @return object the current instance
     */
    public function indent_off()
    {
        $this->indent_on = false;

        return $this;
    }

    /**
     * Adds the PHP representation of a given value to the current buffer
     *
     * @param  mixed $value        The value to convert
     * @param  bool  $double_qoute flag to use double quotes on strings
     *
     * @return object the current instance
     */
    public function repr($value, $double_qoute = true)
    {
        if (is_int($value) || is_float($value)) {
            if (false !== $locale = setlocale(LC_NUMERIC, 0)) {
                setlocale(LC_NUMERIC, 'C');
            }

            $this->raw($value);

            if (false !== $locale) {
                setlocale(LC_NUMERIC, $locale);
            }
        } elseif (null === $value) {
            $this->raw('null');
        } elseif (is_bool($value)) {
            $this->raw($value ? 'true' : 'false');
        } elseif (is_array($value)) {
            $this->raw("array(\n")
                ->indent(2)
                ->addIndentation();
            $i = 0;
            foreach ($value as $key => $val) {
                if ($i ++) {
                    $this->raw(",\n")
                        ->addIndentation();
                }
                $this->repr($key, $double_qoute);
                $this->raw(' => ');
                $this->repr($val, $double_qoute);
            }
            $this->outdent()
                ->raw("\n")
                ->addIndentation()
                ->raw(')')
                ->outdent();
        } else {
            $this->string($value, $double_qoute);
        }

        return $this;
    }

    /**
     * Adds a raw string to the compiled code.
     *
     * @param  string $string The string
     *
     * @return object the current instance
     */
    public function raw($string)
    {
        $this->output .= $string;

        return $this;
    }

    /**
     * Outdents the generated code.
     *
     * @param integer $step The number of indentation to remove
     *
     * @throws SmartyException
     * @return object          the current instance
     */
    public function outdent($step = 1)
    {
        // can't outdent by more steps that the current indentation level
        if ($this->indentation < $step) {
            throw new SmartyException('Unable to call outdent() as the indentation would become negative');
        }
        $this->indentation -= $step;

        return $this;
    }

    /**
     * Adds a quoted string to the compiled code.
     *
     * @param string $value        The string
     * @param bool   $double_quote flag if double quotes shall be used
     *
     * @return object the current instance
     */
    public function string($value, $double_quote = true)
    {
        $length = strlen($value);
        if ($length <= 1000) {
            if ($double_quote) {
                $this->output .= sprintf('"%s"', addcslashes($value, "\0\n\r\t\"\$\\"));
            } else {
                $this->output .= "'" . $value . "'";
            }
        } else {
            $i = 0;
            while (true) {
                if ($double_quote) {
                    $this->output .= sprintf('"%s"', addcslashes(substr($value, $i, 1000), "\0\n\r\t\"\$\\"));
                } else {
                    $this->output .= "'" . substr($value, $i, 1000) . "'";
                }
                if ($i == 0) {
                    $this->indent();
                }
                $i += 1000;
                if ($i >= $length) {
                    $this->outdent();
                    break;
                }
                $this->raw("\n")
                    ->addIndentation()
                    ->raw(', ');
            }
        }

        return $this;
    }

    /**
     * Indents the generated code.
     *
     * @param  integer $step The number of indentation to add
     *
     * @return object  the current instance
     */
    public function indent($step = 1)
    {
        $this->indentation += $step;

        return $this;
    }

    /**
     * preg_replace callback function to process PHP output
     *
     * @param  string $match match string
     *
     * @return string replacement
     */
    public function _processPHPoutput($match)
    {
        if (empty($match[0]) || !empty($match[2])) {
            return;
        }
        if ($this->indent_on) {
            $this->raw("\n");
        }
        if (!empty($match[7])) {
            return;
        }
        if (!empty($match[1])) {
            $this->raw($match[1]);

            return;
        }
        if (!empty($match[4])) {
            $this->raw(";");
            $this->indent_on = true;

            return;
        }
        if (!empty($match[5])) {
            $this->raw("{")
                ->indent();
            $this->indent_on = true;

            return;
        }
        if (!empty($match[6])) {
            if (!$this->indent_on) {
                $this->raw("\n");
                $this->indent_on = true;
            }
            $this->outdent()
                ->addIndentation()
                ->raw('}');

            return;
        }
        if (!empty($match[9])) {
            $this->addIndentation()
                ->raw("/*{$match[9]}*/");

            return;
        }
        if (!empty($match[10])) {
            if ($this->indent_on) {
                $this->addIndentation();
            }
            $this->raw($match[10]);
            $this->indent_on = false;

            return;
        }

        return;
    }
}

