<?php
/**
 * Smarty Wrapper Plugin for Smarty2 Defun
 */
class Smarty_Compiler_Defun extends Smarty_Compiler_Template_Tag
{
    public function compile($args, $compiler)
    {
        $this->compiler = $compiler;
        $function_compiler = new Smarty_Compiler_Template_Tag_Function;
        $code_obj = $function_compiler->compile($args, $compiler);
        $this->_open_tag('defun', $args);

        return;
    }
}

class Smarty_Compiler_Defunclose extends Smarty_Compiler_Template_Tag
{
    public function compile($args, $compiler)
    {
        $this->compiler = $compiler;
        $function_compiler = new Smarty_Compiler_Template_Tag_Functionclose;
        $call_compiler = new Smarty_Compiler_Template_Tag_Call;
        $saved_args = $this->_close_tag(array('defun'));
        $code_obj = $function_compiler->compile($args, $compiler);
        $args = $saved_args;

        return $code_obj . $call_compiler->compile($args, $compiler);
    }
}
