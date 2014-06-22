<?php

namespace Smarty\Compiler;

use Smarty\Compiler\Nodes\Token;
use Smarty\Parser\Peg\Compiler\ParserCompiler;
use Smarty\Compiler\Parser\Rules\Result;
use Smarty\Template\Context;
use Smarty\Compiler\Exception\NoRule;

/**
 * Class Peg
 *
 * @package Smarty\Parser
 */
class Parser extends \Smarty_Exception_Magic
{
    /*
     * Regexp cache
     *
     * @var array
     */
    public $regexpCache = array();
    /**
     * @var array
     */
    public $packCache = array();
    /**
     * @var array
     */
    public $ruleGroupsCache = array();
    /*
    * Rule definition array
    *
    * @var array
    */
    public $rules = array();
    /*
     * Node array
     *
     * @var array
     */
    public $nodes = array();

    /**
     * Compiler object
     *
     * @var Compiler
     */
    public $compiler = null;
    /**
     * Compiler object
     *
     * @var Context
     */
    public $context = null;
    /**
     * @var null
     */
    public $result = null;

    public $force_compile = false;

    public $compile_check = false;
    public $ruleFilePostfix = '';
    public $parserFilePostfix = '';
    public $parserClassPostfix = '';
    public $generatorClass = null;
    /**
     * Source
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
     * parser configuration

     */
    public $parserConfiguration = null;

    public $sourceLanguage = null;

    public $sourceLanguageDir = null;

    public $targetLanguage = null;

    public $targetLanguageDir = null;
    /**
     * Source file path prefix
     */
    public $soureFilePath = null;

    /**
     * Source class prefix
     */
    public $soureClassPrefix = null;
    /**
     * Compiled file path prefix
     */
    public $compiledFilePath = null;

    /**
     * Compiled class prefix
     */
    public $compiledClassPrefix = null;
    /**
     * @var bool
     */
    public $trace = false;
    /**
     * @var string
     */
    public $tracePrompt = "\n<br>";
    /**
     * @var null|resource
     */
    public $traceFile = null;
    /**
     * peg configuration

     */
    public $pegConfiguration = null;

    /**
     * @var \Smarty\Parser\Peg\Node array
     */
    public $pegNodeParserCache = array();

    public $whitespacePattern = '/[\s\t]*(([#][^\r\n]*)?([\r\n]+[\s\t]*))*/';
    public $backtrace = array();
    public $Ldel = '';
    public $Rdel = '';
    public $baseDir = '';

    /**
     * Constructor
     *
     * @param \Smarty\Compiler\Compiler $compiler compiler object
     * @param Context                   $context
     *
     * @throws Exception\NoGeneratorClass
     */
    function __construct(Compiler $compiler, Context $context)
    {
        $this->baseDir = __DIR__ . '/../';
        $this->compiler = $compiler;
        $this->context = $context;
        $config = $this->sxiToArray(new \SimpleXmlIterator(__DIR__ . '/ParserPegConfig.xml', null, true));
        if ($config['pegGenerator']['compile_check'] == 'on' || $config['pegGenerator']['force_compile'] == 'on') {
            $this->force_compile = ($config['pegGenerator']['force_compile'] == 'on');
            $this->compile_check = ($config['pegGenerator']['compile_check'] == 'on');
            $this->generatorClass = $config['pegGenerator']['generatorClass'];
            $this->checkRule('', $this->getBaseDir() . '', $this->getBaseDir(), $config['pegGenerator']['ruleFilePostfix'], $config['pegGenerator']['parserFilePostfix']);
        }
        $this->force_compile = ($config['parserPeg']['force_compile'] == 'on');
        $this->compile_check = ($config['parserPeg']['compile_check'] == 'on');
        $this->ruleFilePostfix = $config['parserPeg']['ruleFilePostfix'];
        $this->parserFilePostfix = $config['parserPeg']['parserFilePostfix'];
        $this->parserClassPostfix = $config['parserPeg']['parserClassPostfix'];
        $this->generatorClass = $config['parserPeg']['generatorClass'];

        $smarty = $this->context->smarty;
        $this->Ldel = preg_quote($smarty->leftDelimiter);
        if (!$smarty->autoLiteral) {
            $this->Ldel .= '\s*';
        }
        $this->Rdel = '\s*' . preg_quote($smarty->rightDelimiter);
        $this->loadRules('Core');
        return $this;
    }

    /**
     * @param $sxi
     *
     * @return array
     */
    function sxiToArray($sxi)
    {
        $a = array();
        for ($sxi->rewind(); $sxi->valid(); $sxi->next()) {
            if ($sxi->hasChildren()) {
                if (!isset($a[$sxi->key()])) {
                    $a[$sxi->key()] = $this->sxiToArray($sxi->current());
                } else {
                    if (!is_array($a[$sxi->key()])) {
                        $a[$sxi->key()] = array($a[$sxi->key()]);
                    }
                    $a[$sxi->key()][] = $this->sxiToArray($sxi->current());
                }
            } else {
                if (!isset($a[$sxi->key()])) {
                    $a[$sxi->key()] = strval($sxi->current());
                } else {
                    if (!is_array($a[$sxi->key()])) {
                        $a[$sxi->key()] = array($a[$sxi->key()]);
                    }
                    $a[$sxi->key()][] = strval($sxi->current());
                }
            }
        }
        return $a;
    }

    /**
     * Check if given Peg Parser for given name and node path is valid or must be recompiled
     *
     * @param  string     $name
     * @param  string     $ruleFilePrefix
     * @param null|string $parserFilePrefix
     * @param null|string $ruleFilePostfix
     * @param null|string $parserFilePostfix
     * @param bool        $force force compilation of rule parser
     *
     * @throws Exception\NoGeneratorClass
     * @return mixed
     */
    public function checkRule($name, $ruleFilePrefix, $parserFilePrefix = null, $ruleFilePostfix = null, $parserFilePostfix = null, $force = null)
    {
        $force = isset($force) ? $force : $this->force_compile;
        $parserFilePrefix = isset($parserFilePrefix) ? $parserFilePrefix : $ruleFilePrefix;
        $ruleFilePostfix = isset($ruleFilePostfix) ? $ruleFilePostfix : $this->ruleFilePostfix;
        $parserFilePostfix = isset($parserFilePostfix) ? $parserFilePostfix : $this->parserFilePostfix;
        $ruleFilePath = $ruleFilePrefix . $name . $ruleFilePostfix;
        $parserFilePath = $parserFilePrefix . $name . $parserFilePostfix;
        if (!is_file($ruleFilePath)) {
            return false;
        }
        $ruleMtime = filemtime($ruleFilePath);
        $parserMtime = 0;
        if (is_file($parserFilePath)) {
            $parserMtime = filemtime($parserFilePath);
        }
        if ($force || $parserMtime < $ruleMtime) {
            if ($parserMtime) {
                unlink($parserFilePath);
            }
            $class = $this->generatorClass;
            if (class_exists($class)) {
                $compiler = new $class($this->compiler, $this->context);
                $this->context->smarty->_writeFile($parserFilePath, $compiler->compileFile($ruleFilePath));
                return true;
            } else {
                throw new Exception\NoGeneratorClass($class);
            }
        }
        return true;
    }

    /**
     * Get base directory
     *
     * @return string
     */
    public function getBaseDir()
    {
        return $this->baseDir;
    }

    /**
     * Add all rule matcher functions of rule object to cache
     *
     * @param string    $name       name of rule file
     * @param int|array $ruleGroups rule groups which should be checked
     */
    public function loadRules($name, $ruleGroups = Compiler::ALL)
    {
        $groups = ($ruleGroups === Compiler::ALL) ? (Compiler::USER + Compiler::SOURCE + Compiler::TARGET + Compiler::SHARED) : $ruleGroups;
        if (isset($this->ruleGroupsCache[$groups])) {
            $ruleArray = $this->ruleGroupsCache[$groups];
        } else {
            $ruleArray = array();
            if ($groups | Compiler::TARGET == Compiler::TARGET) {
                if ($groups | Compiler::SHARED == Compiler::SHARED) {
                    $ruleArray[] = array(__DIR__ . "/Target/Shared/Parser/",
                                         'Smarty\Compiler\Target\Shared\Parser\\');
                }
                $ruleArray[] = array(__DIR__ . "/Target/Language/{$this->getTargetLanguage()}/Parser/",
                                     'Smarty\Compiler\Target\Language\\' . $this->getTargetLanguage() . '\Parser\\');
            }
            if ($groups | Compiler::SOURCE == Compiler::SOURCE) {
                if ($groups | Compiler::SHARED == Compiler::SHARED) {
                    $ruleArray[] = array(__DIR__ . "/Source/Shared/Parser/",
                                         'Smarty\Compiler\Source\Shared\Parser\\');
                }
                $ruleArray[] = array(__DIR__ . "/Source/Language/{$this->getSourceLanguage()}/Parser/",
                                     'Smarty\Compiler\Source\Language\\' . $this->getSourceLanguage() . '\Parser\\');
            }
            $this->ruleGroupsCache[$groups] = $ruleArray;
        }
        foreach ($ruleArray as $rule) {
            // path exists?
            if (!is_dir($rule[0])) {
                continue;
            }
            $exists = true;
            if ($this->compile_check || $this->force_compile) {
                $exists = $this->checkRule($name, $rule[0]);
            }
            $nodeParserClass = $rule[1] . $name . $this->parserClassPostfix;
            if ($exists && class_exists($nodeParserClass)) {
                $o = new $nodeParserClass();
                $this->addRules($o);
            }
        }
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
     * Add all rule matcher functions of rule object to cache
     *
     * @param Node $nodeParser
     */
    public function addRules($nodeParser)
    {
        if ($this->trace) {
            fprintf($this->traceFile, "%sLoad Parser Rules '%s' group '%d' path '%s' \n", $this->tracePrompt, get_class($nodeParser), '$nodeParser->group', '$nodeParser->nodePath');
        }
        foreach ($nodeParser->rules as $name => $rule) {
            if (is_object($rule)) {
                $this->rules[$name] = $rule;
            } else {
                $this->rules[$name] = $this->instanceRule($rule, $nodeParser, $this);
            }
            /**
             * if ($rule['_attr']['_nodetype'] == 'node') {
             * $node = $this->compiler->instanceNode($name, $this->context, $this);
             * } elseif ($rule['_attr']['_nodetype'] == 'token') {
             * $node = new Token($this, $name);
             * } else {
             * continue;
             * }
             * $node->rule = $this->rules[$name];
             * $this->nodes[$name] = $node;
             */
        }
    }

    /**
     * @param        $rule
     * @param        $ruleParser
     * @param Parser $parser
     *
     * @throws \Smarty_Parser_Peg_Exception_NoRuleClass
     * @return mixed
     */
    public function instanceRule($rule, $ruleParser, Parser $parser = null)
    {
        $rclass = 'Smarty\Compiler\Parser\Rules\\' . ucfirst($rule['_type']);
        if (!class_exists($rclass)) {
            throw new NoRuleClass($rule['_type'], 0, $rclass, $this->context);
        }
        return new $rclass($rule, $ruleParser, $parser);
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
     * @param string $node
     *
     * @return array node tree array
     */
    public function parse($nodeName = null, $node = null)
    {
        $this->trace = true;
        if ($this->trace) {
            $this->traceFile = fopen('php://output', 'w');
        }
        $nodeName = isset($nodeName) ? $nodeName : (string) $this->context->smarty->configuration->parser->defaultNode;
        $robj = $this->getRuleNode($nodeName);
        $result = new Result($robj);
        $result->_start();
        if (isset($node)) {
            $result->node = $node;
        }
        $robj->matchRule($result, $robj);
        return $result;
    }

    /**
     * @param $ruleName
     *
     * @return mixed
     * @throws \Smarty_Parser_Peg_Exception_NoRule
     */
    public function getRuleNode($ruleName)
    {
        if (isset($this->rules[$ruleName])) {
            $rule = $this->rules[$ruleName];
        } else {
            $this->loadRules($ruleName);
            if (isset($this->rules[$ruleName])) {
                $rule = $this->rules[$ruleName];
            } else {
                throw new NoRule($ruleName, 0, $this->context);
            }
        }
        return $rule;
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

    /**
     * Lookup and call tag node parser
     *
     * @param array $result
     *
     * @return bool
     */
    public function tagDispatcher(&$result)
    {
        // Reset position to LDel
        $this->pos = $result->_startpos;
        $this->line = $result->_lineno;
        // build match rule
        $ruleName = 'Tag' . ucfirst($result->tagname->_text);
        $ruleNode = $this->getRuleNode($ruleName);

        $subres = new Result($ruleNode);
        $subres->_start();
        $valid = ($ruleNode->_extended) ? $ruleNode->matchRule($subres) : $ruleNode->match($subres);
        if ($valid) {
            if (isset($subres->_actions['_finish'])) {
                foreach ($subres->_actions['_finish'] as $method => $foo) {
                    $callback = array($subres->_ruleParser, $method);
                    call_user_func_array($callback, array($subres));
                }
            }
            $subres->node->setTraceInfo($subres->_lineno, $subres->_text, $subres->_startpos, $subres->_endpos);
            $actions = $result->_actions;
            $result = $subres;
            $result->_actions = $actions;
        }
        return $valid;
    }

    public function cleanup()
    {
        $this->rules = array();
        $this->regexpCache = array();
        $this->packCache = array();
    }
}
