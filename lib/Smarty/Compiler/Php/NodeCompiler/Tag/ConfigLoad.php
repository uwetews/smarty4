<?php

/**
 * Smarty Internal Plugin Compile Config Load
 * Compiles the {config load} tag
 *
 * @package Compiler
 * @author  Uwe Tews
 */

/**
 * Smarty Internal Plugin Compile Config Load Class
 *
 * @package Compiler
 */
class Smarty_Compiler_Php_NodeCompiler_Tag_ConfigLoad extends Smarty_Compiler_Code_Php_NodeCompiler_Tag
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
    public $shorttag_order = array('file', 'section');

    /**
     * Attribute definition: Overwrites base class.
     *
     * @var array
     * @see $tpl_obj
     */
    public $optional_attributes = array('section', 'scope');

    /**
     * Compiles code for the {config_load} tag
     *
     * @param  array  $args     array with attributes from parser
     * @param  object $compiler compiler object
     *
     * @return string compiled code
     */
    public function compile($args, $compiler)
    {
        // check and get attributes
        $_attr = $this->getAttributes($compiler, $args);

        if ($_attr['nocache'] === true) {
            $compiler->error('nocache option not allowed', $compiler->lex->taglineno);
        }

        // save possible attributes
        $conf_file = $_attr['file'];
        if (isset($_attr['section'])) {
            $section = $_attr['section'];
        } else {
            $section = 'null';
        }
        $scope_type = Smarty::SCOPE_LOCAL;
        // scope setup
        if (isset($_attr['scope'])) {
            $_attr['scope'] = trim($_attr['scope'], "'\"");
            if ($_attr['scope'] == 'parent') {
                $scope_type = Smarty::SCOPE_PARENT;
            } elseif ($_attr['scope'] == 'root') {
                $scope_type = Smarty::SCOPE_ROOT;
            } elseif ($_attr['scope'] == 'global') {
                $scope_type = Smarty::SCOPE_GLOBAL;
            } elseif ($_attr['scope'] == 'local') {
                $scope_type = Smarty::SCOPE_LOCAL;
            } else {
                $compiler->error('illegal value for "scope" attribute', $compiler->lex->taglineno);
            }
        }
        // create config object
        $this->iniTagCode($compiler);

        $this->code("\$this->configLoad($conf_file, $section, {$scope_type});")
             ->newline();

        return $this->returnTagCode($compiler);
    }
}
