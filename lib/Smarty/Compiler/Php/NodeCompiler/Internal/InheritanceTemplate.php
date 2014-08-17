<?php

/**
 * Smarty Internal Compile Call Of Inheritance Templates
 * Compiles code to load inheritance child and parent template
 *
 * @package Compiler
 * @author  Uwe Tews
 */

/**
 * Smarty Internal Compile Call Of Inheritance Templates Class
 *
 * @package Compiler
 */
class Smarty_Compiler_Php_ompiler_Internal_InheritanceTemplate extends \Smarty_Compiler_Code_Php_NodeCompiler_Tag
{

    /**
     * Attribute definition: Overwrites base class.
     *
     * @var array
     * @see $tpl_obj
     */
    public $required_attributes = array('file');
    public $option_flags = array('child');

    /**
     * Compiles code for calling inheritance templates
     *
     * @param  array  $args      array with attributes from parser
     * @param  object $compiler  compiler object
     * @param  array  $parameter array with compilation parameter
     * @param  string $tag       name of block plugin
     * @param  string $function  PHP function name
     *
     * @return string compiled code
     */
    public function compile($args, $compiler, $parameter, $tag, $function)
    {
        // check and get attributes
        $_attr = $this->getAttributes($compiler, $args);
        $_caching = Smarty::CACHING_OFF;
        // set inheritance flags
        $compiler->isInheritance = $compiler->isInheritanceChild = true;
        // parents must not create cache files
        if ($compiler->context->caching) {
            $_caching = Smarty::CACHING_NOCACHE_CODE;
        }
        $file = realpath(trim($_attr['file'], "'"));

        $this->iniTagCode($compiler);

        if ($_attr['child'] === true) {
            $this->code("\$compiled_obj = \$this->_getInheritanceTemplate ('{$file}', \$this->smarty->cacheId, \$this->smarty->compileId, {$_caching}, (isset(\$tpl) ? \$tpl : \$this->smarty), true);")
                 ->newline();
            $this->code("\$compiled_obj->_getRenderedTemplate\$this->smarty, \$_scope);")
                 ->newline();
        } else {
            $this->code("\$compiled_obj = \$this->_getInheritanceTemplate ('{$file}', \$this->smarty->cacheId, \$this->smarty->compileId, {$_caching}, (isset(\$tpl) ? \$tpl : \$this->smarty));")
                 ->newline();
            $this->code("echo \$compiled_obj->_getRenderedTemplate(\$this->smarty, \$_scope);")
                 ->newline();
        }
        $compiler->has_code = true;

        return $this->returnTagCode($compiler);
    }
}
