<?php

/**
 * Smarty Extension
 * Smarty class methods
 *
 * @package Smarty\Extension
 * @author  Uwe Tews
 */

/**
 * Class for setAutoloadFilters method
 *
 * @package Smarty\Extension
 */
class Smarty_Method_SetAutoloadFilters
{
    /**
     *  Smarty object
     *
     * @var Smarty
     */
    public $smarty;

    /**
     *  Constructor
     *
     * @param Smarty $smarty Smarty object
     */
    public function __construct(Smarty $smarty)
    {
        $smarty = $smarty;
    }

    /**
     * Set autoload filters
     *
     * @param  array  $filters filters to load automatically
     * @param  string $type    "pre", "output", … specify the filter type to set. Defaults to none treating $filters' keys as the appropriate types
     *
     * @return Smarty current Smarty instance for chaining
     */
    public function setAutoloadFilters($filters, $type = null)
    {
        if ($type !== null) {
            $smarty->_autoloadFilters[$type] = (array) $filters;
        } else {
            $smarty->_autoloadFilters = (array) $filters;
        }

        return $smarty;
    }
}
