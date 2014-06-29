<?php /* Smarty version Smarty 4.0-DEV, created on 2014-06-29 20:34:38 */
use Smarty\Template\Core;
use Smarty\Variable\Entry;
if (!class_exists('_SmartyTemplate_53b05c3e875419_70046986',false)) {
    class _SmartyTemplate_53b05c3e875419_70046986 extends Core {
        /* Compiled from "./templates/bug.tpl" */
        public $version = 'Smarty 4.0-DEV';
        public $has_nocache_code = false;
        public $filepath = '';
        public $timestamp = 0;
        public $file_dependency = array(
                'ff2566969a4e56eb6e9c8584f1ee068c63a89b5d' => array(
                        0 => './templates/bug.tpl',
                        1 => 1403740911,
                        2 => 'file'
                    )
            );


        function _renderTemplate ($_scope) {
            $output = '';
            if ($_scope->_tpl_vars->bar->value) {
                $output .= "c ";
                $output .= 4 + $_scope->_tpl_vars->bar->value / 8;
                $output .= " ";
            }
            $output .= "\n\n";
            return $output;
        }

        function _getSourceInfo () {
            return array();
        }
    }
}
$template_class_name = '_SmartyTemplate_53b05c3e875419_70046986';
