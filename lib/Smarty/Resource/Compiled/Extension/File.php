<?php

/**
 * Smarty Resource Compiled File Plugin
 *
 * @package Smarty\Resource\Compiled * @author Uwe Tews
 */

/**
 * Smarty Resource Compiled File Extension



 */
class Smarty_Resource_Compiled_Extension_File
{

    /**
     * Delete compiled template file
     *
     * @param  Smarty  $smarty           Smarty instance
     * @param  string  $templateResource template name
     * @param  string  $compileId        compile id
     * @param  integer $exp_time         expiration time
     * @param  boolean $isConfig         true if a config file
     *
     * @return integer number of template files deleted
     */
    public static function clear(Smarty $smarty, $templateResource, $compileId, $exp_time, $isConfig)
    {
        $_compile_dir = str_replace('\\', '/', $smarty->getCompileDir());
        $_compileId = isset($compileId) ? preg_replace('![^\w\|]+!', '_', $compileId) : null;
        $compiletime_params = 0;
        $_dir_sep = $smarty->useSubDirs ? '/' : '^';
        if (isset($templateResource)) {
            $context = $smarty->_getContext($templateResource);
            if ($context->exists) {
                // set basename if not specified
                $_basename = $context->handler->getBasename($context);
                if ($_basename === null) {
                    $_basename = basename(preg_replace('![^\w\/]+!', '_', $context->name));
                }
                // separate (optional) basename by dot
                if ($_basename) {
                    $_basename = '.' . $_basename;
                }
                $_resource_part_1 = $context->uid . '_' . $compiletime_params . '.' . $context->type . $_basename . '.php';
                $_resource_part_1_length = strlen($_resource_part_1);
            } else {
                return 0;
            }

            $_resource_part_2 = str_replace('.php', '.cache.php', $_resource_part_1);
            $_resource_part_2_length = strlen($_resource_part_2);
        }
        $_dir = $_compile_dir;
        if ($smarty->useSubDirs && isset($_compileId)) {
            $_dir .= $_compileId . $_dir_sep;
        }
        if (isset($_compileId)) {
            $_compileId_part = $_compile_dir . $_compileId . $_dir_sep;
        }
        $_count = 0;
        try {
            $_compileDirs = new RecursiveDirectoryIterator($_dir);
            // NOTE: UnexpectedValueException thrown for PHP >= 5.3
        }
        catch (Exception $e) {
            return 0;
        }
        $_compile = new RecursiveIteratorIterator($_compileDirs, RecursiveIteratorIterator::CHILD_FIRST);
        foreach ($_compile as $_file) {
            if (substr($_file->getBasename(), 0, 1) == '.' || strpos($_file, '.svn') !== false) {
                continue;
            }

            $_filepath = str_replace('\\', '/', (string) $_file);

            if ($_file->isDir()) {
                if (!$_compile->isDot()) {
                    // delete folder if empty
                    @rmdir($_file->getPathname());
                }
            } else {
                $unlink = false;
                if ((!isset($_compileId) || strpos($_filepath, $_compileId_part) === 0)
                    && (!isset($templateResource)
                        || (isset($_filepath[$_resource_part_1_length])
                            && substr_compare($_filepath, $_resource_part_1, - $_resource_part_1_length, $_resource_part_1_length) == 0)
                        || (isset($_filepath[$_resource_part_2_length])
                            && substr_compare($_filepath, $_resource_part_2, - $_resource_part_2_length, $_resource_part_2_length) == 0))
                ) {
                    if (isset($exp_time)) {
                        if (time() - @filemtime($_filepath) >= $exp_time) {
                            $unlink = true;
                        }
                    } else {
                        $unlink = true;
                    }
                }

                if ($unlink && @unlink($_filepath)) {
                    $_count ++;
                    if ($smarty->enableTrace) {
                        // notify listeners of deleted file
                        $smarty->_triggerTraceCallback('filesystem:delete', array($smarty, $_filepath));
                    }
                }
            }
        }
        return $_count;
    }
}
