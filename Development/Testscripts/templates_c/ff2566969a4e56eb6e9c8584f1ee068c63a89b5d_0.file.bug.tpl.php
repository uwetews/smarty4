<?php /* Smarty version Smarty 4.0-DEV, created on 2014-06-21 17:29:16 */
use Smarty\Template\Core;
use Smarty\Variable\Entry;
if (!class_exists('_SmartyTemplate_53a5a4cc7fffa8_20335425',false)) {
    class _SmartyTemplate_53a5a4cc7fffa8_20335425 extends Core {
        /* Compiled from "./templates/bug.tpl" */
        public $version = 'Smarty 4.0-DEV';
        public $has_nocache_code = false;
        public $filepath = '';
        public $timestamp = 0;
        public $file_dependency = array(
                'ff2566969a4e56eb6e9c8584f1ee068c63a89b5d' => array(
                        0 => './templates/bug.tpl',
                        1 => 1403315571,
                        2 => 'file'
                    )
            );


        function _renderTemplate ($_scope) {
            $output = '';

//line 0001:
            $output .= "\n";

//line 0002:
            $output .= count(strlen($_scope->_tpl_vars->bar->value));
            $output .= "\n\n";
            return $output;
        }

        function _getSourceInfo () {
            return array(
                    23 => 1,
                    26 => 2
                );
        }
    }
}
$template_class_name = '_SmartyTemplate_53a5a4cc7fffa8_20335425';
