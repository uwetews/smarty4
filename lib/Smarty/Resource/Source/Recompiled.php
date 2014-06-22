<?php

/**
 * Smarty Resource Source Recompiled Class
 *
 * @package Smarty\Resource\Source
 * @author  Rodney Rehm
 */

/**
 * Smarty Resource Source Recompiled Class
 * Base implementation for resource plugins that don't compile cache
 *
 * @package Smarty\Resource\Source
 */
abstract class Smarty_Resource_Source_Recompiled extends Smarty_Resource_Source_File
{
    /**
     * Flag that source must always be recompiled
     *
     * @var bool
     */
    public $recompiled = true;

    /**
     * This resource allows relative path
     *
     * @var false
     */
    public $_allowRelativePath = false;
}
