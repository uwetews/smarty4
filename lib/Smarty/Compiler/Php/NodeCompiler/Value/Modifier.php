<?php

/**
 * Smarty Internal Plugin Compile Modifier
 *
 * @package Smarty\Compiler\PHP\Tag
 * @author  Uwe Tews
 */

/**
 * Smarty Internal Plugin Compile Modifier
 *
 * @package Smarty\Compiler\PHP\Tag
 */
class Smarty_Compiler_Php_NodeCompiler_Value_Modifier
{

    /**
     * Compiles code for modifier
     *
     * @param Smarty_Compiler_Node   $target target node
     * @param Smarty_Source_Node_Tag $node   source node
     * @param bool                   $delete flag if compiled nodes shall be deleted
     */
    public static function compile(Smarty_Compiler_Node $target, Smarty_Source_Node_Tag $node, $delete = true)
    {
        $target->lineNo($node->sourceLineNo);
        if ($callable = is_callable($node->value)) {
            $target->raw($node->value . '(');
        }
        if (!empty($node->subtreeNodes)) {
            $target->compileNodeArray($node->subtreeNodes, $delete);
        }
        if (!empty($node->parameterNodes)) {
            foreach ($node->parameterNodes as $key => $n) {
                $target->raw(', ')
                       ->compileNode($n, false);
                unset($n);
                $node->parameterNodes[$key]->cleanup();
                unset($node->parameterNodes[$key]);
            }
        }
        if ($callable) {
            $target->raw(')');
        }
    }
}
