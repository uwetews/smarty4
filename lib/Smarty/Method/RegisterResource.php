<?php

/**
 * Smarty Extension
 * Smarty class methods
 *
 * @package Smarty\Extension
 * @author  Uwe Tews
 */

/**
 * Class for registerResource method
 *
 * @package Smarty\Extension
 */
class Smarty_Method_RegisterResource
{
    /**
     * Registers a resource for source templates
     *
     * @api
     *
     * @param Smarty                             $smarty   smarty object
     * @param  string                            $type     name of resource type
     * @param  Smarty_Resource_Source_File|array $callback or instance of Smarty_Resource_Source, or array of callbacks to handle resource (deprecated)
     *
     * @return Smarty
     */
    public function registerResource(Smarty $smarty, $type, $callback)
    {
        $smarty->_registered['resource'][Smarty::SOURCE][$type] = $callback instanceof Smarty_Resource_Source_File ? $callback : array($callback, false);
        return $smarty;
    }
}
