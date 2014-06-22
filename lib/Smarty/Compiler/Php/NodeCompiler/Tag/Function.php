<?php

/**
 * Smarty Internal Plugin Compile Function
 * Compiles the {function} {/function} tags
 *
 * @package Compiler
 * @author  Uwe Tews
 */

/**
 * Smarty Internal Plugin Compile Function Class
 *
 * @package Compiler
 */
class Smarty_Compiler_Php_NodeCompiler_Tag_Function extends Smarty_Exception_Magic
{

    /**
     * Compile {function} tag
     *
     * @param Smarty_Compiler_Node   $target target node for compiled code
     * @param Smarty_Source_Node_Tag $node   if tag node
     * @param bool                   $delete
     */
    public static function compile(Smarty_Compiler_Node $target, Smarty_Source_Node_Tag $node, $delete)
    {
        if (isset($node->attributeNodes['name']->value) && is_string($node->attributeNodes['name']->value)) {
            $_name = $node->attributeNodes['name']->value;
        } else {
            //TODO error
        }
        unset($node->attributeNodes['name']);
        $target->code("function _renderTemplateFunction_{$_name}(\$_scope, \$params) {\n")
            ->indent()
            ->code("\$output = '';\n");
        if (!empty($node->attributeNodes)) {
            foreach ($node->attributeNodes as $var => $n) {
                $target->lineNo($node->sourceLineNo)
                    ->code("\$_scope->_tpl_vars->{$var}")
                    ->raw(' = new Entry(');
                $target->compileNode($n);
                $target->raw(");\n");
                unset($n, $node->attributeNodes[$var]);
            }
        }
        $target->lineNo($node->sourceLineNo)
            ->code("foreach (\$params as \$key => \$value) {\n")
            ->indent()
            ->code("\$_scope->_tpl_vars->\$key = new Entry (\$value);\n")
            ->outdent()
            ->code("}\n");
        // Body
        $target->compileNodeArray($node->subtreeNodes, $delete);
        $target->code("return \$output;\n")
            ->outdent()
            ->code("}\n\n");
    }

    /**
     * Compiles code for the {/function} tag
     *
     * @param  array  $args      array with attributes from parser
     * @param  object $compiler  compiler object
     * @param  array  $parameter array with compilation parameter
     *
     * @return boolean true
     */
    public function compilex($args, $compiler, $parameter)
    {
        $_attr = $this->getAttributes($compiler, $args);

        $saved_data = $this->closeTag($compiler, array('function'));
        $_name = trim($saved_data[0]['name'], "'\"");
        unset($saved_data[0]['name']);
        // set flag that we are compiling a template function
        $compiler->_templateFunctions[$_name]['parameter'] = array();
        //        $this->smarty = $compiler->context->smarty;
        foreach ($saved_data[0] as $_key => $_data) {
            eval('$tmp=' . $_data . ';');
            $compiler->_templateFunctions[$_name]['parameter'][$_key] = $tmp;
        }
        // if caching save template function for possible nocache call
        if ($compiler->context->caching) {
            if (!empty($compiler->called_template_functions)) {
                $compiler->_templateFunctions[$_name]['called_functions'] = $compiler->called_template_functions;
                $compiler->called_template_functions = array();
            }
            $plugins = array();
            foreach ($compiler->required_plugins['compiled'] as $plugin => $tmp) {
                if (!isset($saved_data[4]['compiled'][$plugin])) {
                    foreach ($tmp as $data) {
                        $plugins[$data['file']] = $data['function'];
                    }
                }
            }
            if (!empty($plugins)) {
                $compiler->_templateFunctions[$_name]['used_plugins'] = $plugins;
            }
        }

        if ($compiler->context->type == 'eval' || $compiler->context->type == 'string') {
            $resource = $compiler->context->type;
        } else {
            $resource = $compiler->context->smarty->templateResource;
            // santitize extends resource
            if (strpos($resource, 'extends:') !== false) {
                $start = strpos($resource, ':');
                $end = strpos($resource, '|');
                $resource = substr($resource, $start + 1, $end - $start - 1);
            }
        }

        $code = new Smarty_Compiler_Code(1);
        $code->code("function _renderTemplateFunction_{$_name}(\$_scope, \$params) {")
            ->newline()
            ->indent();
        $code->addSourceLineNo($saved_data[3]);
        $code->code("foreach (\$params as \$key => \$value) {")
            ->newline()
            ->indent();
        $code->code("\$_scope->_tpl_vars->\$key = new Entry (\$value);")
            ->newline();
        $code->outdent()
            ->code("}")
            ->newline();
        $code->mergeCode($compiler->template_code);
        $code->outdent()
            ->code("}")
            ->newline();

        $compiler->_templateFunctions_code[$_name] = $code;

        // reset flag that we are compiling a template function
        $compiler->compiles_template_function = false;
        // restore old compiler status
        $compiler->template_code = $saved_data[1];

        $compiler->has_nocache_code = $compiler->has_nocache_code | $saved_data[2];
        $compiler->has_code = false;

        return true;
    }
}
