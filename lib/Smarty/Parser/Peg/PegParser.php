<?php
namespace Smarty\Parser\Peg;

use Smarty\Exception\Magic;
use Smarty\Context;
use Smarty\Parser\Exception\NoRule;
use Smarty\Parser\RuleArrayParser;
use Smarty\Parser\TraceBack;
use Smarty\Compiler;
use Smarty\Parser;
use Smarty\Node;

/**
 * Class Parser
 *
 * @package Smarty
 */
class PegParser extends Parser
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
     * Cache of parsed rule results with have <attribute>hash</attribute> set
     *
     * @var array
     */
    public $packCache = array();

    /**
     * Cache of error information of rule results in $packCache
     *
     * @var array
     */
    public $errorCache = array();

    /**
     * Cache of peg parser rule info by rule group  ALL|TARGET|SOURCE|SHARED
     *   The peg parser rule info is an array of filepath and parser class prefix
     *
     * @var array
     */
    public $ruleGroupsCache = array();

    /**
     * Cache of match result of /.../ rules by position and rule nam
     *
     * @var array
     */
    public $regexpCache = array();

    /**
     * Rule definition array of loaded rules defined in array format
     *
     * @var array
     */
    public $ruleArray = array();

    /**
     * RuleRoot; callbacks loaded rules
     *
     * @var array RuleRoot;
     */
    public $ruleCallbackArray = array();

    /**
     * Flag to force recompilation of rule RuleRoot; classes
     *
     * @var bool
     */
    public $force_compile = false;

    /**
     * Flag to check if rule definition as been updated and rule RuleRoot; class must be recompiled
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
     * RuleRoot; file postfix
     *
     * @var string
     */
    public $parserFilePostfix = '';

    /**
     * RuleRoot; class name postfix
     *
     * @var string
     */
    public $parserClassPostfix = '';

    /**
     * Name of RuleRoot; generator Class
     *
     * @var null
     */
    public $generatorClass = null;



    /**
     * Object for trace back output
     *
     * @var TraceBack
     */
    public $traceObj = null;


    /**
     * Result array default content
     *
     * @var array
     */
    public $resultDefault = array('_silent' => 0, '_tag' => '', '_text' => '', '_pregMatch' => array());

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

    /**
     * @var array
     */
    public $knownNodes = array();

    /**
     * Name of current Rx node for replace call backs
     *
     * @var string
     */
    private $nameRx = '';

    /**
     * Constructor
     *
     * @param Compiler $compiler compiler object
     * @param Context  $context
     */
    function __construct(Compiler $compiler, Context $context)
    {
        parent::__construct($compiler, $context);

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

        $this->knownNodes = $this->compiler->sourceConfig['Node'];

        $this->loadRules('CoreTag');
        $this->loadRules('Expression');
        $this->loadRules('Variable');
        $this->loadRules('TagAssign');
        return $this;
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
     ** @return mixed
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
                    $ruleInfoArray[] = array($this->baseDir . "/Compiler/Target/Shared/Parser/",
                                             'Smarty\Compiler\Target\Shared\Parser\\');
                }
                $ruleInfoArray[] = array($this->baseDir . "/Compiler/Target/Language/{$this->getTargetLanguage()}/Parser/",
                                         'Smarty\Compiler\Target\Language\\' . $this->getTargetLanguage() . '\Parser\\');
            }
            if ($groups | Compiler::SOURCE == Compiler::SOURCE) {
                if ($groups | Compiler::SHARED == Compiler::SHARED) {
                    $ruleInfoArray[] = array($this->baseDir . "/Parser/Source/Shared/Parser/",
                                             'Smarty\Parser\Source\Shared\Parser\\');
                }
                $ruleInfoArray[] = array($this->baseDir . "/Parser/Source/Language/{$this->getSourceLanguage()}/Parser/",
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
     * Add all rule matcher functions of rule object to cache
     *
     * @param RuleRoot; $nodeParser
     */
    public function addRules(PegParser $nodeParser)
    {
        if ($this->trace) {
            $this->getTraceObj()->loadRuleMessage($nodeParser);
        }
        if (isset($nodeParser->ruleMethods)) {
            foreach ($nodeParser->ruleMethods as $name => $method) {
                $this->ruleCallbackArray[$name] = array($nodeParser, $method);
            }
        }
    }

    /**
     * Add all rule matcher functions of rule object to cache
     *
     * @param $rules
     *
     * @internal param RuleRoot; $nodeParser
     */
    public function addDynamicRules($rules)
    {
        foreach ($rules as $name => $rule) {
            $this->ruleArray[$name] = $rule;
            $this->rulePegParserArray[$name] = $this;
        }
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
        $error = array();
        $previous = $this->resultDefault;
        if (isset($node)) {
            $previous['node'] = $node;
        }
        $nodeName = isset($nodeName) ? $nodeName : (string) $this->context->smarty->smartyConfigXml->parser->defaultNode;
        $nodeRes = $this->matchRule($previous, $nodeName, $error);
        return $nodeRes;
    }

    /**
     * Get Peg Parser object for rule
     *
     * @param  string $ruleName rule name
     * @param bool    $quiet    if true do not throw exception
     *
     * @return false|PegParser        Peg parser object or false if not found
     * @throws Parser\Exception\NoRule
     */
    public function getPegParser($ruleName, $quiet = false)
    {
        if (isset($this->ruleCallbackArray[$ruleName])) {
            return $this->ruleCallbackArray[$ruleName];
        } else {
            $this->loadRules($ruleName);
            if (isset($this->ruleCallbackArray[$ruleName])) {
                return $this->ruleCallbackArray[$ruleName];
            } else {
                if ($quiet) {
                    return false;
                }
                throw new NoRule($ruleName, 0, $this->context);
            }
        }
    }


    /**
     * Get node attributes by rule name
     *
     * @param string $ruleName rule name
     *
     * @return bool|array
     * @throws Parser\Exception\NoRule
     */
    public function getNodeAttributes($ruleName)
    {
        $peg = $this->getPegParser($ruleName);
        if (isset($peg[0]->nodeAttributes[$ruleName])) {
            return $peg[0]->nodeAttributes[$ruleName];
        } elseif (isset($peg[0]->ruleArray[$ruleName]['_attr'])) {
            return $peg[0]->ruleArray[$ruleName]['_attr'];
        } else {
            return false;
        }
    }

    /**
     * Call match method for rule
     *
     * @param array $nodeRes
     * @param       $ruleName
     * @param null  $error
     * @param bool  $quiet
     *
     * @throws Parser\Exception\NoRule
     * @return false|array   return false if match failed or result array
     */
    public function matchRule(&$nodeRes, $ruleName, &$error = null, $quiet = false)
    {
        if (!isset($error)) {
            $error = array();
        }
        if ($peg = $this->getPegParser($ruleName, $quiet)) {
            return call_user_func($peg,$nodeRes, $error);
        }
        return false;
    }


    /**
     * @param      $error
     * @param      $type
     * @param null $value
     * @param null $name
     */
    public function matchError(&$error, $type, $value = null, $name = null)
    {
        $error['matcherror'][$this->pos]['expected'][] = array($type, $value, $name);
    }

    /**
     * @param      $error
     * @param      $type
     * @param null $value
     * @param null $name
     */
    public function shouldNotMatchError(&$error, $type, $value = null, $name = null)
    {
        $error['shouldnotmatcherror'][$this->pos]['expected'][] = array($type, $value, $name);
    }

    /**
     * @param      $error
     * @param      $type
     * @param null $value
     * @param null $name
     */
    public function logOption(&$error, $type, $value = null, $name = null)
    {
        $error['optionlog'][$this->pos] ['expected'][] = array($type, $value, $name);
    }


    /**
     * Get instance of parser for rule arrays
     *
     * @return RuleArrayParser
     */
    public function instanceRuleArrayParser()
    {
        return isset($this->ruleArrayParser) ? $this->ruleArrayParser : $this->ruleArrayParser = new RuleArrayParser($this);
    }


    /**
     * Insert expression in regular expression at initialization
     *
     * @param string $nameRx node name
     * @param string $regexp regular expression
     *
     * @return string regular expression
     */
    function initRxReplace($nameRx, $regexp)
    {
        $this->nameRx = $nameRx;
        return preg_replace_callback('/{(\w+)}/', array($this, 'initRxReplaceCb'), $regexp);
    }

    /**
     * Callback for initRxReplace()
     *
     * @param array $matches
     *
     * @return string replacement
     * @throws Parser\Exception\NoRule
     */
    function initRxReplaceCb($matches)
    {
        $method = "{$this->nameRx}_INIT_{$matches[1]}";
        $peg = $this->getPegParser($this->nameRx);
        return $peg[0]->$method($this);
    }

    /**
     * Insert expression in regular expression dynamically
     *
     * @param string $nameRx node name
     * @param string $regexp regular expression
     *
     * @return string regular expression
     */
    function dynamicRxReplace($nameRx, $regexp)
    {
        $this->nameRx = $nameRx;
        return preg_replace_callback('/\$(\w+)/', array($this, 'dynamicRxReplaceCb'), $regexp);
    }

    /**
     * Callback for dynamicRxReplace()
     *
     * @param array $matches
     *
     * @return string replacement
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
    public function cleanupCache()
    {
//       return;
       if (!empty($this->packCache)) {
           ksort($this->packCache);
           foreach ($this->packCache as $key => $d) {
               if ($key < $this->pos) {
                   unset($this->packCache[$key], $this->errorCache[$key]);
               }
           }
       }
        foreach ($this->regexpCache as $k1 => $c) {
            ksort($c);
            foreach ($c as $k => $d) {
                if ($k < $this->pos) {
                    if ($k >= 0) {
                        unset($this->regexpCache[$k1][$k]);
                    }
                } else {
                    break;
                }
            }
        }
    }

    /**
     *
     */
    public function cleanup()
    {
//        $this->source = '';
        $this->traceObj = null;
        $this->ruleArray = array();
        $this->rxCache = array();
        $this->packCache = array();
        $this->ruleCallbackArray = array();
        //        $this->context = null;
//        $this->compiler = null;
        $this->ruleArrayParser = null;
    }
}
