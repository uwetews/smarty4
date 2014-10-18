<?php

/**
 * Smarty Internal Plugin Compile Insert
 * Compiles the {insert} tag
 *
 * @package Compiler
 * @author  Uwe Tews
 */

/**
 * Smarty Internal Plugin Compile Insert Class
 *
 * @package Compiler
 */
class Smarty_Compiler_Php_NodeCompiler_Tag_Insert extends Smarty_Compiler_Code_Php_NodeCompiler_Tag
{

    /**
     * Attribute definition: Overwrites base class.
     *
     * @var array
     * @see $tpl_obj
     */
    public $required_attributes = array('name');

    /**
     * Attribute definition: Overwrites base class.
     *
     * @var array
     * @see $tpl_obj
     */
    public $shorttag_order = array('name');

    /**
     * Attribute definition: Overwrites base class.
     *
     * @var array
     * @see $tpl_obj
     */
    public $optional_attributes = array('_any');

    /**
     * Compiles code for the {insert} tag
     *
     * @param  array  $args     array with attributes from parser
     * @param  object $compiler compiler object
     *
     * @return string compiled code
     */
    public function compile($args, $compiler)
    {
        // check and get attributes
        $_attr = $this->getAttributes($compiler, $args);
        // never compile as nocache code
        $compiler->suppressNocacheProcessing = true;
        $compiler->tag_nocache = true;
        $_name = null;
        $_script = null;

        $this->iniTagCode($compiler);

        // save possible attributes
        eval('$_name = ' . $_attr['name'] . ';');
        if (isset($_attr['assign'])) {
            // output will be stored in a smarty variable instead of being displayed
            $_assign = $_attr['assign'];
            // create variable to make sure that the compiler knows about its nocache status
            $compiler->template_scope->_tpl_vars->{trim($_attr['assign'], "'")} = new Entry(null, true);
        }
        if (isset($_attr['script'])) {
            // script which must be included
            $_function = "smarty_insert_{$_name}";
            $_filepath = false;
            eval('$_script = ' . $_attr['script'] . ';');
            if (!isset($compiler->context->smarty->securityPolicy) && is_file($_script)) {
                $_filepath = $_script;
            } else {
                if (isset($compiler->context->smarty->securityPolicy)) {
                    $_dir = $compiler->context->smarty->securityPolicy->trusted_dir;
                } else {
                    $_dir = $compiler->context->smarty->trusted_dir;
                }
                if (!empty($_dir)) {
                    foreach ((array) $_dir as $_script_dir) {
                        $_script_dir = rtrim($_script_dir, '/\\') . '/';
                        if (is_file($_script_dir . $_script)) {
                            $_filepath = $_script_dir . $_script;
                            break;
                        }
                    }
                }
            }
            if ($_filepath == false) {
                $compiler->error("{insert} missing script file '{$_script}'", $compiler->lex->taglineno);
            }
            // code for script file loading
            $this->code("require_once '{$_filepath}';")
                 ->newline();
            require_once $_filepath;
            if (!is_callable($_function)) {
                $compiler->error(" {insert} function '{$_function}' is not callable in script file '{$_script}'", $compiler->lex->taglineno);
            }
        } else {
            $_function = "insert_{$_name}";
            // function in PHP script ?
            if (!is_callable($_function)) {
                // try plugin
                if (!$_function = $compiler->getPlugin($_name, 'insert')) {
                    $compiler->error("{insert} no function or plugin found for '{$_name}'", $compiler->lex->taglineno);
                }
            }
        }
        // delete {insert} standard attributes
        unset($_attr['name'], $_attr['assign'], $_attr['script'], $_attr['nocache']);
        // convert attributes into parameter array string
        $_paramsArray = array();
        foreach ($_attr as $_key => $_value) {
            $_paramsArray[] = "'$_key' => $_value ";
        }
        $_params = 'array(' . implode(", ", $_paramsArray) . ')';
        // call insert
        if (isset($_assign)) {
            if ($compiler->context->smarty->caching) {
                $this->preCompiled .= str_repeat(' ', $this->indentation * 4);

                $this->raw(str_repeat(' ', $this->indentation * 4))
                     ->raw("\$tmp_p = var_export({$_params}, true);")
                     ->raw("\n");
                $this->raw(str_repeat(' ', $this->indentation * 4))
                     ->raw("echo \"/*%%SmartyNocache%%*/\\\$this->assign({$_assign} , {$_function}(\$tmp_p, \\\$this->smarty), true);/*/%%SmartyNocache%%*/\";")
                     ->raw("\n");
            } else {
                $this->code("\$this->assign({$_assign} , {$_function} ({$_params},\$this->smarty), true);")
                     ->newline();
            }
        } else {
            $compiler->has_output = true;
            if ($compiler->context->smarty->caching) {
                $this->raw(str_repeat(' ', $this->indentation * 4))
                     ->raw("\$tmp_p = var_export({$_params}, true);")
                     ->raw("\n");
                $this->raw(str_repeat(' ', $this->indentation * 4))
                     ->raw("echo \"/*%%SmartyNocache%%*/echo {$_function}(\$tmp_p, \\\$this->smarty);/*/%%SmartyNocache%%*/\";")
                     ->raw("\n");
            } else {
                $this->code("echo {$_function}({$_params},\$this->smarty);")
                     ->newline();
            }
        }

        return $this->returnTagCode($compiler);
    }
}
