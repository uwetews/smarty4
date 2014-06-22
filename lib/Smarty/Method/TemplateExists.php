<?php

/**
 * Smarty Extension
 * Smarty class methods
 *
 * @package Smarty\Extension
 * @author  Uwe Tews
 */

/**
 * Class for templateExists method
 *
 * @package Smarty\Extension
 */
class Smarty_Method_TemplateExists
{
    /**
     * Check if a template resource exists
     *
     * @api
     *
     * @param Smarty  $smarty           smarty object
     * @param  string $templateResource template name
     *
     * @return boolean status
     */
    public function templateExists(Smarty $smarty, $templateResource)
    {
        $context = $smarty->_getContext($templateResource);
        return $context->exists;
    }
}
