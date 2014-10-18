<?php
namespace Smarty;

use Smarty\Compiler\Exception\MissingClass;
use Smarty\Compiler\Exception\NodeClassNotFound;
use Smarty\Compiler\Exception\ParserClassNotFound;
use Smarty\Exception\Magic;
use Smarty\Exception;
use Smarty\Node;
use Smarty\Context;
use Smarty\Compiler\Format;
use Smarty\Compiler\Code;
use Smarty\Template\Scope;

/**
 * Class Compiler
 *
 * @package Smarty
 */
class Compiler// extends Magic
{

    /*
     * Rule groups
     */
    /**
     *
     */
    const USER = 1;
    /**
     *
     */
    const SHARED = 10;
    /**
     *
     */
    const SOURCE = 100;
    /**
     *
     */
    const TARGET = 200;
    /**
     *
     */
    const COMMON = 300;
    /**
     *
     */
    const ALL = 1000;
    /**
     * compile tag objects
     *
     * @var array
     */
    public static $_tag_objects = array();
    public $context = null;
    public $smarty = null;
    /**
     * @var array
     */
    public $nodeClassGroupsCache = array();

    /**
     * Node class Cache
     *
     * @var array
     */
    public $nodeClassCache = array();

    /**
     * line offset to start of template source
     *
     * @var int
     */
    public $line_offset = 0;
    /**
     * flag for strip mode
     *
     * @var bool
     */
    public $strip = false;
    /**
     * flag for nocache code not setting $has_nocache_flag
     *
     * @var bool
     */
    public $nocache_nolog = false;
    /**
     * suppress generation of nocache code
     *
     * @var bool
     */
    public $suppressNocacheProcessing = false;
    /**
     * flag when compiling inheritance
     *
     * @var bool
     */
    public $isInheritance = false;
    /**
     * flag when compiling inheritance
     *
     * @var bool
     */
    public $isInheritanceChild = false;
    /**
     * force compilation of complete template as nocache
     * 0 = off
     * 1 = observe nocache flags on template type recompiled
     * 2 = force all code to be nocache
     *
     * @var integer
     */
    public $forceNocache = 0;
    /**
     * tag stack
     *
     * @var array
     */
    public $_tag_stack = array();
    /**
     * file dependencies
     *
     * @var array
     */
    public $file_dependency = array();
    /**
     * block function properties
     *
     * @var array
     */
    public $inheritance_blocks = array();
    /**
     * block function compiled code
     *
     * @var array
     */
    public $inheritance_blocks_code = array();
    /**
     * block name index
     *
     * @var integer
     */
    public $block_name_index = 0;
    /**
     * inheritance block nesting level
     *
     * @var integer
     */
    public $block_nesting_level = 0;
    /**
     * block nesting info
     *
     * @var array
     */
    public $block_nesting_info = array();
    /**
     * compiled footer code
     *
     * @var array
     */
    public $compiled_footer_code = null;
    /**
     * /**
     * plugins loaded by default plugin handler
     *
     * @var array
     */
    public $default_handler_plugins = array();
    /**
     * saved preprocessed modifier list
     *
     * @var mixed
     */
    public $default_modifier_list = null;
    /**
     * suppress template property header code in compiled template
     *
     * @var bool
     */
    public $suppressTemplatePropertyHeader = false;
    /**
     * suppress processing of post filter
     *
     * @var bool
     */
    public $suppressPostFilter = false;
    /**
     * flag if compiled template file shall we written
     *
     * @var bool
     */
    public $write_compiled_code = true;
    /**
     * flag if template does contain nocache code sections
     *
     * @var boolean
     */
    public $has_nocache_code = false;
    /**
     * flag if currently a template function is compiled
     *
     * @var bool
     */
    public $compiles_template_function = false;
    /**
     * called subfuntions from template function
     *
     * @var array
     */
    public $called_template_functions = array();
    /**
     * template functions called nocache
     *
     * @var array
     */
    public $called_nocache_template_functions = array();
    /**
     * required plugins
     *
     * @var array
     * @internal
     */
    public $required_plugins = array('compiled' => array(), 'nocache' => array());
    /**
     * flags for used modifier plugins
     *
     * @var array
     */
    public $modifier_plugins = array();
    /**
     * type of already compiled modifier
     *
     * @var array
     */
    public $known_modifier_type = array();
    /**
     * Compiled Node
     * This is the node which holds the content which will be written to the compiled resource
     *
     * @var
     */
    public $compiled_node = null;
    /**
     * Compiled filepath
     */
    public $compiled_filepath = '';
    /**
     * local variable name in compiled code for template output
     *
     * @var null|string
     */
    public $output_var = null;
    /**
     * Timestamp when we started compilation
     *
     * @var int
     */
    public $timestamp = 0;
    public $tag_cache = array();
    public $template_laguage_cache = array();
    public $code_laguage_cache = array();
    public $has_code = false;

    // TODO check this solution
    public $has_output = false;
    /**
     * Stack for output_var
     *
     * @var array
     */
    private $output_var_stack = array();

    /**
     * Initialize compiler
     *
     * @param Context $context
     *
     * @throws NoConfigFile
     */
    public function __construct(Context $context)
    {
        $this->context = $context;
        $this->smarty = $context->smarty;
        $this->loadSourceConfig();
        exit();
        // make sure that we don't run into backtrack limit errors
        ini_set('pcre.backtrack_limit', - 1);
    }

    public function loadSourceConfig()
    {
        $source = ucfirst($this->context->getSourceLanguage());
        $sourceConfig = array();
            $configs = $this->context->xpath->query("//sourceConfig[@language='{$source}']");
            foreach ($configs as $config) {
                foreach ($config->childNodes as $node) {
                    if ($value = $node->getAttribute('value')) {
                        $sourceConfig[$node->nodeName] = $node->getAttribute('value');
                    } else {
                        $value = array();
                        foreach ($node->attributes as $attr) {
                            $value[$attr->nodeName] = $attr->nodeValue;
                        }
                        $sourceConfig[$node->nodeName][$value['name']] = $value;
                    }
                }
            }

        $basePath = $this->context->_absolutePath($sourceConfig['directoryPath'], \Smarty::$baseDir);
        $xmlFile = $this->context->_absolutePath($sourceConfig['sourceConfigXml'], $basePath);
        if (!isset($this->loadedXmlFiles[$xmlFile])) {
            $xml = $this->context->_loadXml($xmlFile);
            $nodes = $xml->getElementsByTagName('sourceConfig');
            foreach ($nodes as $nd) {
                foreach ($nd->childNodes as $node) {
                    $na = $node->attributes;
                    if ($na->length == 1 && $value = $node->getAttribute('value')) {
                        $sourceConfig[$node->nodeName] = $value;
                    } else {
                        $value = array();
                        foreach ($na as $attr) {
                            $value[$attr->nodeName] = $attr->nodeValue;
                        }
                        $sourceConfig[$node->nodeName][$value['name']] = $value;
                    }
                }
            }
        }
exit();
        $this->context->loadConfigSection($sourceConfig['configSection'], null, null, $this->context->_absolutePath($sourceConfig['sourceConfigXml'], $basePath));
        if (isset($this->configData['sourceConfig']['directoryPathShared'])) {
            $this->configData['sourceConfig'][$source]['directoryPathShared'] = $this->_absolutePath($this->configData['sourceConfig'][$source]['directoryPathShared'], \Smarty::$baseDir);
        }
        //$this->configData['sourceConfig'] = $name;
    }


    /**
     * Compiles from resource
     *
     * @param Context $context
     * @param Node    $node
     * @param bool    $pre_filter  flag for prefilter
     * @param bool    $post_filter flag for postfilter
     *
     * @return string compiled code
     */
    public function compileResource(Context $context, Node $node = null, $pre_filter = true, $post_filter = true)
    {
        if ($debugging = $context->getProperty('debugging')) {
            \Smarty_Debug::start_compile($context);
        }

        $root_node = null;
        $context->smarty->_current_file = $saved_filepath = $context->filepath;
        $code = $this->compileSource($context, $context->getContent(), $root_node, $pre_filter, $post_filter);
        $context->filepath = $saved_filepath;

        unset($root_node);

        if ($debugging) {
            \Smarty_Debug::end_compile($context);
        }
        return $code;
    }

    /**
     * Compiles from source string
     *
     * @param Context $context
     * @param string  $source
     * @param Node    $node
     * @param bool    $pre_filter  flag for prefilter
     * @param bool    $post_filter flag for postfilter
     *
     * @throws \Exception
     * @return string compiled code
     */
    public function compileSource(Context $context, $source, Node $node = null, $pre_filter = false, $post_filter = false)
    {
        // run prefilter if required
        if ($pre_filter && isset($context->smarty->_autoloadFilters['pre']) || isset($context->smarty->_registered['filter']['pre'])) {
            $source = $context->smarty->runFilter('pre', $source, $this);
        }
        try {
            // get default node and instance
            $nodeClass = $this->getDefaultNodeName($context);
            $node = $this->instanceNode($nodeClass, $context);
            $node->setSource($source);
            $node->parse();
            $node->parser->cleanup();
            $codeObj = $node->compile();
            $code = $codeObj->compiled;
 //          $node->parser->cleanup();
            $node->cleanup();
            unset($node);
            echo '<br>exit<br>';
        }
        catch (\Exception $e) {
            // in case of exception free memory
            //           $parser = $node->parser;
            //           $parser->cleanup();
            //           unset($parser);
            //           $node->cleanup();
            //           unset($node);
            throw $e;
        }

        // run postfilter if required on compiled template code
        if ($post_filter && (isset($context->smarty->_autoloadFilters['post']) || isset($context->smarty->_registered['filter']['post']))) {
            $code = $context->smarty->runFilter('post', $code, $context->smarty, $this);
        }
        return $code;
    }

    /**
     * @param $context
     *
     * @return string
     */
    public function getDefaultNodeName(Context $context)
    {
        return $context->_getConfigData('defaultNode');
    }

    /**
     * Instance node
     *
     * @param string                   $nodeName node name
     * @param \Smarty\Context $context
     * @param null                     $parser
     * @param null                     $tokenName
     * @param bool                     $quiet
     * @param int                      $ruleGroups
     *
     * @throws Compiler\Exception\NodeClassNotFound
     * @throws Compiler\Exception\ParserClassNotFound
     * @return \Smarty\Node
     */
    public function instanceNode($nodeName, Context $context = null, $parser = null, $tokenName = null, $quiet = false, $ruleGroups = self::ALL)
    {
        $tokenName = isset($tokenName) ? $tokenName : $nodeName;
        $context = isset($context) ? $context : $this->context;
        $groups = ($ruleGroups === self::ALL) ? (self::USER + self::SOURCE + self::TARGET + self::SHARED + self::COMMON) : $ruleGroups;
        if (isset($this->nodeClassCache[$groups]) && isset($this->nodeClassCache[$groups][$nodeName])) {
            $nodeClass = $this->nodeClassCache[$groups][$nodeName];
            $parser = isset($parser) ? $parser : $this->instanceParser($context);
            return new $nodeClass($parser, $tokenName);
        }
        $classArray = array();
        if ($groups | self::USER == self::USER && !(false == $classArray[0] = $this->getUserNodeClass($nodeName))) {
        } else {
            if (isset($this->nodeClassGroupsCache[$groups])) {
                $classArray = $this->nodeClassGroupsCache[$groups];
            } else {
                $classArray = array();
                if ($groups | self::TARGET == self::TARGET) {
                    $classArray[] = "Smarty\Compiler\Target\Language\\{$context->getTargetLanguage()}\Node\\";
                    if ($groups | self::SHARED == self::SHARED) {
                        $classArray[] = "Smarty\Compiler\Target\Shared\Node\\";
                    }
                }
                if ($groups | self::SOURCE == self::SOURCE) {
                    $classArray[] = "Smarty\Parser\Source\Language\\{$context->getSourceLanguage()}\Node\\";
                    if ($groups | self::SHARED == self::SHARED) {
                        $classArray[] = "Smarty\Parser\Source\Shared\Node\\";
                    }
                }
                if ($groups | self::COMMON == self::COMMON) {
                    $classArray[] = "Smarty\Node\\";
                }
                $this->nodeClassGroupsCache[$groups] = $classArray;
            }
        }
        foreach ($classArray as $nodeClass) {
            $nodeClass .= $nodeName;
            // class exist?
            if (class_exists($nodeClass)) {
                $this->nodeClassCache[$groups][$nodeName] = $nodeClass;
                $parser = isset($parser) ? $parser : $this->instanceParser($context);
                return new $nodeClass($parser, $tokenName);
            }
        }
        if ($quiet) {
            return false;
        } else {
            throw new NodeClassNotFound($nodeName, 0, $this->context);
        }
    }

    /**
     * Instance parser class
     *
     * @param Context $context
     *
     * @throws ParserClassNotFound
     * @return mixed
     */
    public function instanceParser(Context $context)
    {
        $parserClass = $context->getParserClass();
        if (class_exists($parserClass)) {
            return new $parserClass($this, $context);
        } else {
            throw new ParserClassNotFound($parserClass, 0, $context);
        }
    }

    /**
     * Get user registered node class name
     *
     * @param string $nodeName
     *
     * @return bool|string
     */
    public function getUserNodeClass($nodeName)
    {
        // TODO
        return false;
    }

    /**
     * Check if class exists
     *
     * @param string $class     class name
     * @param bool   $exception flag if exception shall be thrown (default true)
     *
     * @throws MissingClass
     * @return bool return status
     */
    public function classExists($class, $exception = true)
    {
        if (class_exists($class)) {
            return true;
        }
        if ($exception) {
            throw new MissingClass($class);
        }
        return false;
    }

    /**
     * Compile node
     *
     * @param Node|\Smarty_Compiler_Node $node
     * @param Code                       $codeTargetObj
     * @param bool                       $delete
     *
     * @throws Exception
     * @throws NodeCompilerClassNotFound
     * @throws \Exception
     * @internal param Context $context
     * @internal param null $indentation
     * @return string compiled code
     */
    public function compileNode(Node $node, Code $codeTargetObj = null, $delete = true)
    {
        try {
            $codeTargetObj = isset($codeTargetObj) ? $codeTargetObj : new Format($node);
            // compiled code in node so just copy it
            if (isset($node->code)) {
                $codeTargetObj->raw($node->code);
                return $codeTargetObj;
            }
            // compiler in node so just call
            if (isset($node->hasLocalCompiler)) {
                $node->compile($codeTargetObj, $delete);
                return $codeTargetObj;
            }
            // call node compiler
            $className = "Smarty\Compiler\Target\Language\\{$this->context->getTargetLanguage()}\Compiler\\{$node->compilerClass}";
            if (class_exists($className)) {
                $className::compile($node, $codeTargetObj, $delete);
                return $codeTargetObj;
            } else {
                throw new NodeCompilerClassNotFound($node->name, 0, $this->context);
            }
        }
            // TODO
        catch (Exception $e) {
            // in case of exception free memory
            $parser = $node->parser;
            $parser->cleanup();
            unset($parser);
            $node->cleanup();
            unset($node);
            throw $e;
        }
    }

    /**
     * Compile an array of nodes and move compiled code into target node if specified
     *
     * @param  array $nodesArray array of nodes to be compiled
     * @param Code   $codeTargetObj
     * @param bool   $delete     flag if compiled nodes shall be deleted
     *
     * @throws Exception
     * @throws NodeCompilerClassNotFound
     * @throws \Exception
     * @return Node  current node
     */
    public function compileNodeArray(&$nodesArray, Code $codeTargetObj = null, $delete = true)
    {
        $codeTargetObj = isset($codeTargetObj) ? $codeTargetObj : new Code($nodesArray);
        if (is_array($nodesArray)) {
            foreach ($nodesArray as $key => $node) {
                $this->compileNode($node, $codeTargetObj, $delete);
                unset($node);
            }
        } else {
            $this->compileNode($nodesArray, $codeTargetObj, $delete);
        }
        if ($delete) {
            if (is_array($nodesArray)) {
                foreach ($nodesArray as $key => $n) {
                    $nodesArray[$key]->cleanup();
                    unset($nodesArray[$key]);
                }
            } else {
                $nodesArray->cleanup();
                unset($nodesArray);
            }
        }
        return $codeTargetObj;
    }

    /**
     * display compiler error messages
     * If parameter $args is empty it is a parser detected syntax error.
     * In this case the parser is called to obtain information about expected tokens.
     * If parameter $msg contains a string this is used as error message
     *
     * @param  string                  $msg  individual error message or null
     * @param  string                  $line line-number
     * @param  \Smarty_Compiler_Parser $parser
     *
     * @throws Exception\Compiler
     */
    public function error($msg = null, $line = null, $parser)
    {
        //throw new Exception\Compiler($msg, $line, $this->context, $parser);
        // TODO
        throw new Exception\Compiler($msg);
    }

    /**
     * Check for plugins and return function name
     *
     * @param  string $plugin_name name of plugin or function
     * @param  string $plugin_type type of plugin
     *
     * @return string call name of function
     */
    public function getPlugin($plugin_name, $plugin_type)
    {
        $function = null;
        if ($this->context->caching && ($this->nocache || $this->tag_nocache)) {
            if (isset($this->required_plugins['nocache'][$plugin_name][$plugin_type])) {
                $function = $this->required_plugins['nocache'][$plugin_name][$plugin_type]['function'];
            } elseif (isset($this->required_plugins['compiled'][$plugin_name][$plugin_type])) {
                $this->required_plugins['nocache'][$plugin_name][$plugin_type] = $this->required_plugins['compiled'][$plugin_name][$plugin_type];
                $function = $this->required_plugins['nocache'][$plugin_name][$plugin_type]['function'];
            }
        } else {
            if (isset($this->required_plugins['compiled'][$plugin_name][$plugin_type])) {
                $function = $this->required_plugins['compiled'][$plugin_name][$plugin_type]['function'];
            } elseif (isset($this->required_plugins['nocache'][$plugin_name][$plugin_type])) {
                $this->required_plugins['compiled'][$plugin_name][$plugin_type] = $this->required_plugins['nocache'][$plugin_name][$plugin_type];
                $function = $this->required_plugins['compiled'][$plugin_name][$plugin_type]['function'];
            }
        }
        if (isset($function)) {
            if ($plugin_type == 'modifier') {
                $this->modifier_plugins[$plugin_name] = true;
            }

            return $function;
        }
        // loop through plugin dirs and find the plugin
        $function = 'smarty_' . $plugin_type . '_' . $plugin_name;
        $file = $this->context->smarty->_loadPlugin($function, false);

        if (is_string($file)) {
            if ($this->context->caching && ($this->nocache || $this->tag_nocache)) {
                $this->required_plugins['nocache'][$plugin_name][$plugin_type]['file'] = $file;
                $this->required_plugins['nocache'][$plugin_name][$plugin_type]['function'] = $function;
            } else {
                $this->required_plugins['compiled'][$plugin_name][$plugin_type]['file'] = $file;
                $this->required_plugins['compiled'][$plugin_name][$plugin_type]['function'] = $function;
            }
            if ($plugin_type == 'modifier') {
                $this->modifier_plugins[$plugin_name] = true;
            }

            return $function;
        }
        if (is_callable($function)) {
            // plugin function is defined in the script
            return $function;
        }

        return false;
    }

    /**
     * Check for plugins by default plugin handler
     *
     * @param  string $tag         name of tag
     * @param  string $plugin_type type of plugin
     *
     * @return boolean true if found
     */
    public function getPluginFromDefaultHandler($tag, $plugin_type)
    {
        $callback = null;
        $script = null;
        $cacheable = true;
        $nodeRes = call_user_func_array(
            $this->context->smarty->default_plugin_handler_func, array($tag, $plugin_type, $this->context->smarty, &$callback, &$script, &$cacheable)
        );
        if ($nodeRes) {
            $this->tag_nocache = $this->tag_nocache || !$cacheable;
            if ($script !== null) {
                if (is_file($script)) {
                    if ($this->context->caching && ($this->nocache || $this->tag_nocache)) {
                        $this->required_plugins['nocache'][$tag][$plugin_type]['file'] = $script;
                        $this->required_plugins['nocache'][$tag][$plugin_type]['function'] = $callback;
                    } else {
                        $this->required_plugins['compiled'][$tag][$plugin_type]['file'] = $script;
                        $this->required_plugins['compiled'][$tag][$plugin_type]['function'] = $callback;
                    }
                    include_once $script;
                } else {
                    $this->error("Default plugin handler: Returned script file \"{$script}\" for \"{$tag}\" not found");
                }
            }
            if (!is_string($callback) && !(is_array($callback) && is_string($callback[0]) && is_string($callback[1]))) {
                $this->error("Default plugin handler: Returned callback for \"{$tag}\" must be a static function name or array of class and function name");
            }
            if (is_callable($callback)) {
                $this->default_handler_plugins[$plugin_type][$tag] = array($callback, true, array());

                return true;
            } else {
                $this->error("Default plugin handler: Returned callback for \"{$tag}\" not callable");
            }
        }

        return false;
    }

    /**
     * Push old output_var to stack and set up new one
     *
     * @param string $name new local variable name for rendered output
     */
    public function pushOutputVar($name)
    {
        array_push($this->output_var_stack, $this->output_var);
        $this->output_var = $name;
    }

    /**
     * Restore output_var

     */
    public function popOutputVar()
    {
        $this->output_var = array_pop($this->output_var_stack);
    }

    /**
     * @param Context $context
     *
     * @return Smarty_Template_Scope
     */
    public function instanceTemplateScope(Context $context)
    {
        return new Scope($context);
    }

    /**
     * Generate unique template class name
     *
     * @return string
     */
    public function getUniqueTemplateClassName()
    {
        return '_SmartyTemplate_' . str_replace(array('.', ','), '_', uniqid('', true));
    }
}
