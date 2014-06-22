<?php

/**
 * Smarty Internal Plugin Compile Compiler Plugin
 * Compiles code of a compiler plugin
 *
 * @package Compiler
 * @author  Uwe Tews
 */

/**
 * Smarty Internal Plugin Compile Compiler Plugin Class
 *
 * @package Compiler
 */
class Smarty_Compiler_Php_NodeCompiler_Internal_PluginCompiler extends \Smarty_Compiler_Php_NodeCompiler_Tag
{

    /**
     * Attribute definition: Overwrites base class.
     *
     * @var array
     * @see $tpl_obj
     */
    public $required_attributes = array();

    /**
     * Attribute definition: Overwrites base class.
     *
     * @var array
     * @see $tpl_obj
     */
    public $optional_attributes = array('_any');

    /**
     * Compiles code for the execution of function plugin
     *
     * @param  array  $args      array with attributes from parser
     * @param  object $compiler  compiler object
     * @param  array  $parameter array with compilation parameter
     * @param  string $tag       name of function plugin
     * @param  string $function  PHP function name
     *
     * @return string compiled code
     */
    public function compile($args, $compiler, $parameter, $tag, $function)
    {
        // This tag does create output
        $compiler->has_output = true;

        // check and get attributes
        $_attr = $this->getAttributes($compiler, $args);
        if ($_attr['nocache'] === true) {
            $compiler->tag_nocache = true;
        }
        // convert arguments format for old compiler plugins
        $new_args = array();
        foreach ($args as $key => $mixed) {
            if (is_array($mixed)) {
                $new_args = array_merge($new_args, $mixed);
            } else {
                $new_args[$key] = $mixed;
            }
        }

        $plugin = 'smarty_compiler_' . $tag;
        if (isset($compiler->context->smarty->_registered['plugin'][Smarty::PLUGIN_COMPILER][$tag]) || isset($compiler->default_handler_plugins[Smarty::PLUGIN_COMPILER][$tag])) {
            if (isset($compiler->context->smarty->_registered['plugin'][Smarty::PLUGIN_COMPILER][$tag])) {
                if (!$compiler->context->smarty->_registered['plugin'][Smarty::PLUGIN_COMPILER][$tag][1]) {
                    $this->tag_nocache = true;
                }
                $function = $compiler->context->smarty->_registered['plugin'][Smarty::PLUGIN_COMPILER][$tag][0];
            } else {
                if (!$compiler->default_handler_plugins[Smarty::PLUGIN_COMPILER][$tag][1]) {
                    $this->tag_nocache = true;
                }
                $function = $compiler->default_handler_plugins[Smarty::PLUGIN_COMPILER][$tag][0];
            }
            if (!is_array($function)) {
                $raw_code = $function($new_args, $this);
            } elseif (is_object($function[0])) {
                $raw_code = $compiler->context->smarty->_registered['plugin'][Smarty::PLUGIN_COMPILER][$tag][0][0]->$function[1]($new_args, $this);
            } else {
                $raw_code = call_user_func_array($function, array($new_args, $this));
            }
        } elseif (is_callable($plugin)) {
            $raw_code = $plugin($new_args, $this->smarty);
        } elseif (class_exists($plugin, false)) {
            $plugin_object = new $plugin;
            if (method_exists($plugin_object, 'compile')) {
                $raw_code = $plugin_object->compile($args, $compiler);
            }
        } else {
            // todo  error message
        }

        // check if it is a compiler plugin fpr blocks
        $closetag = $tag . 'close';
        if (isset($compiler->context->smarty->_registered['plugin'][Smarty::PLUGIN_COMPILER][$closetag]) || isset($compiler->default_handler_plugins[Smarty::PLUGIN_COMPILER][$closetag])
            || $compiler->context->smarty->_loadPlugin('smarty_compiler_' . $closetag)
        ) {
            $this->openTag($compiler, $tag, $compiler->nocache);
            // maybe nocache because of nocache variables
            $compiler->nocache = $compiler->nocache | $compiler->tag_nocache;
        }
        // compile code
        $this->iniTagCode($compiler);

        $raw_code = preg_replace('%(<\?php)[\r\n\t ]*|[\r\n\t ]*(\?>)%', '', $raw_code);

        $this->formatPHP($raw_code);

        return $this->returnTagCode($compiler);
    }
}

/**
 * Smarty Internal Plugin Compile Compiler Plugin Close Class
 *
 * @package Compiler
 */
class Smarty_Compiler_Php_NodeCompiler_Internal_PluginCompilerClose extends \Smarty_Compiler_Php_NodeCompiler_Tag
{

    /**
     * Attribute definition: Overwrites base class.
     *
     * @var array
     * @see $tpl_obj
     */
    public $required_attributes = array();

    /**
     * Attribute definition: Overwrites base class.
     *
     * @var array
     * @see $tpl_obj
     */
    public $optional_attributes = array('_any');

    /**
     * Compiles code for the execution of function plugin
     *
     * @param  array  $args      array with attributes from parser
     * @param  object $compiler  compiler object
     * @param  array  $parameter array with compilation parameter
     * @param  string $tag       name of function plugin
     * @param  string $function  PHP function name
     *
     * @return string compiled code
     */
    public function compile($args, $compiler, $parameter, $tag, $function)
    {
        // This tag does create output
        $compiler->has_output = true;

        // check and get attributes
        $_attr = $this->getAttributes($compiler, $args);

        $compiler->tag_nocache = $compiler->nocache;
        $compiler->nocache = $this->closeTag($compiler, array(substr($tag, 0, - 5)));

        $new_args = array();

        $plugin = 'smarty_compiler_' . $tag;
        if (isset($compiler->context->smarty->_registered['plugin'][Smarty::PLUGIN_COMPILER][$tag]) || isset($compiler->default_handler_plugins[Smarty::PLUGIN_COMPILER][$tag])) {
            if (isset($compiler->context->smarty->_registered['plugin'][Smarty::PLUGIN_COMPILER][$tag])) {
                $function = $compiler->context->smarty->_registered['plugin'][Smarty::PLUGIN_COMPILER][$tag][0];
            } else {
                $function = $compiler->default_handler_plugins[Smarty::PLUGIN_COMPILER][$tag][0];
            }
            if (!is_array($function)) {
                $raw_code = $function($new_args, $this);
            } elseif (is_object($function[0])) {
                $raw_code = $compiler->context->smarty->_registered['plugin'][Smarty::PLUGIN_COMPILER][$tag][0][0]->$function[1]($new_args, $this);
            } else {
                $raw_code = call_user_func_array($function, array($new_args, $this));
            }
        } elseif (is_callable($plugin)) {
            $raw_code = $plugin($new_args, $this->smarty);
        } elseif (class_exists($plugin, false)) {
            $plugin_object = new $plugin;
            if (method_exists($plugin_object, 'compile')) {
                $raw_code = $plugin_object->compile($args, $compiler);
            }
        } else {
            // todo  error message
        }

        // compile code
        $this->iniTagCode($compiler);

        $raw_code = preg_replace('%(<\?php)[\r\n\t ]*|[\r\n\t ]*(\?>)%', '', $raw_code);

        $this->formatPHP($raw_code);

        return $this->returnTagCode($compiler);
    }
}
