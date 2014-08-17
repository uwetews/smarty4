<?php

/**
 * Smarty Internal Plugin Debug
 * Class to collect data for the Smarty Debugging Consol
 *
 * @package Debug
 * @author  Uwe Tews
 */

/**
 * Smarty Internal Plugin Debug Class
 *
 * @package Debug
 */
class Smarty_Debug extends Smarty_Variable_Methods
{

    /**
     * template data
     *
     * @var array
     */
    public static $_template_data = array();

    /**
     *  URL debugging ?
     *
     * @param Smarty $smarty
     */
    public static function checkURLDebug($smarty)
    {
        if (isset($_SERVER['QUERY_STRING'])) {
            $_query_string = $_SERVER['QUERY_STRING'];
        } else {
            $_query_string = '';
        }
        if (false !== strpos($_query_string, $smarty->smartyDebugId)) {
            if (false !== strpos($_query_string, $smarty->smartyDebugId . '=on')) {
                // enable debugging for this browser session
                setcookie('SMARTY_DEBUG', true);
                $smarty->debugging = true;
            } elseif (false !== strpos($_query_string, $smarty->smartyDebugId . '=off')) {
                // disable debugging for this browser session
                setcookie('SMARTY_DEBUG', false);
                $smarty->debugging = false;
            } else {
                // enable debugging for this page
                $smarty->debugging = true;
            }
        } else {
            if (isset($_COOKIE['SMARTY_DEBUG'])) {
                $smarty->debugging = true;
            }
        }
    }

    /**
     * Start logging of compile time
     *
     * @param Context $context
     */
    public static function start_compile(Context $context)
    {
        $key = self::get_key($context);
        self::$_template_data[$key]['start_time'] = microtime(true);
    }

    /**
     * Return key into $_template_data for template
     *
     * @param  Context $context
     *
     * @return string          key into $_template_data
     */
    private static function get_key(Context $context)
    {
        static $_is_stringy = array('string' => true, 'eval' => true);
        // calculate Uid if not already done
        if ($context->uid == '') {
            $context->filepath;
        }
        $key = $context->uid;
        if (isset(self::$_template_data[$key])) {
            return $key;
        } else {
            if (isset($_is_stringy[$context->type])) {
                self::$_template_data[$key]['name'] = '\'' . substr($context->name, 0, 25) . '...\'';
            } else {
                self::$_template_data[$key]['name'] = $context->filepath;
            }
            self::$_template_data[$key]['compile_time'] = 0;
            self::$_template_data[$key]['render_time'] = 0;
            self::$_template_data[$key]['cache_time'] = 0;

            return $key;
        }
    }

    /**
     * End logging of compile time
     *
     * @param Context $context
     */
    public static function end_compile(Context $context)
    {
        $key = self::get_key($context);
        self::$_template_data[$key]['compile_time'] += microtime(true) - self::$_template_data[$key]['start_time'];
    }

    /**
     * Start logging of render time
     *
     * @param Context $context
     */
    public static function start_render(Context $context)
    {
        $key = self::get_key($context);
        self::$_template_data[$key]['start_time'] = microtime(true);
    }

    /**
     * End logging of compile time
     *
     * @param Context $context
     */
    public static function end_render(Context $context)
    {
        $key = self::get_key($context);
        self::$_template_data[$key]['render_time'] += microtime(true) - self::$_template_data[$key]['start_time'];
    }

    /**
     * Start logging of cache time
     *
     * @param Context $context
     */
    public static function start_cache(Context $context)
    {
        $key = self::get_key($context);
        self::$_template_data[$key]['start_time'] = microtime(true);
    }

    /**
     * End logging of cache time
     *
     * @param Context $context
     */
    public static function end_cache(Context $context)
    {
        $key = self::get_key($context);
        self::$_template_data[$key]['cache_time'] += microtime(true) - self::$_template_data[$key]['start_time'];
    }

    /**
     * Opens a window for the Smarty Debugging Consol and display the data
     *
     * @param $obj
     */
    public static function display_debug($obj)
    {
        if ($obj instanceof Smarty_Template) {
            $context = $obj->context;
        } else {
            $context = $obj;
            $obj = $context->smarty;
        }
        // prepare information of assigned variables
        $ptr = self::get_debug_vars($obj);
        $tpl_obj = clone $context->smarty;
        $tpl_obj->_tpl_vars = new Scope();
        $tpl_obj->_registered = array();
        $tpl_obj->autoload_filters = array();
        $tpl_obj->default_modifiers = array();
        $tpl_obj->forceCompile = false;
        $tpl_obj->left_delimiter = '{';
        $tpl_obj->right_delimiter = '}';
        $tpl_obj->debugging = false;
        $tpl_obj->forceCompile = false;
        $tpl_obj->caching = false;
        $tpl_obj->disableSecurity();
        $tpl_obj->debugging_ctrl = 'NONE';
        $tpl_obj->cacheId = null;
        $tpl_obj->compileId = null;
        $tpl_obj->parent = null;
        $_assigned_vars = $ptr->_tpl_vars;
        ksort($_assigned_vars);
        $_config_vars = $ptr->config_vars;
        ksort($_config_vars);
        if ($obj instanceof Smarty_Template) {
            $tpl_obj->assign('template_name', $context->type . ':' . $context->name);
            $tpl_obj->assign('template_data', null);
        } else {
            $tpl_obj->assign('template_name', null);
            $tpl_obj->assign('template_data', self::$_template_data);
        }
        $tpl_obj->assign('assigned_vars', $_assigned_vars);
        $tpl_obj->assign('config_vars', $_config_vars);
        $tpl_obj->assign('execution_time', microtime(true) - $tpl_obj->start_time);
        $debugTpl = isset($tpl_obj->debugTpl) ? $tpl_obj->debugTpl : 'file:' . dirname(__FILE__) . '/debug.tpl';
        echo $tpl_obj->fetch($debugTpl);
    }

    /**
     * Recursively gets variables from all template/data scopes
     *
     * @param  Smarty|Smarty_Variable_Data $obj object to debug
     *
     * @return StdClass
     */
    public static function get_debug_vars($obj)
    {
        $config_vars = array();
        $tpl_vars = array();
        // TODO Source Info
        foreach ($obj->_tpl_vars as $key => $value) {
            if (strpos($key, '___config_var_') !== 0) {
                $tpl_vars[$key] = $value;
                //                    $tpl_vars[$key]->context = $obj->_tpl_vars->___attributes->name;
            } else {
                $key = substr($key, 14);
                $config_vars[$key] = $value;
                //                    $config_vars[$key]['source'] = $obj->context->type . ':' . $obj->context->name;
            }
        }

        if (isset($obj->parent)) {
            $parent = self::get_debug_vars($obj->parent);
            $tpl_vars = array_merge($parent->_tpl_vars, $tpl_vars);
            $config_vars = array_merge($parent->config_vars, $config_vars);
        } else {
            foreach (Smarty::$_global_tpl_vars as $key => $var) {
                if (strpos($key, '___template_ptr') !== 0) {
                    if (!isset($tpl_vars[$key])) {
                        if (strpos($key, '___smarty_conf_') !== 0) {
                            $tpl_vars[$key] = $var;
                            $tpl_vars[$key]->context = 'Smarty global';
                        } else {
                        }
                    }
                }
            }
        }

        return (object) array('_tpl_vars' => $tpl_vars, 'config_vars' => $config_vars);
    }
}

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
function smarty_modifier_debug_print_var($var, $depth = 0, $length = 40, $root = true)
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
                    . smarty_modifier_debug_print_var($curr_val, ++ $depth, $length, false);
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
                    . smarty_modifier_debug_print_var($curr_val, ++ $depth, $length, false) . '<br>';
                $depth --;
            }
            break;

        case 'boolean' :
        case 'NULL' :
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
        case 'double' :
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
        case 'resource' :
            $results = 'Resource ' . get_resource_type($var);
            break;
        case 'unknown type' :
        default :
            $results = 'unknown';
    }

    return $results;
}
