<?php
namespace Smarty\Resource\Compiled;

use Smarty\Context;
use Smarty\Resource\FileBase;

/**
 * Class File
 *
 * @package Smarty\Resource\Compiled
 */
class File extends FileBase
{
    /**
     * Load compiled template
     *
     * @param Context $context
     *
     * @throws Exception
     * @returns Smarty_Template
     */
    public function instanceTemplate(Context $context)
    {
        $timestamp = $exists = false;
        $filepath = $this->buildFilepath($context);
        $this->populateTimestamp($context->smarty, $filepath, $timestamp, $exists);
        $template_obj = null;
        $level = ob_get_level();
        $is_locked = false;
        try {
            $isValid = false;
            if ($exists && !$context->getProperty('forceCompile') && $timestamp >= $context->timestamp) {
                // load existing compiled template class
                $template_class_name = $this->loadTemplateClass($filepath);
                if (class_exists($template_class_name, false)) {
                    $template_obj = new $template_class_name($context);
                    $isValid = $template_obj->isValid;
                }
            }
            if (!$isValid) {
                $context->enableCompiler();
                $is_locked = $this->setLock($context, $filepath, $timestamp, $exists);
                $template_class_name = '';
                // we must compile from source
                $this->write($context->smarty, $filepath, $context->compileResource());
                $this->populateTimestamp($context->smarty, $filepath, $timestamp, $exists);
                $template_class_name = $this->loadTemplateClass($filepath);
                if (class_exists($template_class_name, false)) {
                    $template_obj = new $template_class_name($context);
                    $template_obj->isUpdated = true;
                    $isValid = $template_obj->isValid;
                }
                if (!$isValid) {
                    throw new Smarty_Exception_FileLoadError('compiled template', $filepath);
                }
            }
        }
        catch (Exception $e) {
            $this->resetLock($is_locked, $filepath);
            while (ob_get_level() > $level) {
                ob_end_clean();
            }
            //            throw new Smarty_Exception_Runtime('resource ', -1, null, null, $e);
            throw $e;
        }
        return $template_obj;
    }

    /**
     * populate Compiled Object with compiled filepath
     *
     * @param  Context $context
     *
     * @return string
     */
    public function buildFilepath(Context $context)
    {
        $_compileId = ($_compileId = $context->getProperty('compileId')) ? preg_replace('![^\w\|]+!', '_', $_compileId) : null;
        $_filepath = $context->uid . '_' . $context->smarty->compiletime_params;
        // if useSubDirs, break file into directories
        if ($useSubDirs = $context->getProperty('useSubDirs')) {
            $_filepath = substr($_filepath, 0, 2) . '/'
                . substr($_filepath, 2, 2) . '/'
                . substr($_filepath, 4, 2) . '/'
                . $_filepath;
        }
        $_compile_dir_sep = $useSubDirs ? '/' : '^';
        if (isset($_compileId)) {
            $_filepath = $_compileId . $_compile_dir_sep . $_filepath;
        }
        // subtype
        if ($context->_usage == \Smarty::IS_CONFIG) {
            $_subtype = '.config';
            // TODO must caching be a compiled property?
        } elseif ($context->getProperty('caching')) {
            $_subtype = '.cache';
        } else {
            $_subtype = '';
        }
        $_compile_dir = $context->getProperty('compileDir');
        // set basename if not specified
        $_basename = $context->handler->getBasename($context);
        if ($_basename === null) {
            $_basename = basename(preg_replace('![^\w\/]+!', '_', $context->name));
        }
        // separate (optional) basename by dot
        if ($_basename) {
            $_basename = '.' . $_basename;
        }

        return $_compile_dir . $_filepath . '.' . $context->type . $_basename . $_subtype . '.php';
    }

    /**
     * get timestamp and exists from Resource
     *
     * @param  Smarty $smarty   Smarty object
     * @param  string $filepath
     * @param         reference integer $timestamp
     * @param         reference boolean $exists
     */
    public function populateTimestamp(\Smarty $smarty, $filepath, &$timestamp, &$exists)
    {
        if ($filepath && is_file($filepath)) {
            $timestamp = filemtime($filepath);
            $exists = true;
        } else {
            $timestamp = $exists = false;
        }
    }

    /**
     * load compiled template class
     *
     * @param string $filepath
     *
     * @return string  template class name
     */
    public function loadTemplateClass($filepath)
    {
        $template_class_name = '';
        include $filepath;
        return $template_class_name;
    }

    /**
     * Set lock on compiled file
     *
     * @param $context
     * @param $filepath
     * @param $timestamp
     * @param $exists
     *
     * @return bool|int
     */
    public function setLock($context, $filepath, $timestamp, $exists)
    {
        if (!$exists || !$context->getProperty('compileLocking')) {
            return false;
        }
        // compile locking
        touch($filepath);
        return $timestamp;
    }

    /**
     * Reset lock on comiled files
     *
     * @param $is_locked
     * @param $filepath
     *
     * @return bool
     */
    public function resetLock($is_locked, $filepath)
    {
        if ($is_locked === false) {
            return false;
        }
        touch($filepath, $is_locked);
    }

    /**
     * Delete compiled template file
     *
     * @internal
     *
     * @param  Smarty  $smarty           Smarty instance
     * @param  string  $templateResource template name
     * @param  string  $compileId        compile id
     * @param  integer $exp_time         expiration time
     * @param  boolean $isConfig
     *
     * @return integer number of template files deleted
     */
    public function clear(Smarty $smarty, $templateResource, $compileId, $exp_time, $isConfig)
    {
        // is external to save memory
        return Smarty_Resource_Compiled_Extension_File::clear($smarty, $templateResource, $compileId, $exp_time, $isConfig);
    }
}
