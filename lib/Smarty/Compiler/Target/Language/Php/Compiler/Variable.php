<?php

/**
 * Compile Variable Access To Php Code
 *
 * @package Compiler
 * @author  Uwe Tews
 */
namespace Smarty\Compiler\Target\Language\Php\Compiler;

use Smarty\Node;
use Smarty\Node\Value\String;
use Smarty\Compiler\Code;

/**
 * Compile Variable Access To Php Code
 *
 * @package Compiler
 */
class Variable
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
        $codeTargetObj->raw('$_scope->_tpl_vars->');
        // variable name
        $name = $node->getSubTree('name');
        if (count($name) == 1) {
            $codeTargetObj->compileNode($name, $delete);
        } else {
            // multiple segments
            $codeTargetObj->raw('{');
            foreach ($name as $key => $seg) {
                if ($key > 0) {
                    $codeTargetObj->raw(' . ');
                }
                if ($seg instanceof String) {
                    $seg->compileAsValue = false;
                }
                $codeTargetObj->compileNode($seg, $delete);
            }
            $codeTargetObj->raw('}');
        }
        // user specified property?
        $property = $node->getSubTree('property');
        if ($property !== false) {
            $codeTargetObj->compileNode($property, $delete);
        } else {
            $codeTargetObj->raw('->value');
        }
        // suffix chain
        $suffixChain = $node->getSubTree('suffix');
        if ($suffixChain !== false) {
            foreach ($suffixChain as $suffix) {
                if ($suffix['type'] == 'arrayelement') {
                    $codeTargetObj->raw('[')
                                  ->compileNode($suffix['node'], $delete)
                                  ->raw(']');
                } else {
                    $codeTargetObj->raw('->')
                                  ->compileNodeArray($suffix['name'], $codeTargetObj, $delete);
                    if (isset($suffix['method'])) {
                        $codeTargetObj->compileNode($suffix['method'], $delete);
                    }
                }
            }
        }
    }
}
