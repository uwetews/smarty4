<?php

/**
 */

/**
 * Utility class



 */
class Smarty_Misc_Utility
{

    /**
     * private constructor to prevent calls creation of new instances
     */
    final private function __construct()
    {
        // intentionally left blank
    }

    /**
     * Return array of tag/attributes of all tags used by an template
     *
     * @param  Smarty $template template object
     *
     * @return array  of tag/attributes
     */
    public static function getTags(Smarty $template)
    {
        $tpl_obj->get_used_tags = true;
        $tpl_obj->compiler->compileSource();
        unset($tpl_obj->compiler);

        return $tpl_obj->used_tags;
    }
}
