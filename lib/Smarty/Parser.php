<?php

namespace Smarty;

use Smarty\Context;
use Smarty\Parser\TraceBack;

/**
 * Class Parser
 *
 * @package Smarty
 */
class Parser //extends Magic
{

    /**
     * Compiler object
     *
     * @var Compiler
     */
    public $compiler = null;

    /**
     * Context object
     *
     * @var Context
     */
    public $context = null;


    /**
     * Template source
     *
     * @var string
     */
    public $source = '';

    /**
     * Current position in source
     *
     * @var int
     */
    public $pos = 0;

    /**
     * Current line in source
     *
     * @var int
     */
    public $line = 1;

    /**
     * Source language name of template source
     *
     * @var string
     */
    public $sourceLanguage = null;

    /**
     * Source language directory of template source
     *
     * @var string
     */
    public $sourceLanguageDir = null;

    /**
     * Target language name of compiled template
     *
     * @var string
     */
    public $targetLanguage = null;

    /**
     * Target language directory of compiled template
     *
     * @var string
     */
    public $targetLanguageDir = null;

    /**
     * Flag if trace of parsing process shall be output
     *
     * @var bool
     */
    public $trace = false;

    /**
     * Object for trace back output
     *
     * @var TraceBack
     */
    public $traceObj = null;

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
     * Current Smarty left delimiter
     *
     * @var string
     */
    public $Ldel = '';

    /**
     * Current Smarty right delimiter
     *
     * @var string
     */
    public $Rdel = '';

    /**
     * Case directory
     *
     * @var string
     */
    public $baseDir = '';


    /**
     * Constructor
     *
     * @param Compiler $compiler compiler object
     * @param Context  $context
     */
    function __construct(Compiler $compiler, Context $context)
    {
        $this->baseDir = __DIR__ . '/';
        $this->compiler = $compiler;
        $this->context = $context;

        $smarty = $this->context->smarty;
        $this->Ldel = preg_quote($smarty->leftDelimiter);
        if (!$smarty->autoLiteral) {
            $this->Ldel .= '\s*';
        }
        $this->Rdel = '\s*' . preg_quote($smarty->rightDelimiter);
        return $this;
    }


    /**
     * Get target language
     *
     * @return string
     */
    public function getTargetLanguage()
    {
        return isset($this->targetLanguage) ? $this->targetLanguage : $this->context->getTargetLanguage();
    }

    /**
     * Get source language
     *
     * @return string
     */
    public function getSourceLanguage()
    {
        return isset($this->sourceLanguage) ? $this->sourceLanguage : $this->context->getSourceLanguage();
    }


    /**
     * Set source
     *
     * @param string $source
     *
     * @return $this
     */
    public function setSource($source)
    {
        $this->source = str_replace("\r", '', $source);
        return $this;
    }

    /**
     * Call parser for node
     *
     * @param null|string $nodeName node name, if undefined default node is used
     * @param Node|null   $node
     *
     * @throws Parser\Exception\NoRule
     * @return array node tree array
     */
    public function parse($nodeName = null, Node $node = null)
    {
         return false;
    }

    /**
     * Get source language directory
     *
     * @return string
     */
    public function getSourceLanguageDir()
    {
        return isset($this->sourceLanguageDir) ? $this->sourceLanguageDir : $this->context->getSourceLanguageDir();
    }

    /**
     * Get target language directory
     *
     * @return string
     */
    public function getTargetLanguageDir()
    {
        return isset($this->targetLanguageDir) ? $this->targetLanguageDir : $this->context->getTargetLanguageDir();
    }

    public function getTraceObj() {
        return isset($this->traceObj) ? $this->traceObj : $this->traceObj = new TraceBack($this);
    }

 }
