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
class Smarty_Compiler_Php_NodeCompiler_Internal_Template extends \Smarty_Exception_Magic
{
    /**
     * Compile template node
     *
     * @param Smarty_Compiler_Node  $target target node for compiled code
     * @param \Smarty_Compiler_Node $node   if tag node
     * @param bool                  $delete
     */
    public static function compile(\Smarty_Compiler_Node $target, \Smarty_Compiler_Node $node, $delete = true)
    {
        self::compileHeader($node, $node);
        self::compileProperties($node, $node);
        self::compileBody($node, $node, $delete);
        self::compileFooter($node, $node);
        $node->formatCode();
        if ($target !== null) {
            $target->raw($node->compiled);
            $node->compiled = '';
        }
    }

    /**
     * Compile header of template class
     *
     * @param \Smarty_Compiler_Node $target target node for compiled code
     * @param \Smarty_Compiler_Node $node   if tag node
     */
    public static function compileHeader(\Smarty_Compiler_Node $target, \Smarty_Compiler_Node $node)
    {
        $compiler = $node->compiler;
        $target->code("class {$node->templateClass} Core" . ($compiler->isInheritance ? '_Inheritance' : '') . " {\n")
            ->indent()
            ->code("/* Compiled from \"{$node->parser->parser->context->filepath}\" */\n");
    }

    /**
     * Compile property section of template class
     *
     * @param \Smarty_Compiler_Node $target target node for compiled code
     * @param \Smarty_Compiler_Node $node   if tag node
     */
    public static function compileProperties(\Smarty_Compiler_Node $target, \Smarty_Compiler_Node $node)
    {
        $compiler = $node->compiler;
        $target->code("public \$version = '" . Smarty::\Smarty_VERSION . "';\n")
                ->code("public \$has_nocache_code = " . ($compiler->has_nocache_code ? 'true' : 'false') . ";\n")
                ->code("public \$filepath = '{$compiler->compiled_filepath}';\n")
                ->code("public \$timestamp = {$compiler->timestamp};\n");
        if ($compiler->isInheritanceChild) {
            $target->code("public \$is_inheritance_child = true;\n");
        }
        if (!empty($target->context->smarty->_cachedSubtemplates)) {
            $target->code("public \$_cachedSubtemplates = ")
                ->repr($node->context->smarty->_cachedSubtemplates, false)
                ->raw(";\n");
        }
        $target->code("public \$file_dependency = ")
            ->repr($node->file_dependency, false)
            ->raw(";\n");

        if (!empty($compiler->required_plugins['compiled'])) {
            $plugins = array();
            foreach ($compiler->required_plugins['compiled'] as $tmp) {
                foreach ($tmp as $data) {
                    $plugins[$data['file']] = $data['function'];
                }
            }
            $target->code("public \$required_plugins = ")
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
            $target->code("public \$required_plugins_nocache = ")
                ->repr($plugins, false)
                ->raw(";\n");
        }
        if (!empty($compiler->inheritance_blocks)) {
            $target->code("public \$inheritance_blocks = ")
                ->repr($compiler->inheritance_blocks, false)
                ->raw(";\n");
        }
        if (!empty($compiler->called_nocache_template_functions)) {
            $target->code("public \$called_nocache_template_functions = ")
                ->repr($compiler->called_nocache_template_functions, false)
                ->raw(";\n");
        }
        if (!empty($node->config_variables)) {
            $target->code("public \$config_variables = ")
                ->repr($node->config_variables, true, 2000)
                ->raw(";\n");
        }
    }

    /**
     * Compile body section of template class
     *
     * @param \Smarty_Compiler_Node $target target node for compiled code
     * @param \Smarty_Compiler_Node $node   if tag node
     * @param bool                  $delete
     */
    public static function compileBody(\Smarty_Compiler_Node $target, \Smarty_Compiler_Node $node, $delete)
    {
        $node->compiler->pushOutputVar('output');
        $target->raw("\n\n")
            ->code("function _renderTemplate (\$_scope) {\n")
            ->indent()
            ->code("\$output = '';\n")
            ->formatCode($node->templateBodyNode, $delete)
            ->code("return \$output;\n")
            ->outdent()
            ->code("}\n\n");
        $node->compiler->popOutputVar();
        if ($delete) {
            $node->templateBodyNode = null;
        }
    }

    /**
     * Compile footer of template class
     *
     * @param \Smarty_Compiler_Node $target target node for compiled code
     * @param \Smarty_Compiler_Node $node   if tag node
     */
    public static function compileFooter(\Smarty_Compiler_Node $target, \Smarty_Compiler_Node $node)
    {
        $compiler = $node->compiler;
        $target->compileNodeArray($node->templateFunctionNodes);
        foreach ($compiler->inheritance_blocks_code as $code_obj) {
            $target->mergeCode($code_obj)
                ->newline();
        }
        $target->code("function _getSourceInfo () {\n")
            ->indent()
            ->code("return ")
            ->repr($target->traceback)
            ->raw(";\n")
            ->outdent()
            ->code("}\n")
            ->outdent()
            ->code("}\n");
    }
}
