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
class Smarty_Compiler_Php_NodeCompiler_Value_Array extends Smarty_Exception_Magic
{

    /**
     * Compiles code for static class
     *
     * @param Smarty_Compiler_Node           $target target node
     * @param Smarty_Source_Node_Value_Array $node   source node
     * @param bool                           $delete flag if compiled nodes shall be deleted
     */
    public static function compile(Smarty_Compiler_Node $target, Smarty_Source_Node_Value_Array $node, $delete = true)
    {
        $target->raw('array(');
        // compile property / method chain
        foreach ($node->subtreeNodes as $n) {
            $target->compileNode($n, false);
            unset($n);
            $target->raw(', ');
        }
        $target->raw(')');
        if ($delete) {
            $node->cleanupNodeArray($node->subtreeNodes);
        }
    }
}
