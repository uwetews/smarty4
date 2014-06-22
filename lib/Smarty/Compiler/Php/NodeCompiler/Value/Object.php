<?php

/**
 * Compile Object Access To Php Code
 *
 * @package Compiler
 * @author  Uwe Tews
 */

/**
 * Compile Object Access To Php Code
 *
 * @package Compiler
 */
class Smarty_Compiler_Php_NodeCompiler_Value_Object extends Smarty_Exception_Magic
{

    /**
     * Compiles code for object
     *
     * @param Smarty_Compiler_Node            $target target node
     * @param Smarty_Source_Node_Value_Object $node   source node
     * @param bool                            $delete flag if compiled nodes shall be deleted
     */
    public function compile(Smarty_Compiler_Node $target, Smarty_Source_Node_Value_Object $node, $delete = true)
    {
        $node->value->compileNode($target, $delete);
        // compile property / method chain
        foreach ($node->subtreeNodes as $n) {
            $target->raw('->');
            $n->compileNode($target, false);
        }
        if ($delete) {
            $node->cleanupNodeArray($node->subtreeNodes);
        }
    }
}
