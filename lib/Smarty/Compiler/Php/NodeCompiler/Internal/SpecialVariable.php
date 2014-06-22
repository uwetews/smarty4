<?php

/**
 * Smarty Internal Plugin Compile Special Smarty Variable
 * Compiles the special $smarty variables
 *
 * @package Compiler
 * @author  Uwe Tews
 */

/**
 * Smarty Internal Plugin Compile special Smarty Variable Class
 *
 * @package Compiler
 */
class Smarty_Compiler_Php_ompiler_Internal_SpecialVariable extends \Smarty_Compiler_Code_Php_NodeCompiler_Tag
{

    /**
     * Compiles code for the special $smarty variables
     *
     * @param  array  $args      array with attributes from parser
     * @param  object $compiler  compiler object
     * @param  string $parameter string with optional array indexes
     *
     * @return string compiled code
     */
    public function compile($args, $compiler, $parameter)
    {
        $_index = preg_split("/\]\[/", substr($parameter, 1, strlen($parameter) - 2));
        $compiled_ref = ' ';
        $variable = trim($_index[0], "'");
        switch ($variable) {
            case 'foreach':
            case 'section':
                $name = 'smarty';
                for ($i = 0; $i < count($_index) - 1; $i ++) {
                    $name .= '_' . trim($_index[$i], "'");
                }
                $last = end($_index);
                return "\$_scope->_tpl_vars->{$name}->value[$last]";
            case 'capture':
                return "Smarty::\$_smartyVars$parameter";
            case 'now':
                return 'time()';
            case 'cookies':
                if (isset($compiler->context->smarty->securityPolicy) && !$compiler->context->smarty->securityPolicy->allow_super_globals) {
                    $compiler->error("(secure mode) super globals not permitted");
                    break;
                }
                $compiled_ref = '@$_COOKIE';
                break;

            case 'get':
            case 'post':
            case 'env':
            case 'server':
            case 'session':
            case 'request':
                if (isset($compiler->context->smarty->securityPolicy) && !$compiler->context->smarty->securityPolicy->allow_super_globals) {
                    $compiler->error("(secure mode) super globals not permitted");
                    break;
                }
                $compiled_ref = '@$_' . strtoupper($variable);
                break;

            case 'template':
                return 'basename($this->context->filepath)';

            case 'current_dir':
                return 'dirname($this->context->filepath)';

            case 'is_cached':
                return '$this->is_cache';

            case 'is_nocache':
                // TODO This flag is currently not implemented
                return '$this->smarty->is_nocache';

            case 'version':
                $_version = Smarty::SMARTY_VERSION;

                return "'$_version'";

            case 'const':
                if (isset($compiler->context->smarty->securityPolicy) && !$compiler->context->smarty->securityPolicy->allow_constants) {
                    $compiler->error("(secure mode) constants not permitted");
                    break;
                }

                return '@constant(' . $_index[1] . ')';

            case 'config':
                $name = trim($_index[1], "'");
                if (isset($_index[2])) {
                    return "\$_scope->_tpl_vars->___config_var_{$name}[{$_index[2]}]";
                } else {
                    return "\$_scope->_tpl_vars->___config_var_{$name}";
                }
            case 'ldelim':
                $_ldelim = $compiler->context->smarty->left_delimiter;

                return "'$_ldelim'";

            case 'rdelim':
                $_rdelim = $compiler->context->smarty->right_delimiter;

                return "'$_rdelim'";

            case 'block':
                $output = '';
                if (trim($_index[1], "'") == 'parent') {
                    $output = $compiler->compileTag('private_block_parent', array(), array());
                } elseif (trim($_index[1], "'") == 'child') {
                    $output = $compiler->compileTag('private_block_child', array(), array());
                } else {
                    $compiler->error('$smarty.block.' . trim($_index[1], "'") . ' is invalid');
                }

                return $output;

            default:
                $compiler->error('$smarty.' . trim($_index[0], "'") . ' is invalid');
                break;
        }
        if (isset($_index[1])) {
            array_shift($_index);
            foreach ($_index as $_ind) {
                $compiled_ref = $compiled_ref . "[$_ind]";
            }
        }

        return $compiled_ref;
    }
}
