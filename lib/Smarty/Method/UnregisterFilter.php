<?php
/**
 * Smarty Extension
 * Smarty class methods
 *
 * @package Smarty\Extension
 * @author  Uwe Tews
 */

/**
 * Class for unregisterFilter method
 *
 * @package Smarty\Extension
 */
class Smarty_Method_UnregisterFilter
{

    /**
     * Unregisters a filter function
     *
     * @api
     *
     * @param Smarty    $smarty smarty object
     * @param  string   $type   filter type
     * @param  callback $callback
     *
     * @return Smarty
     */
    public function unregisterFilter(Smarty $smarty, $type, $callback)
    {
        if (!isset($smarty->_registered['filter'][$type])) {
            return $smarty;
        }
        if ($callback instanceof Closure) {
            foreach ($smarty->_registered['filter'][$type] as $key => $_callback) {
                if ($callback === $_callback) {
                    unset($smarty->_registered['filter'][$type][$key]);

                    return $smarty;
                }
            }
        } else {
            if (is_object($callback)) {
                $callback = array($callback, '__invoke');
            }
            $name = $this->_getFilterName($callback);
            if (isset($smarty->_registered['filter'][$type][$name])) {
                unset($smarty->_registered['filter'][$type][$name]);
            }
        }

        return $smarty;
    }

    /**
     * Return internal filter name
     *
     * @internal
     *
     * @param  callback $function_name
     *
     * @return string
     */
    public function _getFilterName($function_name)
    {
        if (is_array($function_name)) {
            $_class_name = (is_object($function_name[0]) ?
                get_class($function_name[0]) : $function_name[0]);

            return $_class_name . '_' . $function_name[1];
        } else {
            return $function_name;
        }
    }
}
