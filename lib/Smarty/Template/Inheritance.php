<?php

/**
 * Smarty Internal Plugin Smart Inheritance
 * This file contains the methods for precessing inheritance
 *
 * @package Smarty\Template
 * @author  Uwe Tews
 */

/**
 * Class with inheritance processing methods
 *
 * @package Smarty\Template
 */
class Smarty_Template_Inheritance extends Smarty_Template
{

    /**
     * Template runtime function to fetch inheritance template
     *
     * @param  string  $resource  the resource handle of the template file
     * @param  mixed   $cacheId   cache id to be used with this template
     * @param  mixed   $compileId compile id to be used with this template
     * @param  integer $caching   cache mode
     * @param  object  $parent    parent template object
     * @param  bool    $is_child  is inheritance child template
     *
     * @return object
     */
    public function _getInheritanceTemplate($resource, $cacheId, $compileId, $caching, $parent, $is_child = false)
    {
        //get source object from cache  or create new one
        $source = Smarty_Resource_Source::load($parent, $resource);
        return Smarty_Resource_Compiled::getRenderedTemplate($parent, $source, $compileId, $parent);
        //        $output = $tpl_obj->_getCompiledTemplate($this->source, $this->compileId, $this->caching)->_getRenderedTemplate($tpl_obj, $_scope, $scope_type, $data, $no_output_filter);

        //        return $parent->_loadCompiled($source, $compileId, $caching);
    }

    /**
     * resolve inheritance for block an return content
     *
     * @param  string  $name           name of block
     * @param  object  $scope_tpl      blocks must be processed in this variable scope
     * @param  Scope   $_scope         template variables
     * @param  object  $current_tpl    calling template  (optional)
     * @param  int     $mode           mode of this call
     * @param  boolean $in_child_chain flag when inside child template chaim
     *
     * @return string                | boolean false
     */
    public function _getInheritanceBlock($name, $scope_tpl, $_scope, $current_tpl = null, $mode = 0, $in_child_chain = false)
    {
        //            if ($this->is_cache) {
        //                $mode = 2;
        //            }

        if ($current_tpl === null) {
            $current_tpl = $scope_tpl;
        }
        switch ($mode) {
            case 0:
                if (!isset($this->inheritance_blocks[$name]['calls_child'])) {
                    if (($child_content = $this->_getInheritanceChildBlock($name, $scope_tpl, $_scope, $mode, $current_tpl, $in_child_chain)) != false) {
                        return $child_content;
                    }
                } else {
                    $child_content = $this->_getInheritanceChildBlock($name, $scope_tpl, $_scope, $mode, $current_tpl, $in_child_chain);
                    if ($child_content == false && isset($this->inheritance_blocks[$name]['hide'])) {
                        return '';
                    } else {
                        $this->inheritance_blocks[$name]['child_content'] = $child_content;
                        unset ($child_content);
                    }
                }

                return $this->_getInheritanceRenderedBlock($name, $scope_tpl, $_scope, $current_tpl);

            case 1:
                $tmp = Smarty_Resource_Cache_Extension_Create::_getCachedObject($current_tpl);

                return $tmp->newcache->_createNocacheInheritanceBlock($current_tpl, $name, $scope_tpl);
            case 2:
                if (isset($this->inheritance_blocks[$name])) {
                    $function = $this->inheritance_blocks[$name]['function'];

                    return $this->$function($current_tpl, $_scope);
                }
        }
    }

    /**
     * resolve inheritance for block in child  {$smarty.block.child}
     *
     * @param  string                         $name           name of block
     * @param  Smarty_Internal_Variable_Scope $scope_tpl      blocks must be processed in this variable scope
     * @param  Scope                          $_scope         template variables
     * @param  int                            $mode           mode of this call
     * @param  Smarty                         $current_tpl    calling template  (optional)
     * @param  boolean                        $in_child_chain flag when inside child template chaim
     * @param  null                           $parent_block
     *
     * @return string                         | boolean false
     */
    public function _getInheritanceChildBlock($name, $scope_tpl, $_scope, $mode, $current_tpl = null, $in_child_chain = false, $parent_block = null)
    {
        if ($current_tpl == null) {
            $current_tpl = $scope_tpl;
        }
        if ($parent_block == null) {
            $parent_block = array($this, $current_tpl, $name);
        }

        // Get real name
        $name = $this->inheritance_blocks[$name]['name'];

        $ptr = $current_tpl->parent;
        while ($ptr !== null && $ptr->_usage == Smarty::IS_SMARTY_TPL_CLONE) {
            $content_ptr = $ptr->compiled->template_obj;
            if ($content_ptr->is_inheritance_child) {
                $in_child_chain = true;
            } elseif ($in_child_chain) {
                // we did reach start of current inhertance chain
                return false;
            }
            if (isset($content_ptr->inheritance_blocks[$name])) {
                if (!isset($content_ptr->inheritance_blocks[$name]['valid'])) {
                    break;
                }
                $content_ptr->inheritance_blocks[$name]['parent_block'] = $parent_block;
                unset($parent_block[0]->inheritance_blocks[$name]['parent_block']);
                if (isset($content_ptr->inheritance_blocks[$name]['calls_child'])) {
                    return $content_ptr->_getInheritanceBlock($name, $scope_tpl, $_scope, $ptr, $mode, $in_child_chain);
                }
                if (($result = $content_ptr->_getInheritanceChildBlock($name, $scope_tpl, $_scope, $mode, $ptr, $in_child_chain)) != false) {
                    return $result;
                } else {
                    if (isset($content_ptr->inheritance_blocks[$name]['parent_block'])) {
                        $parent_content_ptr = $content_ptr->inheritance_blocks[$name]['parent_block'][0];
                        $parent_name = $content_ptr->inheritance_blocks[$name]['parent_block'][2];
                        if (isset($content_ptr->inheritance_blocks[$name]['prepend'])) {
                            return $content_ptr->_getInheritanceRenderedBlock($name, $scope_tpl, $_scope, $ptr) . $parent_content_ptr->_getInheritanceRenderedBlock($parent_name, $scope_tpl, $ptr);
                        } elseif (isset($content_ptr->inheritance_blocks[$name]['append'])) {
                            return $parent_content_ptr->_getInheritanceRenderedBlock($parent_name, $scope_tpl, $_scope, $ptr) . $content_ptr->_getInheritanceRenderedBlock($name, $scope_tpl, $ptr);
                        }
                        unset($parent_block[0]->inheritance_blocks[$name]['parent_block']);
                    }

                    return $content_ptr->_getInheritanceRenderedBlock($name, $scope_tpl, $_scope, $ptr);
                }
                /** TODO  what is the fuction of overwrite
                 * if (isset($current_tpl->compiled->template_obj->inheritance_blocks[$name]['overwrite'])) {
                 * $parent_tpl = null;
                 * }
                 */
            }
            $ptr = $ptr->parent;
        }

        return false;
    }

    /**
     * Fetch output of single block  by name
     *
     * @param  string $name      name of block
     * @param  Smarty $scope_tpl blocks must be processed in this variable scope
     * @param  Scope  $_scope    template variables
     * @param  Smarty $current_tpl
     *
     * @throws Smarty_Exception_Runtime
     * @return string
     */
    public function _getInheritanceRenderedBlock($name, $scope_tpl, $_scope, $current_tpl)
    {
        if (isset($this->inheritance_blocks[$name])) {
            return $this->{$this->inheritance_blocks[$name]['function']} ($scope_tpl, $_scope);
        } else {
            throw new Smarty_Exception_Runtime ("Inheritance: Method {$this->inheritance_blocks[$name]['function']} for block '{$name}' not found", $scope_tpl);
        }
    }

    /**
     * Fetch output of {$smarty.block.parent}
     *
     * @param  string $name      name of block
     * @param  object $scope_tpl blocks must be processed in this variable scope
     * @param  Scope  $_scope    template variables
     *
     * @return string
     */
    public function _getInheritanceParentBlock($name, $scope_tpl, $_scope)
    {
        if (isset($this->inheritance_blocks[$name]['parent_block'])) {
            $parent_block = $this->inheritance_blocks[$name]['parent_block'];

            return $parent_block[0]->{$parent_block[0]->inheritance_blocks[$name]['function']} ($scope_tpl, $_scope);
        }

        return '';
    }
}
