<?php
namespace Smarty\Parser;

use Smarty\Parser;

/**
 * Class TraceBack
 *
 * @package Smarty\Parser
 */
class TraceBack
{

    /**
     * Parser object
     *
     * @var null|Parser
     */
    public $parser = null;

    /**
     * Backtrace information array
     *
     * @var array
     */
    public $backtrace = array();

    /**
     * Trace prompt string
     *
     * @var string
     */
    public $tracePrompt = "\n<br>";

    /**
     * Resource of trace output
     *
     * @var null|resource
     */
    public $traceFile = null;

    /**
     * Constructor
     *
     * @param Parser $parser
     */
    public function __construct(Parser $parser)
    {
        $this->parser = $parser;
        $this->traceFile = fopen('php://output', 'w');
    }

    /**
     * Print load rules message
     *
     * @param $nodeParser
     */
    public function loadRuleMessage($nodeParser)
    {
        fprintf($this->traceFile, "%sLoad Parser Rules '%s'  \n", $this->tracePrompt, get_class($nodeParser));
        if (false && isset($nodeParser->ruleMethods)) {
            foreach ($nodeParser->ruleMethods as $name => $method) {
                fprintf($this->traceFile, "%s    '%s'  \n", $this->tracePrompt, $name);
            }
        }
    }

    /**
     * Print success back track info
     *
     * @param $backTrace
     */
    public function successNode($backTrace = null)
    {
        $backTrace = isset($backTrace) ? $backTrace : $this->popBackTrace();
        $last = $this->printBackTrace();
        if (isset($last)) {
            fprintf($this->traceFile, " = %s('%s')]\n", $backTrace[0], $t = $this->truncateText($backTrace[1]));
            $this->backtrace[$last][1] .= $t;
        }
    }

    /**
     * Print success fail track info
     *
     * @param $backTrace
     */
    public function failNode($backTrace = null)
    {
        $backTrace = isset($backTrace) ? $backTrace : $this->popBackTrace();
        $this->printBackTrace();
        fprintf($this->traceFile, " ] [%s]? Got '%s'\n", $backTrace[0], $this->unexpected());
    }

    /**
     * Add back tack info on stack and print trace
     *
     * @param $backTrace
     */
    public function addBackTrace($backTrace)
    {
        $this->backtrace[] = $backTrace;
        $this->printBackTrace();
    }

    /**
     * Pop back trace info from stack and return it
     *
     * @return mixed
     */
    public function popBackTrace()
    {
        return array_pop($this->backtrace);
    }

    /**
     * Print back trace info stack
     */
    public function printBackTrace()
    {
        fprintf($this->traceFile, "%s [", $this->tracePrompt);
        if (!empty($this->backtrace)) {
            $last = count($this->backtrace) - 1;
            $display = $last - 4;
            for ($i = 0; $i < $last; $i ++) {
                fprintf($this->traceFile, " %s", $this->backtrace[$i][0]);
                if ($i > $display) {
                    fprintf($this->traceFile, "('%s')", $this->truncateText($this->backtrace[$i][1]));
                }
            }
            fprintf($this->traceFile, "][%s('%s')", $this->backtrace[$last][0], $this->truncateText($this->backtrace[$last][1]));
            return $last;
        }
        return null;
    }

    /**
     * @param string $input
     *
     * @return string
     */
    public function truncateText($input)
    {
        $text = preg_replace('/\s+/', ' ', $input);
        if (strlen($text) > 40) {
            $text = substr($text, 0, 15) . '...' . substr($text, - 7);
        }
        return $text;
    }

    /**
     * @return string
     */
    public function unexpected()
    {
        if (preg_match('/\s*(.*?)(?=\s)/', $this->parser->source, $match, 0, $this->parser->pos)) {
            return $this->truncateText($match[0]);
        }
        return '';
    }

    /**
     * @param $literal
     */
    public function successLiteral($literal)
    {
        $this->printBackTrace();
        fprintf($this->traceFile, " = '%s' ]\n", $literal);
    }

    /**
     * @param $literal
     */
    public function failLiteral($literal)
    {
        $this->printBackTrace();
        fprintf($this->traceFile, " ] '%s'? Got '%s'\n", $literal, $this->unexpected());
    }
}