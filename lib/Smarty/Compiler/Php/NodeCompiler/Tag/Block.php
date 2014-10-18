<?php

/**
 * Smarty Internal Plugin Compile Block
 * Compiles the {block}{/block} tags
 *
 * @package Compiler
 * @author  Uwe Tews
 */

/**
 * Smarty Internal Plugin Compile Block Class
 *
 * @package Compiler
 */
class Smarty_Compiler_Php_NodeCompiler_Tag_Block extends SmartSmarty_Compiler_Php_ompiler_Tag
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
    public $option_flags = array('nocache', 'hide', 'append', 'prepend', 'overwrite', 'once');

    /**
     * Compiles code for the {block} tag
     *
     * @param  array  $args     array with attributes from parser
     * @param  object $compiler compiler object
     *
     * @return boolean true
     */
    public function compile($args, $compiler)
    {
        // check and get attributes
        $_attr = $this->getAttributes($compiler, $args);

        $name = trim($_attr['name'], "'\"");

        $this->openTag($compiler, 'block', array($_attr, $compiler->template_code, $compiler->nocache, $name, $compiler->has_nocache_code, $compiler->lex->taglineno));
        if ($_attr['nocache'] == true && $compiler->context->caching) {
            $compiler->nocache = true;
        }
        $compiler->template_code = new Smarty_Compiler_Code(3);
        // maybe nocache because of nocache variables
        $compiler->nocache = $compiler->nocache | $compiler->tag_nocache;

        //nesting level
        $compiler->block_nesting_level ++;
        if ($compiler->block_nesting_level == 1) {
            $int_name = $name;
        } else {
            $compiler->block_name_index ++;
            $int_name = $name . '_' . $compiler->block_name_index;
        }
        array_unshift($compiler->block_nesting_info, array('name' => $name, 'int_name' => $int_name, 'function' => '_renderInteritanceBlock_' . $int_name . '_' . str_replace(array('.', ','), '_', uniqid('', true))));

        $compiler->has_nocache_code = false;
        $compiler->has_code = false;

        return true;
    }
}

/**
 * Smarty Internal Plugin Compile BlockClose Class
 *
 * @package Compiler
 */
class Smarty_ComSmarty_Compiler_Php_er_Tag_Blockclose extends Smarty_CompilerSmarty_Compiler_Php_g
{

    /**
     * Compiles code for the {/block} tag
     *
     * @param  array  $args     array with attributes from parser
     * @param  object $compiler compiler object
     *
     * @return string compiled code
     */
    public function compile($args, $compiler)
    {
        $compiler->has_code = true;
        // check and get attributes
        $_attr = $this->getAttributes($compiler, $args);
        // set inheritance flags
        $compiler->isInheritance = true;

        $saved_data = $this->closeTag($compiler, array('block'));
        $name = trim($saved_data[0]['name'], "'\"");
        // must endblock be nocache?
        if ($compiler->nocache) {
            $compiler->tag_nocache = $compiler->nocache && $compiler->context->caching;
        }
        $compiler->nocache = $saved_data[2];

        // get resource info for traceback code
        if ($compiler->context->type == 'eval' || $compiler->context->type == 'string') {
            $resource = $compiler->context->type;
        } else {
            $resource = $compiler->context->smarty->templateResource;
            // sanitize extends resource
            if (strpos($resource, 'extends:') !== false) {
                $start = strpos($resource, ':');
                $end = strpos($resource, '|');
                $resource = substr($resource, $start + 1, $end - $start - 1);
            }
        }

        if ($saved_data[0]['hide']) {
            $compiler->block_nesting_info[0]['hide'] = true;
        }
        if ($saved_data[0]['prepend']) {
            $compiler->block_nesting_info[0]['prepend'] = true;
        }
        if ($saved_data[0]['append']) {
            $compiler->block_nesting_info[0]['append'] = true;
        }
        if ($saved_data[0]['overwrite']) {
            $compiler->block_nesting_info[0]['overwrite'] = true;
        }

        $block_code = new Smarty_Compiler_Code(2);
        $block_code->code("public function " . $compiler->block_nesting_info[0]['function'] . " (\$this->smarty, \$_scope) {")
                   ->newline()
                   ->indent();
        $block_code->code("ob_start();")
                   ->newline();
        $block_code->code("/* Line {$saved_data[5]} */")
                   ->newline();
        $block_code->preCompiled .= $compiler->template_code->preCompiled;
        $block_code->code("return ob_get_clean();")
                   ->newline();

        $block_code->outdent()
                   ->code('}')
                   ->newline(3);

        $compiler->inheritance_blocks_code[] .= $block_code->preCompiled;

        $compiler->template_code = $saved_data[1];
        $this->iniTagCode($compiler);

        $int_name = $compiler->block_nesting_info[0]['int_name'];
        unset($compiler->block_nesting_info[0]['int_name']);

        if ($compiler->isInheritanceChild && $compiler->block_nesting_level == 1) {
            if ($compiler->tag_nocache) {
                $code = new Smarty_Compiler_Code();
                $code->iniTagCode($this);
                $code->code("\$this->inheritance_blocks['$int_name']['valid'] = true;")
                     ->newline();
                $compiler->postfix_code[] = $code;
            } else {
                $this->code("\$this->inheritance_blocks['$int_name']['valid'] = true;")
                     ->newline();
            }
        } else {
            if ($compiler->tag_nocache) {
                $code = new Smarty_Compiler_Code();
                $code->iniTagCode($this);
                $code->code("echo \$this->_getInheritanceBlock ('{$int_name}', \$this->smarty, \$_scope, 1);")
                     ->newline();
                $compiler->postfix_code[] = $code;
            } else {
                //                $this->code("\$this->inheritance_blocks['$int_name']['valid'] = true;")->newline();
                $this->code("echo \$this->_getInheritanceBlock ('{$int_name}', \$this->smarty, \$_scope, 0);")
                     ->newline();
            }
        }
        if ($compiler->block_nesting_level > 1) {
            $compiler->block_nesting_info[1]['subblocks'][] = $int_name;
        }
        $compiler->inheritance_blocks[$int_name] = $compiler->block_nesting_info[0];
        array_shift($compiler->block_nesting_info);
        $compiler->block_nesting_level --;

        $compiler->has_nocache_code = $compiler->has_nocache_code | $saved_data[4];

        $compiler->has_code = true;

        return $this->returnTagCode($compiler);
    }
}

/**
 * Smarty Internal Plugin Compile Block Parent Class
 *
 * @package Compiler
 */
class Smarty_Compiler_CodeSmarty_Compiler_Php_l_Block_Parent extends Smarty_Compiler_Code_Php_Smarty_Compiler_Php_**
     * Compiles code for the {
    $smart . block . parent} tag
*
     * @param  array  $args     array with attributes from parser
* @param  object $compiler compiler object
*
     * @return string compiled code
*/
    public /**
 * @param $args
 * @param $compiler
 *
 * @return mixed
 */function compile($args, $compiler)
{
    $compiler->has_code = true;
    // check and get attributes
    $_attr = $this->getAttributes($compiler, $args);

    $compiler->block_nesting_info[0]['calls_parent'] = true;

    $this->iniTagCode($compiler);

    $this->raw("\$this->_getInheritanceParentBlock ('{$compiler->block_nesting_info[0]['int_name']}', \$this->smarty, \$_scope)");

    return $this->returnTagCode($compiler);
}
}

/**
 * Smarty Internal Plugin Compile Block Parent Class
 *
 * @package Compiler
 */
class Smarty_Compiler_Code_Php_NodeCSmarty_Compiler_Php_ild extends Smarty_Compiler_Code_Php_NodeCompiler_Tag
{

    /**
     * Compiles code for the {$smart.block.child} tag
     *
     * @param  array  $args     array with attributes from parser
     * @param  object $compiler compiler object
     *
     * @return string compiled code
     */
    public function compile($args, $compiler)
    {
        $compiler->has_code = true;
        // check and get attributes
        $_attr = $this->getAttributes($compiler, $args);
        $this->iniTagCode($compiler);

        $compiler->block_nesting_info[0]['calls_child'] = true;

        $this->raw("\$this->inheritance_blocks['{$compiler->block_nesting_info[0]['int_name']}']['child_content']");
        // TODO  remove this
        //       $this->raw("\$this->_getInheritanceChildBlock ('{$compiler->block_nesting_info[0]['int_name']}', \$this->smarty, \$_scope, 0, \$current_tpl)");
        return $this->returnTagCode($compiler);
    }
}
