<?php

/**
 * Smarty Internal Plugin Compile Include
 * Compiles the {include} tag
 *
 * @package Compiler
 * @author  Uwe Tews
 */

/**
 * Smarty Internal Plugin Compile Include Class
 *
 * @package Compiler
 */
class Smarty_Compiler_Php_NodeCompiler_Tag_Include extends Smarty_Exception_Magic
{

    /**
     * Compiles include tag

     */
    public static function compile($target, Smarty_Source_Node_Tag $node)
    {
        $target->lineNo($node->sourceLineNo);
        $compiler = $node->parser->compiler;
        $context = $node->parser->context;
        $_parent_scope = Smarty::SCOPE_LOCAL;
        if (isset($node->attributeNodes['scope'])) {
            $scope = $node->attributeNodes['scope'];
            unset($node->attributeNodes['scope']);
            if (isset($scope->value) && is_string($scope->value)) {
                $scope = $scope->value;
                if ($scope == 'parent') {
                    $_parent_scope = Smarty::SCOPE_PARENT;
                } elseif ($scope == 'root') {
                    $_parent_scope = Smarty::SCOPE_ROOT;
                } elseif ($scope == 'global') {
                    $_parent_scope = Smarty::SCOPE_GLOBAL;
                } elseif ($scope == 'none') {
                    $_parent_scope = Smarty::SCOPE_NONE;
                } else {
                    $scope = null;
                }
            } else {
                $scope = null;
            }
            if ($scope === null) {
                $compiler->error("illegal value of scope attribute", $node->sourceLineNo, $node->parser);
            }
        }
        $inline = false;
        if (isset($node->options['inline'])) {
            $inline = $node->options['inline'];
        }
        $_caching = Smarty::CACHING_OFF;
        // default for included templates
        // TODO set correct caching mode
        if ($context->caching && !$compiler->nocache && !$compiler->tag_nocache) {
            $_caching = Smarty::CACHING_NOCACHE_CODE;
        }
        $compiling_node = new Smarty_Compiler_Format($node->parser, 'node');

        if (isset($node->attributeNodes['file']->value) && is_string($node->attributeNodes['file']->value)) {
            $file_string = $node->attributeNodes['file']->value;
        } else {
            $file_string = false;
        }
        $_file = $compiling_node->compileNode($node->attributeNodes['file'])
            ->getFormated();
        unset($node->attributeNodes['file']);
        $_assign = null;
        if (isset($node->attributeNodes['assign'])) {
            $_assign = $compiling_node->compileNode($node->attributeNodes['assign'])
                ->getFormated();
            unset($node->attributeNodes['assign']);
        }
        $_cacheLifetime = 0;
        if (isset($node->attributeNodes['cacheLifetime'])) {
            $_cacheLifetime = $compiling_node->compileNode($node->attributeNodes['cacheLifetime'])
                ->getFormated();
            unset($node->attributeNodes['cacheLifetime']);
            $_caching = Smarty::CACHING_LIFETIME_CURRENT;
        }
        $_cacheId = 'null';
        if (isset($node->attributeNodes['cacheId'])) {
            $_cacheId = $compiling_node->compileNode($node->attributeNodes['cacheId'])
                ->getFormated();
            unset($node->attributeNodes['cacheId']);
            $_caching = Smarty::CACHING_LIFETIME_CURRENT;
        }
        $_compileId = 'null';
        if (isset($node->attributeNodes['compileId'])) {
            $_compileId = $compiling_node->compileNode($node->attributeNodes['compileId'])
                ->getFormated();
            unset($node->attributeNodes['compileId']);
        }
        $_vars = array();
        if (!empty($node->attributeNodes)) {
            foreach ($node->attributeNodes as $var => $n) {
                $cn = clone $compiling_node;
                $cn->compileNode($n);
                $_vars[$var] = $cn;
                unset($n, $cn, $node->attributeNodes[$var]);
            }
        }
        if (isset($node->options['caching']) && $node->options['caching']) {
            $_caching = Smarty::CACHING_LIFETIME_CURRENT;
        }
        if (isset($node->options['nocache']) && $node->options['nocache']) {
            $_caching = Smarty::CACHING_OFF;
            // TODO set noache processing
        }

        if ($file_string && ($context->smarty->merge_compiled_includes || $inline) && !$context->handler->recompiled
            && !($context->caching && ($compiler->tag_nocache || $compiler->nocache || $compiler->nocache_nolog)) && $_caching != Smarty::CACHING_LIFETIME_CURRENT
        ) {
            $context = $context->smarty->_getContext($file_string);
            if (false == $node->parser->rootNode->getInlineTemplateClass($context->uid)) {
                // create context
                $node->parser->rootNode->addInlineTemplate($context);
            }
            $_class = "'" . $node->parser->rootNode->getInlineTemplateClass($context->uid) . "'";
            unset($context);
            //TODO add inline processing
        } else {
            $_class = 'null';
        }
        if (isset($_assign)) {
            $target->code("\$this->_assignInScope('{$_assign}',  new Entry (");
        } else {
            if (isset($node->compiler->output_var)) {
                $target->code("\${$node->compiler->output_var} .= ");
            } else {
                $target->code('echo ');
            }
            $target->raw("\$this->_getSubTemplate ($_file, $_cacheId, $_compileId, $_caching, $_cacheLifetime, ")
                ->repr($_vars, false)
                ->raw(", $_parent_scope, \$_scope, $_class)");
        }
        if (isset($_assign)) {
            $target->raw("));\n");
        } else {
            $target->raw(";\n");
        }
    }
}
