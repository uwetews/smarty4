<?php

/**
 * Smarty Internal Plugin Compile While
 * Compiles the {while} tag
 *
 * @package Compiler
 * @author  Uwe Tews
 */

/**
 * Smarty Internal Plugin Compile While Class
 *
 * @package Compiler
 */
class Smarty_Compiler_Php_NodeCompiler_Tag_While extends Smarty_Exception_Magic
{

    /**
     * Compile {while} tag
     *
     * @param Smarty_Compiler_Node   $target target node for compiled code
     * @param Smarty_Source_Node_Tag $node   if tag node
     * @param bool                   $delete
     */
    public static function compile(Smarty_Compiler_Node $target, Smarty_Source_Node_Tag $node, $delete)
    {
        $target->lineNo($node->sourceLineNo)
               ->code("while (")
               ->compileNodeArray($node->attributeNodes, $delete)
               ->raw(") {\n")
               ->indent()
               ->compileNodeArray($node->subtreeNodes, $delete)
               ->outdent()
               ->code("}\n");
    }
}