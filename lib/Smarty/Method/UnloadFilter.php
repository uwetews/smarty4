<?php
/**
 * Smarty Extension
 * Smarty class methods
 *
 * @package Smarty\Extension
 * @author  Uwe Tews
 */

/**
 * Class for unloadFilter method
 *
 * @package Smarty\Extension
 */
class Smarty_Method_UnloadFilter
{
    /**
     * unload a filter of specified type and name
     *
     * @api
     *
     * @param Smarty  $smarty smarty object
     * @param  string $type   filter type
     * @param  string $name   filter name
     *
     * @return Smarty
     */
    public function unloadFilter(Smarty $smarty, $type, $name)
    {
        $_filter_name = "smarty_{$type}filter_{$name}";
        if (isset($smarty->_registered['filter'][$type][$_filter_name])) {
            unset($smarty->_registered['filter'][$type][$_filter_name]);
        }

        return $smarty;
    }
}
