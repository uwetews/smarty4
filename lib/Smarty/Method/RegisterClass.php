<?php
/**
 * Smarty Extension
 * Smarty class methods
 *
 * @package Smarty\Extension
 * @author  Uwe Tews
 */

/**
 * Class for registerClass method
 *
 * @package Smarty\Extension
 */
class Smarty_Method_RegisterClass
{
    /**
     * Registers static classes to be used in templates
     *
     * @api
     *
     * @param Smarty  $smarty     smarty object
     * @param  string $class_name name of class
     * @param  string $class_impl the referenced PHP class to register
     *
     * @return Smarty
     * @throws Smarty_Exception if class does not exist
     */
    public function registerClass(Smarty $smarty, $class_name, $class_impl)
    {
        // test if exists
        if (!class_exists($class_impl, false)) {
            throw new Smarty_Exception("registerClass(): Undefined class \"{$class_impl}\"");
        }
        // register the class
        $smarty->_registered['class'][$class_name] = $class_impl;

        return $smarty;
    }
}
