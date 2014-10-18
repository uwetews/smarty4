<?php

/**
 * Project:     Smarty: the PHP compiling template engine
 * File:        Smarty.class.php
 * SVN:         $Id: Smarty.class.php 4745 2013-06-17 18:27:16Z Uwe.Tews@googlemail.com $
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 * For questions, help, comments, discussion, etc., please join the
 * Smarty mailing list. Send a blank e-mail to
 * smarty-discussion-subscribe@googlegroups.com
 *
 * @link      http://www.smarty.net/
 * @copyright 2008 New Digital Group, Inc.
 * @author    Monte Ohrt <monte at ohrt dot com>
 * @author    Uwe Tews
 * @author    Rodney Rehm
 * @package   Smarty
 * @version   3.2-DEV
 */

use Smarty\Exception\Magic;
use Smarty\Context;
Use Smarty\Variable;
use Smarty\Config;
/**
 * This is the main Smarty class
 *
 * @package Smarty
 */
class Smarty extends Variable\Methods
{
    /*     * #@+
    * constant definitions
    */

    /**
     * smarty version
     */
    const SMARTY_VERSION = 'Smarty 4.0-DEV';

    /**
     * define scopes for variable assignments
     */
    const SCOPE_LOCAL = 0;
    /**
     *
     */
    const SCOPE_PARENT = 1;
    const SCOPE_ROOT = 2;
    const SCOPE_GLOBAL = 3;
    const SCOPE_SMARTY = 4;
    const SCOPE_NONE = 5;

    /**
     * define object and variable scope type
     */
    const IS_SMARTY = 0;
    const IS_SMARTY_TPL_CLONE = 1;
    const IS_TEMPLATE = 2;
    const IS_DATA = 3;
    const IS_CONFIG = 4;

    /**
     * define caching modes
     */
    const CACHING_OFF = 0;
    const CACHING_LIFETIME_CURRENT = 1;
    const CACHING_LIFETIME_SAVED = 2;
    const CACHING_NOCACHE_CODE = 3; // create nocache code but no cache file

    /**
     * define constant for clearing cache files be saved expiration datees
     */
    const CLEAR_EXPIRED = - 1;

    /**
     * define compile check modes
     */
    const COMPILECHECK_OFF = 0;
    const COMPILECHECK_ON = 1;
    const COMPILECHECK_CACHEMISS = 2;

    /**
     * modes for handling of "<?php ... ?>" tags in templates.
     */
    const PHP_PASSTHRU = 0; //-> print tags as plain text
    const PHP_QUOTE = 1; //-> escape tags as entities
    const PHP_REMOVE = 2; //-> escape tags as entities
    const PHP_ALLOW = 3; //-> escape tags as entities
    /**
     * filter types
     */
    const FILTER_POST = 'post';
    const FILTER_PRE = 'pre';
    const FILTER_OUTPUT = 'output';
    const FILTER_VARIABLE = 'variable';
    /**
     * plugin types
     */
    const PLUGIN_FUNCTION = 'function';
    const PLUGIN_BLOCK = 'block';
    const PLUGIN_COMPILER = 'compiler';
    const PLUGIN_MODIFIER = 'modifier';
    const PLUGIN_MODIFIERCOMPILER = 'modifiercompiler';
    /**
     * unassigend template variable handling
     */
    const UNASSIGNED_IGNORE = 0;
    const UNASSIGNED_NOTICE = 1;
    const UNASSIGNED_EXCEPTION = 2;

    /**
     * define resource group
     */
    const SOURCE = 0;
    const COMPILED = 1;
    const CACHE = 2;

    /*     * #@- */
    /**
     * assigned global tpl vars
     *
     * @internal
     * @var stdClass
     */
    public static $_global_tpl_vars = null;
    /**
     * Flag denoting if Multibyte String functions are available
     *
     * @internal
     * @var bool
     */
    public static $_MBSTRING = false;
    /**
     * The character set to adhere to (e.g. "UTF-8")
     *
     * @var string
     */
    public static $_CHARSET = "UTF-8";
    /**
     * The date format to be used internally
     * (accepts date() and strftime())
     *
     * @var string
     */
    public static $_DATE_FORMAT = '%b %e, %Y';
    /**
     * Flag denoting if PCRE should run in UTF-8 mode
     *
     * @internal
     * @var string
     */
    public static $_UTF8_MODIFIER = 'u';
    /**
     * Folder of Smarty build in plugins
     *
     * @internal
     * @var string
     */
    public static $_SMARTY_PLUGINS_DIR = '';
    /**
     * global internal smarty vars
     *
     * @var array
     */
    public static $_smartyVars = array();
    /**
     * error handler returned by set_error_hanlder() in self::muteExpectedErrors()
     *
     * @internal
     */
    public static $_previous_error_handler = null;
    /**
     * contains directories outside of SMARTY_DIR that are to be muted by muteExpectedErrors()
     *
     * @internal
     * @var array
     */
    public static $_muted_directories = array('./templates_c/' => null, './cache/' => null);
    /**
     * contains trace callbacks to invoke on events
     *
     * @internal
     * @var array
     */
    public static $_trace_callbacks = array();
    /**
     * resource handler cache
     *
     * @var array
     * @internal
     */
    public static $_resource_cache = array();
    /**
     * context cache
     *
     * @var array
     * @internal
     */
    public static $_context_cache = array();
    /**
     * compiled object cache
     *
     * @var array
     */
    public static $_compiled_object_cache = array();
    /**
     * cached object cache
     *
     * @var array
     */
    public static $_cached_object_cache = array();

    /**
     * System wide array with all registered extensions
     *
     * @var array
     */
    public static $allExtensions = array();

    /**
     * Array with loaded shared extension objects
     *
     * @var array
     */
    public static $sharedExtensions = array();
    public static $_autoloaded = array();
    public static $_resource_class_prefix = array(
        self::SOURCE   => 'Smarty\Resource\Source\\',
        self::COMPILED => 'Smarty\Resource\Compiled\\',
        self::CACHE    => 'Smarty\Resource\Cache\\'
    );
    static $_set_get_prefixes = array('set' => true, 'get' => true);
    static $_in_extension = array('setAutoloadFilters'  => true, 'getAutoloadFilters' => true,
                                  'setDefaultModifiers' => true, 'getDefaultModifiers' => true, 'getGlobal' => true,
                                  'setDebugTemplate'    => true, 'getDebugTemplate' => true, 'getCachedVars' => true,
                                  'getConfigVars'       => true, 'getTemplateVars' => true, 'getVariable' => true,);
    static $_extension_prefix = array('Smarty_Internal_', 'Smarty_Variable_Internal_', 'Smarty_Method_', 'Smarty_Variable_Method_');
    static $_resolved_property_name = array();
    /**
     * assigned template vars
     *
     * @internal
     * @var Scope
     */
    public $_tpl_vars = null;

    /*
    * caching enabled
    * @var integer
    * @link http://www.smarty.net/docs/en/variable.caching.tpl
    * @uses CACHING_OFF as possible value
    * @uses CACHING_LIFETIME_CURRENT as possible value
    * @uses CACHING_LIFETIME_SAVED as possible value
    */
    /**
     * Declare the type template variable storage
     *
     * @internal
     * @var self::IS_SMARTY | IS_SMARTY_TPL_CLONE
     */
    public $_usage = self::IS_SMARTY;


    /*     * #@+
    * config var settings
    */

    /*     * #@- */
   /**
     * implementation of security class
     *
     * @var Smarty_Security
     * @see  Smarty_Security
     * @link <missing>
     */
    public $securityPolicy = null;
      /**
     * Counter for nested calls of fetch() and isCached()
     *
     * @internal
     * @var int
     */
    public $_fetchNestingLevel = 0;
    /**
     * global template functions
     *
     * @var array
     * @internal
     */
    public $_templateFunctions = array();

    /*     * #@- */

    /*     * #@+
    * template properties
    */
   /**
     * autoload filter
     *
     * @var array
     * @link http://www.smarty.net/docs/en/variable.autoload.filters.tpl
     */
    public $_autoloadFilters = array();
    /**
     * default modifier
     *
     * @var array
     * @link http://www.smarty.net/docs/en/variable.default.modifiers.tpl
     */
    public $_defaultModifier = array();
     /**
     * start time for execution time calculation
     *
     * @var integer
     * @internal
     */
    public $_startTime = 0;
    public $useSubDirs   = true;
    /**
     * required by the compiler for BC
     *
     * @var string
     * @internal
     */
    public $_current_file = null;
    /**
     * individually cached subtemplates
     *
     * @var array
     */
    public $_cachedSubtemplates = array();
     /**
     * root template of hierarchy
     *
     * @var Smarty
     */
    public $_rootTemplate = null;
    /**
     * variable filters
     *
     * @var array
     * @internal
     */
    public $_variableFilters = array();
    /**
     * $compiletime_params
     * value is computed of the compiletime options relevant for config files
     *      $config_read_hidden
     *      $config_booleanize
     *      $config_overwrite
     *
     * @var int
     */
    public $compiletime_params = 0;
    /**
     * registered items of the following types:
     *  - 'resource'
     *  - 'plugin'
     *  - 'object'
     *  - 'class'
     *  - 'modifier'
     *
     * @var array
     * @internal
     */
    public $_registered = array();
   /**
     * @var array
     */
    static $baseDir = '';
    public $context = null;
    /**
     * @var Config|null
     */
    public $configObj = null;
    public $_templateResource = null;
    /*     * #@- */

    /**
     * Initialize new Smarty object

     */
    public function __construct($userConfigXml = false)
    {
        $this->configObj =  new Config($userConfigXml, $this);
        self::$baseDir = __DIR__ . '/';
        // create variable scope for Smarty root
        $this->_tpl_vars = new Variable\Scope();
        self::$_global_tpl_vars = new \stdClass;
        $this->_startTime = microtime(true);
        // set default dirs
        if (empty(self::$_SMARTY_PLUGINS_DIR)) {
            self::$_SMARTY_PLUGINS_DIR = dirname(__FILE__) . '/Plugins/';
        }

        if (isset($_SERVER['SCRIPT_NAME'])) {
            $this->assignGlobal('SCRIPT_NAME', $_SERVER['SCRIPT_NAME']);
        }
    }

    /**
     * Enable error handler to mute expected messages
     *
     * @api
     * @return void
     */
    public static function muteExpectedErrors()
    {
        $error_handler = array('Smarty_Method_MutingErrorHandler', 'mutingErrorHandler');
        $previous = set_error_handler($error_handler);

        // avoid dead loops
        if ($previous !== $error_handler) {
            self::$_previous_error_handler = $previous;
        }
    }

    /**
     * Disable error handler muting expected messages
     *
     * @api
     * @return void
     */
    public static function unmuteExpectedErrors()
    {
        restore_error_handler();
    }

    public function setTemplateResource ($templateResource) {
        $this->_templateResource = $templateResource;
    }
    public function getTemplateResource () {
        return $this->_templateResource;
    }
    /**
     * displays a Smarty template
     *
     * @api
     *
     * @param string $template  the resource handle of the template file or template object
     * @param mixed  $cacheId   cache id to be used with this template
     * @param mixed  $compileId compile id to be used with this template
     * @param object $parent    next higher level of Smarty variables
     */
    public function display($template = null, $cacheId = null, $compileId = null, $parent = null)
    {
        // display template
        $this->fetch($template, $cacheId, $compileId, $parent, true);
    }

    /**
     * fetches a rendered Smarty template
     *
     * @api
     *
     * @param  string   $template         the resource handle of the template file or template object
     * @param  mixed    $cacheId          cache id to be used with this template
     * @param  mixed    $compileId        compile id to be used with this template
     * @param  Smarty   $parent           next higher level of Smarty variables
     * @param  bool     $display          true: display, false: fetch
     * @param  bool     $no_output_filter if true do not run output filter
     * @param  null     $data
     * @param  int      $scope_type
     * @param  null     $caching
     * @param  null|int $cacheLifetime
     *
     * @throws Smarty_Exception
     * @throws Smarty_Exception_Runtime
     * @return string   rendered template HTML output
     */

    public function fetch($template = null, $cacheId = null, $compileId = null, $parent = null, $display = false, $no_output_filter = false, $data = null, $scope_type = self::SCOPE_LOCAL, $caching = null, $cacheLifetime = null)
    {
        if ($template === null) {
            $template = $this->getTemplateResource();
            if ($template === null) {
                //TODO error
            }
        }
        if (!empty($cacheId) && is_object($cacheId)) {
            $parent = $cacheId;
            $cacheId = null;
        }
        if ($parent === null && !is_object($template)) {
            $parent = $this;
        }
        //get context object from cache  or create new one
        $context = $this->_getContext($template, $cacheId, $compileId, $parent, false, $no_output_filter, $data, $scope_type, $caching, $cacheLifetime);
        // checks if source exists
        if (!$context->exists) {
            throw new Smarty_Exception_SourceNotFound($context->type, $context->name);
        }
        $tpl_obj = $context->smarty;

        if ($errorReporting = $context->getProperty('errorReporting') && $tpl_obj->_fetchNestingLevel == 0) {
            $_smarty_old_error_level = error_reporting($errorReporting);
        }
        $tpl_obj->_fetchNestingLevel ++;
        // check URL debugging control
        if (!($debugging = $context->getProperty('debugging')) && $context->getProperty('debuggingCtrl') == 'URL') {
            Smarty_Debug::checkURLDebug($tpl_obj);
        }

        if ($caching = $context->getProperty('caching') == self::CACHING_LIFETIME_CURRENT || $caching == self::CACHING_LIFETIME_SAVED) {
            $browser_cache_valid = false;
            // get template object
            $template_obj = $this->_getTemplateObject(self::CACHE, $context);
            //render template
            $_output = $template_obj->_getRenderedTemplate($context);
            if ($_output === true) {
                $browser_cache_valid = true;
            }
        } else {
            $template_obj = $this->_getTemplateObject(self::COMPILED, $context);
            //render template
            $_output = $template_obj->_getRenderedTemplate($context);
        }
        $tpl_obj->_fetchNestingLevel --;
        if ($errorReporting && $tpl_obj->_fetchNestingLevel == 0) {
            error_reporting($_smarty_old_error_level);
        }

        // display or fetch
        if ($display) {
            if ($caching && $context->getProperty('cacheModifiedCheck')) {
                if (!$browser_cache_valid) {
                    switch (PHP_SAPI) {
                        case 'cli':
                            if ( /* ^phpunit */
                            !empty($_SERVER['SMARTY_PHPUNIT_DISABLE_HEADERS']) /* phpunit$ */
                            ) {
                                $_SERVER['SMARTY_PHPUNIT_HEADERS'][] = 'Last-Modified: ' . gmdate('D, d M Y H:i:s', $tpl_obj->cached->timestamp) . ' GMT';
                            }
                            break;

                        default:
                            header('Last-Modified: ' . gmdate('D, d M Y H:i:s', time()) . ' GMT');
                            break;
                    }
                    echo $_output;
                }
            } else {
                echo $_output;
            }
            // debug output
            if ($debugging) {
                Smarty_Debug::display_debug($context);
            }

            return false;
        } else {
            // return output on fetch
            return $_output;
        }
    }

    /**
     * Get context object from cache or create new one
     * then populate it with current data
     *
     * @internal
     *
     * @param  null | string                                     $resource         template resource name
     * @param  mixed                                             $cacheId          cache id to be used with this template
     * @param  mixed                                             $compileId        compile id to be used with this template
     * @param  Smarty|Smarty_Variable_Data|Smarty_Template_Class $parent           next higher level of Smarty variables
     * @param  bool                                              $cache_context    if true force caching of context block (need for isCached() calls
     * @param  bool                                              $no_output_filter if true do not run output filter
     * @param  null                                              $data
     * @param  int                                               $scope_type
     * @param  null                                              $caching
     * @param  null|int                                          $cacheLifetime
     *
     * @return Context
     */
    public function _getContext($resource, $cacheId = null, $compileId = null, $parent = null, $cache_context = false, $no_output_filter = false, $data = null, $scope_type = self::SCOPE_LOCAL, $caching = null, $cacheLifetime = null)
    {
        if (is_object($resource)) {
            // get source from template clone
            $context_obj = clone $resource->source;
            $context_obj->smarty = $resource;
            $context_obj->configObj = clone $resource->configObj;
        } else {
            $context_obj = null;
            $_cacheKey = null;
            $parent = isset($parent) ? $parent : $this->parent;
            if ($resource == null) {
                $resource = $this->getTemplateResource();
            }
            if ($this->configObj->getProperty('objectCaching')|| $cache_context) {
                if (!($this->configObj->getProperty('allowAmbiguousResources') || isset($this->handler_allowRelativePath))) {
                    $_cacheKey = $this->configObj->getProperty('_joined_templateDir') . '#' . $resource;
                    if (isset($_cacheKey[150])) {
                        $_cacheKey = sha1($_cacheKey);
                    }
                    // source with this $_cacheKey in cache?
                    $context_obj = isset(self::$_context_cache[$_cacheKey]) ? self::$_context_cache[$_cacheKey] : null;
                }
                if ($context_obj == null && isset($this->handler_allowRelativePath)) {
                    // parse templateResource into name and type
                    $parts = explode(':', $resource, 2);
                    if (!isset($parts[1]) || !isset($parts[0][1])) {
                        // no resource given, use default
                        // or single character before the colon is not a resource type, but part of the filepath
                        $type = $this->configObj->getProperty('defaultResourceType');
                        $name = $resource;
                    } else {
                        $type = $parts[0];
                        $name = $parts[1];
                    }
                    $res_obj = isset(self::$_resource_cache[self::SOURCE][$type]) ? self::$_resource_cache[self::SOURCE][$type] : $this->_loadResource(self::SOURCE, $type);
                    if (isset($res_obj->_allowRelativePath) && $_cacheKey = $res_obj->getRelativeKey($resource, $parent)) {
                        if (isset($_cacheKey[150])) {
                            $_cacheKey = sha1($_cacheKey);
                        }
                        // source with this $_cacheKey in cache?
                        $context_obj = isset(self::$_context_cache[$_cacheKey]) ? self::$_context_cache[$_cacheKey] : null;
                    }
                }
                if ($context_obj == null && $this->configObj->getProperty('allowAmbiguousResources')) {
                    // get cacheKey
                    $_cacheKey = self::$_resource_cache[self::SOURCE][$type]->buildUniqueResourceName($this, $resource);
                    if (isset($_cacheKey[150])) {
                        $_cacheKey = sha1($_cacheKey);
                    }
                    // source with this $_cacheKey in cache?
                    $context_obj = isset(self::$_context_cache[$_cacheKey]) ? self::$_context_cache[$_cacheKey] : null;
                }
            }
            if ($context_obj == null) {
                if (!isset($name)) {
                    // parse templateResource into name and type
                    $parts = explode(':', $resource, 2);
                    if (!isset($parts[1]) || !isset($parts[0][1])) {
                        // no resource given, use default
                        // or single character before the colon is not a resource type, but part of the filepath
                        $type = $this->configObj->getProperty('defaultResourceType');
                        $name = $resource;
                    } else {
                        $type = $parts[0];
                        $name = $parts[1];
                    }
                }
                $context_obj = new Context($this, $name, $type, $parent);
                if (($context_obj->getProperty('objectCaching') || $cache_context) && isset($_cacheKey)) {
                    self::$_context_cache[$_cacheKey] = $context_obj;
                }
            }
        }
        //        $context_obj = clone $context_obj;
        // set up parameter for this call
        if ($cache_context) {
            $context_obj->setSaveProperty('forceCaching', true);
        }
        if ($caching){
            $context_obj->setSaveProperty('caching', $caching);
        }
        if ($compileId){
            $context_obj->setSaveProperty('compileId', $compileId);
        }
        if ($cacheId){
            $context_obj->setSaveProperty('cacheId', $cacheId);
        }
        if ($cacheLifetime){
            $context_obj->setSaveProperty('cacheLifetime', $cacheLifetime);
        }
        $context_obj->parent = isset($parent) ? $parent : $context_obj->smarty->parent;
        $context_obj->no_output_filter = $no_output_filter;
        $context_obj->data = $data;
        $context_obj->scope_type = $scope_type;
        return $context_obj;
    }

    /**
     *  Get handler and create resource object
     *
     * @param  int    $resource_group SOURCE|COMPILED|CACHE
     * @param  string $type           resource handler type
     *
     * @throws Smarty_Exception
     * @return Smarty_Resource_xxx | false
     */
    public function _loadResource($resource_group, $type)
    {

        // resource group and type already in cache
        if (isset(self::$_resource_cache[$resource_group][$type])) {
            // return the handler
            return self::$_resource_cache[$resource_group][$type];
        }

        $type = strtolower($type);
        $res_obj = null;

        if (!$res_obj) {
            $resource_class = self::$_resource_class_prefix[$resource_group] . ucfirst($type);
            if (isset($this->_registered['resource'][$resource_group][$type])) {
                // TODO  true?
                if (true || $this->_registered['resource'][$resource_group][$type] instanceof $resource_class) {
                    $res_obj = $this->_registered['resource'][$resource_group][$type][0];
                } else {
                    $res_obj = new Smarty_Resource_Source_Registered();
                }
            } elseif (class_exists($resource_class, true)) {
                $res_obj = new $resource_class();
            } elseif ($this->_loadPlugin($resource_class)) {
                if (class_exists($resource_class, false)) {
                    $res_obj = new $resource_class();
                } elseif ($resource_group == self::SOURCE) {
                    /**
                     * @TODO  This must be rewritten
                     */
                    $this->registerResource($type, array(
                        "smarty_resource_{$type}_source",
                        "smarty_resource_{$type}_timestamp",
                        "smarty_resource_{$type}_secure",
                        "smarty_resource_{$type}_trusted"
                    ));

                    // give it another try, now that the resource is registered properly
                    $res_obj = $this->_loadResource($resource_group, $type);
                }
            } elseif ($resource_group == self::SOURCE) {

                // try streams
                $_known_stream = stream_get_wrappers();
                if (in_array($type, $_known_stream)) {
                    // is known stream
                    if (is_object($this->securityPolicy)) {
                        $this->securityPolicy->isTrustedStream($type);
                    }
                    $res_obj = new Smarty_Resource_Source_Stream();
                }
            }
        }

        if ($res_obj) {
            self::$_resource_cache[$resource_group][$type] = $res_obj;
            return $res_obj;
        }

        // TODO: try default_(template|config)_handler
        // give up
        throw new Smarty_Exception_UnknownResourceType(self::$_resource_class_prefix[$resource_group], $type);
    }

    /**
     * @internal
     *
     * @param  int     $resource_group SOURCE|COMPILED|CACHE
     * @param  Context $context        context object
     * @param bool     $nocache        flag that template object shall not be cached
     * @param string   $tpl_class_name class name if inline template class
     *
     * @return Smarty_Template_Class  template object
     */
    public function _getTemplateObject($resource_group, Context $context, $nocache = false, $tpl_class_name = null)
    {
        $nocache = $nocache || $context->_usage == self::IS_CONFIG;
        $do_cache = $context->getProperty('forceCaching') && !$nocache;
        if ($context->handler->recompiled && $resource_group == self::CACHE) {
            // we can't render from cache
            $resource_group = self::COMPILED;
        }
        if ($resource_group != self::SOURCE) {
            if ($do_cache) {
                $key = $context->_key . '#' . (($compileId = $context->getProperty('compileId')) ? $compileId : '') . '#' . (($context->getProperty('caching')) ? 1 : 0);
            }
            if ($resource_group == self::COMPILED) {
                if ($context->handler->recompiled) {
                    $compiledType = 'recompiled';
                } else {
                    $compiledType = $context->getProperty('defaultCompiledType');
                }
                if ($objectCaching = $context->getProperty('objectCaching') && !$nocache && isset(self::$_compiled_object_cache[$key])) {
                    return self::$_compiled_object_cache[$key];
                }
                if ($tpl_class_name != null) {
                    $template_obj = new $tpl_class_name($context);
                } else {
                    // get compiled resource object
                    $res_obj = isset(self::$_resource_cache[self::COMPILED][$compiledType]) ? self::$_resource_cache[self::COMPILED][$compiledType] : $this->_loadResource(self::COMPILED, $compiledType);
                    $template_obj = $res_obj->instanceTemplate($context);
                }
                if ($objectCaching && !$nocache) {
                    self::$_compiled_object_cache[$key] = $template_obj;
                }
                return $template_obj;
            }
            if ($resource_group == self::CACHE) {
                $cachingType =  $context->getProperty('defaultCacheType');
                if ($do_cache) {
                    $key .= '#' . (($cacheId = $context->getProperty('cacheId')) ? $cacheId : '');
                    if (isset(self::$_cached_object_cache[$key])) {
                        return self::$_cached_object_cache[$key];
                    }
                }
                // get cached resource object
                $res_obj = isset(self::$_resource_cache[self::CACHE][$cachingType]) ? self::$_resource_cache[self::CACHE][$cachingType] : $this->_loadResource(self::CACHE, $cachingType);
                $template_obj = $res_obj->instanceTemplate($context);
                if ($do_cache) {
                    self::$_cached_object_cache[$key] = $template_obj;
                }
                return $template_obj;
            }
        }
    }

    /**
     * Loads security class and enables security
     *
     * @api
     *
     * @param  string|Smarty_Security $securityClass if a string is used, it must be class-name
     *
     * @return Smarty                 current Smarty instance for chaining
     * @throws Smarty_Exception       when an invalid class name is provided
     */
    public function enableSecurity($securityClass = null)
    {
        Smarty_Security::enableSecurity($this, $securityClass);

        return $this;
    }

    /**
     * Disable security
     *
     * @api
     * @return Smarty current Smarty instance for chaining
     */
    public function disableSecurity()
    {
        $this->securityPolicy = null;

        return $this;
    }

    /**
     * @internal
     *
     * @param string $event string event
     * @param mixed  $data
     */
    public function _triggerTraceCallback($event, $data = array())
    {
        if ($this->enableTrace && isset(self::$_trace_callbacks[$event])) {
            foreach (self::$_trace_callbacks[$event] as $callback) {
                call_user_func_array($callback, (array) $data);
            }
        }
    }

    /**
     * <<magic>> method
     * remove resource source
     * remove extensions
     */
    public function __clone()
    {
        unset($this->source);
        unset($this->compiled);
        unset($this->cached);
    }

    /**
     * Handle unknown class methods
     *  - load extensions for external methods
     *  - call generic getter/setter
     *
     * @param  string $name unknown method-name
     * @param  array  $args argument array
     *
     * @throws Smarty_Exception
     * @return mixed    function results
     */
    public function __call($name, $args)
    {
        if  (isset($this->extensions[$name])) {
        }
        if (isset(\Smarty\Config::$propertyMethod[$name])) {
            return call_user_func_array(\Smarty\Config::$propertyMethod[$name], $args);
        }
        // try autoloaded methods
        if (isset(self::$_autoloaded[$name])) {
            array_unshift($args, $this);
            return call_user_func_array(array(self::$_autoloaded[$name], $name), $args);
        }
        if ($name[0] != '_' && !isset(self::$_in_extension[$name])) {
            // see if this is a set/get for a property
            $first3 = strtolower(substr($name, 0, 3));
            if (isset(self::$_set_get_prefixes[$first3]) && isset($name[3]) && $name[3] !== '_') {
                if (isset(self::$_resolved_property_name[$name])) {
                    $property = self::$_resolved_property_name[$name];
                } else {
                    // try to keep case correct for future PHP 6.0 case-sensitive class methods
                    // lcfirst() not available < PHP 5.3.0, so improvise
                    $property = strtolower(substr($name, 3, 1)) . substr($name, 4);
                    // convert camel case to underscored name
                    //$property = preg_replace_callback('/([A-Z])/', array($this, 'replaceCamelcase'), $property);
                    self::$_resolved_property_name[$name] = $property;
                }
                if ($first3 == 'get') {
                    if (property_exists($this, $property)) {
                        return $this->$property;
                    }
                } else {
                    if (property_exists($this, $property)) {
                        return $this->$property = $args[0];
                    }
                }
            }
        }
        // try new autoloaded Smarty methods
        return $this->_callExtension($this, $name, $args);
    }

    /**
     * Class destructor
     */
    public function __destruct()
    {
        if ($this->_usage == self::IS_SMARTY_TPL_CLONE && $this->cache_locking && isset($this->cached) && $this->cached->is_locked) {
            $this->cached->releaseLock($this, $this->cached);
        }
        //parent::__destruct();
    }

    /**
     * <<magic>> Generic getter.
     * Get Smarty property
     *
     * @param  string $property_name property name
     *
     * @throws Smarty_Exception
     * @return mixed
     */
    public function __get($property_name)
    {
         if (false !== strpos($property_name, '_') && $property_name[0] != '_') {
            $arr = explode('_', $property_name);
            $property = '';
            foreach ($arr as $string) {
                $property .= ucfirst($string);
            }
            $property = lcfirst($property);
        } else {
            $property = $property_name;
        }
        switch ($property) {
            case 'compiled':
                return $this->resourceStatus(self::COMPILED);
            case 'cached':
                return $this->resourceStatus(self::CACHE);
            case 'mustCompile':
                return !$this->isCompiled();
        }

        $value = $this->configObj->getProperty($property);
        If ($value !== null)  {
            return $value;
        }
        // throw error through parent
        return parent::__get($property);
    }

    /**
     * <<magic>> Generic setter.
     * Set Smarty property
     *
     * @param  string $property_name property name
     * @param  mixed  $value         value
     *
     * @return bool|void
     * @throws Smarty_Exception
     */
    public function __set($property_name, $value)
    {

        if (false !== strpos($property_name, '_') && $property_name[0] != '_') {
            $arr = explode('_', $property_name);
            $property = '';
            foreach ($arr as $string) {
                $property .= ucfirst($string);
            }
            $property = lcfirst($property);
        } else {
            $property = $property_name;
        }
        switch ($property) {
            case 'source':
            case 'compiled':
            case 'cached':
                $this->$property = $value;
                return false;
        }
        $this->configObj->setProperty($property, $value);
    }

    /**
     * Load API or internal method dynamicly if not in memory.
     * If loaded call it
     *
     * @param Smarty | Smarty_Template_Class | Smarty_Variable_Data $caller     calling object
     * @param string                                                $name       method name
     * @param array                                                 $args       parameter array
     * @param int                                                   $var_method set to 1 when only variable methods shall be loaded
     *
     * @return mixed
     */
    public function _callExtension($caller, $name, $args, $var_method = 0)
    {
        if (!isset(self::$_autoloaded[$name])) {
            if ($name[0] == '_') {
                $postfix = ucfirst(substr($name, 1));
                $offset = 0 + $var_method;
            } else {
                $postfix = ucfirst($name);
                $offset = 2 + $var_method;
            }
            for ($i = $offset; $i < 2 + $offset; $i ++) {
                $class = self::$_extension_prefix[$i] . $postfix;
                if (class_exists($class, true)) {
                    $obj = new $class();
                    self::$_autoloaded[$name] = $obj;
                    array_unshift($args, $caller);
                    return call_user_func_array(array($obj, $name), $args);
                }
            }
            // throw error through parent
            Magic::__call($name, $args);
        } else {
            array_unshift($args, $caller);
            return call_user_func_array(array(self::$_autoloaded[$name], $name), $args);
        }
    }


    /**
     * preg_replace callback to convert camelcase getter/setter to underscore property names
     *
     * @param  string $match match string
     *
     * @return string replacemant
     */
    private function replaceCamelcase($match)
    {
        return "_" . strtolower($match[1]);
    }
}

