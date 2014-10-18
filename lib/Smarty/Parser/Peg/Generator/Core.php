<?php
/**
 * Created by PhpStorm.
 * User: Uwe Tews
 * Date: 04.09.2014
 * Time: 22:44
 */

namespace Smarty\Parser\Peg\Generator;

use Smarty\Parser\Peg\PegParser;
use Smarty\Compiler;
use Smarty\Context;

class Core extends PegParser{

    public $namespaces = array();

    /**
     * Constructor
     *
     * @param \Smarty_Compiler|\Smarty_Compiler_CompilerCore $compiler compiler object
     * @param \Smarty_Template_Context                       $context
     */
    function __construct(Compiler $compiler, Context $context)
    {
        $this->namespaces = array( __NAMESPACE__ . '\\Tool\\');
        $this->parser = $this;
        $this->context = $context;
        if (isset($this->ruleMethods)) {
            foreach ($this->ruleMethods as $name => $method) {
                $this->ruleCallbackArray[$name] = array($this, $method);
            }
        }
        $this->trace = true;
    }

    /**
     * @param string $ruleName
     *
     * @throws \Smarty\Parser\Exception\NoRule
     * @return mixed
     */
    public function getRuleAsArray($ruleName)
    {
        if (isset($this->ruleArray[$ruleName])) {
            $rule = $this->ruleArray[$ruleName];
            $rule['_ruleParser'] = $this;
        } else {
            throw new NoRule($ruleName, 0, $this->context);
        }
        return $rule;
    }

    /**
     * @param $infile
     *
     * @return mixed
     */
    public function compileFile($infile)
    {
        $this->filename = $infile;
        $this->filetime = filemtime($infile);
        $string = file_get_contents($infile);
        return $this->compile($string);
    }

    /**
     * @param $string
     *
     * @return mixed
     */
    public function compile($string)
    {
        $this->setSource($string);
        $nodeRes = $this->parser->parse('Root');
        $root = $nodeRes['_node'];
        $root->setFilename($this->filename);
        $root->setFiletime($this->filetime);
        //$root->compileParserRuleArray();
        $root->compileParser();
        $output = $root->getFormatted();
        return $output;
    }

    /**
     * @param $string
     * @param $outfile
     */
    public function compileStringToFile($string, $outfile)
    {
        $string = $this->compile($string);
        file_put_contents($outfile, $string);
    }

    /**
     * @param $string
     *
     * @return string
     */
    public function compileDynamic($string)
    {
        $this->setSource($string);
        if (preg_match("/([\\S\\s]+(?=([^\\S\\r\\n]\\/\\*!\\*)))|[\\S\\s]+/", $this->parser->source, $match)) {
            $this->parser->pos += strlen($match[1]);
            $this->parser->line += substr_count($match[1], "\n");
            $nodeRes = $this->parser->parse('Parser');
            return $nodeRes['_node']->nodes;
        }
        return '';
    }

} 