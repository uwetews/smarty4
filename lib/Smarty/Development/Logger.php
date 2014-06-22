<?php

/**
 * Smarty Logger
 * This file contains the Smarty Logger
 *
 * @package Smarty
 * @author  Uwe Tews
 */

/**
 * class for the Smarty Logger object
 * This Class handles logging of events
 *
 * @package Smarty
 */
class Smarty_Development_Logger
{
    public $smarty = null;

    public $template = array();

    /**
     * create Smarty Logger object
     *
     * @param  Smarty $smarty object of Smarty instance
     */
    public function __construct(Smarty $smarty)
    {
        $this->smarty = $smarty;
        $this->smarty->enableTrace = true;
        $smarty->registerTraceCallback('render:time:start', array($this, 'templateRenderStart'));
        $smarty->registerTraceCallback('render:time:end', array($this, 'templateRenderEnd'));
        $smarty->registerTraceCallback('compiler:time:start', array($this, 'templateCompilerStart'));
        $smarty->registerTraceCallback('compiler:time:end', array($this, 'templateCompilerEnd'));
        $smarty->registerTraceCallback('filter:', array($this, '_filter'));
        $smarty->registerTraceCallback('cache:update', array($this, '_cacheUpdate'));
        $smarty->registerTraceCallback('cache:delete', array($this, '_cacheDelete'));
    }

    /**
     * @param $template_obj
     */
    public function templateRenderStart($template_obj)
    {
        $ptr = $this->_getContextPtr($template_obj);
        $ptr->filepath = realpath($template_obj->filepath);
        $ptr->timestamp = $template_obj->timestamp;
        $index = count($ptr->calls) + 1;
        array_unshift($ptr->callstack, $index);
        $ptr = $ptr->calls[$index] = new stdClass();
        $ptr->startTime = time();
    }

    /**
     * @param $template_obj
     *
     * @return mixed
     */
    public function _getContextPtr($template_obj)
    {
        $keys = $this->_getKeysTemplate($template_obj);
        $source_ptr = $this->_getSourcePtr($template_obj, $keys);
        if ($template_obj->is_cache) {
            if (isset($source_ptr->cache[$keys['compiled']][$keys['cache']])) {
                $ptr = $source_ptr->cache[$keys['compiled']][$keys['cache']];
            } else {
                $ptr = $source_ptr->cache[$keys['compiled']][$keys['cache']] = new stdClass();
                $ptr->calls = array();
                $ptr->callstack = array();
            }
        } else {
            if (isset($source_ptr->compiled[$keys['compiled']])) {
                $ptr = $source_ptr->compiled[$keys['compiled']];
            } else {
                $ptr = $source_ptr->compiled[$keys['compiled']] = new stdClass();
                $ptr->calls = array();
                $ptr->callstack = array();
            }
        }
        return $ptr;
    }

    /**
     * @param $obj
     *
     * @return array
     */
    public function _getKeysTemplate($obj)
    {
        $keys = array();
        if ($obj instanceof Smarty_Template) {
            $keys['source'] = $obj->context->uid;
            $keys['compiled'] = isset($obj->compileId) ? $obj->compileId : '';
            $keys['cache'] = isset($obj->cacheId) ? $obj->cacheId : '';
            $keys['caching'] = $obj->caching;
        } else {
            $keys['source'] = $obj->uid;
            $keys['compiled'] = '';
            $keys['cache'] = '';
            $keys['caching'] = 0;
        }
        return $keys;
    }

    /**
     * @param      $obj
     * @param null $keys
     *
     * @return mixed
     */
    public function _getSourcePtr($obj, $keys = null)
    {
        if (!isset($keys)) {
            $keys = _getKeysTemplate($obj);
        }
        if ($obj instanceof Smarty_Template) {
            $obj = $obj->context;
        }
        if (!isset($this->template[$keys['source']])) {
            $ptr = $this->template[$keys['source']] = new stdClass();
            $ptr->context = new stdClass();
            $ptr->context->obj = $obj;
            $ptr->compiled = array();
            $ptr->cache = array();
        } else {
            $ptr = $this->template[$keys['source']];
        }
        return $ptr;
    }

    /**
     * @param $template_obj
     */
    public function templateRenderEnd($template_obj)
    {
        $ptr = $this->_getContextPtr($template_obj);
        $index = array_shift($ptr->callstack);
        $ptr = $ptr->calls[$index];
        $ptr->endTime = time();
        $mod = $ptr->modifiedVars = new Scope();
        if (isset($template_obj->parent->_tpl_vars)) {
            $old = $template_obj->parent->_tpl_vars;
        }
        $cur = $template_obj->_tpl_vars;
        foreach ($cur as $name => $value) {
            if (!isset($old->$name) || $old->$name != $cur->$name) {
                $mod->$name = clone $value;
            }
        }
    }

    /**
     * @param $compiler_obj
     */
    public function templateCompilerStart($compiler_obj)
    {
        $ptr = $this->_getCompilerContextPtr($compiler_obj);
        $ptr->startTime = time();
    }

    /**
     * @param $compiler_obj
     *
     * @return stdClass
     */
    public function _getCompilerContextPtr($compiler_obj)
    {
        $keys = $this->_getKeysTemplate($compiler_obj->context);
        $keys['compiled'] = $keys['compiled'] = isset($compiler_obj->compileId) ? $compiler_obj->compileId : '';
        $source_ptr = $this->_getSourcePtr($compiler_obj->context, $keys);
        if (isset($source_ptr->compiled[$keys['compiled']])) {
            $ptr = $source_ptr->compiled[$keys['compiled']];
        } else {
            $ptr = $source_ptr->compiled[$keys['compiled']] = new stdClass();
            $ptr->calls = array();
            $ptr->callstack = array();
        }
        if (isset($ptr->compiler)) {
            $ptr = $ptr->compiler;
        } else {
            $ptr = $ptr->compiler = new stdClass;
        }
        return $ptr;
    }

    /**
     * @param $compiler_obj
     */
    public function templateCompilerEnd($compiler_obj)
    {
        $ptr = $this->_getCompilerContextPtr($compiler_obj);
        $ptr->endTime = time();
    }

    /**
     * @param $obj
     * @param $from
     * @param $type
     * @param $name
     * @param $callback
     */
    public function _filter($obj, $from, $type, $name, $callback)
    {
        $i = 1;
    }

    /**
     * @param $template_obj
     */
    public function _cacheUpdate($template_obj)
    {
        $i = 1;
    }

    /**
     * @param $template_obj
     */
    public function _cacheDelete($template_obj)
    {
        $i = 1;
    }

    public function display()
    {
        $tpl_obj = new Smarty();
        $vars = $this->_get_debug_vars($this->smarty->_tpl_vars);
        ksort($vars[0]);
        ksort($vars[1]);
        $tpl_obj->assign('assigned_vars', $vars[0]);
        $tpl_obj->assign('config_vars', $vars[1]);
        echo $tpl_obj->fetch(dirname(__FILE__) . '/logger.tpl');
    }

    /**
     * Recursively gets variables from all template/data scopes
     *
     * @param  Scope $scope
     *
     * @return array
     */
    public function _get_debug_vars($scope)
    {
        $config_vars = array();
        $tpl_vars = array();
        foreach ($scope as $key => $value) {
            if (strpos($key, '___config_var_') !== 0) {
                $tpl_vars[$key] = $value;
            } else {
                $key = substr($key, 14);
                $config_vars[$key] = $value;
            }
        }
        return array($tpl_vars, $config_vars);
    }
}

if (!function_exists('smarty_modifier_logger_print_var')) {
    /**
     * Smarty debug_print_var modifier
     * Type:     modifier<br>
     * Name:     debug_print_var<br>
     * Purpose:  formats variable contents for display in the console
     *
     * @param array|object $var    variable to be formatted
     * @param integer      $depth  maximum recursion depth if $var is an array
     * @param integer      $length maximum string length if $var is a string
     * @param bool         $root   flag true if called in debug.tpl
     *
     * @return string
     */
    function smarty_modifier_logger_print_var($var, $depth = 0, $length = 40, $root = true)
    {
        $_replace = array("\n" => '<i>\n</i>',
                          "\r" => '<i>\r</i>',
                          "\t" => '<i>\t</i>'
        );

        switch (gettype($var)) {
            case 'array' :
                if ($root) {
                    $results = '';
                } else {
                    $results = '<b>Array (' . count($var) . ')</b>';
                }
                foreach ($var as $curr_key => $curr_val) {
                    $results .= '<br>' . str_repeat('&nbsp;', $depth * 2)
                        . '<b>' . strtr($curr_key, $_replace) . '</b> =&gt; '
                        . smarty_modifier_logger_print_var($curr_val, ++$depth, $length, false);
                    $depth --;
                }
                break;

            case 'object' :
                $object_vars = get_object_vars($var);
                $results = '';
                if (!$root) {
                    $results = '<b>' . get_class($var) . ' Object (' . count($object_vars) . ')</b><br>';
                }
                foreach ($object_vars as $curr_key => $curr_val) {
                    $results .= str_repeat('&nbsp;', $depth * 2)
                        . '<b> -&gt;' . strtr($curr_key, $_replace) . '</b> = '
                        . smarty_modifier_logger_print_var($curr_val, ++$depth, $length, false) . '<br>';
                    $depth --;
                }
                break;

            case 'boolean' :
            case 'NULL' :
            case 'resource' :
                if (true === $var) {
                    $results = 'true';
                } elseif (false === $var) {
                    $results = 'false';
                } elseif (null === $var) {
                    $results = 'null';
                } else {
                    $results = htmlspecialchars((string) $var);
                }
                $results = '<i>' . $results . '</i>';
                break;

            case 'integer' :
            case 'float' :
                $results = htmlspecialchars((string) $var);
                break;

            case 'string' :
                $results = strtr($var, $_replace);
                if (Smarty::$_MBSTRING) {
                    if (mb_strlen($var, Smarty::$_CHARSET) > $length) {
                        $results = mb_substr($var, 0, $length - 3, Smarty::$_CHARSET) . '...';
                    }
                } else {
                    if (isset($var[$length])) {
                        $results = substr($var, 0, $length - 3) . '...';
                    }
                }

                $results = htmlspecialchars('"' . $results . '"');
                break;

            case 'unknown type' :
            default :
                if (Smarty::$_MBSTRING) {
                    if (mb_strlen($results, Smarty::$_CHARSET) > $length) {
                        $results = mb_substr($results, 0, $length - 3, Smarty::$_CHARSET) . '...';
                    }
                } else {
                    if (strlen($results) > $length) {
                        $results = substr($results, 0, $length - 3) . '...';
                    }
                }

                $results = htmlspecialchars($results);
        }

        return $results;
    }
}
