<?php

/**
 * Smarty Extension
 * Smarty class methods
 *
 * @package Smarty\Extension
 * @author  Uwe Tews
 */

/**
 * Class for createTemplate method
 *
 * @package Smarty\Extension
 */
class Smarty_Method_CreateTemplate
{
    /**
     * creates a template object
     *
     * @api
     *
     * @param Smarty  $smarty
     * @param  string $templateResource the resource handle of the template file
     * @param  mixed  $cacheId          cache id to be used with this template
     * @param  mixed  $compileId        compile id to be used with this template
     * @param  object $parent           next higher level of Smarty variables
     *
     * @throws Smarty_Exception_SourceNotFound
     * @internal param \Smarty|\Smarty_Template_Class $object master object
     * @return Smarty           template object
     */
    public function createTemplate(Smarty $smarty, $templateResource, $cacheId = null, $compileId = null, $parent = null)
    {
        if (!empty($cacheId) && (is_object($cacheId) || is_array($cacheId))) {
            $parent = $cacheId;
            $cacheId = null;
        }
        if (!empty($parent) && is_array($parent)) {
            $data = $parent;
            $parent = null;
        } else {
            $data = null;
        }
        $tpl_obj = clone $smarty;
        $tpl_obj->_usage = Smarty::IS_SMARTY_TPL_CLONE;
        $tpl_obj->parent = $parent;
        if (isset($cacheId)) {
            $tpl_obj->cacheId = $cacheId;
        }
        if (isset($compileId)) {
            $tpl_obj->compileId = $compileId;
        }
        //get context object from cache  or create new one
        $context = $tpl_obj->_getContext($templateResource);
        // checks if source exists
        if (!$context->exists) {
            throw new Smarty_Exception_SourceNotFound($context->type, $context->name);
        }
        $tpl_obj->source = $context;
        $tpl_obj->_tpl_vars = new Scope();
        if (isset($data)) {
            foreach ($data as $varname => $value) {
                $tpl_obj->_tpl_vars->$varname = new Entry($value);
            }
        }
        return $tpl_obj;
    }
}
