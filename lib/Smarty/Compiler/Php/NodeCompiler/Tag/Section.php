<?php

/**
 * Smarty Internal Plugin Compile Section
 * Compiles the {section} {sectionelse} {/section} tags
 *
 * @package Compiler
 * @author  Uwe Tews
 */

/**
 * Smarty Internal Plugin Compile Section Class
 *
 * @package Compiler
 */
class Smarty_Compiler_Php_NodeCompiler_Tag_Section
{
    /**
     * Compile {section} and {sectionelse} tags
     *
     * @param Smarty_Compiler_Node   $target target node for compiled code
     * @param Smarty_Source_Node_Tag $node   if tag node
     * @param bool                   $delete
     */
    public static function compile(Smarty_Compiler_Node $target, Smarty_Source_Node_Tag $node, $delete)
    {
        switch ($node->tag) {
            case 'section':
                self::compile_section($target, $node, $delete);
                break;
            case 'sectionelse':
                self::compile_sectionelse($target, $node, $delete);
                break;
            default:
                // TODO Expection
        }
        // Body
        $target->compileNodeArray($node->subtreeNodes, $delete)
               ->outdent()
               ->code("}\n");
        if ($node->tag == 'section') {
            $target->outdent()
                   ->code("}\n");
        }
    }

    /**
     * Compiles code for the {section} tag
     *
     * @param Smarty_Compiler_Node   $target target node for compiled code
     * @param Smarty_Source_Node_Tag $node   if tag node
     * @param bool                   $delete
     */
    public static function compile_section($target, $node, $delete)
    {
        $compiling_node = new Smarty_Compiler_Format($node->parser, 'node');
        $name = trim($compiling_node->compileNode($node->attributeNodes['name'])
                                    ->getFormated(), "'\"");
        $SmartyVarName = '$smarty.foreach.' . $name . '.';
        $section_props = "\$_scope->_tpl_vars->smarty_section_{$name}->value";

        $target->lineNo($node->sourceLineNo)
               ->code("\$_scope->_tpl_vars->smarty_section_{$name} = new Entry;\n");

        foreach ($node->attributeNodes as $attr_name => $n) {
            $attr_value = $compiling_node->compileNode($n)
                                         ->getFormated();
            switch ($attr_name) {
                case 'loop':
                    $target->code("{$section_props}['loop'] = is_array(\$_loop=$attr_value) ? count(\$_loop) : max(0, (int) \$_loop);\n")
                           ->code("unset(\$_loop);\n");
                    break;

                case 'show':
                    if (is_bool($attr_value)) {
                        $show_attr_value = $attr_value ? 'true' : 'false';
                    } else {
                        $show_attr_value = "(bool) $attr_value";
                    }
                    $target->code("{$section_props}['show'] = $show_attr_value;\n");
                    break;

                case 'name':
                    $target->code("{$section_props}['$attr_name'] = '$attr_value';\n");
                    break;

                case 'max':
                case 'start':
                    $target->code("{$section_props}['$attr_name'] = (int) $attr_value;\n");
                    break;

                case 'step':
                    $target->code("{$section_props}['$attr_name'] = ((int) $attr_value) == 0 ? 1 : (int) $attr_value;\n");
                    break;
            }
        }

        if (!isset($node->attributeNodes['show'])) {
            $target->code("{$section_props}['show'] = true;\n");
        }

        if (!isset($node->attributeNodes['loop'])) {
            $target->code("{$section_props}['loop'] = 1;\n");
        }

        if (!isset($node->attributeNodes['max'])) {
            $target->code("{$section_props}['max'] = {$section_props}['loop'];\n");
        } else {
            $target->code("if ({$section_props}['max'] < 0) {\n")
                   ->indent()
                   ->code("{$section_props}['max'] = {$section_props}['loop'];\n")
                   ->outdent()
                   ->code("}\n");
        }

        if (!isset($node->attributeNodes['step'])) {
            $target->code("{$section_props}['step'] = 1;\n");
        }

        if (!isset($node->attributeNodes['start'])) {
            $target->code("{$section_props}['start'] = {$section_props}['step'] > 0 ? 0 : {$section_props}['loop']-1;\n");
        } else {
            $target->code("if ({$section_props}['start'] < 0) {\n")
                   ->indent()
                   ->code("{$section_props}['start'] = max({$section_props}['step'] > 0 ? 0 : -1, {$section_props}['loop'] + {$section_props}['start']);\n")
                   ->outdent()
                   ->code("} else {\n")
                   ->indent()
                   ->code("{$section_props}['start'] = min({$section_props}['start'], {$section_props}['step'] > 0 ? {$section_props}['loop'] : {$section_props}['loop']-1);\n")
                   ->outdent()
                   ->code("}\n");
        }

        $target->code("if ({$section_props}['show']) {\n")
               ->indent();
        if (!isset($node->attributeNodes['start']) && !isset($node->attributeNodes['step']) && !isset($node->attributeNodes['max'])) {
            $target->code("{$section_props}['total'] = {$section_props}['loop'];\n");
        } else {
            $target->code("{$section_props}['total'] = min(ceil(({$section_props}['step'] > 0 ? {$section_props}['loop'] - {$section_props}['start'] : {$section_props}['start']+1)/abs({$section_props}['step'])), {$section_props}['max']);\n");
        }
        $target->code("if ({$section_props}['total'] == 0) {\n")
               ->indent()
               ->code("{$section_props}['show'] = false;\n")
               ->outdent()
               ->code("}\n")
               ->outdent()
               ->code("} else {\n")
               ->indent()
               ->code("{$section_props}['total'] = 0;\n")
               ->outdent()
               ->code("}\n")
               ->code("if ({$section_props}['show']) {\n")
               ->indent()
               ->code("for ({$section_props}['index'] = {$section_props}['start'], {$section_props}['iteration'] = 1; {$section_props}['iteration'] <= {$section_props}['total']; {$section_props}['index'] += {$section_props}['step'], {$section_props}['iteration']++) {\n")
               ->indent()
               ->code("{$section_props}['rownum'] = {$section_props}['iteration'];\n")
               ->code("{$section_props}['index_prev'] = {$section_props}['index'] - {$section_props}['step'];\n")
               ->code("{$section_props}['index_next'] = {$section_props}['index'] + {$section_props}['step'];\n")
               ->code("{$section_props}['first'] = ({$section_props}['iteration'] == 1);\n")
               ->code("{$section_props}['last']  = ({$section_props}['iteration'] == {$section_props}['total']);\n");
    }

    /**
     * Compiles code for the {sectionelse} tag
     *
     * @param Smarty_Compiler_Node   $target target node for compiled code
     * @param Smarty_Source_Node_Tag $node   if tag node
     * @param bool                   $delete
     */
    public static function compile_sectionelse($target, $node, $delete)
    {
        $target->code("else {\n")
               ->indent();
    }
}
