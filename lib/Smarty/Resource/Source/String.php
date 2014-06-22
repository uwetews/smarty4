<?php

/**
 * Smarty Resource Source String Plugin
 *
 * @package Smarty\Resource\Source
 * @author  Uwe Tews
 * @author  Rodney Rehm
 */

/**
 * Smarty Resource Source String Plugin
 * Implements the strings as resource for Smarty template
 * {@internal unlike eval-resources the compiled state of string-resources is saved for subsequent access}}
 *
 * @package Smarty\Resource\Source
 */
class Smarty_Resource_Source_String extends Smarty_Resource_Source_File
{

    /**
     * Flag if source needs no compiler
     *
     * @var bool
     */
    public $uncompiled = false;

    /**
     * Flag if source needs to be always recompiled
     *
     * @var bool
     */
    public $recompiled = false;

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
        $context->uid = $context->filepath = sha1($context->name);
        $context->timestamp = 0;
        $context->exists = true;
    }

    /**
     * Load template's source from $resource_name into current template object
     *
     * @uses decode() to decode base64 and urlencoded templateResources
     *
     * @param Context $context
     *
     * @return string template source
     */
    public function getContent(Context $context)
    {
        return $this->decode($context->name);
    }

    /**
     * decode base64 and urlencode
     *
     * @param  string $string templateResource to decode
     *
     * @return string decoded templateResource
     */
    protected function decode($string)
    {
        // decode if specified
        if (($pos = strpos($string, ':')) !== false) {
            if (strpos($string, 'base64') === 0) {
                return base64_decode(substr($string, 7));
            } elseif (strpos($string, 'urlencode') === 0) {
                return urldecode(substr($string, 10));
            }
        }
        return $string;
    }

    /**
     * Determine basename for compiled filename
     * Always returns an empty string.
     *
     * @param Context $context
     *
     * @return string ''
     */
    public function getBasename(Context $context)
    {
        return '';
    }
}
