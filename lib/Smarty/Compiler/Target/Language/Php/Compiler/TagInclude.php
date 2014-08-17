<?php
namespace Smarty\Compiler\Target\Language\Php\Compiler;

use Smarty\Node;
use Smarty\Compiler\Code;
use Smarty\Exception\Magic;

/**
 * Class TagInclude
 *
 * @package Smarty\Compiler\Target\Language\Php\Compiler
 */
class TagInclude extends Magic
{

    /**
     * Compile {include} tag
     *
     * @param \Smarty_Compiler_Node  $target target node for compiled code
     * @param Smarty_Source_Node_Tag $node   if tag node
     * @param bool                   $delete
     */
    public static function compile(Node $node, Code $codeTargetObj, $delete)
    {
        $compiler = $node->parser->compiler;
        $context = $node->parser->context;
        // TODO nocache handling und variablen assign
        $codeTargetObj->lineNo($node->sourceLineNo);
        $_nocache = 'false';
        $scope = $node->getScope();
        switch ($scope) {
            case 'local':
                $scope_type = \Smarty::SCOPE_LOCAL;
                break;
            case 'parent':
                $scope_type = \Smarty::SCOPE_PARENT;
                break;
            case 'root':
                $scope_type = \Smarty::SCOPE_ROOT;
                break;
            case 'smarty':
                $scope_type = \Smarty::SCOPE_SMARTY;
                break;
            case 'global':
                $scope_type = \Smarty::SCOPE_GLOBAL;
                break;
        }
        $optionNocache = $node->getTagOption('nocache') || !$context->caching;
        $optionCache = $node->getTagOption('cache') || isset($node->tagAttributes['cache_lifetime']) || isset($node->tagAttributes['cache_id']);
        $optionInline = ($context->smarty->merge_compiled_includes || $node->getTagOption('inline')) && $node->tagAttributes['file']->name == 'String' && !($optionNocache || $optionCache || $context->handler->recompiled || isset($node->tagAttributes['compile_id']));
        $_caching = $optionNocache ? \Smarty::CACHING_OFF : \Smarty::CACHING_NOCACHE_CODE;
        $_caching = $optionCache ? \Smarty::CACHING_LIFETIME_CURRENT : $_caching;

        $_vars = array();

        $_class = 'null';

        $_assign = isset($node->tagAttributes['assign']) ? $node->tagAttributes['assign'] : false;
        if ($_assign) {
            $codeTargetObj->code("\$this->_assignInScope(")
                          ->compileNode($_assign)
                          ->raw(", new Entry(");
        } else {
            if (isset($compiler->output_var)) {
                $codeTargetObj->code("\${$compiler->output_var} .= ");
            } else {
                $codeTargetObj->code('echo ');
            }
        }
        $codeTargetObj->raw("\$this->_getSubTemplate (")
                      ->compileNode($node->tagAttributes['file'])
                      ->raw(", ");
        if (isset($node->tagAttributes['cache_id'])) {
            $codeTargetObj->compileNode($node->tagAttributes['cache_id']);
        } else {
            $codeTargetObj->raw("null");
        }
        $codeTargetObj->raw(", ");
        if (isset($node->tagAttributes['compile_id'])) {
            $codeTargetObj->compileNode($node->tagAttributes['compile_id']);
        } else {
            $codeTargetObj->raw("null");
        }
        $codeTargetObj->raw(", {$_caching}, ");
        if (isset($node->tagAttributes['cache_lifetime'])) {
            $codeTargetObj->compileNode($node->tagAttributes['cache_lifetime']);
        } else {
            $codeTargetObj->raw("0");
        }
        $codeTargetObj->raw(", ")
                      ->repr($_vars, false)
                      ->raw(", {$scope_type}, \$_scope, {$_class})");
        if ($_assign) {
            $codeTargetObj->raw("));\n");
        } else {
            $codeTargetObj->raw(";\n");
        }
    }

    public static function compilexx($target, Smarty_Source_Node_Tag $node)
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
