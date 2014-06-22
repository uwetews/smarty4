<?php
/**
 * Smarty Template Scope
 * This file contains the Class for a template scope
 *
 * @package Smarty\Template
 * @author  Uwe Tews
 */
namespace Smarty\Template;

use Smarty\Variable;

/**
 * class for a template scope
 * This class holds scope variables while rendering template

 */
class Scope //extends Smarty_Exception_Magic
{
    /**
     * Local variable scope
     *
     * @var Scope
     */
    public $_tpl_vars = null;

    /**
     * parent
     *
     * @var \Smarty  | \Smarty\Variable\Data | \Smarty\Template\Core
     */
    public $parent = null;

    /**
     * //TODO
     * merged template functions
     *
     * @var array
     */
    public $template_functions = array();

    /**
     * Initialize template scope
     *
     * @param Context $context
     */
    public function __construct(Context $context)
    {
        if ($context->scope_type == \Smarty::SCOPE_NONE) {
            $this->_tpl_vars = new Variable\Scope();
        } else {
            if ($context->parent instanceof \Smarty) {
                $this->_tpl_vars = clone $context->parent->_tpl_vars;
            } else {
                if ($context->parent == null) {
                    $this->_tpl_vars = clone $context->smarty->_tpl_vars;
                } else {
                    $this->_tpl_vars = $this->_mergeScopes($context->parent);
                    foreach ($context->smarty->_tpl_vars as $var => $obj) {
                        $this->_tpl_vars->$var = $obj;
                    }
                }
                // merge global variables
                foreach (\Smarty::$_global_tpl_vars as $var => $obj) {
                    if (!isset($this->_tpl_vars->$var)) {
                        $this->_tpl_vars->$var = $obj;
                    }
                }
            }
        }
    }

    /**
     *  merge recursively template variables into one scope
     *
     * @internal
     *
     * @param   \Smarty  | \Smarty\Variable\Data | \Smarty\Template\Core $ptr
     *
     * @return Scope    merged tpl vars
     */
    public function _mergeScopes($ptr)
    {
        // Smarty::triggerTraceCallback('trace', ' merge tpl ');

        if (isset($ptr->parent)) {
            $scope = $this->_mergeScopes($ptr->parent);
            foreach ($ptr->_tpl_vars as $var => $obj) {
                $scope->$var = $obj;
            }

            return $scope;
        } else {
            return clone $ptr->_tpl_vars;
        }
    }
}
