<?php
namespace Smarty\Compiler\Target\Language\Php\Compiler;

use Smarty\Node;
use Smarty\Compiler\Format;
use Smarty\Exception\Magic;

class ArrayValue extends Magic
{

    /**
     * Compiles array as value
     *
     * @param Node $target target node
     * @param      $node   source node
     * @param bool $delete flag if compiled nodes shall be deleted
     */
    public static function compile(Node $node, Format $codeTargetObj, $delete)
    {
        $codeTargetObj->raw('array(');
        foreach ($node->keyValueNodes as $keyValue) {
            if (isset($keyValue[0])) {
                $codeTargetObj->compileNode($keyValue[0], $delete)
                    ->raw(' => ');
            }
            $codeTargetObj->compileNode($keyValue[1], $delete)
                          ->raw(', ');
        }
        $codeTargetObj->raw(')');
        if ($delete) {
            $node->keyValueNodes = array();
        }
    }
}
