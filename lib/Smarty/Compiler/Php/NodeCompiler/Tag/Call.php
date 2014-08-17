<?php

/**
 * Smarty Internal Plugin Compile Function_Call
 * Compiles the calls of user defined tags defined by {function}
 *
 * @package Compiler
 * @author  Uwe Tews
 */

/**
 * Smarty Internal Plugin Compile Function_Call Class
 *
 * @package Compiler
 */
class Smarty_Compiler_Php_NodeCompiler_Tag_Call extends Smarty_Compiler_Code_Php_NodeCompiler_Tag
{

    /**
     * Attribute definition: Overwrites base class.
     *
     * @var array
     * @see $tpl_obj
     */
    public $required_attributes = array('name');

    /**
     * Attribute definition: Overwrites base class.
     *
     * @var array
     * @see $tpl_obj
     */
    public $shorttag_order = array('name');

    /**
     * Attribute definition: Overwrites base class.
     *
     * @var array
     * @see $tpl_obj
     */
    public $optional_attributes = array('_any');

    /**
     * Compiles the calls of user defined tags defined by {function}
     *
     * @param  array  $args     array with attributes from parser
     * @param  object $compiler compiler object
     *
     * @return string compiled code
     */
    public function compile($args, $compiler)
    {
        // check and get attributes
        $_attr = $this->getAttributes($compiler, $args);
        // save possible attributes
        if (isset($_attr['assign'])) {
            // output will be stored in a smarty variable instead of being displayed
            $_assign = $_attr['assign'];
        } else {
            $_assign = "null";
        }
        $_name = $_attr['name'];
        if ($compiler->compiles_template_function) {
            $compiler->called_template_functions[trim($_name, "'\"")] = true;
        }
        // nocache option
        if ($_attr['nocache'] === true) {
            $compiler->tag_nocache = true;
        }
        if ($compiler->context->caching && ($compiler->tag_nocache || $compiler->nocache)) {
            $compiler->called_nocache_template_functions[trim($_name, "'\"")] = true;
        }
        unset($_attr['name'], $_attr['assign'], $_attr['nocache']);
        $_paramsArray = array();
        foreach ($_attr as $_key => $_value) {
            if (is_int($_key)) {
                $_paramsArray[] = "$_key=>$_value";
            } else {
                $_paramsArray[] = "'$_key'=>$_value";
            }
        }

        $this->iniTagCode($compiler);

        $_params = 'array(' . implode(",", $_paramsArray) . ')';

        $this->code("\$this->_callTemplateFunction ($_name, \$_scope, {$_params},{$_assign});")
             ->newline();

        $compiler->has_code = true;

        return $this->returnTagCode($compiler);
    }
}
