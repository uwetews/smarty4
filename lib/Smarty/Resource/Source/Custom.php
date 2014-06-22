<?php

/**
 * Smarty Resource Source Custom Class
 *
 * @package Smarty\Resource\Source
 * @author  Rodney Rehm
 */

/**
 * Smarty Smarty Resource Source Custom Class
 * Wrapper Implementation for custom source resource plugins
 *
 * @package Smarty\Resource\Source
 */
abstract class Smarty_Resource_Source_Custom extends Smarty_Resource_Source_File
{
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
        $context->filepath = strtolower($context->type . ':' . $context->name);
        $context->uid = sha1($context->type . ':' . $context->name);

        $mtime = $this->fetchTimestamp($context->name);
        if ($mtime !== null) {
            $context->timestamp = $mtime;
        } else {
            $this->fetch($context->name, $content, $timestamp);
            $context->timestamp = isset($timestamp) ? $timestamp : false;
            if (isset($content)) {
                $context->content = $content;
            }
        }
        $context->exists = !!$context->timestamp;
    }

    /**
     * Fetch template's modification timestamp from data source
     * {@internal implementing this method is optional.
     *  Only implement it if modification times can be accessed faster than loading the complete template source.}}
     *
     * @param  string $name template name
     *
     * @return integer|boolean timestamp (epoch) the template was modified, or false if not found
     */
    protected function fetchTimestamp($name)
    {
        return null;
    }

    /**
     * fetch template and its modification time from data source
     *
     * @param string  $name    template name
     * @param string  &$source template source
     * @param integer &$mtime  template modification timestamp (epoch)
     */
    abstract protected function fetch($name, &$source, &$mtime);

    /**
     * populate Source Object filepath
     * Contextam  Context $context
     *
     * @param  Context $context
     *
     * @return void
     */
    public function buildFilepath(Context $context)
    {
    }

    /**
     * Load template's source into current template object
     *
     * @param  Context $context
     *
     * @return string           template source
     * @throws Smarty_Exception if source cannot be loaded
     */
    public function getContent(Context $context)
    {
        $this->fetch($context->name, $content, $timestamp);
        if (isset($content)) {
            return $content;
        }

        throw new Smarty_Exception("Unable to read template {$context->type} '{$context->name}'");
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
