<?php

/**
 * Smarty Internal Plugin Compile For
 * Compiles the {for} {forelse} {/for} tags
 *
 * @package Compiler
 * @author  Uwe Tews
 */

/**
 * Smarty Internal Plugin Compile For Class
 *
 * @package Compiler
 */
class Smarty_Compiler_Php_NodeCompiler_Internal_Text
{

    /**
     * Compile text node
     *
     * @param \Smarty_Compiler_Node $target target node for compiled code
     * @param \Smarty_Compiler_Node $node   if tag node
     * @param bool                  $delete
     */
    public static function compile(\Smarty_Compiler_Node $target, \Smarty_Compiler_Node $node, $delete = true)
    {
        $target->lineNo($node->sourceLineNo);
        if (isset($node->compiler->output_var)) {
            $target->code("\${$node->compiler->output_var} .= ");
        } else {
            $target->code('echo ');
        }
        $target->string($node->value)
            ->raw(";\n");
        if ($delete) {
            $node->value = '';
        }
    }
}
