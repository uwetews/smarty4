<?php

/**
 * Compile Static Class Access To Php Code
 *
 * @package Compiler
 * @author  Uwe Tews
 */
namespace Smarty\Compiler\Target\Language\Php\Compiler;

use Smarty\Node;
use Smarty\Exception\Magic;

/**
 * Compile Static Class Access To Php Code
 *
 * @package Compiler
 */
class ArrayElement extends Magic
{

    /**
     * Compiles array element definition
     *
     * @param Node $target target node
     * @param      $node   source node
     * @param bool $delete flag if compiled nodes shall be deleted
     */
    public static function compile(Node $node, Code $codeTargetObj, $delete)
    {
        foreach ($node->arrayElements as $element) {
            $codeTargetObj->raw('[');
            $element->compile($codeTargetObj, $delete);
            $codeTargetObj->raw(']');
        }
        if ($delete) {
            $node->cleanupNodeArray($node->arrayElements);
        }
    }
}
