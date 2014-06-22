<?php

/**
 * Smarty Internal Plugin Compile Registered Function
 * Compiles code for the execution of a registered function
 *
 * @package Compiler
 * @author  Uwe Tews
 */

/**
 * Smarty Internal Plugin Compile Registered Function Class
 *
 * @package Compiler
 */
class Smarty_Compiler_Php_ompiler_Internal_RegisteredFunction extends \Smarty_Compiler_Code_Php_NodeCompiler_Tag
{

    /**
     * Attribute definition: Overwrites base class.
     *
     * @var array
     * @see $tpl_obj
     */
    public $optional_attributes = array('_any');

    /**
     * Compiles code for the execution of a registered function
     *
     * @param  array  $args      array with attributes from parser
     * @param  object $compiler  compiler object
     * @param  array  $parameter array with compilation parameter
     * @param  string $tag       name of function
     *
     * @return string compiled code
     */
    public function compile($args, $compiler, $parameter, $tag)
    {
        // This tag does create output
        $compiler->has_output = true;
        // check and get attributes
        $_attr = $this->getAttributes($compiler, $args);
        if ($_attr['nocache']) {
            $compiler->tag_nocache = true;
        }
        unset($_attr['nocache']);
        if (isset($compiler->context->smarty->_registered['plugin'][Smarty::PLUGIN_FUNCTION][$tag])) {
            $tag_info = $compiler->context->smarty->_registered['plugin'][Smarty::PLUGIN_FUNCTION][$tag];
        } else {
            $tag_info = $compiler->default_handler_plugins[Smarty::PLUGIN_FUNCTION][$tag];
        }
        // not cachable?
        $compiler->tag_nocache = $compiler->tag_nocache || !$tag_info[1];
        $function = $tag_info[0];
        // convert attributes into parameter string
        $result = $this->getPluginParameterString($function, $_attr, $compiler, false, $tag_info[2]);
        // compile code
        $this->iniTagCode($compiler);

        if ($function instanceof Closure) {
            $this->code("echo \$this->smarty->_registered['plugin'][Smarty::PLUGIN_FUNCTION]['{$tag}'][0]({$result});")
                ->newline();
        } elseif (!is_array($function)) {
            $this->code("echo {$function}({$result});")
                ->newline();
        } elseif (is_object($function[0])) {
            $this->code("echo \$this->smarty->_registered['plugin'][Smarty::PLUGIN_FUNCTION]['{$tag}'][0][0]->{$function[1]}({$result});")
                ->newline();
        } else {
            $this->code("echo {$function[0]}::{$function[1]}({$result});")
                ->newline();
        }

        return $this->returnTagCode($compiler);
    }
}
