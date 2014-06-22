<?php

/**
 * Smarty Internal Plugin Compile Eval
 * Compiles the {eval} tag.
 *
 * @package Compiler
 * @author  Uwe Tews
 */

/**
 * Smarty Internal Plugin Compile Eval Class
 *
 * @package Compiler
 */
class Smarty_Compiler_Php_NodeCompiler_Tag_Eval extends Smarty_Compiler_Code_Php_NodeCompiler_Tag
{

    /**
     * Attribute definition: Overwrites base class.
     *
     * @var array
     * @see $tpl_obj
     */
    public $required_attributes = array('var');

    /**
     * Attribute definition: Overwrites base class.
     *
     * @var array
     * @see $tpl_obj
     */
    public $optional_attributes = array('assign');

    /**
     * Attribute definition: Overwrites base class.
     *
     * @var array
     * @see $tpl_obj
     */
    public $shorttag_order = array('var', 'assign');

    /**
     * Compiles code for the {eval} tag
     *
     * @param  array  $args     array with attributes from parser
     * @param  object $compiler compiler object
     *
     * @return string compiled code
     */
    public function compile($args, $compiler)
    {
        $this->required_attributes = array('var');
        $this->optional_attributes = array('assign');
        // check and get attributes
        $_attr = $this->getAttributes($compiler, $args);
        if (isset($_attr['assign'])) {
            // output will be stored in a smarty variable instead of beind displayed
            $_assign = $_attr['assign'];
        }
        $this->iniTagCode($compiler);

        // create template object
        $this->code("\$tpl_obj = \$this->smarty->createTemplate('eval:'." . $_attr['var'] . ", \$this->smarty);")
            ->newline();
        //was there an assign attribute?
        if (isset($_assign)) {
            $this->code("\$this->assign($_assign,\$tpl_obj->fetch());")
                ->newline();
        } else {
            $this->code("echo \$tpl_obj->fetch();")
                ->newline();
        }
        $this->code("unset(\$tpl_obj->source, \$tpl_obj->compiled, \$tpl_obj->compiler, \$tpl_obj);")
            ->newline();

        return $this->returnTagCode($compiler);
    }
}
