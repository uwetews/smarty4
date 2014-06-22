<?php
/**
 * Smarty Extension
 * Smarty class methods
 *
 * @package Smarty\Extension
 * @author  Uwe Tews
 */

/**
 * Class for unregisterClass method
 *
 * @package Smarty\Extension
 */
class Smarty_Method_UnregisterClass
{
    /**
     * Unregister static class
     *
     * @api
     *
     * @param Smarty  $smarty     smarty object
     * @param  string $class_name name of class or null
     *
     * @return Smarty
     */
    public function unregisterClass(Smarty $smarty, $class_name = null)
    {
        if ($class_name == null) {
            $smarty->_registered['class'] = array();
        } else {
            unset($smarty->_registered['class'][$class_name]);
        }

        return $smarty;
    }
}
