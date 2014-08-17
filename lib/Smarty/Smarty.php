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
use Smarty\Template\Context;
Use Smarty\Variable;

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
     * loaded API or internal methods
     *
     * @internal
     * @var array
     */
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
    /**
     * joined template directory string used in cache keys
     *
     * @var string
     * @internal
     */
    public $_joined_template_dir = './templates/';
    /**
     * force template compiling?
     *
     * @var boolean
     * @link http://www.smarty.net/docs/en/variable.force.compile.tpl
     */
    public $forceCompile = false;
    /**
     * check template for modifications?
     *
     * @var int
     * @link http://www.smarty.net/docs/en/variable.compile.check.tpl
     * @uses COMPILECHECK_OFF as possible value
     * @uses COMPILECHECK_ON as possible value
     * @uses COMPILECHECK_CACHEMISS as possible value
     */
    public $compileCheck = self::COMPILECHECK_ON;
    /**
     * developer mode
     *
     * @var bool
     */
    public $developer_mode = false;

    /*     * #@+
    * security
    */
    /**
     * enable trace back callback
     *
     * @var bool
     */
    public $enableTrace = false;
    /**
     * use sub dirs for compiled/cached files?
     *
     * @var boolean
     * @link http://www.smarty.net/docs/en/variable.use.sub.dirs.tpl
     */
    public $useSubDirs = false;

    /*     * #@- */
    /**
     * allow ambiguous resources (that are made unique by the resource handler)
     *
     * @var boolean
     */
    public $allowAmbiguousResources = false;
    public $caching = self::CACHING_OFF;
    /**
     * cache lifetime in seconds
     *
     * @var integer
     * @link http://www.smarty.net/docs/en/variable.cache.lifetime.tpl
     */
    public $cacheLifetime = 3600;

    /*     * #@+
    * config var settings
    */

    /*     * #@- */
    /**
     * force cache file creation
     *
     * @var boolean
     * @link http://www.smarty.net/docs/en/variable.force.cache.tpl
     */
    public $forceCache = false;
    /**
     * Set this if you want different sets of cache files for the same
     * templates.
     *
     * @var string
     * @link http://www.smarty.net/docs/en/variable.cache.id.tpl
     */
    public $cacheId = null;
    /**
     * Set this if you want different sets of compiled files for the same
     * templates.
     *
     * @var string
     * @link http://www.smarty.net/docs/en/variable.compile.id.tpl
     */
    public $compileId = null;
    /**
     * implementation of security class
     *
     * @var Smarty_Security
     * @see  Smarty_Security
     * @link <missing>
     */
    public $securityPolicy = null;
    /**
     * When set, smarty uses this value as error_reporting-level.
     *
     * @var integer
     * @link http://www.smarty.net/docs/en/variable.error.reporting.tpl
     */
    public $errorReporting = null;
    /**
     * debug mode
     * Setting this to true enables the debug-console.
     *
     * @var boolean
     * @link http://www.smarty.net/docs/en/variable.debugging.tpl
     */
    public $debugging = false;
    /**
     * This determines if debugging is enable-able from the browser.
     * <ul>
     *  <li>NONE => no debugging control allowed</li>
     *  <li>URL => enable debugging when SMARTY_DEBUG is found in the URL.</li>
     * </ul>
     *
     * @var string
     * @link http://www.smarty.net/docs/en/variable.debugging.ctrl.tpl
     */
    public $debuggingCtrl = 'NONE';
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
    /**
     * default resource type
     *
     * @var string
     * @link http://www.smarty.net/docs/en/variable.default.resource.type.tpl
     */
    public $defaultResourceType = 'file';
    /**
     * caching type
     * Must be an element of $cache_resource_types.
     *
     * @var string
     * @link http://www.smarty.net/docs/en/variable.caching.type.tpl
     */
    public $cachingType = 'file';
    /**
     * compiled type
     * Must be an element of $cache_resource_types.
     *
     * @var string
     * @link http://www.smarty.net/docs/en/variable.caching.type.tpl
     */
    public $compiledType = 'file';

    /*     * #@- */

    /*     * #@+
    * template properties
    */
    /**
     * internal config properties
     *
     * @var array
     * @internal
     */
    public $properties = array();
    /**
     * check If-Modified-Since headers
     *
     * @var boolean
     * @link http://www.smarty.net/docs/en/variable.cache.modified.check.tpl
     */
    public $cacheModifiedCheck = false;
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
     * autoescape variable output
     *
     * @var boolean
     * @link http://www.smarty.net/docs/en/variable.escape.html.tpl
     */
    public $escapeHtml = false;
    /**
     * start time for execution time calculation
     *
     * @var integer
     * @internal
     */
    public $_startTime = 0;
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
     * Template resource
     *
     * @var string
     * @internal
     */
    public $templateResource = null;
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
     * internal flag to allow relative path in child template blocks
     *
     * @var boolean
     * @internal
     */
    public $allowRelativePath = false;
    /**
     * internal flag to allow object caching
     *
     * @var boolean
     * @internal
     */
    public $objectCaching = true;
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
    public $smartyConfig = null;
    public $_filePerms = 0644;
    public $_dirPerms = 0771;
    public $compile_locking = false;
    public $disableCorePlugins = false;
    /** #@+
     * variables
     */

    private $_template_dir = array(0 => './templates/');
    /**
     * config directory
     *
     * @var array
     * @internal
     * @link http://www.smarty.net/docs/en/variable.fooobar.tpl
     */
    private $_config_dir = array(0 => './configs/');
    /**
     * compile directory
     *
     * @var string
     * @internal
     * @link http://www.smarty.net/docs/en/variable.compile.dir.tpl
     */
    private $_compile_dir = './templates_c/';
    /**
     * compile directory
     *
     * @var string
     * @internal
     * @link http://www.smarty.net/docs/en/variable.compile.dir.tpl
     */
    private $_parser_dir = './parser_c/';
    /**
     * plugins directory
     *
     * @var array
     * @internal
     * @link http://www.smarty.net/docs/en/variable.plugins.dir.tpl
     */
    private $_plugins_dir = array();
    /**
     * cache directory
     *
     * @var string
     * @internal
     * @link http://www.smarty.net/docs/en/variable.cache.dir.tpl
     */
    private $_cache_dir = './cache/';
    /*     * #@- */

    /**
     * Initialize new Smarty object

     */
    public function __construct($config = null)
    {
        if ($config == null) {
            $config = dirname(__FILE__) . '/SmartyConfig.xml';
        }
        if (!$this->smartyConfig = simplexml_load_file($config)) {
            trigger_error('Error reading XML file', E_USER_ERROR);
        }
        // create variable scope for Smarty root
        $this->_tpl_vars = new Variable\Scope();
        self::$_global_tpl_vars = new \stdClass;
        // PHP options
        if (is_callable('mb_internal_encoding')) {
            mb_internal_encoding(self::$_CHARSET);
            self:: $_MBSTRING = true;
        }
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
        if ($template === null && ($this->_usage == self::IS_SMARTY_TPL_CLONE || $this->_usage == self::IS_CONFIG)) {
            $template = $this;
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

        if (isset($tpl_obj->error_reporting) && $tpl_obj->_fetchNestingLevel == 0) {
            $_smarty_old_error_level = error_reporting($tpl_obj->error_reporting);
        }
        $tpl_obj->_fetchNestingLevel ++;
        // check URL debugging control
        if (!$tpl_obj->debugging && $tpl_obj->debugging_ctrl == 'URL') {
            Smarty_Debug::checkURLDebug($tpl_obj);
        }

        if ($context->caching == self::CACHING_LIFETIME_CURRENT || $context->caching == self::CACHING_LIFETIME_SAVED) {
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
        if (isset($tpl_obj->error_reporting) && $tpl_obj->_fetchNestingLevel == 0) {
            error_reporting($_smarty_old_error_level);
        }

        // display or fetch
        if ($display) {
            if ($tpl_obj->caching && $tpl_obj->cacheModifiedCheck) {
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
            if ($tpl_obj->debugging) {
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
        } else {
            $context_obj = null;
            $_cacheKey = null;
            $parent = isset($parent) ? $parent : $this->parent;
            if ($resource == null) {
                $resource = $this->templateResource;
            }
            if ($this->objectCaching || $cache_context) {
                if (!($this->allowAmbiguousResources || isset($this->handler_allowRelativePath))) {
                    $_cacheKey = $this->_joined_template_dir . '#' . $resource;
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
                        $type = $this->defaultResourceType;
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
                if ($context_obj == null && $this->allowAmbiguousResources) {
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
                        $type = $this->defaultResourceType;
                        $name = $resource;
                    } else {
                        $type = $parts[0];
                        $name = $parts[1];
                    }
                }
                $context_obj = new Context($this, $name, $type, $parent);
                if (($this->objectCaching || $cache_context) && isset($_cacheKey)) {
                    self::$_context_cache[$_cacheKey] = $context_obj;
                }
            }
        }
        //        $context_obj = clone $context_obj;
        // set up parameter for this call
        if ($cache_context) {
            $context_obj->forceCaching = true;
        }
        $context_obj->caching = $caching ? $caching : $context_obj->smarty->caching;
        $context_obj->compileId = isset($compileId) ? $compileId : $context_obj->smarty->compileId;
        $context_obj->cacheId = isset($cacheId) ? $cacheId : $context_obj->smarty->cacheId;
        $context_obj->cacheLifetime = isset($cacheLifetime) ? $cacheLifetime : $context_obj->smarty->cacheLifetime;
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
        $do_cache = $context->forceCaching && !$nocache;
        if ($context->handler->recompiled && $resource_group == self::CACHE) {
            // we can't render from cache
            $resource_group = self::COMPILED;
        }
        if ($resource_group != self::SOURCE) {
            if ($do_cache) {
                $key = $context->_key . '#' . (isset($context->compileId) ? $context->compileId : '') . '#' . (($context->caching) ? 1 : 0);
            }
            if ($resource_group == self::COMPILED) {
                if ($context->handler->recompiled) {
                    $compiledType = 'recompiled';
                } else {
                    $compiledType = $context->smarty->compiledType;
                }
                if ($this->objectCaching && !$nocache && isset(self::$_compiled_object_cache[$key])) {
                    return self::$_compiled_object_cache[$key];
                }
                if ($tpl_class_name != null) {
                    $template_obj = new $tpl_class_name($context);
                } else {
                    // get compiled resource object
                    $res_obj = isset(self::$_resource_cache[self::COMPILED][$compiledType]) ? self::$_resource_cache[self::COMPILED][$compiledType] : $this->_loadResource(self::COMPILED, $compiledType);
                    $template_obj = $res_obj->instanceTemplate($context);
                }
                if ($this->objectCaching && !$nocache) {
                    self::$_compiled_object_cache[$key] = $template_obj;
                }
                return $template_obj;
            }
            if ($resource_group == self::CACHE) {
                $cachingType = $this->cachingType;
                if ($do_cache) {
                    $key .= '#' . isset($context->cacheId) ? $context->cacheId : '';
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
     * Add template directory(s)
     *
     * @api
     *
     * @param  string|array $template_dir directory(s) of template sources
     * @param  string       $key          of the array element to assign the template dir to
     *
     * @return Smarty       current Smarty instance for chaining
     */
    public function addTemplateDir($template_dir, $key = null)
    {
        $this->_addDir($template_dir, $key, '_template_dir');
        return $this;
    }

    /**
     * Add  directory(s)
     *
     * @internal
     *
     * @param  string|array $dir     directory(s)
     * @param  string       $key     of the array element to assign the dir to
     * @param  string       $dirprop name of directory property
     * @param bool          $do_join true if joined directory property must be updated
     *
     * @return bool
     */
    private function _addDir($dir, $key = null, $dirprop, $do_join = true)
    {
        // make sure we're dealing with an array
        $this->$dirprop = (array) $this->$dirprop;

        if (is_array($dir)) {
            foreach ($dir as $k => $v) {
                if (is_int($k)) {
                    // indexes are not merged but appended
                    $this->{$dirprop}[] = $this->_checkDir($v);
                } else {
                    // string indexes are overridden
                    $this->{$dirprop}[$k] = $this->_checkDir($v);
                }
            }
        } elseif ($key !== null) {
            // override directory at specified index
            $this->{$dirprop}[$key] = $this->_checkDir($dir);
        } else {
            // append new directory
            $this->{$dirprop}[] = $this->_checkDir($dir);
        }
        if ($do_join) {
            $joined = '_joined' . $dirprop;
            $this->$joined = join(DIRECTORY_SEPARATOR, $this->$dirprop);
        }
        return false;
    }

    /**
     *  function to check directory path
     *
     * @internal
     *
     * @param  string $path directory
     *
     * @return string           trimmed filepath
     */
    private function _checkDir($path)
    {
        return preg_replace('#(\w+)(/|\\\\){1,}#', '$1$2', rtrim($path, '/\\')) . '/';
    }

    /**
     * Get template directories
     *
     * @api
     *
     * @param  mixed $index of directory to get, null to get all
     *
     * @return array|string list of template directories, or directory of $index
     */
    public function getTemplateDir($index = null)
    {
        if ($index !== null) {
            return isset($this->_template_dir[$index]) ? $this->_template_dir[$index] : null;
        }

        return (array) $this->_template_dir;
    }

    /**
     * Set template directory
     *
     * @api
     *
     * @param  string|array $template_dir directory(s) of template sources
     *
     * @return Smarty       current Smarty instance for chaining
     */
    public function setTemplateDir($template_dir)
    {
        $this->_setDir($template_dir, '_template_dir');
        return $this;
    }

    /**
     * Set  directory
     *
     * @internal
     *
     * @param  string|array $dir     directory(s) of  sources
     * @param  string       $dirprop name of directory property
     * @param bool          $do_join true if joined directory property must be updated
     */
    private function _setDir($dir, $dirprop, $do_join = true)
    {
        $this->$dirprop = array();
        foreach ((array) $dir as $k => $v) {
            $this->{$dirprop}[$k] = $this->_checkDir($v);
        }
        if ($do_join) {
            $joined = '_joined' . $dirprop;
            $this->$joined = join(DIRECTORY_SEPARATOR, $this->$dirprop);
        }
    }

    /**
     * Add config directory(s)
     *
     * @api
     *
     * @param  string|array $config_dir directory(s) of config sources
     * @param  string       $key        of the array element to assign the config dir to
     *
     * @return Smarty       current Smarty instance for chaining
     */
    public function addConfigDir($config_dir, $key = null)
    {
        $this->_addDir($config_dir, $key, '_config_dir', false);
        return $this;
    }

    /**
     * Get config directory
     *
     * @api
     *
     * @param  mixed $index of directory to get, null to get all
     *
     * @return array|string configuration directory
     */
    public function getConfigDir($index = null)
    {
        if ($index !== null) {
            return isset($this->_config_dir
                [$index]) ? $this->_config_dir
            [$index] : null;
        }

        return (array) $this->_config_dir;
    }

    /**
     * Set config directory
     *
     * @api
     *
     * @param  array|string $config_dir directory(s) of configuration sources
     *
     * @return Smarty       current Smarty instance for chaining
     */
    public function setConfigDir($config_dir)
    {
        $this->_setDir($config_dir, '_config_dir', false);
        return $this;
    }

    /**
     * Adds directory of plugin files
     *
     * @api
     *
     * @param  string|array $plugins_dir plugin folder names
     *
     * @return Smarty       current Smarty instance for chaining
     */
    public function addPluginsDir($plugins_dir)
    {
        $this->_addDir($plugins_dir, null, '_plugins_dir', false);
        $this->_plugins_dir = array_unique($this->_plugins_dir);
        return $this;
    }

    /**
     * Get plugin directories
     *
     * @api
     * @return array list of plugin directories
     */
    public function getPluginsDir()
    {
        return (array) $this->_plugins_dir;
    }

    /**
     * Set plugins directory
     *
     * @api
     *
     * @param  string|array $plugins_dir directory(s) of plugins
     *
     * @return Smarty       current Smarty instance for chaining
     */
    public function setPluginsDir($plugins_dir)
    {
        $this->_setDir($plugins_dir, '_plugins_dir', false);
        return $this;
    }

    /**
     * Get compiled directory
     *
     * @api
     * @return string path to compiled templates
     */
    public function getCompileDir()
    {
        return $this->_compile_dir;
    }

    /**
     * Set compile directory
     *
     * @api
     *
     * @param  string $compile_dir directory to store compiled templates in
     *
     * @return Smarty current Smarty instance for chaining
     */
    public function setCompileDir($compile_dir)
    {
        $this->_setMutedDir($compile_dir, '_compile_dir');
        return $this;
    }

    /**
     * Set  muted directory
     *
     * @internal
     *
     * @param  string $dir     directory
     * @param  string $dirprop name of directory property
     *
     * @return bool
     */
    private function _setMutedDir($dir, $dirprop)
    {
        $this->$dirprop = $this->_checkDir($dir);
        if (!isset(self::$_muted_directories[$this->$dirprop])) {
            self::$_muted_directories[$this->$dirprop] = null;
        }

        return false;
    }

    /**
     * Get compiled parser directory
     *
     * @api
     * @return string path to compiled parser
     */
    public function getParserDir()
    {
        return $this->_parser_dir;
    }

    /**
     * Set compiled parser directory
     *
     * @api
     *
     * @param  string $parser_dir directory to store cached templates in
     *
     * @return Smarty current Smarty instance for chaining
     */
    public function setParserDir($parser_dir)
    {
        $this->_parser_dir = $this->_checkDir($parser_dir);
        return $this->_parser_dir;
    }

    /**
     * Get cache directory
     *
     * @api
     * @return string path of cache directory
     */
    public function getCacheDir()
    {
        return $this->_cache_dir;
    }

    /**
     * Set cache directory
     *
     * @api
     *
     * @param  string $cache_dir directory to store cached templates in
     *
     * @return Smarty current Smarty instance for chaining
     */
    public function setCacheDir($cache_dir)
    {
        $this->_setMutedDir($cache_dir, '_cache_dir');
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
        static $getter = array(
            'templateDir' => 'getTemplateDir',
            'configDir'   => 'getConfigDir',
            'pluginsDir'  => 'getPluginsDir',
            'compileDir'  => 'getCompileDir',
            'cacheDir'    => 'getCacheDir',
        );
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
        switch ($property) {
            case 'templateDir':
            case 'configDir':
            case 'pluginsDir':
            case 'compileDir':
            case 'cacheDir':
                return $this->{$getter[$property]}();
        }
        if (property_exists($this, $property) || $this->getConfigProperty($property)) {
            return $this->$property;
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
        static $setter = array(
            'templateDir' => 'setTemplateDir',
            'configDir'   => 'setConfigDir',
            'pluginsDir'  => 'setPluginsDir',
            'compileDir'  => 'setCompileDir',
            'cacheDir'    => 'setCacheDir',
        );

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
            case 'templateDir':
            case 'configDir':
            case 'pluginsDir':
            case 'compileDir':
            case 'cacheDir':
                $this->{$setter[$property]}($value);
                return false;
            case 'source':
            case 'compiled':
            case 'cached':
                $this->$property = $value;
                return false;
        }

        $this->$property = $value;
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

    public function getConfigProperty($property)
    {
        if (isset($this->smartyConfig->properties->$property)) {
            $result = (string) $this->smartyConfig->properties->$property;
            if ($result == 'true') {
                $result = true;
            } elseif ($result == 'false') {
                $result = false;
            }
            $this->$property = $result;
            return true;
        }
        return false;
    }

    /**
     * Converts a simpleXML element into an array. Preserves attributes.<br/>
     * You can choose to get your elements either flattened, or stored in a custom
     * index that you define.<br/>
     * For example, for a given element
     * <code>
     * <field name="someName" type="someType"/>
     * </code>
     * <br>
     * if you choose to flatten attributes, you would get:
     * <code>
     * $array['field']['name'] = 'someName';
     * $array['field']['type'] = 'someType';
     * </code>
     * If you choose not to flatten, you get:
     * <code>
     * $array['field']['@attributes']['name'] = 'someName';
     * </code>
     * <br>__________________________________________________________<br>
     * Repeating fields are stored in indexed arrays. so for a markup such as:
     * <code>
     * <parent>
     *     <child>a</child>
     *     <child>b</child>
     *     <child>c</child>
     * ...
     * </code>
     * you array would be:
     * <code>
     * $array['parent']['child'][0] = 'a';
     * $array['parent']['child'][1] = 'b';
     * ...And so on.
     * </code>
     *
     * @param simpleXMLElement $xml               the XML to convert
     * @param boolean|string   $attributesKey     if you pass TRUE, all values will be
     *                                            stored under an '@attributes' index.
     *                                            Note that you can also pass a string
     *                                            to change the default index.<br/>
     *                                            defaults to null.
     * @param boolean|string   $childrenKey       if you pass TRUE, all values will be
     *                                            stored under an '@children' index.
     *                                            Note that you can also pass a string
     *                                            to change the default index.<br/>
     *                                            defaults to null.
     * @param boolean|string   $valueKey          if you pass TRUE, all values will be
     *                                            stored under an '@values' index. Note
     *                                            that you can also pass a string to
     *                                            change the default index.<br/>
     *                                            defaults to null.
     *
     * @return array the resulting array.
     */
    function simpleXMLToArray(\SimpleXMLElement $xml, $attributesKey = null, $childrenKey = null, $valueKey = null)
    {

        if ($childrenKey && !is_string($childrenKey)) {
            $childrenKey = '@children';
        }
        if ($attributesKey && !is_string($attributesKey)) {
            $attributesKey = '@attributes';
        }
        if ($valueKey && !is_string($valueKey)) {
            $valueKey = '@values';
        }

        $return = array();
        $name = $xml->getName();
        $_value = trim((string) $xml);
        if (!strlen($_value)) {
            $_value = null;
        };

        if ($_value !== null) {
            if ($valueKey) {
                $return[$valueKey] = $_value;
            } else {
                $return = $_value;
            }
        }

        $children = array();
        $first = true;
        foreach ($xml->children() as $elementName => $child) {
            $value = $this->simpleXMLToArray($child, $attributesKey, $childrenKey, $valueKey);
            if (isset($children[$elementName])) {
                if (is_array($children[$elementName])) {
                    if ($first) {
                        $temp = $children[$elementName];
                        unset($children[$elementName]);
                        $children[$elementName][] = $temp;
                        $first = false;
                    }
                    $children[$elementName][] = $value;
                } else {
                    $children[$elementName] = array($children[$elementName], $value);
                }
            } else {
                $children[$elementName] = $value;
            }
        }
        if ($children) {
            if ($childrenKey) {
                $return[$childrenKey] = $children;
            } else {
                $return = array_merge($return, $children);
            }
        }

        $attributes = array();
        foreach ($xml->attributes() as $name => $value) {
            $attributes[$name] = trim($value);
        }
        if ($attributes) {
            if ($attributesKey) {
                $return[$attributesKey] = $attributes;
            } else {
                $return = array_merge((array) $return, $attributes);
            }
        }

        return $return;
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

