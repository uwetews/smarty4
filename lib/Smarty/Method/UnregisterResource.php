<?php
/**
 * Smarty Extension
 * Smarty class methods
 *
 * @package Smarty\Extension
 * @author  Uwe Tews
 */

/**
 * Class for  unregisterResource method
 *
 * @package Smarty\Extension
 */
class Smarty_Method_UnregisterResource
{
    /**
     * Unregisters a resource
     *
     * @api
     *
     * @param Smarty  $smarty smarty object
     * @param  string $type   name of resource type
     *
     * @return Smarty
     */
    public function unregisterResource(Smarty $smarty, $type)
    {
        if (isset($smarty->registered_resources[Smarty::SOURCE][$type])) {
            unset($smarty->registered_resources[Smarty::SOURCE][$type]);
        }

        return $smarty;
    }
}
