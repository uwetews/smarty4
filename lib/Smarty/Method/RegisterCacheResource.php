<?php

/**
 * Smarty Extension
 * Smarty class methods
 *
 * @package Smarty\Extension
 * @author  Uwe Tews
 */

/**
 * Class for registerCacheResource method
 *
 * @package Smarty\Extension
 */
class Smarty_Method_RegisterCacheResource
{
    /**
     * Registers a cache resource to cache a template's output
     *
     * @api
     *
     * @param Smarty                 $smarty   smarty object
     * @param  string                $type     name of cache resource type
     * @param  Smarty_Resource_Cache $callback instance of Smarty_Resource_Cache to handle output caching
     *
     * @return Smarty
     */
    public function registerCacheResource(Smarty $smarty, $type, $callback)
    {
        $smarty->_registered['resource'][Smarty::CACHE][$type] = $callback instanceof Smarty_Resource_Cache ? $callback : array($callback, false);

        return $smarty;
    }
}
