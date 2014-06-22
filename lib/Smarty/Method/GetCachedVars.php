<?php

/**
 * Smarty Extension
 * Smarty class methods
 *
 * @package Smarty\Extension
 * @author  Uwe Tews
 */

/**
 * Class for getCachedVars method
 *
 * @package Smarty\Extension
 */
class Smarty_Method_GetCachedVars
{
    /**
     * Get value from persistent cache storage
     *
     * @api
     *
     * @param Smarty  $smarty smarty object
     * @param  string $key    key of value to retrieve, null for all values (default)
     *
     * @return mixed  value or array of values
     */
    public function getCachedVars(Smarty $smarty, $key = null)
    {
        if (!$smarty->_rootTemplate) {
            $smarty->findRootTemplate();
        }

        if ($key === null) {
            return isset($smarty->_rootTemplate->properties['cachedValues']) ? $smarty->_rootTemplate->properties['cachedValues'] : array();
        }

        return isset($smarty->_rootTemplate->properties['cachedValues'][$key]) ? $smarty->_rootTemplate->properties['cachedValues'][$key] : null;
    }
}
