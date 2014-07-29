<?php /* Smarty version Smarty 4.0-DEV, created on 2014-07-20 23:33:41 */
use Smarty\Template\Core;
use Smarty\Variable\Entry;
if (!class_exists('_SmartyTemplate_53cc35b5549652_40642207',false)) {
    class _SmartyTemplate_53cc35b5549652_40642207 extends Core {
        /* Compiled from "./templates/bug.tpl" */
        public $version = 'Smarty 4.0-DEV';
        public $has_nocache_code = false;
        public $filepath = '';
        public $timestamp = 0;
        public $file_dependency = array(
                'ff2566969a4e56eb6e9c8584f1ee068c63a89b5d' => array(
                        0 => './templates/bug.tpl',
                        1 => 1405249874,
                        2 => 'file'
                    )
            );
        public $required_plugins = array(
                'C:\wamp\www\smarty4\lib\Smarty/Plugins/function.counter.php' => 'smarty_function_counter'
            );


        function _renderTemplate ($_scope) {
            $output = '';

//line 0001:
            $output .= '<br>kk
';

//line 0002:
            $this->_assignInScope('i', new Entry(9, false), 0);
            $output .= '
';

//line 0003:
            $output .= $_scope->_tpl_vars->i->value;
            $output .= '
';
            return $output;
        }

        function _getSourceInfo () {
            return array(
                    26 => 1,
                    29 => 2,
                    33 => 3
                );
        }
    }
}
$template_class_name = '_SmartyTemplate_53cc35b5549652_40642207';
