<?php

/**
 * Smarty Extension
 * Smarty class methods
 *
 * @package Smarty\Extension
 * @author  Uwe Tews
 */

/**
 * Class for isCached method
 *
 * @package Smarty\Extension
 */
class Smarty_Method_IsCached
{
    /**
     * test if cache is valid
     *
     * @api
     *
     * @param Smarty         $smarty    smarty object
     * @param  string|object $template  the resource handle of the template file or template object
     * @param  mixed         $cacheId   cache id to be used with this template
     * @param  mixed         $compileId compile id to be used with this template
     * @param  object        $parent    next higher level of Smarty variables
     *
     * @throws Smarty_Exception
     * @return boolean       cache status
     */
    public function isCached(Smarty $smarty, $template = null, $cacheId = null, $compileId = null, $parent = null)
    {
        if ($smarty->forceCache || $smarty->forceCompile || !($smarty->caching == Smarty::CACHING_LIFETIME_CURRENT || $smarty->caching == Smarty::CACHING_LIFETIME_SAVED)) {
            // caching is disabled
            return false;
        }
        if ($template === null && ($smarty->_usage == Smarty::IS_SMARTY_TPL_CLONE || $smarty->_usage == Smarty::IS_CONFIG)) {
            $template = $smarty;
        }
        //get source object from cache  or create new one
        $context = $smarty->_getContext($template, $cacheId, $compileId, $parent, true);
        // checks if source exists
        if (!$context->exists) {
            throw new Smarty_Exception_SourceNotFound($context->type, $context->name);
        }
        if ($context->handler->recompiled) {
            // recompiled source can't be cached
            return false;
        }
        $tpl_obj = $context->smarty;
        $res_obj = $tpl_obj->_loadResource(Smarty::CACHE, $tpl_obj->cachingType);
        $timestamp = $exists = false;
        $filepath = $res_obj->buildFilepath($context);
        $res_obj->populateTimestamp($tpl_obj, $filepath, $timestamp, $exists);
        if (!$exists || $timestamp < $context->timestamp) {
            return false;
        }
        $template_class_name = $res_obj->loadTemplateClass($filepath);
        if (class_exists($template_class_name, false)) {
            $template_obj = new $template_class_name($context, $filepath, $timestamp);
            $template_obj->isUpdated = true;
            return $template_obj->isValid;
        }
        return false;
    }
}
