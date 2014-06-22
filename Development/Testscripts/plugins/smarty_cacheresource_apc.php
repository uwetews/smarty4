<?php

/**
 * Smarty Plugin CacheResource APC
 *
 * Implements APC resource for the HTML cache
 *
 * Work with Smarty 3.0.x
 * Does not works with Smarty 3.1.x
 *
 * @package Smarty
 * @subpackage Cacher
 * @author Monte Ohrt (APC base)
 * @author Vladimir Kovacevic (Upgrade on lock mechanisam)
 */

/**
 * This class does contain all necessary methods for the HTML cache with APC
 */
class Smarty_Resource_Cache_Apc extends Smarty_Resource_Cache
{

    /**
     * Global var name for temporary key storage
     *
     * @var string
     */
    private $lockKeyVar = 'SMARTYAPCLOCK';

    public function __construct()
    {
        // test if APC is present
        if (!function_exists('apc_cache_info'))
            throw new Exception('APC Template Caching Error: APC is not installed');
    }

    /**
     * populate Cached Object with meta data from Resource
     *
     * @param  Smarty_Template_Cached   $cached    cached object
     * @param  Smarty_Internal_Template $_template template object
     * @return void
     */
    public function populate(Smarty_Template_Cached $cached, Smarty_Internal_Template $_template)
    {
        $_cache_id = isset($_template->cache_id) ? $_template->cache_id : null;
        $_compile_id = isset($_template->compile_id) ? $_template->compile_id : null;
        $_filepath = $_template->source->uid;
        $cached->filepath = $_cache_id . $_compile_id . $_template->source->uid . '.smarty_cache';
        $cached->lock_id = $cached->filepath . '.lock';
        $this->populateTimestamp($cached);
        $cached->timestamp = @filemtime($cached->filepath);
        $cached->exists = !!$cached->timestamp;
    }

    /**
     * populate Cached Object with timestamp and exists from Resource
     *
     * @param  Smarty_Template_Cached $source cached object
     * @return void
     */

    public function populateTimestamp(Smarty_Template_Cached $cached)
    {
        # Try to fetch cached content...
        $cached->content = apc_fetch($cached->filepath, $success);
        $ret = $success ? time() : false;
        $cached->timestamp = $success ? time() : false;
        $cached->exists = !!$cached->timestamp;
    }

    /**
     * Read the cached template and process the header
     *
     * @param  Smarty_Internal_Template $_template template object
     * @param  Smarty_Template_Cached   $cached    cached object
     * @return booelan                  true or false if the cached content does not exist
     */
    public function process(Smarty_Internal_Template $_template, Smarty_Template_Cached $cached = null)
    {
        if (!$cached) {
            $cached = $_template->cached;
        }
        if (!$cached->exists) {
            $this->populateTimestamp($cached);
        }
        if (!$cached->exists) {
            return false;
        }
        $_smarty_tpl = $_template;
        eval("?>" . $cached->content);

        return true;
    }

    /**
     * Write the rendered template output to cache
     *
     * @param  Smarty_Internal_Template $_template template object
     * @param  string                   $content   content to cache
     * @return boolean                  success
     */
    public function writeCachedContent(Smarty_Internal_Template $_template, $content)
    {
        if ($_template->cache_lifetime > 0) {

            $ret = apc_store($this->getCachedFilepath($_template), $content, $_template->cache_lifetime);
            if ($ret) {
                $template->cached->timestamp = time();
                $template->cached->exists true;
           }

            return $ret;
        }
    }
}

/**
 * Empty cache folder
 *
 * @param integer $exp_time expiration time
 * @return integer number of cache files deleted
 */
public
function clearAll($exp_time = null)
{
    return apc_clear_cache('user');
}

/**
 * Empty cache for a specific template
 *
 * @param string $resource_name template name
 * @param string $cache_id cache id
 * @param string $compile_id compile id
 * @param integer $exp_time expiration time
 * @return integer number of cache files deleted
 */
public
function clear($resource_name, $cache_id, $compile_id, $exp_time)
{
    if (isset($resource_name)) {
        $tpl = new $smarty->template_class($resource_name, $smarty);
        $smarty->caching = $_save_stat;
        if ($tpl->source->exists) {
            $uid = $tpl->uid;
            // remove from template cache
            unset($smarty->_source_cache[sha1($tpl->template_resource . $tpl->cache_id . $tpl->compile_id)]);
        } else {
            // remove from template cache
            unset($smarty->_source_cache[sha1($tpl->template_resource . $tpl->cache_id . $tpl->compile_id)]);

            return 0;
        }
    }

    return apc_delete($cache_id . $compile_id . $uid . '.smarty_cache');
}
}
