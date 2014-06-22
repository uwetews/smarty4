<?php

/**
 * Smarty plugin
 *
 * @package Plugins\Function
 */

/**
 * Smarty {exception} plugin
 * Type:     function<br>
 * Name:     exception<br>
 * Purpose:  throw a SnartyRunTimeException
 *
 * @link   http://www.smarty.net/docs/en/language.function.exception.tpl {exception}
 *         (Smarty online manual)
 * @author Uwe Tews
 *
 * @param Smarty $tpl_obj template object
 * @param string $message exception messsage
 *
 * @throws Smarty_Exception_Runtime
 */
function smarty_function_exception(Smarty $tpl_obj, $message = 'User Exception')
{
    throw new Smarty_Exception_Runtime($message, $tpl_obj);
}
