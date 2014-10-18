<?php

/**
 * Smarty Internal Plugin Compile Capture
 * Compiles the {capture} tag
 *
 * @package Compiler
 * @author  Uwe Tews
 */

/**
 * Smarty Internal Plugin Compile Capture Class
 *
 * @package Compiler
 */
class Smarty_Compiler_Php_NodeCompiler_Tag_Capture extends SmartSmarty_Compiler_Php_ompiler_Tag
{

    /**
     * capture  stack during compilation
     *
     * @var array
     */
    public static $_capture_stack = array();
    /**
     * Attribute definition: Overwrites base class.
     *
     * @var array
     * @see $tpl_obj
     */
    public $shorttag_order = array('name');
    /**
     * Attribute definition: Overwrites base class.
     *
     * @var array
     * @see $tpl_obj
     */
    public $optional_attributes = array('name', 'assign', 'append');

    /**
     * Compiles code for the {capture} tag
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

        $preCompiled = isset($_attr['name']) ? $_attr['name'] : "'default'";
        $assign = isset($_attr['assign']) ? $_attr['assign'] : 'null';
        $append = isset($_attr['append']) ? $_attr['append'] : 'null';

        self::$_capture_stack[] = array($preCompiled, $assign, $append, $compiler->nocache);
        // maybe nocache because of nocache variables
        $compiler->nocache = $compiler->nocache | $compiler->tag_nocache;

        $this->iniTagCode($compiler);

        $this->code("\$this->_capture_stack[0][] = array($preCompiled, $assign, $append);")
             ->newline();
        $this->code("ob_start();")
             ->newline();

        return $this->returnTagCode($compiler);
    }
}

/**
 * Smarty Internal Plugin Compile Captureclose Class
 *
 * @package Compiler
 */
class Smarty_ComSmarty_Compiler_Php_er_Tag_CaptureClose extends Smarty_CompilerSmarty_Compiler_Php_g
{

    /**
     * Compiles code for the {/capture} tag
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
        // must end block be nocache?
        if ($compiler->nocache) {
            $compiler->tag_nocache = true;
        }

        list($preCompiled, $assign, $append, $compiler->nocache) = array_pop(Smarty_Compiler_Code_Php_NodeCompiler_Tag_Capture::$_capture_stack);

        $this->iniTagCode($compiler);

        $this->code("list(\$_capture_buffer, \$_capture_assign, \$_capture_append) = array_pop(\$this->_capture_stack[0]);")
             ->newline();
        $this->code("if (!empty(\$_capture_buffer)) {")
             ->newline()
             ->indent();
        $this->code("if (isset(\$_capture_assign)) {")
             ->newline()
             ->indent();
        $this->code("\$this->assign(\$_capture_assign, ob_get_contents());")
             ->newline();
        $this->outdent()
             ->code("}")
             ->newline();
        $this->code("if (isset( \$_capture_append)) {")
             ->newline()
             ->indent();
        $this->code("\$this->append(\$_capture_append, ob_get_contents());")
             ->newline();
        $this->outdent()
             ->code("}")
             ->newline();
        $this->code("Smarty::\$_smartyVars['capture'][\$_capture_buffer]=ob_get_clean();")
             ->newline();
        $this->outdent()
             ->code("} else {")
             ->newline()
             ->indent();
        $this->code("throw new Smarty_Exception_CaptureError();")
             ->newline();
        $this->outdent()
             ->code("}")
             ->newline();

        return $this->returnTagCode($compiler);
    }
}
