<?php

/**
 * Smarty Template
 * This file contains the basic shared methods for precessing content of compiled and cached templates
 *
 * @package Smarty\Template
 * @author  Uwe Tews
 */
namespace Smarty\Template;

use Smarty;
use Smarty\Variable\Methods;
use Smarty\Variable\Entry;

/**
 * Class Smarty Internal Template
 * For backward compatibility to Smarty 3.1
 */
class Smarty_Internal_Template extends Methods
{
}

/**
 * Class Smarty Template
 *
 * @package Smarty\Template
 */
class  Core extends Smarty_Internal_Template
{

    /**
     * call stack
     *
     * @var array
     */
    public static $call_stack = array();
    /**
     * flag if class is valid
     *
     * @var boolean
     * @internal
     */
    public $isValid = false;
    /**
     * flag if class was updated
     *
     * @var boolean
     * @internal
     */
    public $isUpdated = false;
    /**
     * Smarty object
     *
     * @var Smarty
     */
    public $smarty = null;
    /**
     * Parent object
     *
     * @var Smarty|Smarty_Variable_Data|Smarty_Template
     */
    public $parent = null;
    /**
     * Context object
     *
     * @var Context
     */
    public $context = null;
    /**
     * Local variable scope
     *
     * @var Scope
     */
    public $_tpl_vars = null;
    /**
     * Declare the type template variable storage
     *
     * @internal
     * @var\Smarty::IS_DATA
     */
    public $_usage = Smarty::IS_TEMPLATE;
    /**
     * flag if class is from cache file
     *
     * @var boolean
     * @internal
     */
    public $is_cache = false;
    /**
     * flag if content does contain nocache code
     *
     * @var boolean
     * @internal
     */
    public $has_nocache_code = false;
    /**
     * saved cache lifetime
     *
     * @var int
     * @internal
     */
    public $cacheLifetime = 0;
    /**
     * names of cached subtemplates
     *
     * @var array
     * @internal
     */
    public $_cachedSubtemplates = array();
    /**
     * required plugins
     *
     * @var array
     * @internal
     */
    public $required_plugins = array();
    /**
     * required plugins of nocache code
     *
     * @var array
     * @internal
     */
    public $required_plugins_nocache = array();
    /**
     * template function properties
     *
     * @var array
     */
    public $tpl_obj_functions = array();
    /**
     * template functions called nocache
     *
     * @var array
     */
    public $called_nocache_template_functions = array();
    /**
     * file dependencies
     *
     * @var array
     */
    public $file_dependency = array();
    /**
     * Smarty version class was compiled with
     *
     * @var string
     * @internal
     */
    public $version = '';
    /**
     * flag if content is inheritance child
     *
     * @var bool
     */
    public $is_inheritance_child = false;
    /**
     * Timestamp
     *
     * @var integer
     */
    public $timestamp = null;
    /**
     * resource filepath
     *
     * @var string
     */
    public $filepath = null;
    /**
     * Template Compile Id (Smarty::$compileId)
     *
     * @var string
     */
    public $compileId = null;
    /**
     * Template Cache Id (Smarty::cacheId)
     *
     * @var string
     */
    public $cacheId = null;
    /**
     * Flag if caching enabled
     *
     * @var boolean
     */
    public $caching = false;
    /**
     * Array of template functions
     *
     * @var array
     */
    public $template_functions = array();
    /**
     * internal capture runtime stack
     *
     * @var array
     */
    public $_capture_stack = array(0 => array());
    /**
     * Variable scope type template executes in
     *
     * @var integer
     */
    public $scope_type = Smarty::SCOPE_LOCAL;

    /**
     * constructor
     *
     * @param Context $context
     */
    public function __construct(Context $context)
    {
        $this->smarty = $context->smarty;
        $this->context = $context;
        if (!$this->isValid) {
            // check if class is still valid
            if ($this->version != Smarty::SMARTY_VERSION) {
                // not valid because new Smarty version
                return false;
            }
            if ($this->is_cache && $context->caching === Smarty::CACHING_LIFETIME_SAVED && $context->cacheLifetime >= 0 && (time() > ($this->timestamp + $this->cacheLifetime))) {
                // saved lifetime expired
                return false;
            }

            if ((!$this->is_cache && $this->smarty->compileCheck) || ($this->is_cache && ($this->smarty->compileCheck === true || $this->smarty->compileCheck === Smarty::COMPILECHECK_ON)) && !empty($this->file_dependency)) {
                foreach ($this->file_dependency as $_file_to_check) {
                    if ($_file_to_check[2] == 'file' || $_file_to_check[2] == 'php') {
                        if ($this->context->filepath == $_file_to_check[0]) {
                            // do not recheck current template
                            continue;
                        } else {
                            // file and php types can be checked without loading the respective resource handlers
                            $mtime = @filemtime($_file_to_check[0]);
                        }
                    } elseif ($_file_to_check[2] == 'string' || $_file_to_check[2] == 'eval') {
                        continue;
                    } else {
                        $context = new Context($this->smarty, $_file_to_check[0], $_file_to_check[2]);
                        $mtime = $context->timestamp;
                    }
                    if (!$mtime || $mtime > $_file_to_check[1]) {
                        // not valid because newer dependent resource/file
                        return false;
                    }
                }
            }
            foreach ($this->required_plugins as $file => $call) {
                if (!is_callable($call)) {
                    include $file;
                }
            }
            $this->isValid = true;
        }
        if (!$this->is_cache) {
            //            if (!empty($this->template_functions) && isset($this->parent) && $this->parent->_usage ==\Smarty::IS_TEMPLATE) {
            //                $this->parent->template_function_chain = $this;
            //            }
            // TODO template function chain
            if (!empty($this->template_functions)) {
                $this->smarty->template_functions = array_merge($this->smarty->template_functions, $this->template_functions);
            }
        }
    }

    /**
     * get rendered template output from compiled template
     *
     * @param Context                $context
     * @param  Smarty_Template_Scope $_scope
     *
     * @throws Exception
     * @return string
     */
    public function _getRenderedTemplate(Context $context, $_scope = null)
    {
        // TODO
        //        $this->smarty->_cachedSubtemplates = array();
        $level = ob_get_level();
        try {
            // TODO must be removed --- load template object pointer for temmplate functions
            foreach ($this->template_functions as $name => $foo) {
                $context->smarty->template_functions[$name] = $this;
            }
            if ($_scope !== null) {
                // is subtemplate, so we can clone template scope
                $template_scope = clone $_scope;
                $template_scope->_tpl_vars = clone $template_scope->_tpl_vars;
            } else {
                $template_scope = new Scope($context);
            }
            $template_scope->parent = $context->parent;
            // fill data if present
            if ($context->data != null) {
                // set up variable values
                foreach ($context->data as $var => $value) {
                    if ($value instanceof Smarty_Variable) {
                        $template_scope->_tpl_vars->$var = $value;
                    } else {
                        $template_scope->_tpl_vars->$var = new Entry($value);
                    }
                }
            }
            // load template object pointer for temmplate functions
            foreach ($this->template_functions as $name => $foo) {
                $template_scope->template_functions[$name] = $this;
            }
            if ($this->smarty->debugging) {
                Smarty_Debug::start_render($this->context);
            }
            array_unshift($this->_capture_stack, array());
            self::$call_stack[] = array($this, $this->_tpl_vars, $this->parent, $this->scope_type);
            $this->_tpl_vars = $template_scope->_tpl_vars;
            $this->parent = $context->parent;
            $this->scope_type = $context->scope_type;
            if ($this->smarty->enableTrace && isset(Smarty::$_trace_callbacks['render:time:end'])) {
                $this->smarty->_triggerTraceCallback('render:time:start', array($this));
            }
            $output = $this->_renderTemplate($template_scope);
            if (!$context->no_output_filter && (isset($this->smarty->_autoloadFilters['output']) || isset($this->smarty->_registered['filter']['output']))) {
                $output = $this->smarty->runFilter('output', $output, $this);
            }
            if ($this->smarty->enableTrace && isset(Smarty::$_trace_callbacks['render:time:end'])) {
                $this->smarty->_triggerTraceCallback('render:time:end', array($this));
            }
            $restore = array_pop(self::$call_stack);
            $this->_tpl_vars = $restore[1];
            $this->parent = $restore[2];
            $this->scope_type = $restore[3];
            // TODO MUST BE CHANGED
            if ($_scope !== null) {
                $_scope->template_functions = $template_scope->template_functions;
            }
            // any unclosed {capture} tags ?
            if (isset($this->_capture_stack[0][0])) {
                throw new Smarty_Exception_CaptureError();
            }
            array_shift($this->_capture_stack);
        }
        catch (Exception $e) {
            while (ob_get_level() > $level) {
                ob_end_clean();
            }
            throw $e;
        }
        //        if ($this->context->recompiled && empty($this->file_dependency[$this->context->uid])) {
        //            $this->file_dependency[$this->context->uid] = array($this->context->filepath, $this->context->timestamp, $this->context->type);
        //        }
        // TODO
        //        if ($this->caching && isset(Smarty_Resource_Cache_Extension_Create::$creator[0])) {
        //            Smarty_Resource_Cache_Extension_Create::$creator[0]->_mergeFromCompiled($this);
        //        }
        if ($this->smarty->debugging) {
            Smarty_Debug::end_render($this->context);
        }

        return $output;
    }

    /**
     * Template runtime function to call a template function
     *
     * @param  string $name   name of template function
     * @param  Scope  $_scope
     * @param  array  $params array with calling parameter
     * @param  string $assign optional template variable for result
     *
     * @throws Smarty_Exception_Runtime
     * @return bool
     */
    public function _callTemplateFunction($name, Scope $_scope, $params, $assign)
    {
        if (isset($_scope->template_functions[$name])) {
            $template_object = $_scope->template_functions[$name];
            self::$call_stack[] = array($this, $this->_tpl_vars, $this->parent, $this->scope_type);
            $this->_tpl_vars = $_scope->_tpl_vars = clone $_scope->_tpl_vars;
            $this->scope_type = Smarty::SCOPE_LOCAL;
            foreach ($template_object->template_functions[$name]['parameter'] as $key => $value) {
                $this->_tpl_vars->$key = new Entry($value);
            }
            if (!empty($assign)) {
                ob_start();
            }
            $func_name = "_renderTemplateFunction_{$name}";
            $template_object->$func_name($_scope, $params);
            $restore = array_pop(self::$call_stack);
            $this->_tpl_vars = $_scope->_tpl_vars = $restore[1];
            $this->scope_type = $restore[3];
            if (!empty($assign)) {
                $this->_tpl_vars->$assign = ob_get_clean();
            }
            return false;
        }
        throw new Smarty_Exception_Runtime("Call to undefined template function '{$name}'");
    }

    /**
     * [util function] counts an array, arrayaccess/traversable or PDOStatement object
     *
     * @param  mixed $value
     *
     * @return int   the count for arrays and objects that implement countable, 1 for other objects that don't, and 0 for empty elements
     */
    public function _count($value)
    {
        if (is_array($value) === true || $value instanceof Countable) {
            return count($value);
        } elseif ($value instanceof IteratorAggregate) {
            // Note: getIterator() returns a Traversable, not an Iterator
            // thus rewind() and valid() methods may not be present
            return iterator_count($value->getIterator());
        } elseif ($value instanceof Iterator) {
            return iterator_count($value);
        } elseif ($value instanceof PDOStatement) {
            return $value->rowCount();
        } elseif ($value instanceof Traversable) {
            return iterator_count($value);
        } elseif ($value instanceof ArrayAccess) {
            if ($value->offsetExists(0)) {
                return 1;
            }
        } elseif (is_object($value)) {
            return count($value);
        }

        return 0;
    }

    /**
     * Template code runtime function to create a local Smarty variable for array assignments
     *
     * @param string $varname template variable name
     * @param bool   $nocache cache mode of variable
     * @param int    $scope_type
     */
    public function _createLocalArrayVariable($varname, $nocache = false, $scope_type = Smarty::SCOPE_LOCAL)
    {
        $_scope = ($scope_type == Smarty::SCOPE_GLOBAL) ? Smarty::$_global_tpl_vars : $this->_tpl_vars;

        if (isset($_scope->{$varname})) {
            $variable_obj = clone $_scope->{$varname};
            $variable_obj->nocache = $nocache;
            if (!(is_array($variable_obj->value) || $variable_obj->value instanceof ArrayAccess)) {
                settype($variable_obj->value, 'array');
            }
        } else {
            $variable_obj = new Entry(array(), $nocache);
        }
        $this->_assignInScope($varname, $variable_obj, $scope_type);
    }

    /**
     * Template code runtime function to get subtemplate content
     *
     * @param  string  $templateResource the resource handle of the template file
     * @param  mixed   $cacheId          cache id to be used with this template
     * @param  mixed   $compileId        compile id to be used with this template
     * @param  integer $caching          cache mode
     * @param  integer $cacheLifetime    life time of cache data
     * @param  array   $data             array with parameter template variables
     * @param  int     $scope_type       scope in which {include} should execute
     * @param  Scope   $_scope
     * @param  string  $content_class    optional name of inline content class
     *
     * @throws Smarty_Exception_SourceNotFound
     * @return string                template content
     */
    public function _getSubTemplate($templateResource, $cacheId, $compileId, $caching, $cacheLifetime, $data, $scope_type, $_scope, $content_class = null)
    {
        if ($this->smarty->caching && $caching && $caching != Smarty::CACHING_NOCACHE_CODE) {
            $this->smarty->_cachedSubtemplates[$templateResource] = array($templateResource, $cacheId, $compileId, $caching, $cacheLifetime);
        }
        //get source object from cache  or create new one
        $context = $this->smarty->_getContext($templateResource, $cacheId, $compileId, $this, false, false, $data, $scope_type, $caching, $cacheLifetime);
        // checks if source exists
        if (!$context->exists) {
            throw new Smarty_Exception_SourceNotFound($context->type, $context->name);
        }
        if ($caching == Smarty::CACHING_NOCACHE_CODE) {
            return Smarty_Resource_Cache_Extension_Create::$stack[0]->_renderCacheSubTemplate($context, true);
        }
        // get template object
        $template_obj = $this->smarty->_getTemplateObject(($caching) ? Smarty::CACHE : Smarty::COMPILED, $context, false, $content_class);
        //render template
        return $template_obj->_getRenderedTemplate($context, $_scope);
    }

    /**
     * [util function] to use either var_export or unserialize/serialize to generate code for the
     * cachevalue optionflag of {assign} tag
     *
     * @param  mixed $var Smarty variable value
     *
     * @throws Smarty_Exception
     * @return string           PHP inline code
     */
    public function _exportCacheValue($var)
    {
        if (is_int($var) || is_float($var) || is_bool($var) || is_string($var) || (is_array($var) && !is_object($var) && !array_reduce($var, array($this, '_checkAarrayCallback')))) {
            return var_export($var, true);
        }
        if (is_resource($var)) {
            throw new Smarty_Exception('Cannot serialize resource');
        }

        return 'unserialize(\'' . serialize($var) . '\')';
    }

    /**
     * Handle unknown class methods
     *  - try to Smarty methods
     *
     * @param  string $name unknown method-name
     * @param  array  $args argument array
     *
     * @return mixed    function results
     */
    public function __call($name, $args)
    {
        // method of Smarty object?
        if (method_exists($this->smarty, $name)) {
            return call_user_func_array(array($this->smarty, $name), $args);
        }
        // try new autoloaded Smarty methods
        return $this->_callExtension($this->smarty, $name, $args);
    }

    /**
     * callback used by _export_cache_value to check arrays recursively
     *
     * @param  bool  $flag    status of previous elements
     * @param  mixed $element array element to check
     *
     * @throws Smarty_Exception
     * @return bool             status
     */
    private function _checkArrayCallback($flag, $element)
    {
        if (is_resource($element)) {
            throw new Smarty_Exception('Cannot serialize resource');
        }
        $flag = $flag || is_object($element) || (!is_int($element) && !is_float($element) && !is_bool($element) && !is_string($element) && (is_array($element) && array_reduce($element, array($this, '_checkAarrayCallback'))));

        return $flag;
    }
}
