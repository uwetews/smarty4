<?php

/**
 * Smarty Extension
 * Smarty class methods
 *
 * @package Smarty\Extension
 * @author  Uwe Tews
 */

/**
 * Class for clearAllCache method
 *
 * @package Smarty\Extension
 */
class Smarty_Method_ClearAllCache
{
    /**
     * Empty cache folder
     *
     * @api
     *
     * @param Smarty   $smarty
     * @param  integer $exp_time expiration time
     * @param  string  $type     resource type
     *
     * @internal param \Smarty|\Smarty_Template_Class $object master object
     * @return integer number of cache files deleted
     */
    public function clearAllCache(Smarty $smarty, $exp_time = null, $type = null)
    {
        // load cache resource
        $type = $type ? $type : $smarty->cachingType;
        $cache = $smarty->_loadResource(Smarty::CACHE, $type);
        // invalidate complete cache
        // TODO
        //unset(Smarty::$template_cache[Smarty::CACHE]);
        //  call clearAll
        return $cache->clearAll($smarty, $exp_time);
    }
}
