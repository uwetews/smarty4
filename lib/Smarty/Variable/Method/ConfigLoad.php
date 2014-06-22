<?php

/**
 * Smarty Extension
 * Smarty class methods
 *
 * @package Smarty\Variable
 * @author  Uwe Tews
 */

/**
 * Class for static configLoad method
 *
 * @package Smarty\Variable
 */
class Smarty_Variable_Method_ConfigLoad
{
    /**
     * load a config file, optionally load just selected sections
     *
     * @api
     *
     * @param Smarty | Smarty_Template_Class | Smarty_Variable_Data $object      master object
     * @param  string                                               $config_file filename
     * @param  mixed                                                $sections    array of section names, single section or null
     * @param int                                                   $scope_type  template scope into which config file shall be loaded
     *
     * @throws Smarty_Exception_SourceNotFound
     * @return Smarty_Variable_Methods current Smarty_Variable_Methods (or Smarty) instance for chaining
     */
    public function configLoad($object, $config_file, $sections = null, $scope_type = Smarty::SCOPE_LOCAL)
    {
        $smarty = isset($object->smarty) ? $object->smarty : $object;
        // parse templateResource into name and type
        $parts = explode(':', $config_file, 2);
        if (!isset($parts[1]) || !isset($parts[0][1])) {
            // no resource given, use default
            // or single character before the colon is not a resource type, but part of the filepath
            $type = $smarty->defaultResourceType;
            $name = $config_file;
        } else {
            $type = $parts[0];
            $name = $parts[1];
        }
        $context = new Context($smarty, $name, $type, $object, true);
        // checks if source exists
        if (!$context->exists) {
            throw new Smarty_Exception_SourceNotFound($context->type, $context->name);
        }
        // create template object without caching it
        $template_obj = $context->smarty->_getTemplateObject(Smarty::COMPILED, $context, true);
        $target = $object;
        $scope = $target->_tpl_vars;
        // load global variables
        if (isset($template_obj->config_variables['vars'])) {
            foreach ($template_obj->config_variables['vars'] as $var => $value) {
                if (!$smarty->config_overwrite && isset($scope->$var)) {
                    $value = array_merge((array) $scope->{$var}, (array) $value);
                }
                if ($target->_usage == Smarty::IS_TEMPLATE || $scope_type != Smarty::SCOPE_LOCAL) {
                    $target->_assignInScope($var, $value, $scope_type);
                } else {
                    $target->_tpl_vars->$var = $value;
                }
            }
        }
        // load variables from section
        if (isset($sections)) {
            foreach ((array) $sections as $section) {
                if (isset($template_obj->config_variables['sections'][$section])) {
                    foreach ($template_obj->config_variables['sections'][$section]['vars'] as $var => $value) {
                        if (!$smarty->config_overwrite && isset($scope->$var)) {
                            $value = array_merge((array) $scope->{$var}, (array) $value);
                        }
                        if ($target->_usage == Smarty::IS_TEMPLATE || $scope_type != Smarty::SCOPE_LOCAL) {
                            $target->_assignInScope($var, $value, $scope_type);
                        } else {
                            $target->_tpl_vars->$var = $value;
                        }
                    }
                }
            }
        }
        return $object;
    }
}