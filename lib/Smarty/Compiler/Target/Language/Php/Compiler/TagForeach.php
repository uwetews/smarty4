<?php

/**
 * Smarty Internal Plugin Compile Foreach
 * Compiles the {foreach} {foreachelse} {/foreach} tags
 *
 * @package Compiler
 * @author  Uwe Tews
 */
namespace Smarty\Compiler\Target\Language\Php\Compiler;

use Smarty\Node;
use Smarty\Compiler\Code;
use Smarty\Exception\Magic;

/**
 * Smarty Internal Plugin Compile Foreach Class
 *
 * @package Compiler
 */
class TagForeach extends Magic
{

    /**
     * Compile foreach tag
     *
     * @param Smarty_Compiler_Node   $target target node for compiled code
     * @param Smarty_Source_Node_Tag $node   if tag node
     * @param bool                   $delete
     */
    public static function compile(Node $node, Code $codeTargetObj, $delete)
    {
        /**
         * $compiling_node = new Smarty_Compiler_Format($node->parser, 'node');
         * if (isset($node->attributeNodes['name'])) {
         * $has_name = true;
         * $name = trim($compiling_node->compileNode($node->attributeNodes['name'])
         * ->getFormated(), "'\"");
         * $SmartyVarName = '$smarty.foreach.' . $name . '.';
         * unset($node->attributeNodes['name']);
         * } else {
         * $name = null;
         * $has_name = false;
         * }
         * $item = trim($compiling_node->compileNode($node->attributeNodes['item'])
         * ->getFormated(), "'\"");
         * unset($node->attributeNodes['item']);
         * $ItemVarName = '$' . $item . '@';
         * // evaluates which Smarty variables and properties have to be computed        // TODO  this must be changed
         * if ($has_name) {
         * $usesSmartyFirst = strpos($node->parser->lex->source, $SmartyVarName . 'first') !== false;
         * $usesSmartyLast = strpos($node->parser->lex->source, $SmartyVarName . 'last') !== false;
         * $usesSmartyIndex = strpos($node->parser->lex->source, $SmartyVarName . 'index') !== false;
         * $usesSmartyIteration = strpos($node->parser->lex->source, $SmartyVarName . 'iteration') !== false;
         * $usesSmartyShow = strpos($node->parser->lex->source, $SmartyVarName . 'show') !== false;
         * $usesSmartyTotal = strpos($node->parser->lex->source, $SmartyVarName . 'total') !== false;
         * } else {
         * $usesSmartyFirst = false;
         * $usesSmartyLast = false;
         * $usesSmartyTotal = false;
         * $usesSmartyShow = false;
         * }
         * $usesPropKey = strpos($node->parser->lex->source, $ItemVarName . 'key') !== false;
         * $usesPropFirst = $usesSmartyFirst || strpos($node->parser->lex->source, $ItemVarName . 'first') !== false;
         * $usesPropLast = $usesSmartyLast || strpos($node->parser->lex->source, $ItemVarName . 'last') !== false;
         * $usesPropIndex = $usesPropFirst || strpos($node->parser->lex->source, $ItemVarName . 'index') !== false;
         * $usesPropIteration = $usesPropLast || strpos($node->parser->lex->source, $ItemVarName . 'iteration') !== false;
         * $usesPropShow = strpos($node->parser->lex->source, $ItemVarName . 'show') !== false;
         * $usesPropTotal = $usesSmartyTotal || $usesSmartyShow || $usesPropShow || $usesPropLast || strpos($node->parser->lex->source, $ItemVarName . 'total') !== false;
         * // End TODO
         */

        // compile tag
        $item = self::getCompiledItem($node, $node->tagAttributes['item']->nameSegments);
        $codeTargetObj->lineNo($node->sourceLineNo)
            ->code("\$_scope->_tpl_vars->{$item} = new Entry;\n")
            ->code("\$_scope->_tpl_vars->{$item}->_loop = false;\n");
        if (isset($node->tagAttributes['key'])) {
            $key = self::getCompiledItem($node, $node->tagAttributes['key']->nameSegments);
            $codeTargetObj->code("\$_scope->_tpl_vars->{$key} = new Entry;\n")
                ->code("\$_scope->_tpl_vars->{$key}->_loop = false;\n");
        } else {
            $key = null;
        }
        $codeTargetObj->code('$_from = ');
        $node->tagAttributes['from']->compile($codeTargetObj, true);
        $codeTargetObj->raw(";\n")
            ->code("if (!is_array(\$_from) && !is_object(\$_from)) {\n")
            ->indent()
            ->code("settype(\$_from, 'array');\n")
            ->outdent()
            ->code("}\n");
        /**
         * if ($usesPropTotal) {
         * $target->code("\$_scope->_tpl_vars->{$item}->total = \$this->_count(\$_from);\n");
         * }
         * if ($usesPropIteration) {
         * $target->code("\$_scope->_tpl_vars->{$item}->iteration = 0;")
         * ->newline();
         * }
         * if ($usesPropIndex) {
         * $target->code("\$_scope->_tpl_vars->{$item}->index = -1;")
         * ->newline();
         * }
         * if ($usesPropShow) {
         * $target->code("\$_scope->_tpl_vars->{$item}->show = (\$_scope->_tpl_vars->{$item}->total > 0);")
         * ->newline();
         * }
         * if ($has_name) {
         * $varname = 'smarty_foreach_' . $name;
         * $target->code("\$_scope->_tpl_vars->{$varname} = new Entry;")
         * ->newline();
         * if ($usesSmartyTotal) {
         * $target->code("\$_scope->_tpl_vars->{$varname}->value['total'] = \$_scope->_tpl_vars->{$item}->total;")
         * ->newline();
         * }
         * if ($usesSmartyIteration) {
         * $target->code("\$_scope->_tpl_vars->{$varname}->value['iteration'] = 0;")
         * ->newline();
         * }
         * if ($usesSmartyIndex) {
         * $target->code("\$_scope->_tpl_vars->{$varname}->value['index'] = -1;")
         * ->newline();
         * }
         * if ($usesSmartyShow) {
         * $target->code("\$_scope->_tpl_vars->{$varname}->value['show']=(\$_scope->_tpl_vars->{$item}->total > 0);")
         * ->newline();
         * }
         * }
         * $keyterm = '';
         */
        if ($key != null) {
            $keyterm = "\$_scope->_tpl_vars->{$key}->value =>";
        } else {
            /**
             * if ($usesPropKey) {
             * $keyterm = "\$_scope->_tpl_vars->{$item}->key =>";
             * }
             * */
        }
        $codeTargetObj->code("foreach (\$_from as " . $keyterm . " \$_scope->_tpl_vars->{$item}->value) {\n")
            ->indent()
            ->code("\$_scope->_tpl_vars->{$item}->_loop = true;\n");
        /**
         * if ($key != null && $usesPropKey) {
         * $target->code("\$_scope->_tpl_vars->{$item}->key = \$_scope->_tpl_vars->{$key}->value;")
         * ->newline();
         * }
         * if ($usesPropIteration) {
         * $target->code("\$_scope->_tpl_vars->{$item}->iteration++;")
         * ->newline();
         * }
         * if ($usesPropIndex) {
         * $target->code("\$_scope->_tpl_vars->{$item}->index++;")
         * ->newline();
         * }
         * if ($usesPropFirst) {
         * $target->code("\$_scope->_tpl_vars->{$item}->first = \$_scope->_tpl_vars->{$item}->index === 0;")
         * ->newline();
         * }
         * if ($usesPropLast) {
         * $target->code("\$_scope->_tpl_vars->{$item}->last = \$_scope->_tpl_vars->{$item}->iteration === \$_scope->_tpl_vars->{$item}->total;")
         * ->newline();
         * }
         * if ($has_name) {
         * if ($usesSmartyFirst) {
         * $target->code("\$_scope->_tpl_vars->{$varname}->value['first'] = \$_scope->_tpl_vars->{$item}->first;")
         * ->newline();
         * }
         * if ($usesSmartyIteration) {
         * $target->code("\$_scope->_tpl_vars->{$varname}->value['iteration']++;")
         * ->newline();
         * }
         * if ($usesSmartyIndex) {
         * $target->code("\$_scope->_tpl_vars->{$varname}->value['index']++;")
         * ->newline();
         * }
         * if ($usesSmartyLast) {
         * $target->code("\$_scope->_tpl_vars->{$varname}->value['last'] = \$_scope->_tpl_vars->{$item}->last;")
         * ->newline();
         * }
         * }
         */
        if (false !== $body = $node->getSubTree('foreach')) {
            $node->parser->compiler->compileNode($body, $codeTargetObj, $delete);
        }
        $codeTargetObj->outdent()
            ->code("}\n");

        // compile {foreachelse} if present
        if (false !== $body = $node->getSubTree('foreachelse')) {
            $codeTargetObj->lineNo($node->sourceLineNo)
                ->code("if (!\$_scope->_tpl_vars->{$item}->_loop) {\n")
                ->indent();
            $node->parser->compiler->compileNode($body, $codeTargetObj, $delete);
            $codeTargetObj->outdent()
                ->code("}\n");

        }
    }

    public static function getCompiledItem($node, $item)
    {
        $comp = new Code($node);
        $comp->compileNodeItems($item, false);
        return $comp->getFormatted();
    }

    /**
     * Compile foreachelse tag
     *
     * @param Smarty_Compiler_Node   $target target node for compiled code
     * @param Smarty_Source_Node_Tag $node   if tag node
     * @param bool                   $delete
     */
    public static function compile_foreachelse(Node $node, Code $codeTargetObj, $delete)
    {
        $codeTargetObj->lineNo($node->sourceLineNo)
            ->code("if (!\$_scope->_tpl_vars->{$node->parentNode->item}->_loop) {\n")
            ->indent();
    }
}
