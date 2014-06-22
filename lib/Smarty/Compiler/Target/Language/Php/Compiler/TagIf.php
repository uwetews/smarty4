<?php

/**
 * Smarty Internal Plugin Compile If
 * Compiles the {if} {else} {elseif} {/if} tags
 *
 * @package Compiler
 * @author  Uwe Tews
 */
namespace Smarty\Compiler\Target\Language\Php\Compiler;

use Smarty\Node\Tag;
use Smarty\Compiler\Code;
use Smarty\Exception\Magic;

/**
 * Smarty Internal Plugin Compile If Class
 *
 * @package Compiler
 */
class TagIf extends Magic
{

    /**
     * Compile {if}, {ifelse} and {else} tags
     *
     * @param Tag  $node if tag node
     * @param Code $codeTargetObj
     * @param bool $delete
     */
    public static function compile(Tag $node, Code $codeTargetObj, $delete)
    {
        self::compile_if($node, $codeTargetObj, $delete);
        $elseifTags = $node->getSubTree('elseif');
        if ($elseifTags !== false) {
            self::compile_elseif($elseifTags, $node, $codeTargetObj, $delete);
        }
        $elseTag = $node->getSubTree('else');
        if ($elseTag !== false) {
            self::compile_else($elseTag, $node, $codeTargetObj, $delete);
        }
    }

    /**
     * Compile if tag
     *
     * @param Tag  $node if tag node
     * @param Code $codeTargetObj
     * @param bool $delete
     */
    public static function compile_if(Tag $node, Code $codeTargetObj, $delete)
    {
        $ifTag = $node->getSubTree('if');
        $codeTargetObj->lineNo($node->sourceLineNo)
            ->code("if (")
            ->compileNodeArray($ifTag['condition'], $codeTargetObj, $delete)
            ->raw(") {\n");
        if ($ifTag['body'] !== false) {
            $codeTargetObj->indent()
                ->compileNodeArray($ifTag['body'], $codeTargetObj, $delete)
                ->outdent();
        }
        $codeTargetObj->code("}\n");
    }

    /**
     * Compile elseif tag
     *
     * @param array $elseifTags
     * @param Tag   $node if tag node
     * @param Code  $codeTargetObj
     * @param bool  $delete
     */
    public static function compile_elseif($elseifTags, Tag $node, Code $codeTargetObj, $delete)
    {
        foreach ($elseifTags as $elseifTag) {
            $codeTargetObj->lineNo($node->sourceLineNo)
                ->code("elseif (")
                ->compileNodeArray($elseifTag['condition'], $codeTargetObj, $delete)
                ->raw(") {\n");
            if ($elseifTag['body'] !== false) {
                $codeTargetObj->indent()
                    ->compileNodeArray($elseifTag['body'], $codeTargetObj, $delete)
                    ->outdent();
            }
            $codeTargetObj->code("}\n");
        }
    }

    /**
     * Compile elseif tag
     *
     * @param array $elseTag
     * @param Tag   $node if tag node
     * @param Code  $codeTargetObj
     * @param bool  $delete
     */
    public static function compile_else($elseTag, Tag $node, Code $codeTargetObj, $delete)
    {
        $codeTargetObj->lineNo($node->sourceLineNo)
            ->code("else {\n");
        if ($elseTag['body'] !== false) {
            $codeTargetObj->indent()
                ->compileNodeArray($elseTag['body'], $codeTargetObj, $delete)
                ->outdent();
        }
        $codeTargetObj->code("}\n");
    }
}