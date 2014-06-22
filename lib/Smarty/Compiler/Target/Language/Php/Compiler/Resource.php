<?php

/**
 * Smarty Internal Plugin Compile For
 * Compiles the {for} {forelse} {/for} tags
 *
 * @package Compiler
 * @author  Uwe Tews
 */
namespace Smarty\Compiler\Target\Language\Php\Compiler;

use Smarty\Node;
use Smarty\Compiler\Code;

/**
 * Smarty Internal Plugin Compile For Class
 *
 * @package Compiler
 */
class Resource
{
    /**
     * Compile root node
     *
     * @param bool                  $delete
     */
    public static function compile(Node $node, Code $codeTargetObj, $delete = true)
    {
        // compile and format header
        $codeTargetObj->code("<?php ")
            ->code("/* Smarty version " . \Smarty::SMARTY_VERSION . ", created on " . strftime("%Y-%m-%d %H:%M:%S") . " */")
            ->newline()
            ->code("use Smarty\Template\Core;")
            ->newline()
            ->code("use Smarty\Variable\Entry;")
            ->newline()
            ->code("if (!class_exists('{$node->templateNode->templateClass}',false)) {")
            ->newline()
            ->indent()
            ->formatCode();

        //compile main template
        if (!empty($node->templateNode)) {
            self::compileTemplate($node->templateNode, $codeTargetObj, $delete);
            $templateClass = $node->templateNode->templateClass;
        }

        /**
        // compile inline templates
        // this is a loop because each template which gets compiled can create a new ones
        while (!empty($node->inlineTemplateContext)) {
            foreach ($node->inlineTemplateContext as $key => $context) {
                unset ($node->inlineTemplateContext[$key]);
                $n = $node->compiler->instanceBodyNode($context);
                $n->templateClass = $node->inlineTemplateClass[$context->uid];
                $source = $context->getContent();
                $context->smarty->_current_file = $context->filepath;
                if (isset($context->smarty->_autoloadFilters['pre']) || isset($context->smarty->_registered['filter']['pre'])) {
                    $source = $context->smarty->runFilter('pre', $source, $node);
                }
                $n->parser->setSource($source);
                unset($source);
                $n->indentation = $node->indentation;
                $n->compiledLineNumber = $node->compiledLineNumber;
                $n->parserInit($n->parser);
                // call compiler
                $n->parser->parse();
                self::compileTemplate($codeTargetObj, $n, $delete);
                $n->parser->cleanup();
                $node->subtreeNodes[] = $n;
            }
        }
         * */

        /**
        //format main template
        if (!empty($node->templateNode)) {
            $node->templateNode->indentation = $node->indentation;
            $node->templateNode->compiledLineNumber = $node->compiledLineNumber;
            //            $node->templateNode->compile($node->templateNode, $delete);
            $node->formatCode($node->templateNode, $delete);
            if ($delete) {
                $node->templateNode->cleanup();
                $node->templateNode = null;
            }
        }
         * */

        // if we have compiled inline templates format now the output code
        if (!empty($node->subtreeNodes)) {
            foreach ($node->subtreeNodes as $key => $n) {
                $n->indentation = $node->indentation;
                $n->compiledLineNumber = $node->compiledLineNumber;
                $node->formatCode($n, $delete);
                if ($delete) {
                    $node->subtreeNodes[$key]->cleanup();
                    unset($n, $node->subtreeNodes[$key]);
                }
            }
        }

        $codeTargetObj->outdent()
            ->code('}')
            ->newline()
            ->code("\$template_class_name = '{$templateClass}';")
            ->newline();

        $codeTargetObj->formatCode();
    }

    /**
     * @param \Smarty_Compiler_Node $templateNode
     * @param                       $delete
     */
    public static function compileTemplate(Node $templateNode, Code $codeTargetObj, $delete)
    {
        return $templateNode->compile($codeTargetObj, $delete);
    }
}
