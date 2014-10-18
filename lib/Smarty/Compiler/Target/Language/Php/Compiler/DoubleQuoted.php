<?php
namespace Smarty\Compiler\Target\Language\Php\Compiler;

use Smarty\Node;
use Smarty\Compiler\Format;
use Smarty\Exception\Magic;
use Smarty\Parser\Source\Language\Smarty\Node\Value\String;
use Smarty\Parser\Source\Language\Smarty\Node\Value\Variable;

class DoubleQuoted extends Magic
{

    /**
     * Compiles double quoted strings
     *
     * @param Node $target target node
     * @param      $node   source node
     * @param bool $delete flag if compiled nodes shall be deleted
     */
    public static function compile(Node $node, Format $codeTargetObj, $delete)
    {
        $first = true;
        foreach ($node->textSegments as $segment) {
            if (!$first) {
                $codeTargetObj->raw(' . ');
            }
            $simple = ($segment instanceof String) || ($segment instanceof Variable);
            if (!$simple) {
                $codeTargetObj->raw('( ');
            }
            $codeTargetObj->compileNode($segment, $delete);
            if (!$simple) {
                $codeTargetObj->raw(' )');
            }
            $first = false;
        }
    }
}
