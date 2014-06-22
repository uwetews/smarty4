<?php
/**
 * Smarty plugin
 *
 * @package Smarty
 * @subpackage PluginsClasses
 */
class Smarty_Class_Test extends Smarty_Compiler_Template_Tag
{
    public function execute()
    {
        return 'hello world';
    }
}
