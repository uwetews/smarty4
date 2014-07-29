<?php

namespace Smarty\Compiler\Target\Language\Php\Compiler;

use Smarty\Node;
use Smarty\Compiler\Code;
use Smarty\Exception\Magic;

/**
 * Class TagAssign
 *
 * @package Smarty\Compiler\Target\Language\Php\Compiler
 */
class TagAssign extends Magic
{

    /**
     * Compile {assign} tag
     *
     * @param \Smarty_Compiler_Node  $target target node for compiled code
     * @param Smarty_Source_Node_Tag $node   if tag node
     * @param bool                   $delete
     */
    public static function compile(Node $node, Code $codeTargetObj, $delete)
    {
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
        if ($scope_type == \Smarty::SCOPE_GLOBAL) {
            $scopeString = '\Smarty::$_global_tpl_vars';
        } else {
            $scopeString = '$_scope->_tpl_vars';
        }
        $suffixChain = false;
        if (isset($node->tagAttributes['var'])) {
            $varname = $node->tagAttributes['var'];
        } else {
            $varname = $node->tagAttributes['variable']->internalNodeTrees['name'];
            if (isset($node->tagAttributes['variable']->internalNodeTrees['suffix'])) {
                $suffixChain = $node->tagAttributes['variable']->internalNodeTrees['suffix'];
            }
        }
        $varname[0]->compileAsValue = false;
        if ($suffixChain) {
            $codeTargetObj->code("\$this->_createLocalArrayVariable(")
                          ->compileNode($varname)
                          ->raw(", {$_nocache}, {$scope_type});\n")
                          ->code("{$scopeString}->{")
                          ->compileNode($varname)
                          ->raw("}->value");
            foreach ($suffixChain as $suffix) {
                $codeTargetObj->raw('[');
                if (isset($suffix['node'])) {
                    $codeTargetObj->compileNode($suffix['node'], $delete);
                }
                $codeTargetObj->raw(']');
            }
            $codeTargetObj->raw(" = ")
                          ->compileNode($node->tagAttributes['value'])
                          ->raw(";\n");
        } else {
            $codeTargetObj->code("\$this->_assignInScope(")
                          ->compileNode($varname)
                          ->raw(", new Entry(")
                          ->compileNode($node->tagAttributes['value'])
                          ->raw(", {$_nocache}), {$scope_type});\n");
        }

        if ($node->getTagOption('cachevalue')) {
            $node->tagAttributes['var']->compileAsValue = true;
            $codeTargetObj->code("echo '/*%%SmartyNocache%%*/\$_scope->_tpl_vars->")
                          ->compileNode($node->tagAttributes['var'], $delete)
                          ->raw(" = new Entry(' . \$this->_exportCacheValue(");
            if ($scope_type == \Smarty::SCOPE_GLOBAL) {
                $codeTargetObj->raw('\Smarty::$_global_tpl_vars->');
            } else {
                $codeTargetObj->raw('$_scope->_tpl_vars->');
            }
            $codeTargetObj->compileNode($node->tagAttributes['var'], $delete)
                          ->raw("->value) . ');/*/%%SmartyNocache%%*/';\n");
        }
    }

    /**
     * Compiles code for the {assign} tag
     *
     * @param  array  $args      array with attributes from parser
     * @param  object $compiler  compiler object
     * @param  array  $parameter array with compilation parameter
     *
     * @return string compiled code
     */
    public function compilerr($args, $compiler, $parameter)
    {
        // the following must be assigned at runtime because it will be overwritten in Smarty_Compiler_Code_Php_NodeCompiler_Tag_Append
        $this->required_attributes = array('var', 'value');
        $this->shorttag_order = array('var', 'value');
        $this->optional_attributes = array('scope');
        $this->option_flags = array('nocache', 'cachevalue');

        $_nocache = 'false';
        $scope_type = \Smarty::SCOPE_LOCAL;
        // check and get attributes
        $_attr = $this->getAttributes($compiler, $args);
        $var = trim($_attr['var'], '\'"');
        // nocache ?
        if ($compiler->tag_nocache || $compiler->nocache) {
            $_nocache = 'true';
            // create nocache var to make it know for further compiling
            if (isset($compiler->template_scope->_tpl_vars->$var)) {
                $compiler->template_scope->_tpl_vars->$var->nocache = true;
            } else {
                $compiler->template_scope->_tpl_vars->$var = new Entry(null, true);
            }
        }
        // scope setup
        if (isset($_attr['scope'])) {
            $_attr['scope'] = trim($_attr['scope'], "'\"");
            if ($_attr['scope'] == 'parent') {
                $scope_type = \Smarty::SCOPE_PARENT;
            } elseif ($_attr['scope'] == 'root') {
                $scope_type = \Smarty::SCOPE_ROOT;
            } elseif ($_attr['scope'] == 'smarty') {
                $scope_type = \Smarty::SCOPE_SMARTY;
            } elseif ($_attr['scope'] == 'global') {
                $scope_type = \Smarty::SCOPE_GLOBAL;
            } else {
                $compiler->error('illegal value for "scope" attribute', $compiler->lex->taglineno);
            }
        }
        // compiled output
        $this->iniTagCode($compiler);

        if ($scope_type == \Smarty::SCOPE_GLOBAL) {
            $scopeString = '\Smarty::$_global_tpl_vars';
        } else {
            $scopeString = '$_scope->_tpl_vars';
        }

        if (isset($parameter['smarty_internal_index'])) {
            $this->code("\$this->_createLocalArrayVariable('{$var}', {$_nocache}, {$scope_type});")
                 ->newline();
            $this->code("{$scopeString}->{$var}->value{$parameter['smarty_internal_index']} = {$_attr['value']};")
                 ->newline();
        } else {
            $this->code("\$this->_assignInScope('{$var}', new Entry($_attr[value], $_nocache), {$scope_type});")
                 ->newline();
        }

        if ($_attr['cachevalue'] === true && $compiler->context->caching) {
            if (isset($parameter['smarty_internal_index'])) {
                $compiler->error('cannot assign to array with "cachevalue" option', $compiler->lex->taglineno);
            } else {
                if (!$compiler->tag_nocache && !$compiler->nocache) {
                    $this->code("echo '/*%%SmartyNocache%%*/\$_scope->_tpl_vars->{$var} = new Entry (' . \$this->_exportCacheValue({$_attr['value']}) . ');/*/%%SmartyNocache%%*/';")
                         ->newline();
                } else {
                    $compiler->error('cannot assign with "cachevalue" option inside nocache section', $compiler->lex->taglineno);
                }
            }
        }

        return $this->returnTagCode($compiler);
    }
}
