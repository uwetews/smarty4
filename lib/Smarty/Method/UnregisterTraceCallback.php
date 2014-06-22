<?php

/**
 * Smarty Extension
 * Smarty class methods
 *
 * @package Smarty\Extension
 * @author  Uwe Tews
 */

/**
 * Class for unregisterTraceCallback method
 *
 * @package Smarty\Extension
 */
class Smarty_Method_UnregisterTraceCallback
{
    /*
    EVENTS:
    filesystem:write
    filesystem:delete
    */

    /**
     * @api
     *
     * @param Smarty        $smarty smarty object
     * @param  string|array $event
     *
     * @return Smarty
     */
    public function unregisterTraceCallback(Smarty $smarty, $event = null)
    {
        if ($event == null) {
            Smarty::$_trace_callbacks = array();
            return $smarty;
        } else {
            foreach ($event as $_event) {
                if (isset(Smarty::$_trace_callbacks[$_event])) {
                    unset(Smarty::$_trace_callbacks);
                }
            }
        }
        return $smarty;
    }
}
