<?php

/**
 * Smarty Resource Source Extends Plugin
 *
 * @package Smarty\Resource\Source
 * @author  Uwe Tews
 * @author  Rodney Rehm
 */

/**
 * Smarty Resource Source Extends Plugin
 * Implements the file system as resource for Smarty which {extend}s a chain of template files templates
 *
 * @package Smarty\Resource\Source
 */
class Smarty_Resource_Source_Extends extends Smarty_Resource_Source_File
{

    /**
     * populate Source Object with meta data from Resource
     *
     * @param Smarty $smarty Smarty object
     *
     * @throws Smarty_Exception_SourceNotFound
     * @throws IllegalInheritanceResourceType
     */
    public function populate(Smarty $smarty)
    {
        $uid = '';
        $sources = array();
        $components = explode('|', $this->name);
        $exists = true;
        foreach ($components as $component) {
            $context = $smarty->_getContext($component);
            // checks if source exists
            if (!$context->exists) {
                throw new Smarty_Exception_SourceNotFound($context->type, $context->name);
            }
            if ($context->type == 'php') {
                throw new IllegalInheritanceResourceType($context->type);
            }
            $sources[$context->uid] = $context;
            $uid .= $context->filepath;
            if ($smarty && $smarty->compileCheck) {
                $exists = $exists && $context->exists;
            }
        }
        $this->components = $sources;
        $this->filepath = $context->filepath;
        $this->uid = sha1($uid);
        $this->filepath = 'extends_resource_' . $this->uid . '.tpl';
        if ($smarty && $smarty->compileCheck) {
            $this->timestamp = 1;
            $this->exists = $exists;
        }
        // need the template at getContent()
        $this->template = $smarty;
    }

    /**
     * populate Source Object with timestamp and exists from Resource

     */
    public function populateTimestamp()
    {
        $this->exists = true;
        $this->timestamp = 1;
    }

    /**
     * Load template's source from files into current template object
     *
     * @return string           template source
     * @throws Smarty_Exception if source cannot be loaded
     */
    public function getContent()
    {
        $source_code = '';
        $_components = array_reverse($this->components);
        $_last = end($_components);

        foreach ($_components as $_component) {
            if ($_component != $_last) {
                $source_code .= "{$this->tpl_obj->left_delimiter}private_inheritancetpl_obj file='$_component->filepath' child--{$this->tpl_obj->right_delimiter}\n";
            } else {
                $source_code .= "{$this->tpl_obj->left_delimiter}private_inheritancetpl_obj file='$_component->filepath'--{$this->tpl_obj->right_delimiter}\n";
            }
        }

        return $source_code;
    }

    /**
     * Determine basename for compiled filename
     *
     * @return string resource's basename
     */
    public function getBasename()
    {
        return str_replace(':', '.', basename($this->filepath));
    }

    /**
     * populate Source Object with meta data from Resource
     *
     * @param Smarty $smarty template object
     *
     * @return string|void
     */

    public function buildFilepath(Smarty $smarty = null)
    {
    }
}
