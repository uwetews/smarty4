<?php

/**
 * Compile Static Class Access To Php Code
 *
 * @package Compiler
 * @author  Uwe Tews
 */

/**
 * Compile Static Class Access To Php Code
 *
 * @package Compiler
 */
class Smarty_Compiler_Php_NodeCompiler_Value_ArrayIndex extends Smarty_Exception_Magic
{

    /**
     * Compiles array element definition
     *
     * @param Smarty_Compiler_Node                $target target node
     * @param Smarty_Source_Node_Value_ArrayIndex $node   source node
     * @param bool                                $delete flag if compiled nodes shall be deleted
     */
    public static function compile(Smarty_Compiler_Node $target, Smarty_Source_Node_Value_ArrayIndex $node, $delete = true)
    {
        $node->value->compileNode($target, $delete);
        $target->raw(' => ');
        $node->value->compileNode($target, $delete);
    }
}
