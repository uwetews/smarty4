<?php

/**
 * Smarty Extension
 * Smarty class methods
 *
 * @package Smarty\Extension
 * @author  Uwe Tews
 */

/**
 * Class for compileTemplate method
 *
 * @package Smarty\Extension
 */
class Smarty_Method_CompileTemplate
{
    /**
     * test if compiled template is valid
     *
     * @api
     *
     * @param Smarty         $smarty    smarty object
     * @param  string|object $template  the resource handle of the template file or template object
     * @param  mixed         $compileId compile id to be used with this template
     * @param  object        $parent    next higher level of Smarty variables
     * @param  null          $caching
     *
     * @throws Smarty_Exception_SourceNotFound
     * @throws Exception
     * @return boolean      status of compilation
     */
    public function compileTemplate(Smarty $smarty, $template = null, $compileId = null, $parent = null, $caching = null)
    {
        if ($template === null && ($smarty->_usage == Smarty::IS_SMARTY_TPL_CLONE || $smarty->_usage == Smarty::IS_CONFIG)) {
            $template = $smarty;
        }
        //get source object from cache  or create new one
        $context = $smarty->_getContext($template, null, $compileId, $parent, false, null, null, null, $caching);
        // checks if source exists
        if (!$context->exists) {
            throw new Smarty_Exception_SourceNotFound($context->type, $context->name);
        }
        if ($context->handler->uncompiled) {
            // uncompiled source returns always true
            return true;
        }
        try {
            $res_obj = $context->smarty->_loadResource(Smarty::COMPILED, $context->smarty->compiledType);
            $filepath = $res_obj->buildFilepath($context);
            $compiler = Smarty_Compiler::load($context, $filepath);
            $compiler->compileSource();
            $key = $context->_key . '#' . (isset($context->compileId) ? $context->compileId : '') . '#' . (($context->caching) ? 1 : 0);
            unset(Smarty::$_compiled_object_cache[$key]);
            return true;
        }
        catch (Exception $e) {
            throw $e;
        }
    }
}
