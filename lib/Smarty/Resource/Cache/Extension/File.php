<?php
namespace Smarty\Resource\Cache\Extension;
/**
 * Smarty Resource Cache File Plugin
 *
 * @package Smarty\Resource\Cache
 * @author  Uwe Tews
 */

/**
 * Smarty Resource Cache File Extension



 */
class File
{

    /**
     * Delete cache file for a specific template
     *
     * @internal
     *
     * @param  Smarty  $smarty        Smarty object
     * @param  string  $resource_name template name
     * @param  string  $cacheId       cache id
     * @param  string  $compileId     compile id
     * @param  integer $exp_time      expiration time (number of seconds, not timestamp)
     *
     * @return integer number of cache files deleted
     */
    public static function clear(Smarty $smarty, $resource_name, $cacheId, $compileId, $exp_time)
    {
        $_cacheId = isset($cacheId) ? preg_replace('![^\w\|]+!', '_', $cacheId) : null;
        $_compileId = isset($compileId) ? preg_replace('![^\w\|]+!', '_', $compileId) : null;
        $_preg_compileId = ($_compileId == null) ? '(.*)?' : preg_quote($_compileId);
        $_preg_cacheId = '(.*)?';
        $_preg_file = '(.*)?';
        $_cache_dir = str_replace('\\', '/', $smarty->getCacheDir());
        $_count = 0;
        $_time = time();

        if (isset($resource_name)) {
            $context = $smarty->_getContext($resource_name);
            if ($context->exists) {
                // set basename if not specified
                $_basename = $context->handler->getBasename($context);
                if ($_basename === null) {
                    $_basename = basename(preg_replace('![^\w\/]+!', '_', $context->name));
                }
                // separate (optional) basename by dot
                //                if ($_basename) {
                //                    $_basename = '.' . $_basename;
                //                }
                if ($smarty->useSubDirs) {
                    $_preg_file = preg_quote($_basename);
                    $_dirtpl_obj = $_cache_dir . substr($context->uid, 0, 2) . '/' . $context->uid . '/';
                    // does subdir for template exits?
                    if (!is_dir($_dirtpl_obj)) {
                        return 0;
                    }
                    // use template subdir as top level
                    $_dir_array = array($_dirtpl_obj);
                } else {
                    $_preg_file = preg_quote($context->uid . '.' . $_basename);
                }
            } else {
                // template does not exist
                return 0;
            }
        }
        // if useSubDirs iterate over folder
        if ($smarty->useSubDirs) {
            // if no template was specified build top level array for all templates
            if (!isset($resource_name)) {
                $_dir_array = array();
                $_dir_it1 = new DirectoryIterator($_cache_dir);
                foreach ($_dir_it1 as $_dir1) {
                    if (!$_dir1->isDir() || $_dir1->isDot() || substr(basename($_dir1->getPathname()), 0, 1) == '.') {
                        continue;
                    }
                    $_dir_it2 = new DirectoryIterator($_dir1->getPathname());
                    foreach ($_dir_it2 as $_dir2) {
                        if (!$_dir2->isDir() || $_dir2->isDot() || substr(basename($_dir2->getPathname()), 0, 1) == '.') {
                            continue;
                        }
                        $_dir_array[] = $_dir2->getPathname() . '/';
                    }
                }
            }
            $_dir_cacheId = '';
            // build subfolders by cacheId
            if (isset($_cacheId)) {
                $_cacheId_parts = explode('|', $_cacheId);
                $_cacheId_last = count($_cacheId_parts) - 1;
                $_cacheId_hash = md5($_cacheId_parts[$_cacheId_last]);
                // lower levels of structured cacheId
                if ($_cacheId_last > 0) {
                    for ($i = 0; $i < $_cacheId_last; $i ++) {
                        $_dir_cacheId .= $_cacheId_parts[$i] . '/';
                    }
                }
                // hash for highest level of cacheId
                $_dir_cacheId2 = $_dir_cacheId . substr($_cacheId_hash, 0, 2) . '/'
                    . substr($_cacheId_hash, 2, 2) . '/'
                    . substr($_cacheId_hash, 4, 2) . '/';
                $_preg_cacheId2 = preg_quote($_cacheId_parts[$_cacheId_last]);
                // add highest level
                $_dir_cacheId .= $_cacheId_parts[$_cacheId_last] . '/';
            }
            // loop over templates
            foreach ($_dir_array as $dir) {
                $_dirs = array($dir . $_dir_cacheId, isset($_cacheId) ? $dir . $_dir_cacheId2 : null);
                $_deleted = array(false, false);
                for ($i = 0; $i < 2; $i ++) {
                    if ($i == 0) {
                        if (!is_dir($_dirs[$i])) {
                            continue;
                        }
                        // folder for lower levels is present or no cacheId specified
                        $_cacheDirs1 = new RecursiveDirectoryIterator($_dirs[$i]);
                        $_cacheDirs = new RecursiveIteratorIterator($_cacheDirs1, RecursiveIteratorIterator::CHILD_FIRST);
                        $_preg_cacheId = '(.*)?';
                    } elseif (isset($_cacheId)) {
                        if (!is_dir($_dirs[$i])) {
                            continue;
                        }
                        // folder with highest level hash is present
                        $_cacheDirs = new DirectoryIterator($_dirs[$i]);
                        $_preg_cacheId = $_preg_cacheId2;
                    }
                    if ($i == 0 || isset($_cacheId)) {
                        $regex = "/^{$_preg_cacheId}\^{$_preg_compileId}\^{$_preg_file}\.php\$/i";
                        foreach ($_cacheDirs as $_file) {
                            // directory ?
                            if ($_file->isDir()) {
                                if (!$_cacheDirs->isDot()) {
                                    // delete folder if empty
                                    @rmdir($_file->getPathname());
                                    continue;
                                }
                            }
                            $path = $_file->getPathname();
                            if (substr(basename($path), 0, 1) == '.') {
                                continue;
                            }
                            $filename = str_replace('\\', '/', $path);
                            // does file match selections?
                            if (!preg_match($regex, $filename, $matches)) {
                                continue;
                            }
                            // expired ?
                            if (isset($exp_time) && $_time - @filemtime($path) < $exp_time) {
                                continue;
                            }
                            $_count += @unlink($path) ? 1 : 0;
                            $_deleted[$i] = true;
                            if ($smarty->enableTrace && isset(Smarty::$_trace_callbacks['cache:delete'])) {
                                $smarty->_triggerTraceCallback('cache:delete', array($path, $compileId, $cacheId, $exp_time));
                            }
                        }
                    }
                    unset($_cacheDirs, $_cacheDirs1);
                    if ($_deleted[$i]) {
                        $_dir = $_dirs[$i];
                        while ($_dir != $_cache_dir) {
                            if (@rmdir($_dir) === false) {
                                break;
                            }
                            $_dir = substr($_dir, 0, strrpos(substr($_dir, 0, - 1), '/') + 1);
                        }
                    }
                }
            }
        } else {
            if (isset($_cacheId)) {
                $_preg_cacheId = preg_quote(str_replace('|', '.', $_cacheId)) . '(?=[\^\.])(.*)?';
            }
            $regex = "/^{$_preg_cacheId}\^{$_preg_compileId}\^{$_preg_file}\.php\$/i";
            $_cacheDirs = new DirectoryIterator($_cache_dir);
            foreach ($_cacheDirs as $_file) {
                // directory ?
                if ($_file->isDir()) {
                    continue;
                }
                $path = $_file->getPathname();
                $filename = basename($path);
                // does file match selections?
                if (!preg_match($regex, $filename, $matches)) {
                    continue;
                }
                // expired ?
                if (isset($exp_time)) {
                    if ($exp_time < 0) {
                        preg_match('#$cacheLifetime =\s*(\d*)#', file_get_contents($path), $match);
                        if ($_time < (@filemtime($path) + $match[1])) {
                            continue;
                        }
                    } else {
                        if ($_time - @filemtime($path) < $exp_time) {
                            continue;
                        }
                    }
                }
                $_count += @unlink($path) ? 1 : 0;
                if ($smarty->enableTrace && isset(Smarty::$_trace_callbacks['cache:delete'])) {
                    $smarty->_triggerTraceCallback('cache:delete', array($path, $compileId, $cacheId, $exp_time));
                }
            }
        }

        return $_count;
    }
}
