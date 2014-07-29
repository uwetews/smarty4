<?php

namespace Smarty;

use Smarty\Exception\Magic;
use Smarty\Template\Context;
use Smarty\Parser\Exception\NoRule;
use Smarty\Parser\RuleArrayParser;


/**
 * Class Peg
 *
 * @package Smarty\Parser
 */
class Parser// extends Magic
{

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
     * RuleArrayParser object for parsing rules in array format
     *
     * @var RuleArrayParser
     */
    public $ruleArrayParser = null;

    /**
     * Cache of regular expressions for '/ ... /' match rules
     *
     * @var array
     */
    public $rxCache = array();

    /**
     * Cache of parsed rules with have <attribute>hash</attribute> set
     *
     * @var array
     */
    public $packCache = array();
    public $errorCache = array();

    /**
     * Cache of peg parser rule info by rule group  ALL|TARGET|SOURCE|SHARED
     *   The peg parser rule info is an array of filepath and parser class prefix
     *
     *@var array
     */
    public $ruleGroupsCache = array();

    /**
     * Cache of match result of /.../ rules by position and rule nam
     *
     * @var array
     */
    public $regexpCache  = array();

    /*
    * Rule definition array of loaded rules defined in array format
    *
    * @var array
    */
    /**
     * @var array
     */
    public $rules = array();

    /*
    * PegParser object of loaded rules
    *
    * @var array PegParser
    */
    /**
     * @var array
     */
    public $rulePegParserArray = array();

    /*
    * Match method names of loaded rules
    *
    * @var array
    */
    /**
     * @var array
     */
    public $matchMethods = array();

    /**
     * Flag to force recompilation of rule PegParser classes
     *
     * @var bool
     */
    public $force_compile = false;

    /**
     * Flag to check if rule definition as been updated and rule PegParser class must be recompiled
     *
     * @var bool
     */
    public $compile_check = false;

    /**
     * Rule definition file postfix
     *
     * @var string
     */
    public $ruleFilePostfix = '';

    /**
     * PegParser file postfix
     *
     * @var string
     */
    public $parserFilePostfix = '';

    /**
     * PegParser class name postfix
     *
     * @var string
     */
    public $parserClassPostfix = '';

    /**
     * Name of PegParser generator Class
     *
     * @var null
     */
    public $generatorClass = null;

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
     * Subtags of current tag while parsing
     *
     * @var array
     */
    public $currentSubtags = array();

    /**
     * Name of current Rx node for replace call backs
     *
     * @var string
     */
    private $nameRx = '';

    /**
     * Stack of subtags while processing nested tags
     *
     * @var array
     */
    public $subtagsStack = array();

    /**
     * Result array deafult content
     *
     * @var array
     */
    public $resultDefault = array('_silent' => false, '_tag' => false, '_text' => '', '_matchres' => array());

    /**
     * Regular expression for white spaces while parsing rule definition files
     *
     * @var string
     */
    public $whitespacePattern = '/[\s\t]*(([#][^\r\n]*)?([\r\n]+[\s\t]*))*/';

    /**
     * Backtrace information array
     *
     * @var array
     */
    public $backtrace = array();

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

    public $knownNodes = array();

    /**
     * Constructor
     *
     * @param Compiler $compiler compiler object
     * @param Context                    $context
     *
     */
    function __construct(Compiler $compiler, Context $context)
    {
        $this->baseDir = __DIR__ . '/';
        $this->compiler = $compiler;
        $this->context = $context;
        $config['pegGenerator'] = $this->context->smarty->simpleXMLToArray($this->compiler->compilerConfigXml->pegGenerator, 'param');
        if ($config['pegGenerator']['compile_check'] == 'on' || $config['pegGenerator']['force_compile'] == 'on') {
            $this->force_compile = ($config['pegGenerator']['force_compile'] == 'on');
            $this->compile_check = ($config['pegGenerator']['compile_check'] == 'on');
            $this->trace = ($config['pegGenerator']['trace'] == 'on');
            $this->generatorClass = $config['pegGenerator']['generatorClass'];
            $this->checkRule('', $this->getBaseDir() . '', $this->getBaseDir(), $config['pegGenerator']['ruleFilePostfix'], $config['pegGenerator']['parserFilePostfix']);
        }
        $config['parserPeg'] = $this->context->smarty->simpleXMLToArray($this->compiler->compilerConfigXml->parserPeg, 'param');
        $this->force_compile = ($config['parserPeg']['force_compile'] == 'on');
        $this->trace = ($config['parserPeg']['trace'] == 'on');
        $this->compile_check = ($config['parserPeg']['compile_check'] == 'on');
        $this->ruleFilePostfix = $config['parserPeg']['ruleFilePostfix'];
        $this->parserFilePostfix = $config['parserPeg']['parserFilePostfix'];
        $this->parserClassPostfix = $config['parserPeg']['parserClassPostfix'];
        $this->generatorClass = $config['parserPeg']['generatorClass'];
        if ($this->trace) {
            $this->traceFile = fopen('php://output', 'w');
        }

        $this->knownNodes = $this->compiler->sourceConfig['language'][$this->getSourceLanguage()]['Node'];

        $smarty = $this->context->smarty;
        $this->Ldel = preg_quote($smarty->leftDelimiter);
        if (!$smarty->autoLiteral) {
            $this->Ldel .= '\s*';
        }
        $this->Rdel = '\s*' . preg_quote($smarty->rightDelimiter);
        $this->loadRules('Core');
        $this->loadRules('Expression');
        $this->loadRules('Variable');
        $this->loadRules('TagAssign');
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
     * @return mixed
     */
    public function checkRule($name, $ruleFilePrefix, $parserFilePrefix = null, $ruleFilePostfix = null, $parserFilePostfix = null, $force = null)
    {
        $ruleFilePostfix = isset($ruleFilePostfix) ? $ruleFilePostfix : $this->ruleFilePostfix;
        $ruleFilePath = $ruleFilePrefix . $name . $ruleFilePostfix;
        if (!is_file($ruleFilePath)) {
            return false;
        }
        $parserFilePrefix = isset($parserFilePrefix) ? $parserFilePrefix : $ruleFilePrefix;
        $parserFilePostfix = isset($parserFilePostfix) ? $parserFilePostfix : $this->parserFilePostfix;
        $parserFilePath = $parserFilePrefix . $name . $parserFilePostfix;
        $parserMtime = 0;
        if (is_file($parserFilePath)) {
            $parserMtime = filemtime($parserFilePath);
        }
        $force = isset($force) ? $force : $this->force_compile;
        if ($force || $parserMtime < filemtime($ruleFilePath)) {
            if ($parserMtime) {
                unlink($parserFilePath);
            }
            $class = $this->generatorClass;
            if (class_exists($class)) {
                $compiler = new $class($this->compiler, $this->context);
                $this->context->smarty->_writeFile($parserFilePath, $compiler->compileFile($ruleFilePath));
                $compiler->parser = null;
                $compiler->cleanup();
                unset($compiler);
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
            $ruleInfoArray = $this->ruleGroupsCache[$groups];
        } else {
            $ruleInfoArray = array();
            if ($groups | Compiler::TARGET == Compiler::TARGET) {
                if ($groups | Compiler::SHARED == Compiler::SHARED) {
                    $ruleInfoArray[] = array(__DIR__ . "/Compiler/Target/Shared/Parser/",
                                         'Smarty\Compiler\Target\Shared\Parser\\');
                }
                $ruleInfoArray[] = array(__DIR__ . "/Compiler/Target/Language/{$this->getTargetLanguage()}/Parser/",
                                     'Smarty\Compiler\Target\Language\\' . $this->getTargetLanguage() . '\Parser\\');
            }
            if ($groups | Compiler::SOURCE == Compiler::SOURCE) {
                if ($groups | Compiler::SHARED == Compiler::SHARED) {
                    $ruleInfoArray[] = array(__DIR__ . "/Parser/Source/Shared/Parser/",
                                         'Smarty\Parser\Source\Shared\Parser\\');
                }
                $ruleInfoArray[] = array(__DIR__ . "/Parser/Source/Language/{$this->getSourceLanguage()}/Parser/",
                                     'Smarty\Parser\Source\Language\\' . $this->getSourceLanguage() . '\Parser\\');
            }
            $this->ruleGroupsCache[$groups] = $ruleInfoArray;
        }
        foreach ($ruleInfoArray as $ruleInfo) {
            // path exists?
            if (!is_dir($ruleInfo[0])) {
                continue;
            }
            $exists = true;
            if ($this->compile_check || $this->force_compile) {
                $exists = $this->checkRule($name, $ruleInfo[0]);
            }
            $nodeParserClass = $ruleInfo[1] . $name . $this->parserClassPostfix;
            if ($exists && class_exists($nodeParserClass)) {
                $o = new $nodeParserClass($this);
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
     * @param PegParser $nodeParser
     */
    public function addRules(PegParser $nodeParser)
    {
        if ($this->trace) {
            fprintf($this->traceFile, "%sLoad Parser Rules '%s' group '%d' path '%s' \n", $this->tracePrompt, get_class($nodeParser), '$nodeParser->group', '$nodeParser->nodePath');
        }
        if (isset($nodeParser->rules)) {
            foreach ($nodeParser->rules as $name => $rule) {
                $this->rules[$name] = $nodeParser;
                $this->rulePegParserArray[$name] = $nodeParser;
            }
        }
        if (isset($nodeParser->matchMethods)) {
            foreach ($nodeParser->matchMethods as $name => $rule) {
                $this->matchMethods[$name] = $nodeParser;
                $this->rulePegParserArray[$name] = $nodeParser;
            }
        }
    }

    /**
     * Add all rule matcher functions of rule object to cache
     *
     * @param PegParser $nodeParser
     */
    public function addDynamicRules($rules)
    {
        foreach ($rules as $name => $rule) {
            $this->rules[$name] = $rule;
            $this->rulePegParserArray[$name] = $this;
        }
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
     * @param null|string        $nodeName node name, if undefined default node is used
     * @param Node|null  $node
     *
     * @throws Parser\Exception\NoRule
     * @return array node tree array
     */
    public function parse($nodeName = null, Node $node = null)
    {
        if ($this->trace) {
            $this->traceFile = fopen('php://output', 'w');
        }
        $error = array();
        $previous = array();
        if (isset($node)) {
            $previous['node'] = $node;
        }
        $nodeName = isset($nodeName) ? $nodeName : (string) $this->context->smarty->smartyConfig->parser->defaultNode;
            $result = $this->matchRule($previous, $nodeName, $error);
            return $result;
    }

    /**
     * Get Peg Parser object for rule
     *
     * @param  string    $ruleName rule name
     * @param bool $quiet if true do not throw exception
     *
     * @return false|PegParser        Peg parser object or false if not found
     * @throws Parser\Exception\NoRule
     */
    public function getPegParser($ruleName, $quiet = false) {
        if (isset($this->rulePegParserArray[$ruleName])) {
            return $this->rulePegParserArray[$ruleName];
        } else {
            $this->loadRules($ruleName);
            if (isset($this->rulePegParserArray[$ruleName])) {
                return $this->rulePegParserArray[$ruleName];
            } else {
                if ($quiet) {
                    return false;
                }
                throw new NoRule($ruleName, 0, $this->context);
            }
        }
    }

    /**
     * Get match method name for rule
     * 
     * @param string $ruleName rule name
     * @param bool $quiet if true do not throw exception
     *
     *
     * @throws Parser\Exception\NoRule
     */
    public function getMatchMethod($ruleName, $quiet = false) {
        $peg = $this->getPegParser($ruleName);
        if (isset($peg->matchMethods[$ruleName])) {
            return $peg->matchMethods[$ruleName];
        } else {
            if ($quiet) {
                return false;
            }
            throw new NoRule($ruleName, 0, $this->context);
        }
    }

    /**
     * Get node attributes by rule name
     *
     * @param string $ruleName  rule name
     *
     * @return bool|array
     * @throws Parser\Exception\NoRule
     */
    public function getNodeAttributes($ruleName) {
        $peg = $this->getPegParser($ruleName);
        if (isset($peg->nodeAttributes[$ruleName])) {
            return $peg->nodeAttributes[$ruleName];
        } else {
            return false;
        }
    }

    /**
     * Call match method for rule
     *
     * @param array $result
     * @param $ruleName
     *
     * @return false|array   return false if match failed or result array
     * @throws Parser\Exception\NoRule
     */
    public function matchRule(&$result, $ruleName, &$error = null, $quiet = false){
        if (!isset($error)) {
            $error = array();
        }
        if ($peg = $this->getPegParser($ruleName, $quiet)) {
            if ($method = isset($peg->matchMethods[$ruleName]) ? $peg->matchMethods[$ruleName] : false) {
                return $peg->$method($result, $error);
            } elseif (isset($this->rules[$ruleName])) {
                $ruleArrayParser = $this->instanceRuleArrayParser();
                // match node rule
                return $ruleArrayParser->matchArrayRule($result, $ruleName, $error);
             }
        }
     }



    /**
     * @param $backTrace
     *
     */
    public function successNode($backTrace)
    {
        if ($this->trace) {
                $last = $this->backtrace();
            if (isset($last)) {
                fprintf($this->traceFile, " = %s('%s')]\n", $backTrace[0], $t = $this->truncateText($backTrace[1]));
                $this->backtrace[$last][1] .= $t;
            }
        }
    }

    /**
     * @param $backTrace
     */
    public function addBackTrace($backTrace)
    {
        if ($this->trace) {
            $this->backtrace[] = $backTrace;
        }
    }
    /**
     *
     */
    public function backtrace()
    {
        fprintf($this->traceFile, "%s [", $this->tracePrompt);
        if (!empty($this->backtrace)) {
            $last = count($this->backtrace) -1;
            $display = $last - 4;
            for ($i = 0; $i < $last; $i++)  {
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
     * @param $backTrace
     *
     */
    public function failNode($backTrace)
    {
        if ($this->trace) {
            $this->backtrace();
            fprintf($this->traceFile, " ] [%s]? Got '%s'\n", $backTrace[0], $this->unexpected());
        }
    }

    /**
     * @return string
     */
    public function unexpected()
    {
        if (preg_match('/\s*(.*?)(?=\s)/', $this->source, $match, 0, $this->pos)) {
            return $this->truncateText($match[0]);
        }
        return '';
    }


    /**
     * @param $literal
     */
    public function successLiteral($literal)
    {
        if ($this->trace) {
            $this->backtrace();
            fprintf($this->traceFile, " = '%s' ]\n", $literal);
        }
    }

    /**
     * @param $literal
     */
    public function failLiteral($literal)
    {
        if ($this->trace) {
            $this->backtrace();
            fprintf($this->traceFile, " ] '%s'? Got '%s'\n", $literal, $this->unexpected());
        }
    }

    public function matchError(&$error, $type, $value = null, $name = null) {
        $error['matcherror'][$this->pos]['expected'][] = array($type, $value, $name);
    }
    public function shouldNotMatchError(&$error, $type, $value = null, $name = null) {
        $error['shouldnotmatcherror'][$this->pos]['expected'][] = array($type, $value, $name);
    }

    public function logOption(&$error, $type, $value = null, $name = null) {
        $error['optionlog'][$this->pos] ['expected'][] = array($type, $value, $name);
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
     * Get instance of parser for rule arrays
     *
     * @return RuleArrayParser
     */
    public function instanceRuleArrayParser() {
        return isset($this->ruleArrayParser) ? $this->ruleArrayParser : $this->ruleArrayParser = new RuleArrayParser($this);
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
        // a subtag shall not be processed by dispatcher but while parsing the original tag
        if (isset($this->currentSubtags[$result['tagname']])) {
            return false;
        }
        // Reset position to LDel
        $this->pos = $result['_startpos'];
        $this->line = $result['_lineno'];

        $tag = $result['tagname'];
        if (isset($this->knownNodes['Tag'][ucfirst($tag)])) {
            // build match rule
            $ruleName = 'Tag' . ucfirst($tag);
            if (!$tagNode = $this->compiler->instanceNode('Tag\\' . $ruleName, $this->compiler->context, $this, $ruleName, true)) {
                $tagNode = $this->compiler->instanceNode('Tag', $this->compiler->context, $this, $ruleName);
            }
            $subtags = $tagNode->getNodeAttribute('subtags');
            if ($subtags !== false) {
                $this->subtagsStack[] = $this->currentSubtags;
                $this->currentSubtags = $subtags;
            }
        } else {
            if (preg_match("/{$this->Ldel}\/{$tag}{$this->Rdel}/", $this->source, $matches)) {
                //  block processing
                return false;
            } else {
                //  function
                $plugin_type = 'function';
                if ($function = $this->compiler->getPlugin($tag, $plugin_type)) {
                    $reflection = new \ReflectionFunction ($function);
                    $doc = $reflection->getDocComment();
                    if ($doc && preg_match('/\s*\/\*!\* /Sxs', $doc, $matches)) {
                        $class = $this->generatorClass;
                        if (class_exists($class)) {
                            $compiler = new $class($this->compiler, $this->context);
                            $rules = $compiler->compileDynamic($doc);
                            unset($compiler);
                            $this->addDynamicRules($rules);
                        }
                    }
                    if (!isset($this->context->smarty->securityPolicy) || $this->context->smarty->securityPolicy->isTrustedTag($tag, $this)) {
                        $ruleName = 'TagPluginFunction';
                        if (!$tagNode = $this->compiler->instanceNode('Tag\\' . $ruleName, $this->compiler->context, $this, $ruleName, true)) {
                            $tagNode = $this->compiler->instanceNode('Tag', $this->compiler->context, $this, $ruleName);
                        }
                        $tagNode->pluginName = $tag;
                        $tagNode->parserNode = 'Plugin' . ucfirst($tag);
                        $subtags = $tagNode->getNodeAttribute('subtags');
                        if ($subtags !== false) {
                            $this->subtagsStack[] = $this->currentSubtags;
                            $this->currentSubtags = $subtags;
                        }
                        $result = $tagNode->parse();
                    }
                } else {
                    return false;
                }
            }
        }
        $error = array();
        $previous = array('node' => $tagNode);
            $result = $this->matchRule($previous, $ruleName, $error);
            if (!empty($error)) {
                var_dump($error);
            }
            if ( $result) {
                $result['node']->setTraceInfo($result['_lineno'], $result['_text'], $result['_startpos'], $result['_endpos']);
                $valid = true;
            } else {
            $valid = false;
            }
         if ($subtags !== false) {
            $this->currentSubtags = array_pop($this->subtagsStack);
        }
        return $valid;
    }

    /**
     *
     * Insert expression in regular expression at initialization
     *
     * @param string $nameRx node name
     * @param string $regexp regular expression
     *
     * @return string regular expression
     */
    function initRxReplace($nameRx, $regexp) {
        $this->nameRx = $nameRx;
        return preg_replace_callback('/{(\w+)}/', array($this, 'initRxReplaceCb'), $regexp);
    }

    /**
     * Callback for initRxReplace()
     *
     * @param array $matches
     *
     * @return string replacement
     *
     * @throws Parser\Exception\NoRule
     */
    function initRxReplaceCb($matches)
    {
        $method = "{$this->nameRx}_INIT_{$matches[1]}";
        $peg = $this->getPegParser($this->nameRx);
        return $peg->$method($this);
    }

    /**
     *
     * Insert expression in regular expression dynamically
     *
     * @param string $nameRx node name
     * @param string $regexp regular expression
     *
     * @return string regular expression
     */
    function dynamicRxReplace($nameRx, $regexp) {
        $this->nameRx = $nameRx;
        return preg_replace_callback('/\$(\w+)/', array($this, 'dynamicRxReplaceCb'), $regexp);
    }

    /**
     * Callback for dynamicRxReplace()
     *
     * @param array $matches
     *
     * @return string replacement
     *
     * @throws Parser\Exception\NoRule
     */
    function dynamicRxReplaceCb($matches)
    {
        $method = "{$this->nameRx}_INIT_{$matches[1]}";
        $peg = $this->getPegParser($this->nameRx);
        return $peg->$method($this);
    }

    /**
     *
     */
    public function cleanup()
    {
        $this->source = '';
        $this->rules = array();
        $this->rxCache = array();
        $this->packCache = array();
        $this->rulePegParserArray = array();
        $this->matchMethods = array();
        $this->context = null;
        $this->compiler = null;
        $this->ruleArrayParser = null;
    }
}
