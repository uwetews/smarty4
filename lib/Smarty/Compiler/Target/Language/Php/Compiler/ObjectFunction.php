<?php

/**
 * Smarty Internal Plugin Compile Object Function
 * Compiles code for registered objects as function
 *
 * @package Compiler
 * @author  Uwe Tews
 */

/**
 * Smarty Internal Plugin Compile Object Function Class
 *
 * @package Compiler
 */
class Smarty_Compiler_Php_ompiler_Internal_ObjectFunction extends \Smarty_Compiler_Code_Php_NodeCompiler_Tag
{

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
     * @param  string $tag       name of function
     * @param  string $method    name of method to call
     *
     * @return string compiled code
     */
    public function compile($args, $compiler, $parameter, $tag, $method)
    {
        // check and get attributes
        $_attr = $this->getAttributes($compiler, $args);
        if ($_attr['nocache'] === true) {
            $compiler->tag_nocache = true;
        }
        unset($_attr['nocache']);
        $_assign = null;
        if (isset($_attr['assign'])) {
            $_assign = $_attr['assign'];
            unset($_attr['assign']);
        }
        // method or property ?
        if (method_exists($compiler->context->smarty->_registered['object'][$tag][0], $method)) {
            // convert attributes into parameter array string
            if ($compiler->context->smarty->_registered['object'][$tag][2]) {
                $_paramsArray = array();
                foreach ($_attr as $_key => $_value) {
                    if (is_int($_key)) {
                        $_paramsArray[] = "$_key=>$_value";
                    } else {
                        $_paramsArray[] = "'$_key'=>$_value";
                    }
                }
                $_params = 'array(' . implode(",", $_paramsArray) . ')';
                $return = "\$this->smarty->_registered['object']['{$tag}'][0]->{$method}({$_params},\$this->smarty)";
            } else {
                $_params = implode(",", $_attr);
                $return = "\$this->smarty->_registered['object']['{$tag}'][0]->{$method}({$_params})";
            }
        } else {
            // object property
            $return = "\$this->smarty->_registered['object']['{$tag}'][0]->{$method}";
        }

        $this->iniTagCode($compiler);

        if (empty($_assign)) {
            // This tag does create output
            $compiler->has_output = true;
            $this->code("echo {$return};")
                 ->newline();
        } else {
            $this->code("\$this->assign({$_assign},{$return});")
                 ->newline();
        }

        return $this->returnTagCode($compiler);
    }
}
