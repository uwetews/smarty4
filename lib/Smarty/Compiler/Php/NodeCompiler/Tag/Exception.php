<?php

/**
 * Smarty Compile a Runtime Exception
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
class Smarty_Compiler_Php_NodeCompiler_Tag_Exception extends Smarty_Compiler_Code_Php_NodeCompiler_Tag
{

    /**
     * Attribute definition: Overwrites base class.
     *
     * @var array
     * @see $tpl_obj
     */
    public $shorttag_order = array('message');

    /**
     * Attribute definition: Overwrites base class.
     *
     * @var array
     * @see $tpl_obj
     */
    public $optional_attributes = array('message');

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
        if (isset($_attr['message'])) {
            // output will be stored in a smarty variable instead of being displayed
            $message = $_attr['message'];
        } else {
            $message = "'User Exception'";
        }
        // nocache option
        if ($_attr['nocache'] === true) {
            $compiler->tag_nocache = true;
        }

        $this->iniTagCode($compiler);
        $this->code("throw new Smarty_Exception_Runtime($message);")
            ->newline();

        $compiler->has_code = true;

        return $this->returnTagCode($compiler);
    }
}
