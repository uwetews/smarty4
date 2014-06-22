<?php

/**
 * Smarty Internal Plugin Compile Strip
 * Compiles the {strip} {/strip} tags.
 *
 * @package Compiler
 * @author  Uwe Tews
 */

/**
 * Smarty Internal Plugin Compile Strip Class
 *
 * @package Compiler
 */
class Smarty_Compiler_Php_NodeCompiler_Tag_Strip extends SmartSmarty_Compiler_Php_ompiler_Tag
{

    /**
     * Compiles code for the {strip} tag
     * This tag does not generate compiled output. It only sets a compiler flag.
     *
     * @param  array  $args     array with attributes from parser
     * @param  object $compiler compiler object
     *
     * @return bool
     */
    public function compile($args, $compiler)
    {
        $_attr = $this->getAttributes($compiler, $args);
        if ($_attr['nocache'] === true) {
            $compiler->error('nocache option not allowed', $compiler->lex->taglineno);
        }
        // flush old text buffer
        $compiler->compileFlushText();
        // enter strip mode
        $compiler->strip = true;
        // this tag does not return compiled code
        $compiler->has_code = false;

        return true;
    }
}

/**
 * Smarty Internal Plugin Compile Stripclose Class
 *
 * @package Compiler
 */
class Smarty_ComSmarty_Compiler_Php_er_Tag_Stripclose extends Smarty_Compiler_Code_Php_NodeCompiler_Tag
{

    /**
     * Compiles code for the {/strip} tag
     * This tag does not generate compiled output. It only sets a compiler flag.
     *
     * @param  array  $args     array with attributes from parser
     * @param  object $compiler compiler object
     *
     * @return bool
     */
    public function compile($args, $compiler)
    {
        $_attr = $this->getAttributes($compiler, $args);
        // flush old text buffer
        $compiler->compileFlushText();
        // enter leave strip mode
        $compiler->strip = false;
        // this tag does not return compiled code
        $compiler->has_code = false;

        return true;
    }
}
