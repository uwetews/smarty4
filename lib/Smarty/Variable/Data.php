<?php

/**
 * Smarty Data
 * This file contains the Smarty Data Class
 *
 * @package Template
 * @author  Uwe Tews
 */
namespace Smarty\Variable;

use Smarty\Smarty;

/**
 * class for the Smarty data object
 * The Smarty data object will hold Smarty variables in the current scope
 *
 * @package Smarty
 */
class Data extends Methods
{
    /**
     * assigned template vars
     *
     * @internal
     * @var Scope
     */
    public $_tpl_vars = null;
    /**
     * Declare the type template variable storage
     *
     * @internal
     * @var Smarty::IS_DATA
     */
    public $_usage = Smarty::IS_DATA;
    /**
     * Smarty Object
     *
     * @var Smarty
     */
    public $smarty = null;
    /**
     * Name of data Object
     *
     * @var string
     */
    public $scope_name = null;

    /**
     * create Smarty data object
     *
     * @param  Smarty                        $smarty     object of Smarty instance
     * @param  Smarty_Variable_Methods|array $parent     parent object or variable array
     * @param  string                        $scope_name name of variable scope
     *
     * @throws Smarty_Exception
     */
    public function __construct(Smarty $smarty, $parent = null, $scope_name = 'Data unnamed')
    {
        // variables passed as array?
        if (is_array($parent)) {
            $data = $parent;
            $parent = null;
        } else {
            $data = null;
        }

        $this->smarty = $smarty;
        $this->scope_name = $scope_name;
        $this->parent = $parent;

        // create variabale container
        $this->_tpl_vars = new Scope();

        //load optional variable array
        if (isset($data)) {
            foreach ($data as $_key => $_val) {
                $this->_tpl_vars->$_key = new Entry($_val);
            }
        }
    }

    /**
     * Handle unknown class methods
     *  - load extensions for external variable methods
     *
     * @param  string $name unknown method-name
     * @param  array  $args argument array
     *
     * @throws Smarty_Exception
     * @return mixed    function results
     */
    public function __call($name, $args)
    {
        // try new autoloaded Smarty methods
        return $this->smarty->_callExtension($this, $name, $args, 1);
    }
}
