<?php
/**
 * Smarty Wrapper Plugin for Smarty2 Defun
 */
class Smarty_Compiler_Fun extends Smarty_Compiler_Template_Tag
{
    public function compile($args, $compiler)
    {
        $function_compiler = new Smarty_Compiler_Template_Tag_Call;

        return $function_compiler->compile($args, $compiler);
    }
}
