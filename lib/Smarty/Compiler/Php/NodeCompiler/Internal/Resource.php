<?php

/**
 * Smarty Internal Plugin Compile For
 * Compiles the {for} {forelse} {/for} tags
 *
 * @package Compiler
 * @author  Uwe Tews
 */

/**
 * Smarty Internal Plugin Compile For Class
 *
 * @package Compiler
 */
class Smarty_Compiler_Php_NodeCompiler_Internal_Resource
{
    /**
     * Compile root node
     *
     * @param \Smarty_Compiler_Node $target target node for compiled code
     * @param \Smarty_Compiler_Node $node   if tag node
     * @param bool                  $delete
     */
    public static function compile(\Smarty_Compiler_Node $target, \Smarty_Compiler_Node $node, $delete = true)
    {
        // compile and format header
        $node->code("<?php ")
            ->code("/* Smarty version " . Smarty::SMARTY_VERSION . ", created on " . strftime("%Y-%m-%d %H:%M:%S") . " */")
            ->newline()
            ->code("if (!class_exists('{$node->templateClass}',false)) {")
            ->newline()
            ->indent()
            ->formatCode();

        //compile main template
        if (!empty($node->templateNode)) {
            $node->templateNode->indentation = $node->indentation;
            $node->templateNode->compiledLineNumber = $node->compiledLineNumber;
            self::compileTemplate($node->templateNode, $delete);
        }

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
                self::compileTemplate($n, $delete);
                $n->parser->cleanup();
                $node->subtreeNodes[] = $n;
            }
        }

        //format main template
        if (!empty($node->templateNode)) {
            $node->templateNode->indentation = $node->indentation;
            $node->templateNode->compiledLineNumber = $node->compiledLineNumber;
            $node->templateNode->compileNode($node->templateNode, $delete);
            $node->formatCode($node->templateNode, $delete);
            if ($delete) {
                $node->templateNode = null;
            }
        }

        // if we have compiled inline templates format now the output code
        if (!empty($node->subtreeNodes)) {
            foreach ($node->subtreeNodes as $key => $n) {
                $n->indentation = $node->indentation;
                $n->compiledLineNumber = $node->compiledLineNumber;
                $node->formatCode($n, $delete);
                if ($delete) {
                    unset($n, $node->subtreeNodes[$key]);
                }
            }
        }

        $node->outdent()
            ->code('}')
            ->newline()
            ->code("\$template_class_name = '{$node->templateClass}';")
            ->newline();

        $node->formatCode();
    }

    /**
     * @param \Smarty_Compiler_Node $templateNode
     * @param                       $delete
     */
    public static function compileTemplate(\Smarty_Compiler_Node $templateNode, $delete)
    {
        $templateNode->templateBodyNode = new \Smarty_Compiler_Format($templateNode->parser, 'node');
        foreach ($templateNode->subtreeNodes as $key => $n) {
            $n->indentation = $templateNode->indentation;
            $n->compiledLineNumber = $templateNode->compiledLineNumber;
            $templateNode->templateBodyNode->compileNode($n, false);
            if ($delete) {
                unset($n, $templateNode->subtreeNodes[$key]);
            }
        }
    }
}
