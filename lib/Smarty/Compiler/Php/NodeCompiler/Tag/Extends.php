<?php

/**
 * Smarty Internal Plugin Compile extend
 * Compiles the {extends} tag
 *
 * @package Compiler
 * @author  Uwe Tews
 */

/**
 * Smarty Internal Plugin Compile extend Class
 *
 * @package Compiler
 */
class Smarty_Compiler_Php_NodeCompiler_Tag_Extends extends Smarty_Compiler_Code_Php_NodeCompiler_Tag
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
     * Compiles code for the {extends} tag
     *
     * @param  array  $args     array with attributes from parser
     * @param  object $compiler compiler object
     *
     * @return string compiled code
     */
    public function compile($args, $compiler)
    {
        // do not compile tag if template is recompiled to create nocache {block} code
        if ($compiler->nocache) {
            $compiler->has_code = false;

            return true;
        }
        // set inheritance flags
        $compiler->isInheritance = $compiler->isInheritanceChild = true;
        // check and get attributes
        $_attr = $this->getAttributes($compiler, $args);
        if ($_attr['nocache'] === true) {
            $compiler->error('nocache option not allowed', $compiler->lex->taglineno);
        }
        $_caching = Smarty::CACHING_OFF;
        // parents must not create cache files
        if ($compiler->context->caching) {
            $_caching = Smarty::CACHING_NOCACHE_CODE;
        }

        $this->iniTagCode($compiler);

        $this->code("ob_get_clean();")
             ->newline();
        $this->code("\$compiled_obj = \$this->_getInheritanceTemplate ({$_attr['file']}, \$this->smarty->cacheId, \$this->smarty->compileId, {$_caching}, \$this->smarty);")
             ->newline();
        $this->code("echo \$compiled_obj->_getRenderedTemplate(\$this->smarty, \$_scope);")
             ->newline();

        $compiler->compiled_footer_code[] = $this->preCompiled;
        $this->preCompiled = '';

        // code for grabbing all output of child template which must be dropped
        $this->code("ob_start();")
             ->newline();
        //      TODO remove
        //        $this->code("\$this->is_child = true;")->newline();
        $compiler->has_code = true;

        return $this->returnTagCode($compiler);
    }
}
