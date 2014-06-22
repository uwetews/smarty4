<?php

/**
 * Smarty Internal Plugin Compile Object Block Function
 * Compiles code for registered objects as block function
 *
 * @package Compiler
 * @author  Uwe Tews
 */

/**
 * Smarty Internal Plugin Compile Object Block Function Class
 *
 * @package Compiler
 */
class Smarty_Compiler_Php_ompiler_Internal_ObjectBlockFunction extends \Smarty_Compiler_Code_Php_NodeCompiler_Tag
{

    /**
     * Attribute definition: Overwrites base class.
     *
     * @var array
     * @see $tpl_obj
     */
    public $optional_attributes = array('_any');

    /**
     * Compiles code for the execution of block plugin
     *
     * @param  array  $args      array with attributes from parser
     * @param  object $compiler  compiler object
     * @param  array  $parameter array with compilation parameter
     * @param  string $tag       name of block object
     * @param  string $method    name of method to call
     *
     * @return string compiled code
     */
    public function compile($args, $compiler, $parameter, $tag, $method)
    {
        if (!isset($tag[5]) || substr($tag, - 5) != 'close') {
            // opening tag of block plugin
            // check and get attributes
            $_attr = $this->getAttributes($compiler, $args);
            if ($_attr['nocache'] === true) {
                $compiler->tag_nocache = true;
            }
            unset($_attr['nocache']);
            // convert attributes into parameter array string
            $_paramsArray = array();
            foreach ($_attr as $_key => $_value) {
                if (is_int($_key)) {
                    $_paramsArray[] = "$_key=>$_value";
                } else {
                    $_paramsArray[] = "'$_key'=>$_value";
                }
            }
            $_params = 'array(' . implode(",", $_paramsArray) . ')';

            $this->openTag($compiler, $tag . '->' . $method, array($_params, $compiler->nocache));
            // maybe nocache because of nocache variables or nocache plugin
            $compiler->nocache = $compiler->nocache | $compiler->tag_nocache;
            // compile code
            $this->code("\$this->smarty->_tag_stack[] = array('{$tag}->{$method}', {$_params});")
                ->newline();
            $this->code("\$_block_repeat=true;")
                ->newline();
            $this->code("echo \$this->smarty->_registered['object']['{$tag}'][0]->{$method}({$_params}, null, \$this->smarty, \$_block_repeat);")
                ->newline();
            $this->code("while (\$_block_repeat) {")
                ->newline()
                ->indent();
            $this->code("ob_start();")
                ->newline();
        } else {
            $base_tag = substr($tag, 0, - 5);
            // must endblock be nocache?
            if ($compiler->nocache) {
                $compiler->tag_nocache = true;
            }
            // closing tag of block plugin, restore nocache
            list($_params, $compiler->nocache) = $this->closeTag($compiler, $base_tag . '->' . $method);
            // This tag does create output
            $compiler->has_output = true;
            // compile code
            $this->iniTagCode($compiler);

            $this->code("\$_block_content = ob_get_clean();")
                ->newline();
            $this->code("\$_block_repeat=false;")
                ->newline();
            if (isset($parameter['modifier_list'])) {
                $this->code("ob_start();")
                    ->newline();
            }
            $this->code("echo \$this->smarty->_registered['object']['{$base_tag}'][0]->{$method}({$_params}, \$_block_content, \$this->smarty, \$_block_repeat);")
                ->newline();
            if (isset($parameter['modifier_list'])) {
                $this->code('echo ' . $compiler->compileTag('Internal_Modifier', array(), array('modifier_list' => $parameter['modifier_list'], 'value' => 'ob_get_clean()')) . ';')
                    ->newline();
            }
            $this->outdent()
                ->code("}")
                ->newline();
            $this->code("array_pop(\$this->smarty->_tag_stack);")
                ->newline();
        }

        return $this->returnTagCode($compiler);
    }
}
