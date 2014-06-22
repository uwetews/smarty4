<?php

/**
 * Smarty Resource Compiled Recompiled Plugin
 *
 * @package Smarty\Resource\Compiled * @author Uwe Tews
 */

/**
 * Smarty Resource Compiled File Plugin
 * Meta Data Container for Compiled Template Files

 */
class Smarty_Resource_Compiled_Recompiled //extends Smarty_Exception_Magic
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
        $template_obj = null;
        $level = ob_get_level();
        try {
            $template_class_name = '';
            $isValid = false;
            if ($context->smarty->debugging) {
                Smarty_Debug::start_compile($context);
            }
            $class_name = $context->getCompilerClass();
            $compiler = new $class_name($context, null);
            eval('?>' . $compiler->compileResource($context));
            unset($compiler);
            if ($context->smarty->debugging) {
                Smarty_Debug::end_compile($context);
            }
            if (class_exists($template_class_name, false)) {
                $template_obj = new $template_class_name($context);
                $template_obj->isUpdated = true;
                $isValid = $template_obj->isValid;
            }
            if (!$isValid) {
                throw new Smarty_Exception_FileLoadError('compiled template', $context->filepath);
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
     * @return false
     */
    public function buildFilepath(Context $context)
    {
        return false;
    }

    /**
     * get timestamp and exists from Resource
     *
     * @param  Smarty $smarty   Smarty object
     * @param  string $filepath
     * @param         reference integer $timestamp
     * @param         reference boolean $exists
     */
    public function populateTimestamp(Smarty $smarty, $filepath, &$timestamp, &$exists)
    {
        $timestamp = $exists = false;
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
     * @param          $isConfig
     *
     * @return integer number of template files deleted
     */
    public function clear(Smarty $smarty, $templateResource, $compileId, $exp_time, $isConfig)
    {
        // is a noop on recompiled resources
        return 0;
    }
}
