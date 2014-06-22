<?php

/**
 * Smarty Internal Plugin Compile For
 * Compiles the {for} {forelse} {/for} tags
 *
 * @package Compiler
 * @author  Uwe Tews
 */
namespace Smarty\Compiler\Target\Language\Php\Compiler;

use Smarty\Node;
use Smarty\Compiler\Code;
/**
 * Smarty Internal Plugin Compile For Class
 *
 * @package Compiler
 */
class InternalText
{

    /**
     * Compile text node
     *
     * @param \Smarty_Compiler_Node $target target node for compiled code
     * @param \Smarty_Compiler_Node $node   if tag node
     * @param bool                  $delete
     */
    public static function compile(Node $node, Code $codeTargetObj,  $delete = true)
    {
        $codeTargetObj->lineNo($node->sourceLineNo);
        if (isset($node->parser->compiler->output_var)) {
            $codeTargetObj->code("\${$node->parser->compiler->output_var} .= ");
        } else {
            $codeTargetObj->code('echo ');
        }
        $codeTargetObj->string($node->value)
            ->raw(";\n");
        if ($delete) {
            $node->value = '';
        }
    }
}
