<?php
namespace Smarty\Compiler\Target\Language\Php\Compiler;

use Smarty\Node;
use Smarty\Compiler\Code;
use Smarty\Exception\Magic;

/**
 * Class TagFor
 *
 * @package Smarty\Compiler\Target\Language\Php\Compiler
 */
class TagFor extends Magic
{

    static $index = 0;
    /**
     * Compiles code for the {for} tag
     * Smarty 3 does implement two different syntax's:
     * - {for $var in $array}
     * For looping over arrays or iterators
     * - {for $x=0; $x<$y; $x++}
     * For general loops
     * The parser is generating different sets of attribute by which this compiler can
     * determine which syntax is used.
     *
     * @param  array  $args      array with attributes from parser
     * @param  object $compiler  compiler object
     * @param  array  $parameter array with compilation parameter
     *
     * @return string compiled code
     */
    public static function compile(Node $node, Code $codeTargetObj, $delete)
    {
        $codeTargetObj->lineNo($node->sourceLineNo);
        $codeTargetObj->code("// {$node->sourceText}");
        $condition = isset($node->tagAttributes['condition']);
        if ($condition) {
            $codeTargetObj->compileNode($node->tagAttributes['start'], $delete);
            $codeTargetObj->code("if (")
                          ->compileNode($node->tagAttributes['condition'], false)
                          ->raw(") {\n")
            ->indent();
            $codeTargetObj->code("for (\$_foo=true; ")
                ->compileNode($node->tagAttributes['condition'], $delete)
                ->raw("; ");
            foreach ($node->tagAttributes['iteration'] as $key => $iteration) {
                if ($key) {
                    $codeTargetObj->raw(", ");
                }
                $codeTargetObj->compileNode($iteration, $delete);
            }
            $codeTargetObj->raw(") {\n")
                ->indent();
            } else {
            $index = self::$index++;
            $tmpvar = "\$__tmp_for_var_{$index}";
             $startnode = $node->tagAttributes['start'];
            $var = self::getCompiledVariable($startnode, $startnode->tagAttributes['variable']->internalNodeTrees['name']);
            $codeTargetObj->lineNo($startnode->sourceLineNo)
                          ->code("\$_scope->_tpl_vars->{$var} = {$tmpvar} = new Entry;\n");
            if (isset($node->tagAttributes['step'])) {
                $codeTargetObj->code("{$tmpvar}->step = ")
                    ->compileNode($node->tagAttributes['step'], $delete)
                ->raw(";\n");
            } else {
                $codeTargetObj->code("{$tmpvar}->step = 1;\n");
            }
            $codeTargetObj->code("{$tmpvar}->value = ")
                          ->compileNode($node->tagAttributes['start']->tagAttributes['value'], $delete)
                          ->raw(";\n");
            $codeTargetObj->code("{$tmpvar}->to = ")
                          ->compileNode($node->tagAttributes['to'], $delete)
                          ->raw(";\n");
            if (isset($node->tagAttributes['max'])) {
                $codeTargetObj->code("{$tmpvar}->total = (int) min(ceil(({$tmpvar}->step > 0 ? {$tmpvar}->to + 1 - {$tmpvar}->value : {$tmpvar}->value - {$tmpvar}->to +1)/abs({$tmpvar}->step)), ")
                    ->compileNode($node->tagAttributes['max'], $delete)
                ->raw(");\n");
            } else {
                $codeTargetObj->code("{$tmpvar}->total = (int) ceil(({$tmpvar}->step > 0 ? {$tmpvar}->to + 1 - {$tmpvar}->value : {$tmpvar}->value -  {$tmpvar}->to +1)/abs( {$tmpvar}->step));\n");
             }
            $codeTargetObj->code("if ({$tmpvar}->total > 0) {\n", 1);
            $codeTargetObj->code("for ({$tmpvar}->iteration = 1;{$tmpvar}->iteration <= {$tmpvar}->total; {$tmpvar}->value += {$tmpvar}->step, {$tmpvar}->iteration++) {\n", 1);
            $codeTargetObj->code("{$tmpvar}->first = {$tmpvar}->iteration == 1;\n");
            $codeTargetObj->code("{$tmpvar}->last = {$tmpvar}->iteration == {$tmpvar}->total;\n");
        }
        if (false !== $body = $node->getSubTree('for')) {
            $node->parser->compiler->compileNode($body, $codeTargetObj, $delete);
        }
        $codeTargetObj->outdent()
                      ->code("}\n");
        // compile {forelse} if present
        if (false !== $body = $node->getSubTree('forelse')) {
            $codeTargetObj->lineNo($node->sourceLineNo)
                ->outdent()
                          ->code("} else {\n", 1);
            $node->parser->compiler->compileNode($body, $codeTargetObj, $delete);
            $codeTargetObj->code("}\n", -1);

        } else {
            $codeTargetObj->code("}\n", -1);

        }
    }

    /**
     * Compile code for 'key' or 'item' variable
     *
     * @param Node $node
     * @param Node $item
     *
     * @return string
     */
    public static function getCompiledVariable(Node $node, $item)
    {
        $comp = new Code($node);
        $comp->compileNodeItems($item, false);
        return $comp->getFormatted();
    }

    /**
        public static function compilexx(Node $node, Code $codeTargetObj, $delete)
    {
        if ($parameter == 0) {
            $this->required_attributes = array('start', 'to');
            $this->optional_attributes = array('max', 'step');
        } else {
            $this->required_attributes = array('start', 'ifexp', 'var', 'step');
            $this->optional_attributes = array();
        }
        // check and get attributes
        $_attr = $this->getAttributes($compiler, $args);

        $this->iniTagCode($compiler);

        $vars = array();
        if ($parameter == 1) {
            $var2 = trim($_attr['var'], '\'"');
            foreach ($_attr['start'] as $_statement) {
                $var = trim($_statement['var'], '\'"');
                $vars[] = $var;
                $this->code("\$_scope->_tpl_vars->{$var} = new Entry ({$_statement['value']});")
                    ->newline();
            }
            $this->code("if ({$_attr['ifexp']}) {")
                ->newline()
                ->indent();
            $this->code("for (\$_foo=true;{$_attr['ifexp']}; \$_scope->_tpl_vars->{$var2}->value{$_attr['step']}) {")
                ->newline()
                ->indent();
        } else {
            $_statement = $_attr['start'];
            $var = trim($_statement['var'], '\'"');
            $vars[] = $var;
            $this->code("\$_scope->_tpl_vars->{$var} = new Entry (array());")
                ->newline();
            if (isset($_attr['step'])) {
                $this->code("\$_scope->_tpl_vars->{$var}->step = {$_attr['step']};")
                    ->newline();
            } else {
                $this->code("\$_scope->_tpl_vars->{$var}->step = 1;")
                    ->newline();
            }
            if (isset($_attr['max'])) {
                $this->code("\$_scope->_tpl_vars->{$var}->total = (int) min(ceil((\$_scope->_tpl_vars->{$var}->step > 0 ? {$_attr['to']}+1 - ({$_statement['value']}) : {$_statement['value']}-({$_attr['to']})+1)/abs(\$_scope->_tpl_vars->{$var}->step)),{$_attr['max']});")
                    ->newline();
            } else {
                $this->code("\$_scope->_tpl_vars->{$var}->total = (int) ceil((\$_scope->_tpl_vars->{$var}->step > 0 ? {$_attr['to']}+1 - ({$_statement['value']}) : {$_statement['value']}-({$_attr['to']})+1)/abs(\$_scope->_tpl_vars->{$var}->step));")
                    ->newline();
            }
            $this->code("if (\$_scope->_tpl_vars->{$var}->total > 0) {")
                ->newline()
                ->indent();
            $this->code("for (\$_scope->_tpl_vars->{$var}->value = {$_statement['value']}, \$_scope->_tpl_vars->{$var}->iteration = 1;\$_scope->_tpl_vars->{$var}->iteration <= \$_scope->_tpl_vars->{$var}->total;\$_scope->_tpl_vars->{$var}->value += \$_scope->_tpl_vars->{$var}->step, \$_scope->_tpl_vars->{$var}->iteration++) {")
                ->newline()
                ->indent();
            $this->code("\$_scope->_tpl_vars->{$var}->first = \$_scope->_tpl_vars->{$var}->iteration == 1;")
                ->newline();
            $this->code("\$_scope->_tpl_vars->{$var}->last = \$_scope->_tpl_vars->{$var}->iteration == \$_scope->_tpl_vars->{$var}->total;")
                ->newline();
        }
        $this->openTag($compiler, 'for', array('for', $compiler->nocache, $vars));
        // maybe nocache because of nocache variables
        $compiler->nocache = $compiler->nocache | $compiler->tag_nocache;

        return $this->returnTagCode($compiler);
    }
}

/**
 * Smarty Internal Plugin Compile Forelse Class
 *
 * @package Compiler

class Smarty_Compiler_Php_NodeCompiler_Tag_Forelse extends Smarty_Compiler_Php_NodeCompiler_Tag
{

    /**
     * Compiles code for the {forelse} tag
     *
     * @param  array  $args      array with attributes from parser
     * @param  object $compiler  compiler object
     * @param  array  $parameter array with compilation parameter
     *
     * @return string compiled code

    public function compile($args, $compiler, $parameter)
    {
        // check and get attributes
        $_attr = $this->getAttributes($compiler, $args);

        list($openTag, $nocache, $vars) = $this->closeTag($compiler, array('for'));
        $this->openTag($compiler, 'forelse', array('forelse', $nocache, $vars));

        $this->iniTagCode($compiler);

        $this->outdent()
            ->code("}")
            ->newline();
        $this->outdent()
            ->code("} else {")
            ->newline()
            ->indent();

        return $this->returnTagCode($compiler);
    }
}

/**
 * Smarty Internal Plugin Compile Forclose Class
 *
 * @package Compiler

class Smarty_Compiler_Php_NodeCompiler_Tag_Forclose extends Smarty_Compiler_Php_NodeCompiler_Tag
{

    /**
     * Compiles code for the {/for} tag
     *
     * @param  array  $args      array with attributes from parser
     * @param  object $compiler  compiler object
     * @param  array  $parameter array with compilation parameter
     *
     * @return string compiled code

    public function compile($args, $compiler, $parameter)
    {
        // check and get attributes
        $_attr = $this->getAttributes($compiler, $args);
        // must endblock be nocache?
        if ($compiler->nocache) {
            $compiler->tag_nocache = true;
        }

        list($openTag, $compiler->nocache, $vars) = $this->closeTag($compiler, array('for', 'forelse'));

        $this->iniTagCode($compiler);

        $this->outdent()
            ->code("}")
            ->newline();
        if ($openTag != 'forelse') {
            $this->outdent()
                ->code("}")
                ->newline();
        }
        // TODO delete local vars?
        if (false) {
            $this->code("unset(");
            foreach ($vars as $key => $var) {
                if ($key != 0) {
                    $this->raw(', ');
                }
                $this->raw("\$_scope->_tpl_vars->{$var}");
            }
            $this->raw(');')
                ->newline();
        }
        return $this->returnTagCode($compiler);
    }
     *                */
}
