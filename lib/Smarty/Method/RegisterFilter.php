<?php

/**
 * Smarty Extension
 * Smarty class methods
 *
 * @package Smarty\Extension
 * @author  Uwe Tews
 */

/**
 * Class for registerFilter method
 *
 * @package Smarty\Extension
 */
class Smarty_Method_RegisterFilter
{
    /**
     * Registers a filter function
     *
     * @api
     *
     * @param Smarty    $smarty smarty object
     * @param           $type
     * @param  callback $callback
     *
     * @throws Smarty_Exception
     * @return Smarty
     */
    public function registerFilter(Smarty $smarty, $type, $callback)
    {
        if (!in_array($type, array('pre', 'post', 'output', 'variable'))) {
            throw new Smarty_Exception("registerFilter(): Invalid filter type \"{$type}\"");
        }
        if (is_callable($callback)) {
            if ($callback instanceof Closure) {
                $smarty->_registered['filter'][$type][] = $callback;
            } else {
                if (is_object($callback)) {
                    $callback = array($callback, '__invoke');
                }
                $smarty->_registered['filter'][$type][$this->_getFilterName($callback)] = $callback;
            }
        } else {
            throw new Smarty_Exception("registerFilter(): Invalid callback");
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
