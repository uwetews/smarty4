<?php /* Smarty version Smarty 4.0-DEV, created on 2014-09-04 05:14:43 */
use Smarty\Template\Core;
use Smarty\Variable\Entry;
if (!class_exists('_SmartyTemplate_5407d923033336_48365726',false)) {
    class _SmartyTemplate_5407d923033336_48365726 extends Core {
        /* Compiled from "./templates/bug.tpl" */
        public $version = 'Smarty 4.0-DEV';
        public $has_nocache_code = false;
        public $filepath = '';
        public $timestamp = 0;
        public $file_dependency = array(
                'ff2566969a4e56eb6e9c8584f1ee068c63a89b5d' => array(
                        0 => './templates/bug.tpl',
                        1 => 1409787683,
                        2 => 'file'
                    )
            );


        function _renderTemplate ($_scope) {
            ob_start();

//line 0001:
            echo '
';

//line 0002:
            $this->_assignInScope('i', new Entry('ja', false), 0);
            echo '
';

//line 0003:
            echo $_scope->_tpl_vars->i->value;
            echo '
';

//line 0004:
            $this->_assignInScope('i', new Entry('nein', false), 0);
            echo '
';

//line 0005:
            echo $_scope->_tpl_vars->i->value;
            echo '
';

//line 0006:
            $_scope->_tpl_vars->aa = new Entry;
            $_scope->_tpl_vars->aa->_loop = false;
            $_from = $_scope->_tpl_vars->a->value;
            if (!is_array($_from) && !($_from instanceof Traversable)) {
                settype($_from, 'array');
            }
            foreach ($_from as  $_scope->_tpl_vars->aa->value) {
                $_scope->_tpl_vars->aa->_loop = true;
                echo '
    <br>';

//line 0007:
                echo $_scope->_tpl_vars->aa->value;
                echo 3 + 5;
                echo '
';
            }
            return ob_get_clean();
        }

        function _getSourceInfo () {
            return array(
                    23 => 1,
                    26 => 2,
                    30 => 3,
                    34 => 4,
                    38 => 5,
                    42 => 6,
                    53 => 7
                );
        }
    }
}
$template_class_name = '_SmartyTemplate_5407d923033336_48365726';
