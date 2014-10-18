<?php
namespace Smarty\Compiler\Target\Language\Php\Compiler;

use Smarty\Node\Tag;
use Smarty\Compiler\Code;
use Smarty\Exception\Magic;

/**
 * Class TagWhile
 *
 * @package Smarty\Compiler\Target\Language\Php\Compiler
 */
class TagWhile extends Magic
{

    /**
     * Compile {while} tags
     *
     * @param Tag  $node if tag node
     * @param Code $codeTargetObj
     * @param bool $delete
     */
    public static function compile(Tag $node, Code $codeTargetObj, $delete)
    {
        $whileTag = $node->getSubTree('while');
        $codeTargetObj->lineNo($node->sourceLineNo)
                      ->code("while (")
                      ->compileNodeArray($whileTag['condition'], $codeTargetObj, $delete)
                      ->raw(") {\n");
        if ($whileTag['body'] !== false) {
            $codeTargetObj->indent()
                          ->compileNodeArray($whileTag['body'], $codeTargetObj, $delete)
                          ->outdent();
        }
        $codeTargetObj->code("}\n");
    }
}