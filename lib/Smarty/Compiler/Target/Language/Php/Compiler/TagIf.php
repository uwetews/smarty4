<?php
namespace Smarty\Compiler\Target\Language\Php\Compiler;

use Smarty\Node\Tag;
use Smarty\Compiler\Code;
use Smarty\Exception\Magic;

/**
 * Smarty Internal Plugin Compile If Class
 *
 * @package Compiler
 */
class TagWhile extends Magic
{

    /**
     * Compile {While} tags
     *
     * @param Tag  $node while tag node
     * @param Code $codeTargetObj
     * @param bool $delete
     */
    public static function compile(Tag $node, Code $codeTargetObj, $delete)
    {
        $ifTag = $node->getSubTree('if');
        $codeTargetObj->lineNo($node->sourceLineNo)
                      ->code("while (")
                      ->compileNodeArray($ifTag['condition'], $codeTargetObj, $delete)
                      ->raw(") {\n");
        if ($ifTag['body'] !== false) {
            $codeTargetObj->indent()
                          ->compileNodeArray($ifTag['body'], $codeTargetObj, $delete)
                          ->outdent();
        }
        $codeTargetObj->code("}\n");
    }

}