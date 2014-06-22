<?php

/**
 * Smarty Resource Source Uncompiled Class
 *
 * @package Smarty\Resource\Source
 * @author  Rodney Rehm
 */

/**
 * Smarty Resource Source Uncompiled Class
 * Base implementation for resource plugins that don't use the compiler
 *
 * @package Smarty\Resource\Source
 */
abstract class Smarty_Resource_Source_Uncompiled extends Smarty_Resource_Source_File
{

    /**
     * Flag that source does not nee compilation
     *
     * @var bool
     */
    public $uncompiled = true;

    /**
     * get rendered template output from compiled template
     *
     * @param \Smarty_Resource_Source_File $source  source object
     * @param \Smarty                      $tpl_obj template object
     *
     * @throws Exception
     * @return string
     */
    public function getRenderedTemplate(Smarty_Resource_Source_File $source, Smarty $tpl_obj)
    {
        if ($tpl_obj->debugging) {
            Smarty_Debug::start_render($source);
        }
        try {
            $level = ob_get_level();
            ob_start();
            $this->renderUncompiled($source, $tpl_obj);
            $output = ob_get_clean();
        }
        catch (Exception $e) {
            while (ob_get_level() > $level) {
                ob_end_clean();
            }
            throw $e;
        }
        if ($tpl_obj->caching) {
            $cached = Smarty_Resource_Cache_Extension_Create::_getCachedObject($tpl_obj);
            $cached->newcache->file_dependency[$source->uid] = array($source->filepath, $source->timestamp, $source->type);
        }
        return $output;
    }

    /**
     * Render and output the template (without using the compiler)
     *
     * @param Smarty $tpl_obj template object
     *
     * @return
     * @internal param \Smarty_Resource_Source $source source object
     */
    abstract public function renderUncompiled(Smarty $tpl_obj);
}
