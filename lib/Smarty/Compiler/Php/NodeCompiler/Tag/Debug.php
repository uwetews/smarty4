<?php

/**
 * Smarty Internal Plugin Compile Debug
 * Compiles the {debug} tag.
 * It opens a window the the Smarty Debugging Console.
 *
 * @package Compiler
 * @author  Uwe Tews
 */

/**
 * Smarty Internal Plugin Compile Debug Class
 *
 * @package Compiler
 */
class Smarty_Compiler_Php_NodeCompiler_Tag_Debug extends Smarty_Compiler_Code_Php_NodeCompiler_Tag
{

    /**
     * Compiles code for the {debug} tag
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

        // compile always as nocache
        $compiler->tag_nocache = true;

        $this->iniTagCode($compiler);

        $this->code("Smarty_Debug::display_debug(\$this);")
             ->newline();

        return $this->returnTagCode($compiler);
    }
}
