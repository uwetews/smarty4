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
use Smarty\Exception\Magic;

/**
 * Smarty Internal Plugin Compile For Class
 *
 * @package Compiler
 */
class Template extends Magic
{
    /**
     * Compile template node
     *
     * @param Node                       $node if tag node
     * @param Code                       $codeTargetObj
     * @param bool                       $delete
     *
     */
    public static function compile(Node $node, Code $codeTargetObj, $delete = true)
    {
        self::compileHeader($node, $codeTargetObj);
        self::compileProperties($node, $codeTargetObj);
        self::compileBody($node, $codeTargetObj, $delete);
        self::compileFooter($node, $codeTargetObj);
    }

    /**
     * Compile header of template class
     *
     * @param Node $node
     * @param Code                       $codeTargetObj
     *
     */
    public static function compileHeader(Node $node, Code $codeTargetObj)
    {
        $compiler = $node->parser->compiler;
        $codeTargetObj->code("class {$node->templateClass} extends Core" . ($compiler->isInheritance ? '_Inheritance' : '') . " {\n")
            ->indent()
            ->code("/* Compiled from \"{$node->parser->context->filepath}\" */\n");
    }

    /**
     * Compile property section of template class
     *
     * @param Node $node if tag node
     * @param Code                       $codeTargetObj
     *
     */
    public static function compileProperties(Node $node, Code $codeTargetObj)
    {
        $compiler = $node->parser->compiler;
        $codeTargetObj->code("public \$version = '" . \Smarty::SMARTY_VERSION . "';\n")
            ->code("public \$has_nocache_code = " . ($compiler->has_nocache_code ? 'true' : 'false') . ";\n")
            ->code("public \$filepath = '{$compiler->compiled_filepath}';\n")
            ->code("public \$timestamp = {$compiler->timestamp};\n");
        if ($compiler->isInheritanceChild) {
            $codeTargetObj->code("public \$is_inheritance_child = true;\n");
        }
        if (!empty($node->parser->context->smarty->_cachedSubtemplates)) {
            $codeTargetObj->code("public \$_cachedSubtemplates = ")
                ->repr($node->context->smarty->_cachedSubtemplates, false)
                ->raw(";\n");
        }
        $codeTargetObj->code("public \$file_dependency = ")
            ->repr($node->file_dependency, false)
            ->raw(";\n");

        if (!empty($compiler->required_plugins['compiled'])) {
            $plugins = array();
            foreach ($compiler->required_plugins['compiled'] as $tmp) {
                foreach ($tmp as $data) {
                    $plugins[$data['file']] = $data['function'];
                }
            }
            $codeTargetObj->code("public \$required_plugins = ")
                ->repr($plugins, false)
                ->raw(";\n");
        }

        if (!empty($compiler->required_plugins['nocache'])) {
            $plugins = array();
            foreach ($compiler->required_plugins['nocache'] as $tmp) {
                foreach ($tmp as $data) {
                    $plugins[$data['file']] = $data['function'];
                }
            }
            $codeTargetObj->code("public \$required_plugins_nocache = ")
                ->repr($plugins, false)
                ->raw(";\n");
        }
        if (!empty($compiler->inheritance_blocks)) {
            $codeTargetObj->code("public \$inheritance_blocks = ")
                ->repr($compiler->inheritance_blocks, false)
                ->raw(";\n");
        }
        if (!empty($compiler->called_nocache_template_functions)) {
            $codeTargetObj->code("public \$called_nocache_template_functions = ")
                ->repr($compiler->called_nocache_template_functions, false)
                ->raw(";\n");
        }
        if (!empty($node->config_variables)) {
            $codeTargetObj->code("public \$config_variables = ")
                ->repr($node->config_variables, true, 2000)
                ->raw(";\n");
        }
    }

    /**
     * Compile body section of template class
     *
     * @param Node $node
     * @param Code $codeTargetObj target node for compiled code
     * @param bool                       $delete
     */
    public static function compileBody(Node $node, Code $codeTargetObj, $delete)
    {
        //$codeBody = $node->templateBodyNode->compile(null, $delete);
        $node->parser->compiler->pushOutputVar('output');
        $codeTargetObj->raw("\n\n")
            ->code("function _renderTemplate (\$_scope) {\n")
            ->indent()
            ->code("\$output = '';\n");
        $node->templateBodyNode->compile($codeTargetObj, $delete);
        $codeTargetObj->code("return \$output;\n")
            ->outdent()
            ->code("}\n\n");
        $node->parser->compiler->popOutputVar();
        if ($delete) {
            $node->templateBodyNode->cleanup();
            $node->templateBodyNode = null;
        }
    }

    /**
     * Compile footer of template class
     *
     * @param Node $node          if tag node
     * @param Code $codeTargetObj target node for compiled code
     */
    public static function compileFooter(Node $node, Code $codeTargetObj)
    {
        $compiler = $node->parser->compiler;
        $node->parser->compiler->compileNodeArray($node->templateFunctionNodes, $codeTargetObj);
        foreach ($compiler->inheritance_blocks_code as $code_obj) {
            $codeTargetObj->mergeCode($code_obj)
                ->newline();
        }
        $codeTargetObj->formatCode();
        $codeTargetObj->code("function _getSourceInfo () {\n")
            ->indent()
            ->code("return ")
            ->repr($codeTargetObj->traceback)
            ->raw(";\n")
            ->outdent()
            ->code("}\n")
            ->outdent()
            ->code("}\n");
        $codeTargetObj->formatCode();
    }
}
