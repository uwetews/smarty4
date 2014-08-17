<?php
namespace Smarty\Resource\Cache\Extension;

use Smarty\Exception\Magic;

/**
 * Smarty Internal Plugin
 *
 * @package Smarty\Resource\Cache
 * @author  Uwe Tews
 */

/**
 * Cache Support Routines To Create Cache
 *
 * @package Smarty\Resource\Cache
 */
class Create extends Magic
{

    /**
     * nesting stack
     *
     * @var array Smarty_Cache_Helper_Create
     */
    public static $stack = array();
    /**
     * Code Object
     *
     * @var Smarty_Compiler_Code
     */
    public $template_code = null;
    /**
     * required plugins
     *
     * @var array
     * @internal
     */
    public $required_plugins = array();
    /**
     * template function properties
     *
     * @var array
     */
    public $template_functions = array();
    /**
     * template function properties
     *
     * @var array
     */
    public $template_functions_code = array();
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
     * file dependencies
     *
     * @var array
     */
    public $file_dependency = array();

    /*
     * Internal class to render new cached content
     *
     * @var Smarty_Template
     */
    /**
     * flag if cache does have nocache code
     *
     * @var boolean
     */
    public $has_nocache_code = false;

    /*
     * Cache Resource Object
     *
     * @var object
     */
    public $template_obj = null;

    /*
     * cache filepath
     *
     * @var string
     */
    public $cache_obj = null;

    // dummmy
    public $filepath = null;
    public $isValid;

    /**
     * @param null $cache_obj
     * @param null $filepath
     */
    public function __construct($cache_obj = null, $filepath = null)
    {
        $this->cache_obj = $cache_obj;
        $this->filepath = $filepath;
        array_unshift(self::$stack, $this);
    }

    /**
     * Find template object of cache file and return Smarty_template_Cached
     *
     * @param  Smarty $tpl_obj current template
     *
     * @return Smarty_template_Cached
     */
    public static function _getCachedObject($tpl_obj)
    {
        $_tpl = $tpl_obj;
        while ($_tpl->_usage == Smarty::IS_SMARTY_TPL_CLONE) {
            if (isset($_tpl->cached)) {
                break;
            }
            $_tpl = $_tpl->parent;
        }

        return $_tpl->cached;
    }

    public function destroy()
    {
        array_shift(self::$stack);
    }

    /**
     * @param  Context $context
     * @param  bool    $isSubtemplate call from subtemplate
     *
     * @return string   rendered template HTML output
     */
    public function _renderCacheSubTemplate(Context $context, $isSubtemplate = false)
    {
        // get template object
        $template_obj = $context->smarty->_getTemplateObject(Smarty::COMPILED, $context);
        //render template
        $_output = $template_obj->_getRenderedTemplate($context);
        // merge cache file properties
        $this->file_dependency = array_merge($this->file_dependency, $template_obj->file_dependency);
        $this->required_plugins = array_merge($this->required_plugins, $template_obj->required_plugins_nocache);
        // if not root template return output
        if ($isSubtemplate) {
            return $_output;
        }
        // write to cache when necessary
        if (!$context->handler->recompiled) {
            $this->_createCacheFile($context, $_output);
        }
        unset($_output);
    }

    /**
     * Create new cache file
     *
     * @param  Context $context
     * @param  string  $output cache file content
     *
     * @throws Exception
     * @return string
     */
    public function _createCacheFile(Context $context, $output)
    {
        if ($context->smarty->debugging) {
            Smarty_Debug::start_cache($context);
        }
        $this->template_code = new Smarty_Compiler_Code(3);
        // get text between non-cached items
        $cache_split = preg_split("!/\*%%SmartyNocache%%\*/(.+?)/\*/%%SmartyNocache%%\*/!s", $output);
        // get non-cached items
        preg_match_all("!/\*%%SmartyNocache%%\*/(.+?)/\*/%%SmartyNocache%%\*/!s", $output, $cache_parts);
        unset($output);
        // loop over items, stitch back together
        foreach ($cache_split as $curr_idx => $curr_split) {
            if (!empty($curr_split)) {
                $this->template_code->code("echo ")
                                    ->string($curr_split)
                                    ->raw(";\n");
            }
            if (isset($cache_parts[0][$curr_idx])) {
                $this->has_nocache_code = true;
                // format and add nocache PHP code
                $this->template_code->formatPHP($cache_parts[1][$curr_idx]);
            }
        }
        if (!$context->no_output_filter && !$this->has_nocache_code && (isset($context->smarty->_autoloadFilters['output']) || isset($context->smarty->_registered['filter']['output']))) {
            $this->template_code->precompiled = $context->smarty->runFilter('output', $this->template_code->precompiled, $this);
        }
        // write cache file content
        if (!$context->handler->recompiled && ($context->caching == Smarty::CACHING_LIFETIME_CURRENT || $context->caching == Smarty::CACHING_LIFETIME_SAVED)) {
            $this->template_code = $this->_createSmartyContentClass($context->smarty);
            $this->cache_obj->writeCache($context->smarty, $this->filepath, $this->template_code->precompiled);
            $this->template_code = null;
            if ($context->smarty->debugging) {
                Smarty_Debug::end_cache($context);
            }
            return false;

            // TODO Remove this
            try {
                $level = ob_get_level();
                $output = $cache_obj->template_obj->_renderTemplate($tpl_obj, $_scope);
            }
            catch (Exception $e) {
                while (ob_get_level() > $level) {
                    ob_end_clean();
                }
                throw $e;
            }
        }
        if ($context->smarty->debugging) {
            Smarty_Debug::start_cache($context);
        }

        return $this->template_code->precompiled;
    }

    /**
     * Create Smarty content class for cache files
     *
     * @param  Smarty $tpl_obj template object
     *
     * @return string
     */
    public function _createSmartyContentClass(Smarty $tpl_obj)
    {
        $template_code = new Smarty_Compiler_Code();
        $template_code->code("<?php /* Smarty version " . Smarty::SMARTY_VERSION . ", created on " . strftime("%Y-%m-%d %H:%M:%S") . " */")
                      ->newline();
        // content class name
        $class = $parser->compiler->getUniqueTemplateClassName();
        $template_code->code("if (!class_exists('{$class}',false)) {")
                      ->newline()
                      ->indent();
        $template_code->code("class {$class} extends Smarty_Template" . (!empty($this->inheritance_blocks_code) ? "_Inheritance" : '') . " {")
                      ->newline()
                      ->indent();
        $template_code->code("public \$version = '" . Smarty::SMARTY_VERSION . "';")
                      ->newline();
        $template_code->code("public \$has_nocache_code = " . ($this->has_nocache_code ? 'true' : 'false') . ";")
                      ->newline();
        $template_code->code("public \$filepath = '{$this->filepath}';")
                      ->newline();
        $template_code->code("public \$timestamp = " . time() . ";")
                      ->newline();
        if (!empty($tpl_obj->_cachedSubtemplates)) {
            $template_code->code("public \$_cachedSubtemplates = ")
                          ->repr($tpl_obj->_cachedSubtemplates, false)
                          ->raw(";")
                          ->newline();
        }
        $template_code->code("public \$is_cache = true;")
                      ->newline();
        $template_code->code("public \$cacheLifetime = {$tpl_obj->cacheLifetime};")
                      ->newline();
        $template_code->code("public \$file_dependency = ")
                      ->repr($this->file_dependency, false)
                      ->raw(";")
                      ->newline();
        if (!empty($this->required_plugins)) {
            $template_code->code("public \$required_plugins = ")
                          ->repr($this->required_plugins, false)
                          ->raw(";")
                          ->newline();
        }
        if (!empty($this->template_functions)) {
            $template_code->code("public \$template_functions = ")
                          ->repr($this->template_functions, false)
                          ->raw(";")
                          ->newline();
        }
        $this->template_functions = array();
        if (!empty($this->inheritance_blocks)) {
            $template_code->code("public \$inheritance_blocks = ")
                          ->repr($this->inheritance_blocks, false)
                          ->raw(';')
                          ->newline();
        }
        $template_code->newline()
                      ->code("function _renderTemplate (\$_scope) {")
                      ->newline()
                      ->indent();
        $template_code->code("ob_start();")
                      ->newline();
        $template_code->mergeCode($this->template_code);
        $template_code->code('return ob_get_clean();')
                      ->newline();
        $template_code->outdent()
                      ->code('}')
                      ->newline()
                      ->newline();
        foreach ($this->template_functions_code as $code) {
            $template_code->newline()
                          ->raw($code);
        }
        $this->template_functions_code = array();
        foreach ($this->inheritance_blocks_code as $code) {
            $template_code->newline()
                          ->raw($code);
        }

        $template_code->code("function _getSourceInfo () {")
                      ->newline()
                      ->indent();
        $template_code->code("return ")
                      ->repr($template_code->traceback)
                      ->raw(";")
                      ->newline();
        $template_code->outdent()
                      ->code('}')
                      ->newline();

        $template_code->outdent()
                      ->code('}')
                      ->newline();
        $template_code->outdent()
                      ->code('}')
                      ->newline();
        $template_code->code("\$template_class_name = '{$class}';")
                      ->newline();

        return $template_code;
    }

    /**
     * Merge plugin info, dependencies and nocache template functions into cache
     *
     * @param Smarty_Compiled_Resource $comp_obj compiled object
     */
    public function _mergeFromCompiled($comp_obj)
    {
        $this->required_plugins = array_merge($this->required_plugins, $comp_obj->template_obj->required_plugins_nocache);
        $this->file_dependency = array_merge($this->file_dependency, $comp_obj->template_obj->file_dependency);
        $this->has_nocache_code = $this->has_nocache_code || $comp_obj->template_obj->has_nocache_code;

        if (!empty($comp_obj->template_obj->called_nocache_template_functions)) {
            foreach ($comp_obj->template_obj->called_nocache_template_functions as $name => $dummy) {
                self::_mergeNocacheTemplateFunction($tpl_obj, $name);
            }
        }
    }

    /**
     * Merge plugin info, dependencies and nocache template functions into cache
     *
     * @param Smarty $template current template
     * @param string $name     name of template function
     *
     * @return bool
     */
    public function _mergeNocacheTemplateFunction($template, $name)
    {
        if (isset($this->template_functions[$name])) {
            return false;
        }
        $ptr = $tpl = $template;
        while ($ptr != null && !isset($ptr->compiled->template_obj->template_functions[$name])) {
            $ptr = $ptr->template_function_chain;
            if ($ptr == null && ($tpl->parent->_usage == Smarty::IS_SMARTY_TPL_CLONE || $tpl->parent->_usage == Smarty::IS_CONFIG)) {
                $ptr = $tpl = $tpl->parent;
            }
        }
        if (isset($ptr->compiled->template_obj->template_functions[$name])) {
            if (isset($ptr->compiled->template_obj->template_functions[$name]['used_plugins'])) {
                foreach ($ptr->compiled->template_obj->template_functions[$name]['used_plugins'] as $key => $function) {
                    $this->required_plugins[$key] = $function;
                }
            }
            $this->template_code = new Smarty_Compiler_Code(3);
            $this->template_functions[$name] = $ptr->compiled->template_obj->template_functions[$name];
            $obj = new ReflectionObject($ptr->compiled->template_obj);
            $refFunc = $obj->getMethod("_renderTemplateFunction_{$name}");
            $file = $refFunc->getFileName();
            $start = $refFunc->getStartLine() - 1;
            $end = $refFunc->getEndLine();
            $source = file($file);
            for ($i = $start; $i < $end; $i ++) {
                if (preg_match("!/\*%%SmartyNocache%%\*/!", $source[$i])) {
                    $this->template_code->formatPHP(stripcslashes(preg_replace("!echo\s(\"|')/\*%%SmartyNocache%%\*/|/\*/%%SmartyNocache%%\*/(\"|');!", '', $source[$i])));
                } else {
                    $this->template_code->precompiled .= $source[$i];
                }
            }
            $this->template_functions_code[$name] = $this->template_code->precompiled;
            $this->template_code = null;
            if (isset($ptr->compiled->template_obj->template_functions[$name]['called_functions'])) {
                foreach ($ptr->compiled->template_obj->template_functions[$name]['called_functions'] as $name => $dummy) {
                    $this->_mergeNocacheTemplateFunction($template, $name);
                }
            }
        }
    }

    /**
     * Creates an inheritance block in cache file
     *
     * @param  object $current_tpl calling template
     * @param  string $name        name of block
     * @param  object $scope_tpl   blocks must be processed in this variable scope
     *
     * @return string
     */
    // TODO has to be finished
    public function _createNocacheBlockChild($current_tpl, $name, $scope_tpl)
    {
        while ($current_tpl !== null && $current_tpl->_usage == Smarty::IS_SMARTY_TPL_CLONE) {
            if (isset($current_tpl->compiled->template_obj->inheritance_blocks[$name]['valid'])) {
                if (isset($current_tpl->compiled->template_obj->inheritance_blocks[$name]['hide'])) {
                    break;
                }
                if (isset($current_tpl->compiled->template_obj->inheritance_blocks[$name]['inc_child'])) {
                    $parent_tpl = $current_tpl;
                }
                if (isset($current_tpl->compiled->template_obj->inheritance_blocks[$name]['overwrite'])) {
                    $parent_tpl = null;
                }
                // back link pointers to inheritance parent template
                $template_stack[] = $current_tpl;
            }
            if ($status == 0 && ($current_tpl->is_inheritance_child || $current_tpl->compiled->template_obj->is_inheritance_child)) {
                $status = 1;
            }
            $current_tpl = $current_tpl->parent;
            if ($current_tpl === null || $current_tpl->_usage != Smarty::IS_SMARTY_TPL_CLONE || ($status == 1 && !$current_tpl->is_inheritance_child && !$current_tpl->compiled->template_obj->is_inheritance_child)) {
                // quit at first child of current inheritance chain
                break;
            }
        }
    }

    /**
     * Creates an inheritance block in cache file
     *
     * @param  object $current_tpl calling template
     * @param  string $name        name of block
     * @param  object $scope_tpl   blocks must be processed in this variable scope
     *
     * @return string
     */
    public function _createNocacheInheritanceBlock($current_tpl, $name, $scope_tpl)
    {
        $output = '';
        $status = 0;
        $child_tpl = null;
        $parent_tpl = null;
        $template_stack = array();
        while ($current_tpl !== null && $current_tpl->_usage == Smarty::IS_SMARTY_TPL_CLONE) {
            if (isset($current_tpl->compiled->template_obj->inheritance_blocks[$name]['valid'])) {
                if (isset($current_tpl->compiled->template_obj->inheritance_blocks[$name]['hide'])) {
                    break;
                }
                $child_tpl = $current_tpl;
                if (isset($current_tpl->compiled->template_obj->inheritance_blocks[$name]['inc_child'])) {
                    $parent_tpl = $current_tpl;
                }
                if (isset($current_tpl->compiled->template_obj->inheritance_blocks[$name]['overwrite'])) {
                    $parent_tpl = null;
                }
                // back link pointers to inheritance parent template
                $template_stack[] = $current_tpl;
            }
            if ($status == 0 && ($current_tpl->is_inheritance_child || $current_tpl->compiled->template_obj->is_inheritance_child)) {
                $status = 1;
            }
            $current_tpl = $current_tpl->parent;
            if ($current_tpl === null || $current_tpl->_usage != Smarty::IS_SMARTY_TPL_CLONE || ($status == 1 && !$current_tpl->is_inheritance_child && !$current_tpl->compiled->template_obj->is_inheritance_child)) {
                // quit at first child of current inheritance chain
                break;
            }
        }

        if ($parent_tpl != null) {
            $child_tpl = $parent_tpl;
        }
        if ($child_tpl !== null) {
            $template_obj = $child_tpl->compiled->template_obj;

            if (isset($template_obj->inheritance_blocks[$name]['subblock'])) {
                foreach ($template_obj->inheritance_blocks[$name]['subblock'] as $subblock) {
                    $function = $template_obj->inheritance_blocks[$subblock]['function'];
                    $this->inheritance_blocks_code[$function] = $this->_getInheritanceBlockMethodSource($template_obj, $function);
                    $this->inheritance_blocks[$subblock]['function'] = $function;
                }
            }

            $function = $template_obj->inheritance_blocks[$name]['function'];
            $this->inheritance_blocks_code[$function] = $this->_getInheritanceBlockMethodSource($template_obj, $function);
            $this->inheritance_blocks[$name]['function'] = $function;
            $output = "/*%%SmartyNocache%%*/echo \$this->_getInheritanceBlock(\$_smarty_tpl, '{$name}', \$_smarty_tpl, 2);/*/%%SmartyNocache%%*/";
            if (isset($child_tpl->compiled->template_obj->inheritance_blocks[$name]['prepend'])) {
                $output .= $child_tpl->compiled->template_obj->_getInheritanceParentBlock($name, $template_stack, $scope_tpl);
            } elseif (isset($child_tpl->compiled->template_obj->inheritance_blocks[$name]['append'])) {
                $output = $child_tpl->compiled->template_obj->_getInheritanceParentBlock($name, $template_stack, $scope_tpl) . $output;
            }
        }

        return $output;
    }

    /**
     * Get block method source
     *
     * @param  object $template_obj Smarty content object
     * @param  string $function     method name of block
     *
     * @return string source code
     */
    public function _getInheritanceBlockMethodSource($template_obj, $function)
    {
        $template_code = new Smarty_Compiler_Code(3);
        $obj = new ReflectionObject($template_obj);
        $refFunc = $obj->getMethod($function);
        $file = $refFunc->getFileName();
        $start = $refFunc->getStartLine() - 1;
        $end = $refFunc->getEndLine();
        $source = file($file);
        for ($i = $start; $i < $end; $i ++) {
            if (preg_match("!/\*%%SmartyNocache%%\*/!", $source[$i])) {
                $template_code->formatPHP(stripcslashes(preg_replace("!echo\s(\"|')/\*%%SmartyNocache%%\*/|/\*/%%SmartyNocache%%\*/(\"|');!", '', $source[$i])));
            } else {
                $template_code->precompiled .= $source[$i];
            }
        }

        return $template_code->precompiled;
    }
}
