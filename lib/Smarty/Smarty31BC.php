<?php

/**
 * set SMARTY_DIR to absolute path to Smarty library files.
 * Sets SMARTY_DIR only if user application has not already defined it.
 */
if (!defined('SMARTY_DIR')) {
    define('SMARTY_DIR', dirname(__FILE__) . '/');
}
if (!defined('SMARTY_PLUGINS_DIR')) {
    define('SMARTY_PLUGINS_DIR', SMARTY_DIR . 'plugins/');
}
if (!defined('SMARTY_MBSTRING')) {
    define('SMARTY_MBSTRING', function_exists('mb_split'));
}
if (!defined('SMARTY_RESOURCE_CHAR_SET')) {
    // UTF-8 can only be done properly when mbstring is available!
    /**
     * @deprecated in favor of Smarty::$_CHARSET
     */
    define('SMARTY_RESOURCE_CHAR_SET', SMARTY_MBSTRING ? 'UTF-8' : 'ISO-8859-1');
}
if (!defined('SMARTY_RESOURCE_DATE_FORMAT')) {
    /**
     * @deprecated in favor of Smarty::$_DATE_FORMAT
     */
    define('SMARTY_RESOURCE_DATE_FORMAT', '%b %e, %Y');
}

/**
 * Project:     Smarty: the PHP compiling template engine
 * File:        SmartyBC31.class.php
 * SVN:         $Id: $
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 * For questions, help, comments, discussion, etc., please join the
 * Smarty mailing list. Send a blank e-mail to
 * smarty-discussion-subscribe@googlegroups.com
 *
 * @link      http://www.smarty.net/
 * @copyright 2008 New Digital Group, Inc.
 * @author    Monte Ohrt <monte at ohrt dot com>
 * @author    Uwe Tews
 * @author    Rodney Rehm
 * @package   Smarty\BC
 * @deprecated
 */
/**
 * @ignore
 */

/**
 * Smarty Backward Compatibility Wrapper Class for Smarty 3.1
 *
 * @package Smarty\BC
 * @deprecated
 */
class Smarty_Smarty31BC extends Smarty
{
    /**
     * Flag denoting if Multibyte String functions are available
     */
    public static $_MBSTRING = SMARTY_MBSTRING;

    /**
     * The character set to adhere to (e.g. "UTF-8")
     */
    public static $_CHARSET = SMARTY_RESOURCE_CHAR_SET;

    /**
     * The date format to be used internally
     * (accepts date() and strftime())
     */
    public static $_DATE_FORMAT = SMARTY_RESOURCE_DATE_FORMAT;

    /**
     * Folder of Smarty build in plugins
     */
    public static $_SMARTY_PLUGINS_DIR = SMARTY_PLUGINS_DIR;

    public function __construct($userConfigXml = false) {
        parent::__construct($userConfigXml);
    }
    /**
     * <<magic>> Generic getter.
     * Get Smarty or Template property
     *
     * @param  string $property_name property name
     *
     * @throws Smarty_Exception
     * @return $this
     */
    public function __get($property_name)
    {
        // resolve 3.1 references from template to Smarty object
        if ($property_name == 'smarty') {
            return $this;
        }

        return parent::__get($property_name);
    }

    /**
     * assigns values to template variables by reference
     *
     * @deprecated
     * @api
     *
     * @param  string  $tpl_var the template variable name
     * @param  mixed   &$value  the referenced value to assign
     * @param  boolean $nocache if true any output of this variable will be not cached
     *
     * @return Smarty_Internal_Data current Smarty_Internal_Data (or Smarty or Smarty_Internal_Template_) instance for chaining
     */
    public function assignByRef($tpl_var, &$value, $nocache = false)
    {
        if ($tpl_var != '') {
            $this->_tpl_vars->$tpl_var = new Entry(null, $nocache);
            $this->_tpl_vars->$tpl_var->value = & $value;
        }

        return $this;
    }

    /**
     * appends values to template variables by reference
     *
     * @deprecated
     * @api
     *
     * @param  string  $tpl_var the template variable name
     * @param  mixed   &$value  the referenced value to append
     * @param  boolean $merge   flag if array elements shall be merged
     *
     * @return Smarty_Internal_Data current Smarty_Internal_Data (or Smarty or Smarty_Internal_Template_) instance for chaining
     */
    public function appendByRef($tpl_var, &$value, $merge = false)
    {
        if ($tpl_var != '' && isset($value)) {
            if (!isset($this->_tpl_vars->$tpl_var)) {
                $this->_tpl_vars->$tpl_var = new Entry(array());
            }
            if (!@is_array($this->_tpl_vars->$tpl_var->value)) {
                settype($this->_tpl_vars->$tpl_var->value, 'array');
            }
            if ($merge && is_array($value)) {
                foreach ($value as $_key => $_val) {
                    $this->_tpl_vars->$tpl_var->value[$_key] = & $value[$_key];
                }
            } else {
                $this->_tpl_vars->$tpl_var->value[] = & $value;
            }
        }

        return $this;
    }

    /**
     * Registers object to be used in templates
     *
     * @deprecated
     * @api
     *
     * @param          $object_name
     * @param  string  $object        $object        the referenced PHP object to register
     * @param  array   $allowed       list of allowed methods (empty = all)
     * @param  boolean $smarty_args   smarty argument format, else traditional
     * @param  array   $block_methods list of block-methods
     *
     * @throws Smarty_Exception
     * @return Smarty
     */
    public function registerObject($object_name, $object, $allowed = array(), $smarty_args = true, $block_methods = array())
    {
        if (!is_object($object)) {
            throw new Smarty_Exception("registerObject(): Invalid parameter for object");
        }
        // test if allowed methods callable
        if (!empty($allowed)) {
            foreach ((array) $allowed as $method) {
                if (!is_callable(array($object, $method)) && !property_exists($object_impl, $method)) {
                    throw new Smarty_Exception("registerObject(): Undefined method or property \"{$method}\"");
                }
            }
        }
        // test if block methods callable
        if (!empty($block_methods)) {
            foreach ((array) $block_methods as $method) {
                if (!is_callable(array($object, $method))) {
                    throw new Smarty_Exception("registerObject(): Undefined method \"{$method}\"");
                }
            }
        }
        // register the object
        $this->_registered['object'][$object_name] =
            array($object, (array) $allowed, (boolean) $smarty_args, (array) $block_methods);

        return $this;
    }

    /**
     * return a reference to a registered object
     *
     * @deprecated
     * @api
     *
     * @param  string $name object name
     *
     * @return object
     * @throws Smarty_Exception if no such object is found
     */
    public function getRegisteredObject($name)
    {
        if (!isset($this->_registered['object'][$name])) {
            throw new Smarty_Exception("getRegisteredObject(): No object resgistered for \"{$name}\"");
        }

        return $this->_registered['object'][$name][0];
    }

    /**
     * unregister an object
     *
     * @deprecated
     * @api
     *
     * @param  string $name object name
     *
     * @return Smarty
     */
    public function unregisterObject($name)
    {
        if (isset($this->_registered['object'][$name])) {
            unset($this->_registered['object'][$name]);
        }

        return $this;
    }
}
