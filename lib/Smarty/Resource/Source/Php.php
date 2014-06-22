<?php

/**
 * Smarty Resource Source PHP File Plugin
 *
 * @package Smarty\Resource\Source
 * @author  Uwe Tews
 * @author  Rodney Rehm
 */

/**
 * Smarty Resource Source PHP File Plugin
 * Implements the file system as resource for PHP templates
 *
 * @package Smarty\Resource\Source
 */
class Smarty_Resource_Source_Php extends Smarty_Resource_Source_File
{

    /**
     * container for short_open_tag directive's value before executing PHP templates
     *
     * @var string
     */
    protected $short_open_tag;

    /**
     * Create a new PHP Resource

     */
    public function __construct()
    {
        $this->uncompiled = true;
        $this->short_open_tag = ini_get('short_open_tag');
    }

    /**
     * Load template's source from file into current template object
     *
     * @return string           template source
     * @throws Smarty_Exception if source cannot be loaded
     */
    public function getContent()
    {
        if ($this->timestamp) {
            return '';
        }
        throw new Smarty_Exception("Unable to read template {$this->type} '{$this->name}'");
    }

    /**
     * Render and output the template (without using the compiler)
     *
     * @param  Smarty $tpl_obj template object
     *
     * @return void
     * @throws Smarty_Exception if template cannot be loaded or allow_Code_Php_templates is disabled
     */
    public function renderUncompiled(Smarty $tpl_obj)
    {
        $_smarty_tpl = $tpl_obj;

        if (!$tpl_obj->allow_Code_Php_templates) {
            throw new Smarty_Exception("PHP templates are disabled");
        }
        if (!$this->exists) {
            if ($tpl_obj->parent instanceof Smarty) {
                $parent_resource = " in '{$tpl_obj->parent->templateResource}'";
            } else {
                $parent_resource = '';
            }
            throw new Smarty_Exception("Unable to load template {$this->type} '{$this->name}'{$parent_resource}");
        }

        // prepare variables
        extract($tpl_obj->getTemplateVars());

        // include PHP template with short open tags enabled
        ini_set('short_open_tag', '1');
        include($this->filepath);
        ini_set('short_open_tag', $this->short_open_tag);
    }
}
