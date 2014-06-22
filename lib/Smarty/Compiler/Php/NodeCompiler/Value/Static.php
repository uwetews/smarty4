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
class Smarty_Compiler_Php_NodeCompiler_Value_Static extends Smarty_Exception_Magic
{

    /**
     * Compiles code for static class
     *
     * @param Smarty_Compiler_Node            $target target node
     * @param Smarty_Source_Node_Value_Static $node   source node
     * @param bool                            $delete flag if compiled nodes shall be deleted
     */
    public function compile(Smarty_Compiler_Node $target, Smarty_Source_Node_Value_Static $node, $delete = true)
    {
        $node->value->compileNode($target, $delete);
        $ptr = '::';
        // compile property / method chain
        foreach ($node->subtreeNodes as $n) {
            $target->raw($ptr);
            $n->compileNode($target, false);
            $ptr = '->';
        }
        if ($delete) {
            $node->cleanupNodeArray($node->subtreeNodes);
        }
    }
}
