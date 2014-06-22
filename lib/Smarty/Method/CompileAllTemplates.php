<?php

/**
 * Smarty Extension
 * Smarty class methods
 *
 * @package Smarty\Extension
 * @author  Uwe Tews
 */

/**
 * Class for compileAllTemplates method
 *
 * @package Smarty\Extension
 */
class Smarty_Method_CompileAllTemplates
{
    /**
     * Compile all template files
     *
     * @api
     *
     * @param Smarty  $smarty       smarty object
     * @param string  $extension    extension of template file names
     * @param boolean $forceCompile true to force recompilation of all templates
     * @param int     $time_limit   set maximum execution time
     * @param int     $max_errors   set maximum allowed errors
     *
     * @return integer number of template files compiled
     */
    public function compileAllTemplates(Smarty $smarty, $extension, $forceCompile, $time_limit, $max_errors)
    {
        // switch off time limit
        if (function_exists('set_time_limit')) {
            @set_time_limit($time_limit);
        }
        $smarty->forceCompile = $forceCompile;
        $_count = 0;
        $_error_count = 0;
        // loop over array of template directories
        foreach ($smarty->getTemplateDir() as $_dir) {
            $_compileDirs = new RecursiveDirectoryIterator($_dir);
            $_compile = new RecursiveIteratorIterator($_compileDirs);
            foreach ($_compile as $_fileinfo) {
                $_file = $_fileinfo->getFilename();
                if (substr(basename($_fileinfo->getPathname()), 0, 1) == '.' || strpos($_file, '.svn') !== false) {
                    continue;
                }
                if (!substr_compare($_file, $extension, - strlen($extension)) == 0) {
                    continue;
                }
                if ($_fileinfo->getPath() == substr($_dir, 0, - 1)) {
                    $_template_file = $_file;
                } else {
                    $_template_file = substr($_fileinfo->getPath(), strlen($_dir)) . '/' . $_file;
                }
                echo '<br>', $_dir, '---', $_template_file;
                flush();
                $_start_time = microtime(true);
                try {
                    $_tpl = $smarty->createTemplate($_template_file);
                    if ($_tpl->mustCompile) {
                        $_tpl->compiler->compileSource();
                        $_tpl->cleanPointer();
                        $_count ++;
                        echo ' compiled in  ', microtime(true) - $_start_time, ' seconds';
                        flush();
                        echo '<br>' . memory_get_usage(true);
                    } else {
                        echo ' is up to date';
                        flush();
                    }
                }
                catch (Exception $e) {
                    echo 'Error: ', $e->getMessage(), "<br><br>";
                    $_error_count ++;
                }
                // free memory
                Smarty::$_resource_cache = array();
                if ($max_errors !== null && $_error_count == $max_errors) {
                    echo '<br><br>too many errors';
                    exit();
                }
            }
        }

        return $_count;
    }
}
