<?php

/**
 * Smarty Extension
 * Smarty class methods
 *
 * @package Smarty\Extension
 * @author  Uwe Tews
 */

/**
 * Class for isCompiled method
 *
 * @package Smarty\Extension
 */
class Smarty_Method_IsCompiled
{
    /**
     * test if compiled template is valid
     *
     * @api
     *
     * @param Smarty         $smarty    smarty object
     * @param  string|object $template  the resource handle of the template file or template object
     * @param  mixed         $compileId compile id to be used with this template
     * @param  null          $caching
     *
     * @throws Smarty_Exception_SourceNotFound
     * @throws Exception
     * @return boolean       compilation status
     */
    public function isCompiled(Smarty $smarty, $template = null, $compileId = null, $caching = null)
    {
        if ($smarty->forceCompile) {
            return false;
        }
        if ($template === null && ($smarty->_usage == Smarty::IS_SMARTY_TPL_CLONE || $smarty->_usage == Smarty::IS_CONFIG)) {
            $template = $smarty;
        }
        //get source object from cache  or create new one
        $context = $smarty->_getContext($template, null, $compileId, null, false, null, null, null, $caching);
        // checks if source exists
        if (!$context->exists) {
            throw new Smarty_Exception_SourceNotFound($context->type, $context->name);
        }
        if ($context->handler->recompiled) {
            // recompiled return always false
            return false;
        }
        if ($context->handler->uncompiled) {
            // uncompiled source returns always true
            return true;
        }
        $res_obj = $smarty->_loadResource(Smarty::COMPILED, $smarty->compiledType);
        $timestamp = $exists = false;
        $filepath = $res_obj->buildFilepath($context);
        $res_obj->populateTimestamp($smarty, $filepath, $timestamp, $exists);
        if (!$exists || $timestamp < $context->timestamp) {
            return false;
        }
        try {
            $template_obj = $smarty->_getTemplateObject(Smarty::COMPILED, $context, false);
            if ($template_obj === false) {
                return false;
            }
            return $template_obj->isValid;
        }
        catch (Exception $e) {
            throw $e;
        }
    }
}
