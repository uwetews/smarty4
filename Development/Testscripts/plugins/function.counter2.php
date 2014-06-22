<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage PluginsFunction
 */

/**
 * Smarty {counter} function plugin
 *
 * Type:     function<br>
 * Name:     counter<br>
 * Purpose:  print out a counter value
 *
 * @author Monte Ohrt <monte at ohrt dot com>
 * @link http://www.smarty.net/manual/en/language.function.counter.php {counter}
 *       (Smarty online manual)
 * @param array                    $params   parameters
 * @param Smarty_Internal_Template $template template object
 * @return string|null
 */
function smarty_function_counter2(Smarty_Internal_Template $template, $start = null, $name = null, $assign = null, $print = true, $skip = null, $direction = null)
{
    static $counters = array();

    if (!isset($name)) {
        $name = 'default';
    }
    if (!isset($counters[$name])) {
        $counters[$name] = array(
            'start' => 1,
            'skip' => 1,
            'direction' => 'up',
            'count' => 1
        );
    }
    $counter =& $counters[$name];

    if (isset($start)) {
        $counter['start'] = $counter['count'] = (int) $start;
    }

    if (isset($assign)) {
        $counter['assign'] = $assign;
    }

    if (isset($counter['assign'])) {
        $template->assign($counter['assign'], $counter['count']);
    }

    if (!isset($print)) {
        $print = empty($counter['assign']);
    }

    if ($print) {
        $retval = $counter['count'];
    } else {
        $retval = null;
    }

    if (isset($skip)) {
        $counter['skip'] = $skip;
    }

    if (isset($direction)) {
        $counter['direction'] = $direction;
    }

    if ($counter['direction'] == "down")
        $counter['count'] -= $counter['skip'];
    else
        $counter['count'] += $counter['skip'];

    return $retval;

}
