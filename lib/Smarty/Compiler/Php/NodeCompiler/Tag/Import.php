<?php

/**
 * Smarty Internal Plugin Compile Import
 * Compiles the {import} tag
 *
 * @package Compiler
 * @author  Uwe Tews
 */

/**
 * Smarty Internal Plugin Compile Import Class
 *
 * @package Compiler
 */
class Smarty_Compiler_Php_NodeCompiler_Tag_Import extends Smarty_Compiler_Code_Php_NodeCompiler_Tag
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
    public $option_flags = array();

    /**
     * Attribute definition: Overwrites base class.
     *
     * @var array
     * @see $tpl_obj
     */
    public $optional_attributes = array();

    /**
     * Compiles code for the {import} tag
     *
     * @param  array  $args      array with attributes from parser
     * @param  object $compiler  compiler object
     * @param  array  $parameter array with compilation parameter
     *
     * @return string compiled code
     */
    public function compile($args, $compiler, $parameter)
    {
        // check and get attributes
        $_attr = $this->getAttributes($compiler, $args);

        $include_file = $_attr['file'];
        if (!(substr_count($include_file, "'") == 2 || substr_count($include_file, '"') == 2)) {
            $compiler->error('illegal variable template name', $compiler->lex->taglineno);
        }
        $_scope = new Smarty_Template_Scope($compiler->context);
        eval("\$tpl_name = $include_file;");
        $context = $compiler->context->smarty->_getContext($tpl_name);
        $comp = Smarty_Compiler::load($context, null);
        $comp->nocache = $compiler->nocache;
        // set up parameter
        $comp->suppressTemplatePropertyHeader = true;
        $comp->suppressPostFilter = true;
        $comp->write_compiled_code = false;
        $comp->template_code->indentation = $compiler->template_code->indentation;
        $comp->isInheritance = $compiler->isInheritance;
        $comp->isInheritanceChild = $compiler->isInheritanceChild;
        // compile imported template
        $comp->template_code->code("/*  Imported template \"{$tpl_name}\" */")
                            ->newline();
        $comp->compileTemplate();
        $comp->template_code->code("/*  End of imported template \"{$tpl_name}\" */")
                            ->newline();
        // merge compiled code for {function} tags
        if (!empty($comp->_templateFunctions)) {
            $compiler->_templateFunctions = array_merge($compiler->_templateFunctions, $comp->_templateFunctions);
            $compiler->_templateFunctions_code = array_merge($compiler->_templateFunctions_code, $comp->_templateFunctions_code);
        }
        // merge compiled code for {block} tags
        if (!empty($comp->inheritance_blocks)) {
            $compiler->inheritance_blocks = array_merge($compiler->inheritance_blocks, $comp->inheritance_blocks);
            $compiler->inheritance_blocks_code = array_merge($compiler->inheritance_blocks_code, $comp->inheritance_blocks_code);
        }
        $compiler->required_plugins['compiled'] = array_merge($compiler->required_plugins['compiled'], $comp->required_plugins['compiled']);
        $compiler->required_plugins['nocache'] = array_merge($compiler->required_plugins['nocache'], $comp->required_plugins['nocache']);
        // merge filedependency
        $compiler->file_dependency = array_merge($compiler->file_dependency, $comp->file_dependency);
        $compiler->has_nocache_code = $compiler->has_nocache_code | $comp->has_nocache_code;

        // output compiled code

        $compiler->suppressNocacheProcessing = true;
        $this->iniTagCode($compiler);
        $this->preCompiled .= $comp->template_code->preCompiled;
        // release compiler object to free memory
        unset($comp);

        return $this->returnTagCode($compiler);
    }
}
