<?php
/**
 * Smarty Internal Plugin Compile Break
 *
 * Compiles the {break} tag
 *
 * @package Smarty
 * @subpackage Compiler
 * @author Jens-Andr� Koch
 */
/**
 * Smarty Internal Plugin Compile Break Class
 */
class Smarty_Compiler_Break extends
    Smarty_Compiler_Template_Tag
{
    /**
     * Compiles code for the {break} tag
     *
     * @param  array  $args     array with attributes from parser
     * @param  object $compiler compiler object
     * @return string compiled code
     */
    public function compile($args, $compiler)
    {
        $this->compiler = $compiler;
        // check and get attributes
        $_attr = $this->_get_attributes($args);

        $_output = "<?php break; ?>";

        return $_output;
    }
}
