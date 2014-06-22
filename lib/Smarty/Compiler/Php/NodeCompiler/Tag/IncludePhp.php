<?php

/**
 * Smarty Internal Plugin Compile Include PHP
 * Compiles the {include_php} tag
 *
 * @package Compiler
 * @author  Uwe Tews
 */

/**
 * Smarty Internal Plugin Compile Insert Class
 *
 * @package Compiler
 */
class Smarty_Compiler_Php_NodeCompiler_Tag_IncludePhp extends Smarty_Compiler_Code_Php_NodeCompiler_Tag
{

    /**
     * Attribute definition: Overwrites base class.
     *
     * @var array
     * @see $tpl_obj
     */
    public $required_attributes = array('file');

    /**
     * Attribute definition: Overwrites base class.
     *
     * @var array
     * @see $tpl_obj
     */
    public $shorttag_order = array('file');

    /**
     * Attribute definition: Overwrites base class.
     *
     * @var array
     * @see $tpl_obj
     */
    public $optional_attributes = array('once', 'assign');

    /**
     * Compiles code for the {include_php} tag
     *
     * @param  array  $args     array with attributes from parser
     * @param  object $compiler compiler object
     *
     * @throws Smarty_Exception
     * @return string           compiled code
     */
    public function compile($args, $compiler)
    {
        if (!($compiler->context->smarty instanceof Smarty_Smarty2BC)) {
            throw new Smarty_Exception("{include_php} is deprecated, use Smarty_Smarty2BC class to enable");
        }
        // check and get attributes
        $_attr = $this->getAttributes($compiler, $args);
        $_scope = new Smarty_Template_Scope($compiler->context);
        $_filepath = false;
        eval('$_file = ' . $_attr['file'] . ';');
        if (!isset($compiler->context->smarty->securityPolicy) && is_file($_file)) {
            $_filepath = $_file;
        } else {
            if (isset($compiler->context->smarty->securityPolicy)) {
                $_dir = $compiler->context->smarty->securityPolicy->trusted_dir;
            } else {
                $_dir = $compiler->context->smarty->trusted_dir;
            }
            if (!empty($_dir)) {
                foreach ((array) $_dir as $_script_dir) {
                    $_script_dir = rtrim($_script_dir, '/\\') . '/';
                    if (is_file($_script_dir . $_file)) {
                        $_filepath = $_script_dir . $_file;
                        break;
                    }
                }
            }
        }
        if ($_filepath == false) {
            $compiler->error("{include_php} file '{$_file}' is not readable", $compiler->lex->taglineno);
        }

        if (isset($compiler->context->smarty->securityPolicy)) {
            $compiler->context->smarty->securityPolicy->isTrustedPHPDir($_filepath);
        }

        if (isset($_attr['assign'])) {
            // output will be stored in a smarty variable instead of being displayed
            $_assign = $_attr['assign'];
        }
        $_once = '_once';
        if (isset($_attr['once'])) {
            if ($_attr['once'] == 'false') {
                $_once = '';
            }
        }

        $this->iniTagCode($compiler);

        if (isset($_assign)) {
            $this->code('ob_start();')
                ->newline();
            $this->code("include{$_once} ('{$_filepath}');")
                ->newline();
            $this->code("\$this->assign({$_assign},ob_get_clean());")
                ->newline();
        } else {
            $this->code("include{$_once} ('{$_filepath}');")
                ->newline();
        }

        return $this->returnTagCode($compiler);
    }
}
