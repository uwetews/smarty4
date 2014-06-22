<?php

/**
 * Smarty Extension
 * Smarty class methods
 *
 * @package Smarty\Extension
 * @author  Uwe Tews
 */

/**
 * Class for setDebugTemplate method
 *
 * @package Smarty\Extension
 */
class Smarty_Method_SetDebugTemplate
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
     * set the debug template
     *
     * @api
     *
     * @param  string $tpl_name
     *
     * @return Smarty           current Smarty instance for chaining
     * @throws Smarty_Exception if file is not readable
     */
    public function setDebugTemplate($tpl_name)
    {
        if (!is_readable($tpl_name)) {
            throw new Smarty_Exception("setDebugTemplate(): Unknown file '{$tpl_name}'");
        }
        $this->debugTpl = $tpl_name;

        return $this;
    }
}
