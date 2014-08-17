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
class Modifier
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
        $codeTargetObj->compileNode($node->getSubTree('name'), $delete)
                      ->raw('(')
                      ->compileNode($node->getSubTree('value'), $delete);
        $params = $node->getSubTree('param');
        if ($params !== false) {
            foreach ($params as $param) {
                $codeTargetObj->raw(', ')
                              ->compileNode($param, $delete);
            }
        }
        $codeTargetObj->raw(')');
    }
}
