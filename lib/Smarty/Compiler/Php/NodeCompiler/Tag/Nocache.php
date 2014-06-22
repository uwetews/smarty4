<?php

/**
 * Smarty Internal Plugin Compile Nocache
 * Compiles the {nocache} {/nocache} tags.
 *
 * @package Compiler
 * @author  Uwe Tews
 */

/**
 * Smarty Internal Plugin Compile Nocache Class
 *
 * @package Compiler
 */
class Smarty_Compiler_Php_NodeCompiler_Tag_Nocache extends SmartSmarty_Compiler_Php_ompiler_Tag
{

    /**
     * Compiles code for the {nocache} tag
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
        $this->openTag($compiler, 'nocache', $compiler->nocache);
        // enter nocache mode
        $compiler->nocache = true;
        // this tag does not return compiled code
        $compiler->has_code = false;

        return true;
    }
}

/**
 * Smarty Internal Plugin Compile Nocacheclose Class
 *
 * @package Compiler
 */
class Smarty_ComSmarty_Compiler_Php_er_Tag_Nocacheclose extends Smarty_Compiler_Code_Php_NodeCompiler_Tag
{

    /**
     * Compiles code for the {/nocache} tag
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
        // leave nocache mode   and restore saved stats
        $compiler->nocache = $this->closeTag($compiler, array('nocache'));
        // this tag does not return compiled code
        $compiler->has_code = false;

        return true;
    }
}
