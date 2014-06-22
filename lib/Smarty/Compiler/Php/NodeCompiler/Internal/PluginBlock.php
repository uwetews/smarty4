<?php

/**
 * Smarty Internal Plugin Compile Block Plugin
 * Compiles code for the execution of block plugin
 *
 * @package Compiler
 * @author  Uwe Tews
 */

/**
 * Smarty Internal Plugin Compile Block Plugin Class
 *
 * @package Compiler
 */
class Smarty_Compiler_Php_ompiler_Internal_PluginBlock extends \Smarty_Compiler_Code_Php_NodeCompiler_Tag
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
     * @param  string $tag       name of block plugin
     * @param  string $function  PHP function name
     *
     * @return string compiled code
     */
    public function compile($args, $compiler, $parameter, $tag, $function)
    {
        if (!isset($tag[5]) || substr($tag, - 5) != 'close') {
            // opening tag of block plugin
            // check and get attributes
            $_attr = $this->getAttributes($compiler, $args);
            if ($_attr['nocache'] === true) {
                $compiler->tag_nocache = true;
            }
            unset($_attr['nocache']);
            $cache_attr = null;
            if ($compiler->context->caching) {
                $result = $this->getAnnotation($function, 'smarty_nocache');
                if ($result) {
                    $compiler->tag_nocache = $compiler->tag_nocache || $result;
                    $compiler->getPlugin(substr($function, 16), Smarty::PLUGIN_FUNCTION);
                }
                if ($compiler->tag_nocache || $compiler->nocache) {
                    $cache_attr = $this->getAnnotation($function, 'smarty_cache_attr');
                }
            }
            // convert attributes into parameter string
            $par_string = $this->getPluginParameterString($function, $_attr, $compiler, true, $cache_attr);

            $this->openTag($compiler, $tag, array($par_string, $compiler->nocache));
            // maybe nocache because of nocache variables or nocache plugin
            $compiler->nocache = $compiler->nocache | $compiler->tag_nocache;
            // compile code
            $this->iniTagCode($compiler);

            if (is_array($par_string)) {
                // old style with params array
                $this->code("\$this->smarty->_tag_stack[] = array('{$tag}', {$par_string['par']});")
                    ->newline();
                $this->code("\$_block_repeat=true;")
                    ->newline();
                $this->code("echo {$function}({$par_string['par']}, null, {$par_string['obj']}, \$_block_repeat);")
                    ->newline();
                $this->code("while (\$_block_repeat) {")
                    ->newline()
                    ->indent();
                $this->code("ob_start();")
                    ->newline();
            } else {
                // new style with real parameter
                $par_string = str_replace('__content__', 'null', $par_string);
                $this->code("\$this->smarty->_tag_stack[] = array('{$tag}', {$par_string});")
                    ->newline();
                $this->code("\$_block_repeat=true;")
                    ->newline();
                $this->code("echo {$function}({$par_string};")
                    ->newline();
                $this->code("while (\$_block_repeat) {")
                    ->newline()
                    ->indent();
                $this->code("ob_start();")
                    ->newline();
            }
        } else {
            // must end block be nocache?
            if ($compiler->nocache) {
                $compiler->tag_nocache = true;
            }
            // closing tag of block plugin, restore nocache
            list($par_string, $compiler->nocache) = $this->closeTag($compiler, substr($tag, 0, - 5));
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
            if (is_array($par_string)) {
                // old style with params array
                $this->code("echo {$function}({$par_string['par']}, \$_block_content, {$par_string['obj']}, \$_block_repeat);")
                    ->newline();
            } else {
                // new style with real parameter
                $par_string = str_replace('__content__', '$_block_content', $par_string);
                $this->code("echo {$function}({$par_string});")
                    ->newline();
            }
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
