<?php

/**
 * Smarty Extension
 * Smarty class methods
 *
 * @package Smarty\Extension
 * @author  Uwe Tews
 */

/**
 * Class for writeFile method
 *
 * @internal
 * @package Smarty\Extension
 */
class Smarty_Internal_WriteFile
{
    /**
     * Flag if we are running on Windows
     *
     * @var boolean
     */
    static $_IS_WINDOWS = null;

    /**
     * Writes compiled or cache file in a safe way to disk
     *
     * @internal
     *
     * @param  Smarty $smarty    smarty object
     * @param  string $_filepath complete filepath
     * @param  string $_contents file content
     *
     * @throws Smarty_Exception
     * @return boolean          true
     */
    public function _writeFile(Smarty $smarty, $_filepath, $_contents)
    {
        if (!isset(self::$_IS_WINDOWS)) {
            self::$_IS_WINDOWS = strtoupper(substr(PHP_OS, 0, 3)) === 'WIN';
        }
        $_error_reporting = error_reporting();
        error_reporting($_error_reporting & ~E_NOTICE & ~E_WARNING);
        if ($smarty->_filePerms !== null) {
            $old_umask = umask(0);
        }

        $_dirpath = dirname($_filepath);
        // if subdirs, create dir structure
        if ($_dirpath !== '.' && !file_exists($_dirpath)) {
            mkdir($_dirpath, $smarty->_dir_perms === null ? 0777 : $smarty->_dir_perms, true);
        }

        // write to tmp file, then move to overt file lock race condition
        $_tmp_file = $_dirpath . '/' . str_replace(array('.', ','), '_', uniqid('wrt', true)) . '.tmp';
        if (!file_put_contents($_tmp_file, $_contents)) {
            error_reporting($_error_reporting);
            throw new Smarty_Exception("unable to write file {$_tmp_file}");
        }

        /*
         * Windows' rename() fails if the destination exists,
         * Linux' rename() properly handles the overwrite.
         * Simply unlink()ing a file might cause other processes
         * currently reading that file to fail, but linux' rename()
         * seems to be smart enough to handle that for us.
         */
        if (self::$_IS_WINDOWS) {
            // remove original file
            if (is_file($_filepath)) {
                @unlink($_filepath);
            }
            // rename tmp file
            $success = @rename($_tmp_file, $_filepath);
        } else {
            // rename tmp file
            $success = @rename($_tmp_file, $_filepath);
            if (!$success) {
                // remove original file
                @unlink($_filepath);
                // rename tmp file
                $success = @rename($_tmp_file, $_filepath);
            }
        }

        if (!$success) {
            error_reporting($_error_reporting);
            throw new Smarty_Exception("unable to write file {$_filepath}");
        }

        if ($smarty->enableTrace) {
            // notify listeners of written file
            $smarty->_triggerTraceCallback('filesystem:write', array($smarty, $_filepath));
        }

        if ($smarty->_filePerms !== null) {
            // set file permissions
            chmod($_filepath, $smarty->_filePerms);
            umask($old_umask);
        }
        error_reporting($_error_reporting);

        return true;
    }
}
