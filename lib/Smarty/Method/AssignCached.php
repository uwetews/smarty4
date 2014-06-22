<?php

/**
 * Smarty Extension
 * Smarty class methods
 *
 * @package Smarty\Extension
 * @author  Uwe Tews
 */

/**
 * Class for assignCached method
 *
 * @package Smarty\Extension
 */
class Smarty_Method_AssignCached
{

    /**
     * Save value to persistent cache storage
     *
     * @api
     *
     * @param Smarty        $smarty smarty object
     * @param  string|array $key    key to store data under, or array of key => values to store
     * @param  mixed        $value  value to store for $key, ignored if key is an array
     *
     * @return Smarty       $this for chaining
     */
    public function assignCached(Smarty $smarty, $key, $value = null)
    {
        if (!$smarty->_rootTemplate) {
            $smarty->findRootTemplate();
        }

        if (is_array($key)) {
            foreach ($key as $_key => $_value) {
                if ($_key !== '') {
                    $smarty->_rootTemplate->properties['cachedValues'][$_key] = $_value;
                }
            }
        } else {
            if ($key !== '') {
                $smarty->_rootTemplate->properties['cachedValues'][$key] = $value;
            }
        }

        return $smarty;
    }
}
