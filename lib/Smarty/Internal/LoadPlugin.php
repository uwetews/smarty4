<?php
/**
 * Smarty Extension
 * Smarty class methods
 *
 * @package Smarty\Extension
 * @author  Uwe Tews
 */

/**
 * Class for getIncludePath method
 *
 * @package Smarty\Extension
 */
class Smarty_Internal_LoadPlugin
{
    /**
     * Takes unknown classes and loads plugin files for them
     * class name format: Smarty_PluginType_PluginName
     * plugin filename format: plugintype.pluginname.php
     *
     * @internal
     *
     * @param   Smarty $smarty
     * @param  string  $plugin_name plugin or class name
     * @param  bool    $check       check if already loaded
     *
     * @throws Smarty_Exception
     * @return string|boolean   filepath of loaded plugin | true if it was a Smarty core class || false if not found
     */
    public function _loadPlugin(Smarty $smarty, $plugin_name, $check = true)
    {
        if ($check) {
            // if function or class exists, exit silently (already loaded)
            if (is_callable($plugin_name) || class_exists($plugin_name, false)) {
                return true;
            }
        }
        // Plugin name is expected to be: Smarty_[Type]_[Name]
        $_name_parts = explode('_', $plugin_name, 3);
        // class name must have at least three parts to be valid plugin
        if (!isset($_name_parts[2]) || strtolower($_name_parts[0]) !== 'smarty') {
            throw new Smarty_Exception("loadPlugin(): Plugin {$plugin_name} is not a valid name format");
        }
        // plugin filename is expected to be: [type].[name].php
        $_plugin_filename = "{$_name_parts[1]}.{$_name_parts[2]}.php";
        // add SMARTY_PLUGINS_DIR if not present
        $_plugins_dir = $smarty->getPluginsDir();
        if (!$smarty->disable_core_plugins) {
            $_plugins_dir[] = Smarty::$_SMARTY_PLUGINS_DIR;
        }

        // loop through plugin dirs and find the plugin
        foreach ($_plugins_dir as $_plugin_dir) {
            $names = array(
                $_plugin_dir . $_plugin_filename,
                $_plugin_dir . strtolower($_plugin_filename),
            );
            foreach ($names as $file) {
                if (file_exists($file)) {
                    require_once($file);

                    return $file;
                }
            }
        }

        // no plugin loaded
        return false;
    }
}
