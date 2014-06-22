<?php

/**
 * Smarty Extension
 * Smarty class methods
 *
 * @package Smarty\Extension
 * @author  Uwe Tews
 */

/**
 * Class for registerPlugin method
 *
 * @package Smarty\Extension
 */
class Smarty_Method_RegisterPlugin
{
    /**
     * Registers plugin to be used in templates
     *
     * @api
     *
     * @param Smarty    $smarty     smarty object
     * @param  string   $type       plugin type
     * @param  string   $tag        name of template tag
     * @param  callback $callback   PHP callback to register
     * @param  boolean  $cacheable  if true (default) this fuction is cachable
     * @param  array    $cache_attr caching attributes if any
     *
     * @return Smarty
     * @throws Smarty_Exception when the plugin tag is invalid
     */
    public function registerPlugin(Smarty $smarty, $type, $tag, $callback, $cacheable = true, $cache_attr = null)
    {
        if (isset($smarty->_registered['plugin'][$type][$tag])) {
            throw new Smarty_Exception("registerPlugin(): Plugin tag \"{$tag}\" already registered");
        } elseif (!is_callable($callback)) {
            throw new Smarty_Exception("registerPlugin(): Plugin \"{$tag}\" not callable");
        } else {
            if (is_object($callback)) {
                $callback = array($callback, '__invoke');
            }
            $smarty->_registered['plugin'][$type][$tag] = array($callback, (bool) $cacheable, (array) $cache_attr);
        }

        return $smarty;
    }
}
