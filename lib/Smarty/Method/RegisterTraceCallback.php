<?php

/**
 * Smarty Extension
 * Smarty class methods
 *
 * @package Smarty\Extension
 * @author  Uwe Tews
 */

/**
 * Class for registerTraceCallback method
 *
 * @package Smarty\Extension
 */
class Smarty_Method_RegisterTraceCallback
{
    /*
    EVENTS:
    filesystem:write
    filesystem:delete
    */

    /**
     * @api
     *
     * @param Smarty        $smarty   smarty object
     * @param  string|array $event
     * @param  callable     $callback class/method name
     *
     * @return Smarty
     * @throws Smarty_Exception
     */
    public function registerTraceCallback(Smarty $smarty, $event, $callback = null)
    {
        if (is_array($event)) {
            foreach ($event as $_event => $_callback) {
                if (!is_callable($_callback)) {
                    throw new Smarty_Exception("registerCallback(): \"{$_event}\" not callable");
                }
                Smarty::$_trace_callbacks[$_event][] = $_callback;
            }
        } else {
            if (!is_callable($callback)) {
                throw new Smarty_Exception("registerCallback(): \"{$event}\" not callable");
            }
            Smarty::$_trace_callbacks[$event][] = $callback;
        }
        return $smarty;
    }
}
