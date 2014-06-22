<?php
/**
 * Smarty Extension
 * Smarty class methods
 *
 * @package Smarty\Extension
 * @author  Uwe Tews
 */

/**
 * Class for findRootTemplate method
 *
 * @package Smarty\Extension
 */
class Smarty_Method_FindRootTemplate
{
    /**
     * Identify and get top-level template instance
     *
     * @api
     *
     * @param Smarty $smarty smarty object
     *
     * @return Smarty root template object
     */
    public function findRootTemplate(Smarty $smarty)
    {
        $tpl_obj = $smarty;
        while ($tpl_obj->parent && ($tpl_obj->parent->_usage == Smarty::IS_SMARTY_TPL_CLONE || $tpl_obj->parent->_usage == Smarty::IS_CONFIG)) {
            if ($tpl_obj->_rootTemplate) {
                return $smarty->_rootTemplate = $tpl_obj->_rootTemplate;
            }

            $tpl_obj = $tpl_obj->parent;
        }

        return $smarty->_rootTemplate = $tpl_obj;
    }
}
