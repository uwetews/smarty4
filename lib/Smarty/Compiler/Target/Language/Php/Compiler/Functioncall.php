<?php

/**
 * Compile Variable Access To Php Code
 *
 * @package Compiler
 * @author  Uwe Tews
 */
namespace Smarty\Compiler\Target\Language\Php\Compiler;

use Smarty\Node;
use Smarty\Compiler\Code;

/**
 * Compile Variable Access To Php Code
 *
 * @package Compiler
 */
class Functioncall
{

    /**
     * Compiles code for variable access
     *
     * @param Node $node   source node
     * @param Code $codeTargetObj
     * @param bool $delete flag if compiled nodes shall be deleted
     */
    public static function compile(Node $node, Code $codeTargetObj, $delete = true)
    {
        $name = $node->getSubTree('name');
        $codeTargetObj->compileNode($name, $delete);
        $codeTargetObj->raw('(');
        $params = $node->getSubTree('param');
        if ($params !== false) {
            foreach ($params as $key => $param) {
                if ($key > 0) {
                    $codeTargetObj->raw(', ');
                    }
                $codeTargetObj->compileNode($param, $delete);
            }
        }
        $codeTargetObj->raw(')');
    }
}
