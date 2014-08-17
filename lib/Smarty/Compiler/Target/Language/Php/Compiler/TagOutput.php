<?php

/**
 * Smarty Internal Plugin Compile Print Expression
 * Compiles any tag which will output an expression or variable
 *
 * @package Compiler
 * @author  Uwe Tews
 */
namespace Smarty\Compiler\Target\Language\Php\Compiler;

use Smarty\Node;
use Smarty\Compiler\Code;
use Smarty\Exception\Magic;

/**
 * Smarty Internal Plugin Compile Print Expression Class
 *
 * @package Compiler
 */
class TagOutput extends Magic
{

    /**
     * Compile print tag
     *
     * @param \Smarty_Compiler_Node   $target target node for compiled code
     * @param \Smarty_Source_Node_Tag $node   if tag node
     * @param bool                    $delete
     */
    public static function compile(Node $node, Code $codeTargetObj, $delete = true)
    {
        $codeTargetObj->lineNo($node->sourceLineNo);
        if (isset($node->parser->compiler->output_var)) {
            $codeTargetObj->code("\${$node->parser->compiler->output_var} .= ");
        } else {
            $codeTargetObj->code('echo ');
        }
        $codeTargetObj->compileNode($node->getSubTree('value'), $delete)
                      ->raw(";\n");
    }

    /**
     * Compiles code for generting output from any expression
     *
     * @param  array  $args      array with attributes from parser
     * @param  object $compiler  compiler object
     * @param  array  $parameter array with compilation parameter
     *
     * @throws \Smarty_Exception
     * @return string           compiled code
     */
    public function compilex($args, $compiler, $parameter)
    {
        // check and get attributes
        $_attr = $this->getAttributes($compiler, $args);
        // nocache option
        if ($_attr['nocache'] === true) {
            $compiler->tag_nocache = true;
        }
        // filter handling
        if ($_attr['nofilter'] === true) {
            $_filter = 'false';
        } else {
            $_filter = 'true';
        }
        $this->iniTagCode($compiler);
        if (isset($_attr['assign'])) {
            // assign output to variable
            $this->code("\$this->assign({$_attr['assign']},{$parameter['value']});")
                 ->newline();
        } else {
            $this->code("echo ");
            // display value
            $output = $parameter['value'];
            // tag modifier
            if (!empty($parameter['modifier_list'])) {
                $output = $compiler->compileTag('Internal_Modifier', array(), array('modifier_list' => $parameter['modifier_list'], 'value' => $output));
            }
            if (!$_attr['nofilter']) {
                // default modifier
                if (!empty($compiler->context->smarty->_defaultModifier)) {
                    if (empty($compiler->default_modifier_list)) {
                        $modifierlist = array();
                        foreach ($compiler->context->smarty->_defaultModifier as $key => $single_default_modifier) {
                            preg_match_all('/(\'[^\'\\\\]*(?:\\\\.[^\'\\\\]*)*\'|"[^"\\\\]*(?:\\\\.[^"\\\\]*)*"|:|[^:]+)/', $single_default_modifier, $mod_array);
                            for ($i = 0, $count = count($mod_array[0]); $i < $count; $i ++) {
                                if ($mod_array[0][$i] != ':') {
                                    $modifierlist[$key][] = $mod_array[0][$i];
                                }
                            }
                        }
                        $compiler->default_modifier_list = $modifierlist;
                    }
                    $output = $compiler->compileTag('Internal_Modifier', array(), array('modifier_list' => $compiler->default_modifier_list, 'value' => $output));
                }
                // autoescape html
                if ($compiler->context->smarty->escapeHtml) {
                    $output = "htmlspecialchars({$output}, ENT_QUOTES, '" . addslashes(Smarty::$_CHARSET) . "')";
                }
                // loop over registerd filters
                if (!empty($compiler->context->smarty->_registered['filter'][Smarty::FILTER_VARIABLE])) {
                    foreach ($compiler->context->smarty->_registered['filter'][Smarty::FILTER_VARIABLE] as $key => $function) {
                        if ($function instanceof Closure) {
                            $output = "\$this->smarty->_registered['filter'][Smarty::FILTER_VARIABLE]['{$key}']({$output},\$this->smarty)";
                        } elseif (!is_array($function)) {
                            $output = "{$function}({$output},\$this->smarty)";
                        } elseif (is_object($function[0])) {
                            $output = "\$this->smarty->_registered['filter'][Smarty::FILTER_VARIABLE]['{$key}'][0]->{$function[1]}({$output},\$this->smarty)";
                        } else {
                            $output = "{$function[0]}::{$function[1]}({$output},\$this->smarty)";
                        }
                    }
                }
                // auto loaded filters
                if (isset($compiler->context->smarty->_autoloadFilters[Smarty::FILTER_VARIABLE])) {
                    foreach ((array) $compiler->context->smarty->_autoloadFilters[Smarty::FILTER_VARIABLE] as $name) {
                        $result = $this->compile_output_filter($compiler, $name, $output);
                        if ($result !== false) {
                            $output = $result;
                        } else {
                            // not found, throw exception
                            throw new \Smarty_Exception("Unable to load filter '{$name}'");
                        }
                    }
                }
                if (isset($compiler->context->smarty->_variableFilters)) {
                    foreach ($compiler->context->smarty->_variableFilters as $filter) {
                        if (count($filter) == 1 && ($result = $this->compile_output_filter($compiler, $filter[0], $output)) !== false) {
                            $output = $result;
                        } else {
                            $output = $compiler->compileTag('Internal_Modifier', array(), array('modifier_list' => array($filter), 'value' => $output));
                        }
                    }
                }
            }

            $compiler->has_output = true;
            $this->raw(" {$output};")
                 ->newline();
        }

        return $this->returnTagCode($compiler);
    }

    /**
     * @param  object $compiler compiler object
     * @param  string $name     name of variable filter
     * @param  string $output   embedded output
     *
     * @return string
     */
    private function compile_output_filter($compiler, $name, $output)
    {
        $plugin_name = "smarty_variablefilter_{$name}";
        $path = $compiler->context->smarty->_loadPlugin($plugin_name, false);
        if ($path) {
            if ($compiler->context->caching) {
                $compiler->required_plugins['nocache'][$name][Smarty::FILTER_VARIABLE]['file'] = $path;
                $compiler->required_plugins['nocache'][$name][Smarty::FILTER_VARIABLE]['function'] = $plugin_name;
            } else {
                $compiler->required_plugins['compiled'][$name][Smarty::FILTER_VARIABLE]['file'] = $path;
                $compiler->required_plugins['compiled'][$name][Smarty::FILTER_VARIABLE]['function'] = $plugin_name;
            }
        } else {
            // not found
            return false;
        }

        return "{$plugin_name}({$output},\$this->smarty)";
    }
}
