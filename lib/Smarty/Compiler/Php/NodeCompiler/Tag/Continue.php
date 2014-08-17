<?php

/**
 * Smarty Internal Plugin Compile Continue
 * Compiles the {continue} tag
 *
 * @package Compiler
 * @author  Uwe Tews
 */

/**
 * Smarty Internal Plugin Compile Continue Class
 *
 * @package Compiler
 */
class Smarty_Compiler_Php_NodeCompiler_Tag_Continue extends Smarty_Compiler_Code_Php_NodeCompiler_Tag
{

    /**
     * Attribute definition: Overwrites base class.
     *
     * @var array
     * @see $tpl_obj
     */
    public $optional_attributes = array('levels');

    /**
     * Attribute definition: Overwrites base class.
     *
     * @var array
     * @see $tpl_obj
     */
    public $shorttag_order = array('levels');

    /**
     * Compiles code for the {continue} tag
     *
     * @param  array  $args      array with attributes from parser
     * @param  object $compiler  compiler object
     * @param  array  $parameter array with compilation parameter
     *
     * @return string compiled code
     */
    public function compile($args, $compiler, $parameter)
    {
        static $_is_loopy = array('for' => true, 'foreach' => true, 'while' => true, 'section' => true);
        // check and get attributes
        $_attr = $this->getAttributes($compiler, $args);

        if ($_attr['nocache'] === true) {
            $compiler->error('nocache option not allowed', $compiler->lex->taglineno);
        }

        if (isset($_attr['levels'])) {
            if (!is_numeric($_attr['levels'])) {
                $compiler->error('level attribute must be a numeric constant', $compiler->lex->taglineno);
            }
            $_levels = $_attr['levels'];
        } else {
            $_levels = 1;
        }
        $level_count = $_levels;
        $stack_count = count($compiler->_tag_stack) - 1;
        while ($level_count > 0 && $stack_count >= 0) {
            if (isset($_is_loopy[$compiler->_tag_stack[$stack_count][0]])) {
                $level_count --;
            }
            $stack_count --;
        }
        if ($level_count != 0) {
            $compiler->error("cannot continue {$_levels} level(s)", $compiler->lex->taglineno);
        }
        $compiler->has_code = true;

        $this->iniTagCode($compiler);

        $this->code("continue {$_levels};")
             ->newline();

        return $this->returnTagCode($compiler);
    }
}
