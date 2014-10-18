<?php
namespace Smarty\Compiler\Target\Language\Php\Compiler;

use Smarty\Node;
use Smarty\Compiler\Code;
use Smarty\Exception\Magic;

/**
 * Class TagPluginFunction
 *
 * @package Smarty\Compiler\Target\Language\Php\Compiler
 */
class TagPluginFunction extends Magic
{

    /**
     * Compile function plugin tag
     *
     * @param Node $node if tag node
     * @param Code $codeTargetObj
     * @param bool $delete
     */
    public static function compile(Node $node, Code $codeTargetObj, $delete)
    {
        $codeTargetObj->lineNo($node->sourceLineNo);
        $parameter = array();
        if (isset($node->parser->compiler->output_var)) {
            $codeTargetObj->code("\${$node->parser->compiler->output_var} .= ");
        } else {
            $codeTargetObj->code('echo ');
        }
        $function = 'smarty_function_' . $node->pluginName;
        $codeTargetObj->raw("{$function}(array(");
        foreach ($node->tagAttributes as $attribute => $anode) {
            $codeTargetObj->raw("'{$attribute}' => ")
                          ->compileNode($anode, $delete)
                          ->raw(", ");
        }
        $codeTargetObj->raw("), \$this);\n");
    }

    /**
     * Compiles code for the execution of function plugin
     *
     * @param  array  $args      array with attributes from parser
     * @param  object $compiler  compiler object
     * @param  array  $parameter array with compilation parameter
     * @param  string $tag       name of function plugin
     * @param  string $function  PHP function name
     *
     * @return string compiled code
     */
    public function compilecc($args, $compiler, $parameter, $tag, $function)
    {
        // This tag does create output
        $compiler->has_output = true;

        // check and get attributes
        $_attr = $this->getAttributes($compiler, $args);
        if ($_attr['nocache'] === true) {
            $compiler->tag_nocache = true;
        }
        unset($_attr['nocache']);
        $cache_attr = null;
        if ($compiler->context->caching) {
            $nodeRes = $this->getAnnotation($function, 'smarty_nocache');
            if ($nodeRes) {
                $compiler->tag_nocache = $compiler->tag_nocache || $nodeRes;
                $compiler->getPlugin(substr($function, 16), Smarty::PLUGIN_FUNCTION);
            }
            if ($compiler->tag_nocache || $compiler->nocache) {
                $cache_attr = $this->getAnnotation($function, 'smarty_cache_attr');
            }
        }
        // convert attributes into parameter string
        $nodeRes = $this->getPluginParameterString($function, $_attr, $compiler, false, $cache_attr);
        // compile code
        $this->iniTagCode($compiler);

        $this->code("echo {$function}({$nodeRes});")
             ->newline();

        return $this->returnTagCode($compiler);
    }
}
