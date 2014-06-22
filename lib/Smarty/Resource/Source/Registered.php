<?php

/**
 * Smarty Resource Source Registered Plugin
 *
 * @package Smarty\Resource\Source
 * @author  Uwe Tews
 * @author  Rodney Rehm
 */

/**
 * Smarty Resource Source Registered Plugin
 * Implements the registered resource for Smarty template
 *
 * @package Smarty\Resource\Source
 * @deprecated
 */
class Smarty_Resource_Source_Registered extends Smarty_Resource_Source_File
{
    /**
     *  Smarty object
     *
     * @var Smarty
     */
    public $smarty = null;

    /**
     * This resource allows relative path
     *
     * @var false
     */
    public $_allowRelativePath = false;

    /**
     * populate Source Object with meta data from Resource
     *
     * @param Context $context
     */
    public function populate(Context $context)
    {
        $context->filepath = $context->type . ':' . $context->name;
        $context->uid = sha1($context->filepath);
        if ($context->smarty->compileCheck) {
            $context->timestamp = $this->getTemplateTimestamp($context);
            $context->exists = !!$context->timestamp;
        }
    }

    /**
     * Get timestamp (epoch) the template source was modified
     *
     * @param  Context $context
     *
     * @return integer|boolean timestamp (epoch) the template was modified, false if resources has no timestamp
     */
    public function getTemplateTimestamp(Context $context)
    {
        // return timestamp
        $time_stamp = false;
        call_user_func_array($context->smarty->_registered['resource'][Smarty::SOURCE][$context->type][0][1], array($context->name, &$time_stamp, $context->smarty));

        return is_numeric($time_stamp) ? (int) $time_stamp : $time_stamp;
    }

    /**
     * populate Source Object filepath
     *
     * @param  Context $context
     *
     * @return void
     */
    public function buildFilepath(Context $context)
    {
    }

    /**
     * Load template's source by invoking the registered callback into current template object
     *
     * @param  Context $context
     *
     * @return string           template source
     * @throws Smarty_Exception if source cannot be loaded
     */
    public function getContent(Context $context)
    {
        // return template string
        $t = call_user_func_array($context->smarty->_registered['resource'][Smarty::SOURCE][$context->type][0][0], array($context->name, &$context->content, $context->smarty));
        if (is_bool($t) && !$t) {
            throw new Smarty_Exception("Unable to read template {$context->type} '{$context->name}'");
        }
        return $context->content;
    }

    /**
     * Determine basename for compiled filename
     *
     * @param  Context $context
     *
     * @return string resource's basename
     */
    public function getBasename(Context $context)
    {
        return basename($context->name);
    }
}
