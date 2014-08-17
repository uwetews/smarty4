<?php
namespace Smarty\Resource\Cache;

use Smarty\Template\Context;

/**
 * Class File
 * This class does contain all necessary methods for the HTML cache on file system
 * Implements the file system as resource for the HTML cache Version using nocache inserts.
 *
 * @package Smarty\Resource\Cache
 */
class File //extends Smarty_Exception_Magic
{

    /**
     * Id for cache locking
     *
     * @var string
     */
    public $lock_id = null;

    /**
     * flag that cache is locked by this instance
     *
     * @var bool
     */
    public $is_locked = false;

    /**
     * Load cached template
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
        try {
            $level = ob_get_level();
            $isValid = false;
            if ($exists && !$context->smarty->forceCompile && !$context->smarty->forceCache && $timestamp >= $context->timestamp) {
                $template_class_name = '';
                // load existing compiled template class
                $template_class_name = $this->loadTemplateClass($filepath);
                if (class_exists($template_class_name, false)) {
                    $template_obj = new $template_class_name($context);
                    $isValid = $template_obj->isValid;
                }
            }
            if (!$isValid) {
                // rebuild cache file
                $obj = new Smarty_Resource_Cache_Extension_Create($this, $filepath);
                $obj->_renderCacheSubTemplate($context);
                $obj->destroy();
                unset($obj);
                // load existing compiled template class
                $this->populateTimestamp($context->smarty, $filepath, $timestamp, $exists);
                if ($exists) {
                    $template_class_name = '';
                    $template_class_name = $this->loadTemplateClass($filepath);
                    if (class_exists($template_class_name, false)) {
                        $template_obj = new $template_class_name($context);
                        $template_obj->isUpdated = true;
                        $isValid = $template_obj->isValid;
                        if ($context->smarty->enableTrace && isset(Smarty::$_trace_callbacks['cache:update'])) {
                            $context->smarty->_triggerTraceCallback('cache:update', array($template_obj));
                        }
                    }
                }
                if (!$isValid) {
                    throw new Smarty_Exception("Unable to load cached template file '{$filepath}'");
                }
            }
        }
        catch (Exception $e) {
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
        $_source_file_path = str_replace(':', '.', $context->filepath);
        $_cacheId = isset($context->cacheId) ? preg_replace('![^\w\|]+!', '_', $context->cacheId) : null;
        $_compileId = isset($context->compileId) ? preg_replace('![^\w\|]+!', '_', $context->compileId) : null;
        // if useSubDirs build subfolders
        if ($context->smarty->useSubDirs) {
            $_filepath = substr($context->uid, 0, 2) . '/' . $context->uid . '/';
            if (isset($_cacheId)) {
                $_cacheId_parts = explode('|', $_cacheId);
                $_cacheId_last = count($_cacheId_parts) - 1;
                $_cacheId_hash = md5($_cacheId_parts[$_cacheId_last]);
                if ($_cacheId_last > 0) {
                    for ($i = 0; $i < $_cacheId_last; $i ++) {
                        $_filepath .= $_cacheId_parts[$i] . '/';
                    }
                }
                $_filepath .= substr($_cacheId_hash, 0, 2) . '/'
                    . substr($_cacheId_hash, 2, 2) . '/'
                    . substr($_cacheId_hash, 4, 2) . '/';
                $_filepath .= $_cacheId_parts[$_cacheId_last];
            }
            $_filepath .= '^' . $_compileId . '^';
        } else {
            $_filepath = str_replace('|', '.', $_cacheId) . '^' . $_compileId . '^' . $context->uid . '.';
        }
        $_cache_dir = $context->smarty->getCacheDir();
        if ($context->smarty->cache_locking) {
            // create locking file name
            // relative file name?
            if (!preg_match('/^([\/\\\\]|[a-zA-Z]:[\/\\\\])/', $_cache_dir)) {
                $_lock_dir = rtrim(getcwd(), '/\\') . '/' . $_cache_dir;
            } else {
                $_lock_dir = $_cache_dir;
            }
            $this->lock_id = $_lock_dir . sha1($_cacheId . $_compileId . $context->uid) . '.lock';
        }

        return $_cache_dir . $_filepath . basename($_source_file_path) . '.php';
    }

    /**
     * get timestamp and exists from Resource
     *
     * @param  Smarty $smarty Smarty object
     * @param         $filepath
     * @param         $timestamp
     * @param         $exists
     *
     * @return boolean  true if file exits
     */
    public function populateTimestamp(Smarty $smarty, $filepath, &$timestamp, &$exists)
    {
        if (is_file($filepath)) {
            $timestamp = filemtime($filepath);
            $exists = true;
            return true;
        } else {
            $timestamp = $exists = false;
            return false;
        }
    }

    /**
     * load cache template class
     *
     * @param $filepath
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
     * Write the rendered template output to cache
     *
     * @param  Smarty $tpl_obj  template object
     * @param  string $filepath filepath
     * @param  string $content  content to cache
     *
     * @return boolean success
     */
    public function writeCache(Smarty $tpl_obj, $filepath, $content)
    {
        return $tpl_obj->_writeFile($filepath, $content);
    }

    /**
     * Empty cache
     *
     * @param  Smarty  $smarty   Smarty object
     * @param  integer $exp_time expiration time (number of seconds, not timestamp)
     *
     * @return integer number of cache files deleted
     */
    public function clearAll(Smarty $smarty, $exp_time = null)
    {
        $save_useSubDirs = $smarty->useSubDirs;
        $smarty->useSubDirs = false;
        $count = $this->clear($smarty, null, null, null, $exp_time);
        $smarty->useSubDirs = true;
        $count += $this->clear($smarty, null, null, null, $exp_time);
        $smarty->useSubDirs = $save_useSubDirs;
        return $count;
    }

    /**
     * Empty cache for a specific template
     *
     * @param  Smarty  $smarty        Smarty object
     * @param  string  $resource_name template name
     * @param  string  $cacheId       cache id
     * @param  string  $compileId     compile id
     * @param  integer $exp_time      expiration time (number of seconds, not timestamp)
     *
     * @return integer number of cache files deleted
     */
    public function clear(Smarty $smarty, $resource_name, $cacheId, $compileId, $exp_time)
    {
        // is external to save memory
        return Smarty_Resource_Cache_Extension_File::clear($smarty, $resource_name, $cacheId, $compileId, $exp_time);
    }

    /**
     * Check is cache is locked for this template
     *
     * @param  Smarty $smarty Smarty object
     *
     * @return bool   true or false if cache is locked
     */
    public function hasLock(Smarty $smarty)
    {
        if (version_compare(PHP_VERSION, '5.3.0', '>=')) {
            clearstatcache(true, $this->lock_id);
        } else {
            clearstatcache();
        }
        $t = @filemtime($this->lock_id);

        return $t && (time() - $t < $smarty->locking_timeout);
    }

    /**
     * Lock cache for this template
     *
     * @param  Smarty $smarty Smarty object
     *
     * @return void
     */
    public function acquireLock(Smarty $smarty)
    {
        $this->is_locked = true;
        touch($this->lock_id);
    }

    /**
     * Unlock cache for this template
     *
     * @param  Smarty $smarty Smarty object
     *
     * @return void
     */
    public function releaseLock(Smarty $smarty)
    {
        $this->is_locked = false;
        @unlink($this->lock_id);
    }

    /**
     * Check timestamp of browser cache against timestamp of individually cached subtemplates
     *
     * @param  Smarty  $smarty                   template object
     * @param  integer $_last_modified_timestamp browser cache timestamp
     *
     * @return bool    true if browser cache is valid
     */
    private function checkSubtemplateCache($smarty, $_last_modified_timestamp)
    {
        $subtpl = reset($smarty->_cachedSubtemplates);
        while ($subtpl) {
            $tpl = clone $this;
            unset($tpl->source, $tpl->compiled, $tpl->cached, $tpl->compiler, $tpl->mustCompile);
            $tpl->_usage = Smarty::IS_SMARTY_TPL_CLONE;
            $tpl->templateResource = $subtpl[0];
            $tpl->cacheId = $subtpl[1];
            $tpl->compileId = $subtpl[2];
            $tpl->caching = $subtpl[3];
            $tpl->cacheLifetime = $subtpl[4];
            if (!$tpl->cached->valid || $tpl->has_nocache_code || $tpl->cached->timestamp > $_last_modified_timestamp ||
                !$this->checkSubtemplateCache($tpl, $_last_modified_timestamp)
            ) {
                // browser cache invalid
                return false;
            }
            $subtpl = next($smarty->_cachedSubtemplates);
        }
        // browser cache valid
        return true;
    }
}
