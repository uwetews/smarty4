<?php
/**
 * Smarty Extension
 * Smarty class methods
 *
 * @package Smarty\Extension
 * @author  Uwe Tews
 */

/**
 * Class for  unregisterCacheResource method
 *
 * @package Smarty\Extension
 */
class Smarty_Method_UnregisterCacheResource
{
    /**
     * Unregisters a cache resource
     *
     * @api
     *
     * @param Smarty  $smarty smarty object
     * @param  string $type   name of cache resource type
     *
     * @return Smarty
     */
    public function unregisterCacheResource(Smarty $smarty, $type)
    {
        if (isset($smarty->_registered['resource'][Smarty::CACHE][$type])) {
            unset($smarty->_registered['resource'][Smarty::CACHE][$type]);
        }

        return $this;
    }
}
