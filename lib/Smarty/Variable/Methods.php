<?php

/**
 * Smarty Variable Methods
 * This file contains the basic methods for variable handling
 *
 * @package Smarty\Variable
 * @author  Uwe Tews
 */
namespace Smarty\Variable;

use Smarty;
use Smarty\Exception\Magic;

/**
 * Base class with variable methods
 *
 * @package Smarty\Variable
 */
class Methods extends Magic
{
    /**
     * parent
     *
     * @var Smarty  | Smarty_Variable_Data | Smarty_Template
     */
    public $parent = null;

    /**
     * assigns a Smarty variable
     *
     * @api
     *
     * @param  array|string $tpl_var the template variable name(s)
     * @param  mixed        $value   the value to assign
     * @param  boolean      $nocache if true any output of this variable will be not cached
     * @param int           $scope_type
     *
     * @return Smarty_Variable_Methods current Smarty_Variable_Methods (or Smarty) instance for chaining
     */
    public function assign($tpl_var, $value = null, $nocache = false, $scope_type = Smarty::SCOPE_LOCAL)
    {
        if (is_array($tpl_var)) {
            foreach ($tpl_var as $varname => $value) {
                if ($varname != '') {
                    if ($this->_usage == Smarty::IS_TEMPLATE || $scope_type != Smarty::SCOPE_LOCAL) {
                        $this->_assignInScope($varname, new Entry($value, $nocache), $scope_type);
                    } else {
                        $this->_tpl_vars->$varname = new Entry($value, $nocache);
                    }
                }
            }
        } else {
            if ($tpl_var != '') {
                if ($this->_usage == Smarty::IS_TEMPLATE || $scope_type != Smarty::SCOPE_LOCAL) {
                    $this->_assignInScope($tpl_var, new Entry($value, $nocache), $scope_type);
                } else {
                    $this->_tpl_vars->$tpl_var = new Entry($value, $nocache);
                }
            }
        }

        return $this;
    }

    /**
     * Assign variable in scope
     * bubble up if required
     *
     * @internal
     *
     * @param string                                   $varname      variable name
     * @param Smarty_Variable|Smarty_Variable_Callback $variable_obj variable object
     * @param int                                      $scope_type
     *
     * @return bool
     */
    public function _assignInScope($varname, $variable_obj, $scope_type = Smarty::SCOPE_LOCAL)
    {
        if ($scope_type == Smarty::SCOPE_GLOBAL) {
            Smarty::$_global_tpl_vars->{$varname} = $variable_obj;
            if ($this->_usage == Smarty::IS_TEMPLATE) {
                // we must bubble from current template
                $scope_type = Smarty::SCOPE_ROOT;
            } else {
                // otherwise done
                return false;
            }
        }

        // must always assign in local scope
        $this->_tpl_vars->{$varname} = $variable_obj;

        // if called on data object return
        if ($this->_usage == Smarty::IS_DATA) {
            return false;
        }

        // if called from template object ($this->scope_type set) we must consider
        // the scope type if template object
        if ($this->_usage == Smarty::IS_TEMPLATE) {
            if (($this->scope_type == Smarty::SCOPE_ROOT || $this->scope_type == Smarty::SCOPE_PARENT) &&
                $scope_type != Smarty::SCOPE_ROOT && $scope_type != Smarty::SCOPE_SMARTY
            ) {
                $scope_type = $this->scope_type;
            }
        }

        if ($scope_type == Smarty::SCOPE_LOCAL) {
            return false;
        }

        $node = $this->parent;
        while ($node) {
            // bubble up only in template objects
            if ($node->_usage == Smarty::IS_TEMPLATE || ($scope_type == Smarty::SCOPE_SMARTY && $node->_usage != Smarty::IS_DATA)) {
                $node->_tpl_vars->{$varname} = $variable_obj;
                if ($scope_type == Smarty::SCOPE_PARENT) {
                    break;
                }
            }
            $node = $node->parent;
        }
    }

    /**
     * assigns a global Smarty variable
     *
     * @api
     *
     * @param  string  $varname the global variable name
     * @param  mixed   $value   the value to assign
     * @param  boolean $nocache if true any output of this variable will be not cached
     *
     * @return Smarty_Variable_Methods current Smarty_Variable_Methods (or Smarty) instance for chaining
     */
    public function assignGlobal($varname, $value = null, $nocache = false)
    {
        if ($varname != '') {
            if ($this->_usage == Smarty::IS_TEMPLATE) {
                $this->_assignInScope($varname, new Entry($value, $nocache), Smarty::SCOPE_GLOBAL);
            } else {
                Smarty::$_global_tpl_vars->$varname = new Entry($value, $nocache);
            }
        }
        return $this;
    }
}
