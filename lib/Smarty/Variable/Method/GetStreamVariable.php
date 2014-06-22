<?php

/**
 * Smarty Extension
 * Smarty class methods
 *
 * @package Smarty\Variable
 * @author  Uwe Tews
 */

/**
 * Class for static getStreamVariable method
 *
 * @package Smarty\Variable
 */
class Smarty_Variable_Method_GetStreamVariable
{
    /**
     * gets  a stream variable
     *
     * @api
     *
     * @param Smarty | Smarty_Template_Class | Smarty_Variable_Data $object master object
     * @param                                                       $variable
     *
     * @throws Smarty_Exception
     * @return mixed            the value of the stream variable
     */
    public function getStreamVariable($object, $variable)
    {
        $_result = '';
        $fp = fopen($variable, 'r+');
        if ($fp) {
            while (!feof($fp) && ($current_line = fgets($fp)) !== false) {
                $_result .= $current_line;
            }
            fclose($fp);

            return $_result;
        }

        $smarty = isset($object->smarty) ? $object->smarty : $object;
        if ($smarty->error_unassigned) {
            throw new Smarty_Exception('getStreamVariable(): Undefined stream variable "' . $variable . '"');
        } else {
            return null;
        }
    }
}