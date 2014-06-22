<?php

/**
 * Smarty Extension
 * Smarty class methods
 *
 * @package Smarty\Extension
 * @author  Uwe Tews
 */

/**
 * Class for getAutoloadFilters method
 *
 * @package Smarty\Extension
 */
class Smarty_Method_GetAutoloadFilters
{
    /**
     * Get autoload filters
     *
     * @api
     *
     * @param Smarty  $smarty smarty object
     * @param  string $type   type of filter to get autoloads for. Defaults to all autoload filters
     *
     * @return array  array( 'type1' => array( 'filter1', 'filter2', … ) ) or array( 'filter1', 'filter2', …) if $type was specified
     */
    public function getAutoloadFilters(Smarty $smarty, $type = null)
    {
        if ($type !== null) {
            return isset($smarty->_autoloadFilters[$type]) ? $smarty->_autoloadFilters[$type] : array();
        }

        return $smarty->_autoloadFilters;
    }
}
