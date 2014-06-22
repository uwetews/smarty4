<?php

/**
 * Smarty Extension
 * Smarty class methods
 *
 * @package Smarty\Extension
 * @author  Uwe Tews
 */

/**
 * Class for clearCache method
 *
 * @package Smarty\Extension
 */
class Smarty_Method_ClearCache
{
    /**
     * Empty cache for a specific template
     *
     * @api
     *
     * @param Smarty   $smarty        smarty object
     * @param  string  $template_name template name
     * @param  string  $cacheId       cache id
     * @param  string  $compileId     compile id
     * @param  integer $exp_time      expiration time
     * @param  string  $type          resource type
     *
     * @return integer number of cache files deleted
     */
    public function clearCache(Smarty $smarty, $template_name = null, $cacheId = null, $compileId = null, $exp_time = null, $type = null)
    {
        // load cache resource and call clear
        $type = $type ? $type : $smarty->cachingType;
        $cache = $smarty->_loadResource(Smarty::CACHE, $type);
        // invalidate complete cache
        // TODO
        //unset(Smarty::$template_cache[Smarty::CACHE]);
        // call clear
        return $cache->clear($smarty, $template_name, $cacheId, $compileId, $exp_time);
    }
}
