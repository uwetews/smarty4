<?php

namespace Smarty;

use Smarty\Exception\Magic;
use Smarty\Parser\Rules\RxMatch;
use Smarty\Template\Context;
use Smarty\Parser\Exception\NoRule;


/**
 * Class Peg
 *
 * @package Smarty\Parser
 */
class Parser extends Magic
{
    /*
     * Regexp cache
     *
     * @var array
     */
    /**
     * @var array
     */
    public $rxCache = array();
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
     * Subtags of current tag while parsing
     *
     * @var array
     */
    public $currentSubtags = array();

    /**
     * Stack of subtags while processing nested tags
     *
     * @var array
     */
    public $subtagsStack = array();

    public $resultDefault = array('_silent' => false, '_tag' => false, '_text' => '', '_matchres' => array());

    public $whitespacePattern = '/[\s\t]*(([#][^\r\n]*)?([\r\n]+[\s\t]*))*/';
    public $backtrace = array();
    public $Ldel = '';
    public $Rdel = '';
    public $baseDir = '';

    /**
     * Constructor
     *
     * @param Compiler $compiler compiler object
     * @param Context                    $context
     *
     * @throws Exception\NoGeneratorClass
     */
    function __construct(Compiler $compiler, Context $context)
    {
        $this->baseDir = __DIR__ . '/';
        $this->compiler = $compiler;
        $this->context = $context;
        $config = $this->sxiToArray(new \SimpleXmlIterator(__DIR__ . '/CompilerConfig.xml', null, true));
        if ($config['pegGenerator']['compile_check'] == 'on' || $config['pegGenerator']['force_compile'] == 'on') {
            $this->force_compile = ($config['pegGenerator']['force_compile'] == 'on');
            $this->compile_check = ($config['pegGenerator']['compile_check'] == 'on');
            $this->trace = ($config['pegGenerator']['trace'] == 'on');
            $this->generatorClass = $config['pegGenerator']['generatorClass'];
            $this->checkRule('', $this->getBaseDir() . '', $this->getBaseDir(), $config['pegGenerator']['ruleFilePostfix'], $config['pegGenerator']['parserFilePostfix']);
        }
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

        $smarty = $this->context->smarty;
        $this->Ldel = preg_quote($smarty->leftDelimiter);
        if (!$smarty->autoLiteral) {
            $this->Ldel .= '\s*';
        }
        $this->Rdel = '\s*' . preg_quote($smarty->rightDelimiter);
        $this->loadRules('Core');
        $this->loadRules('Expression');
        $this->loadRules('Variable');
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
                    $ruleArray[] = array(__DIR__ . "/Compiler/Target/Shared/Parser/",
                                         'Smarty\Compiler\Target\Shared\Parser\\');
                }
                $ruleArray[] = array(__DIR__ . "/Compiler/Target/Language/{$this->getTargetLanguage()}/Parser/",
                                     'Smarty\Compiler\Target\Language\\' . $this->getTargetLanguage() . '\Parser\\');
            }
            if ($groups | Compiler::SOURCE == Compiler::SOURCE) {
                if ($groups | Compiler::SHARED == Compiler::SHARED) {
                    $ruleArray[] = array(__DIR__ . "/Compiler/Source/Shared/Parser/",
                                         'Smarty\Compiler\Source\Shared\Parser\\');
                }
                $ruleArray[] = array(__DIR__ . "/Compiler/Source/Language/{$this->getSourceLanguage()}/Parser/",
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
            $this->rules[$name] = $nodeParser;
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
        $nodeName = isset($nodeName) ? $nodeName : (string) $this->context->smarty->smartyConfig->parser->defaultNode;
        // build result array
        $result = array_merge($this->resultDefault, $this->getRuleNode($nodeName));
        if (isset($node)) {
            $result['node'] = $node;
        }
        // call start actions
        $this->ruleStart($result);
        // match node rule
        $this->matchRule($result, $this->buildParams($result));
        // free memory
        $this->rules = array();
        $this->rxCache = array();
        $this->packCache = array();
        // return result array
        return $result;
    }

    /**
     * @param $ruleName
     *
     * @throws Parser\Exception\NoRule
     * @return mixed
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
        if (is_array($rule)) {
            $rule['_ruleParser'] = $this;
        } else {
            $rule = $rule->rules[$ruleName];
            $rule['_ruleParser'] = $this->rules[$ruleName];
        }
        return $rule;
    }

    /**
     * Rule result array initialization
     *
     * @param array     $result
     * @param null|array $previous optional result array of calling rule
     */
    public function ruleStart(&$result, $previous = null)
    {
        $result['_parser'] = $this;
        $result['_startpos'] = $result['_endpos'] = $this->pos;
        $result['_lineno'] = $this->line;
        if (isset($result['_actions']['_start'])) {
            foreach ($result['_actions']['_start'] as $method => $foo) {
                $callback = array($result['_ruleParser'], $method);
                call_user_func_array($callback, array(&$result, $previous));
            }
        }
    }

    /**
     * Match token rule observing all parameter
     *
     * @param array $result result array
     * @param array $params rule parameter array
     *
     * @return bool
     */
    public function matchRule(&$result, $params)
    {
        $iteration = 0;
        if ($params['_pla'] || $params['_nla']) {
            $backup = $result;
        }
        $pos = $this->pos;
        $line = $this->line;
        do {
            $a = substr($this->source, $this->pos, 30);
            $valid = $this->matchToken($result, $params);
            if ($params['_pla'] || $params['_nla']) {
                $this->pos = $pos;
                $this->line = $line;
                $result = $backup;
            }
            if ($params['_nla']) {
                $valid = !$valid;
            }
            if ($valid) {
                $iteration ++;
            }
            if ($valid && $params['_max'] != null && $iteration == $params['_max']) {
                break;
            }
            if (!$valid && $iteration >= $params['_min']) {
                $valid = true;
                break;
            }
            if (!$valid) {
                break;
            }
        } while (true);
        return $valid;
    }

    /**
     * Match rule token by its type
     *
     * @param array $result   result array
     * @param array $params   rule parameter array
     *
     * @return bool  result of match
     */
    public function matchToken(&$result, $params)
    {
        switch ($params['_type']) {
            case 'recurse':
                return $this->matchRecurse($result, $params);
                break;
            case 'rx':
                $rx = isset($this->rxCache[$params['_param']]) ? $this->rxCache[$params['_param']] : $this->rxCache[$params['_param']] = new RxMatch($params, $this);
                return $rx->matchRx($result, $params);
                break;
            case 'option':
                return $this->matchOption($result, $params);
                break;
            case 'sequence':
                return $this->matchSequence($result, $params);
                break;
            case 'whitespace':
                return $this->matchWhitespace($result, $params);
                break;
            case 'literal':
                return $this->matchLiteral($result, $params);
                break;
            case 'expression':
                return $this->matchExpression($result, $params);
                break;
            default:
                //TODO
                return false;
                break;
        }
    }

    /**
     * Match Token by its node name
     *     *
     *
     * @param array     $result result array
     * @param array $params rule parameter array
     *
     * @throws Parser\Exception\NoRule
     * @return bool result of match
     */
    public function matchRecurse(&$result, $params)
    {
        $subres = array_merge($this->resultDefault, $this->getRuleNode($params['_param']));
        $newParams = $this->buildParams($subres);

        $this->backtrace[] = $subres;
        $hashed = isset($subres['_attr']['hash']);
        $pos = $this->pos;
        $hashvalid = false;
        if ($hashed && isset($this->packCache[$pos][$subres['_name']])) {
            $subres = $this->packCache[$pos][$subres['_name']];
            $hashvalid = $valid = !(false === $subres);
            if ($hashvalid) {
                $subres['_tag'] = $params['_tag'];
                $this->pos = $subres['_endpos'];
            }
        } else {
            $this->ruleStart($subres, $result);
            $subres['_tag'] = $params['_tag'];
            $valid = ($newParams['_extended']) ? $this->matchRule($subres, $newParams) : $this->matchToken($subres, $newParams);
            if ($hashed) {
                if ($valid) {
                    $this->packCache[$pos][$subres['_name']] = $subres;
                } else {
                    $this->packCache[$pos][$subres['_name']] = false;
                }
            }
        }
        $remove = array_pop($this->backtrace);
        if ($valid) {
            $this->successNode($subres);
            if ($subres['_silent'] < 2) {
                if (!$hashvalid && isset($subres['_actions']['_finish'])) {
                    foreach ($subres['_actions']['_finish'] as $method => $foo) {
                        $callback = array($subres['_ruleParser'], $method);
                        call_user_func_array($callback, array(&$subres));
                        if ($subres === false) {
                            return false;
                        }
                    }
                }
                $this->ruleMatch($result, $subres);
            } else {
                $result['_endpos'] = $this->pos;
            }
        } else {
            $this->failNode($remove);
        }
        return $valid;
    }

    /**
     * Build rule parameter array
     *
     * @param array $rule  rule array
     *
     * @return array
     */
    public function buildParams($rule)
    {
        $param = array();
        $param['_pla'] = isset($rule['_pla']) ? $rule['_pla'] : false;
        $param['_nla'] = isset($rule['_nla']) ? $rule['_nla'] : false;
        $param['_min'] = array_key_exists('_min', $rule) ? $rule['_min'] : 1;
        $param['_max'] = array_key_exists('_max', $rule) ? $rule['_max'] : 1;
        $param['_tag'] = isset($rule['_tag']) ? $rule['_tag'] : false;
        if (isset($rule['_type'])) {
            $param['_type'] = $rule['_type'];
        }
        if (isset($rule['_name'])) {
            $param['_name'] = $rule['_name'];
        }
        if (isset($rule['_param'])) {
            $param['_param'] = $rule['_param'];
        }
        if (isset($rule['_ruleParser'])) {
            $param['_ruleParser'] = $rule['_ruleParser'];
        }
        $param['_extended'] = $param['_pla'] || $param['_nla'] || $param['_min'] != 1 || $param['_max'] != 1;
        return $param;
    }

    /**
     * @param $subres
     */
    public function successNode($subres)
    {
        if ($this->trace) {
            $this->backtrace();
            fprintf($this->traceFile, " = %s('%s')]\n", ($subres['_tag'] ? $subres['_tag'] . ':' : '') . $subres['_name'], $this->truncateText($subres['_text']));
        }
    }

    /**
     *
     */
    public function backtrace()
    {
        fprintf($this->traceFile, "%s [", $this->tracePrompt);
        foreach ($this->backtrace as $t) {
            fprintf($this->traceFile, " %s", $t['_name']);
        }
        if (isset($t['_text'])) {
            fprintf($this->traceFile, "('%s')", $this->truncateText($t['_text']));
        }
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
     * Calls store actions on matching rules
     *
     * @param array $result result array
     * @param array $subres result array of matched token
     */
    public function ruleMatch(&$result, $subres)
    {
        $result['_endpos'] = $this->pos;
        if ($subres['_silent'] == 0) {
            $result['_text'] .= $subres['_text'];
        }
        $storetag = (isset($subres['_tag']) && !empty($subres['_tag'])) ? $subres['_tag'] : false;
        // TODO
        if (false && $this->trace) {
            $backlinks = $this->getBacklinks();
            fprintf($this->traceFile, "%sParser Match [", $this->tracePrompt);
            foreach ($backlinks as $bl) {
                fprintf($this->traceFile, "%s ", $bl['_name']);
            }
            fprintf($this->traceFile, "= %s]\n", $subres['_name']);
        }

        /**
         * if ($storetag) {
         * $this->_result[$storetag][$subres->_startpos][$subres->_endpos]['text'] = $subres->_text;
         * $this->_result[$storetag][$subres->_startpos][$subres->_endpos]['node'] = $subres->node;
         * $this->_result[$storetag][$subres->_startpos][$subres->_endpos]['result'] = $subres->_result;
         * }
         * */
        if (isset($result['_actions']['_match'])) {
            if (isset($subres['_matchres']) && !empty($subres['_matchres'])) {
                foreach ($subres['_matchres'] as $type => $foo) {
                    if (!empty($foo) && isset($result['_actions']['_match'][$type])) {
                        foreach ($result['_actions']['_match'][$type] as $method => $bar) {
                            $storetag = false;
                            $callback = array($result['_ruleParser'], $method);
                            call_user_func_array($callback, array(&$result, $subres));
                        }
                    }
                }
            }
            if ($storetag || isset($subres['_name'])) {
                $type = $storetag ? $storetag : $subres['_name'];
                if (false) {
                    $method = "{$result['_name']}_{$type}";
                    if (isset($result['_actions'][$method])) {
                        $callback = array($result['_ruleParser'], $method);
                        call_user_func_array($callback, array(&$result, $subres));
                        return;
                    }
                }
                if (isset($result['_actions']['_match'][$type])) {
                    foreach ($result['_actions']['_match'][$type] as $method => $foo) {
                        $callback = array($result['_ruleParser'], $method);
                        call_user_func_array($callback, array(&$result, $subres));
                        return;
                    }
                }
            }
        }

        if (isset($result['_actions']['_all'])) {
            foreach ($result['_actions']['_all'] as $method => $foo) {
                $callback = array($result['_ruleParser'], $method);
                call_user_func_array($callback, array(&$result, $subres));
                return;
            }
        }
        if (!empty($subres['_matchres'])) {
            $result['_matchres'] = array_merge($result['_matchres'], $subres['_matchres']);
        } elseif ($storetag) {
            if (!isset($result[$storetag])) {
                $result[$storetag] = $subres;
            } else {
                if (!is_array($result[$storetag])) {
                    $result[$storetag] = array($result[$storetag], $subres);
                }
                $result[$storetag][] = $subres;
            }
        }
        /**
         * else {
         * if (isset($subres['_matchres'])) {
         * $result['_matchres'] = array_merge($result['_matchres'], $subres['_matchres']);
         * }
         * }
         */
    }

    /**
     * @param $subres
     */
    public function failNode($subres)
    {
        if ($this->trace) {
            $this->backtrace();
            fprintf($this->traceFile, " ] [%s]? Got '%s'\n", $subres['_name'], $this->unexpected());
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
     * Match optional tokens
     *
     * @param array $result result array
     * @param array $params rule parameter array
     *
     * @return bool result of match
     */
    public function matchOption(&$result, $params)
    {
        $backup = $result;
        $pos = $this->pos;
        $line = $this->line;
        $count = count($params['_param']);
        $loop = 0;
        do {
            $newParams = $this->buildParams($params['_param'][$loop]);
            $valid = ($newParams['_extended']) ? $this->matchRule($result, $newParams) : $this->matchToken($result, $newParams);
            if ($valid) {
                return true;
            }
            $loop ++;
        } while ($loop < $count);
        $this->pos = $pos;
        $this->line = $line;
        $result = $backup;
        return false;
    }

    /**
     * Match sequence of tokens
     *
     * @param array $result result array
     * @param array $params rule parameter array
     *
     * @return bool result of match
     */
    public function matchSequence(&$result, $params)
    {
        $backup = $result;
        $pos = $this->pos;
        $line = $this->line;
        $count = count($params['_param']);
        $loop = 0;
        do {
            $newParams = $this->buildParams($params['_param'][$loop]);
            $valid = ($newParams['_extended']) ? $this->matchRule($result, $newParams) : $this->matchToken($result, $newParams);
            if ($valid === false) {
                $this->pos = $pos;
                $this->line = $line;
                $result = $backup;
                return false;
            }
            $loop ++;
        } while ($loop < $count);
       if ($params['_tag']) {
            $result['_tag'] = $params['_tag'];
            $this->ruleMatch($backup, $result);
            $result = $backup;
        }
        return true;
    }

    /**
     * Match whitespace token
     *
     * @param array $result result array
     * @param array $params rule parameter array ($params['_param'] == true is optional)
     *
     * @return bool result of match
     */
    public function matchWhitespace(&$result, $params)
    {
        if (preg_match($this->whitespacePattern, $this->source, $match, 0, $this->pos)) {
            $result['_text'] .= ' ';
            $this->pos += strlen($match[0]);
            $this->line += substr_count($match[0], "\n");
            $result['_endpos'] = $this->pos;
            return true;
        }
        if ($params['_param']) {
            return true;
        }
        return false;
    }

    /**
     * Match literal token
     *
     * @param array $result result array
     * @param array $params rule parameter array ($params['_param'] contains literal)
     *
     * @return bool result of match
     */
    public function matchLiteral(&$result, $params)
    {
        if ($params['_param'] == substr($this->source, $this->pos, strlen($params['_param']))) {
            $this->pos += strlen($params['_param']);
            $result['_text'] .= $params['_param'];
            $result['_endpos'] = $this->pos;
            $this->successLiteral($params['_param']);
            // if literal was tagged call matching action
            if ($params['_tag']) {
                if (isset($result['_actions']['_match'][$params['_tag']])) {
                    foreach ($result['_actions']['_match'][$params['_tag']] as $method => $foo) {
                        $callback = array($result['_ruleParser'], $method);
                        $subres = array();
                        call_user_func_array($callback, array(&$result, $subres));
                        return true;
                    }
                }
            }
            return true;
        }
        $this->failLiteral($params['_param']);
        return false;
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

    /**
     * Match expression token
     *
     * @param array $result result array
     * @param array $params rule parameter array
     *
     * @return bool result of match
     */
    public function matchExpression(&$result, $params)
    {
        $subres = $result;
        $subres['_tag'] = $params['_tag'];
        $this->backtrace[] = $result;
        $valid = false;
        // call runtime function to perform the match
        $method = "{$result['_name']}_EXP_{$params['_param']}";
        if (isset($result['_actions']['_expression'][$method])) {
            $callback = array($result['_ruleParser'], $method);
            $valid = call_user_func_array($callback, array(&$subres));
        }
        $remove = array_pop($this->backtrace);
        if ($valid) {
            $this->successNode($subres);
            // call matching actions
            if ($subres['_silent'] < 2) {
                if (isset($subres['_actions']['_finish'])) {
                    foreach ($subres['_actions']['_finish'] as $method => $foo) {
                        $callback = array($subres['_ruleParser'], $method);
                        call_user_func_array($callback, array(&$subres));
                    }
                }
                $this->ruleMatch($result, $subres);
            } else {
                $result['_endpos'] = $this->pos;
            }
        } else {
            $this->failNode($remove);
        }
        return $valid;
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
        // a subtag shall not be processed by dispatcher but while parsing the original tag
        if (isset($this->currentSubtags[$result['tagname']['_text']])) {
            return false;
        }
        // Reset position to LDel
        $this->pos = $result['_startpos'];
        $this->line = $result['_lineno'];
        $tag = $result['_tag'];
        // build match rule
        $ruleName = 'Tag' . ucfirst($result['tagname']['_text']);
        $subres = array_merge($this->resultDefault, $this->getRuleNode($ruleName));
        $subres['node'] = $tagNode = $this->compiler->instanceNode('Tag', $this->compiler->context, $this, $subres);
        $subtags = $tagNode->getNodeAttribute('subtags');
        if ($subtags !== false) {
            $this->subtagsStack[] = $this->currentSubtags;
            $this->currentSubtags = $subtags;
        }
        $this->ruleStart($subres);
        $valid = $this->matchRule($subres, $this->buildParams($subres));
        if ($subtags !== false) {
            $this->currentSubtags = array_pop($this->subtagsStack);
        }
        if ($valid) {
            if (isset($subres['_actions']['_finish'])) {
                foreach ($subres['_actions']['_finish'] as $method => $foo) {
                    $callback = array($subres['_ruleParser'], $method);
                    call_user_func_array($callback, array(&$subres));
                }
            }
            $subres['node']->setTraceInfo($subres['_lineno'], $subres['_text'], $subres['_startpos'], $subres['_endpos']);
            $actions = $result['_actions'];
            $result = $subres;
            $result['_actions'] = $actions;
            $result['_tag'] = $tag;
        }
        return $valid;
    }

    public function cleanup()
    {
        $this->source = '';
        $this->rules = array();
        $this->rxCache = array();
        $this->packCache = array();
        $this->context = null;
        $this->compiler = null;
    }
}
