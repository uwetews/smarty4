<?php

/**
 * Smarty Magic Error Exception
 *
 * @package Smarty\Exception
 * @author  Uwe Tews
 */
namespace Smarty\Exception;

use Smarty\Exception;

/**
 * Smarty Internal Magic Error
 * Throws error on on defined properties or methods
 *
 * @package Smarty\Exception
 */
class Magic
{

    /**
     * <<magic>> Generic getter.
     *
     * @throws Smarty_Exception
     */
    public function __get($property_name)
    {
        throw new Exception("Read access to undefined property '{$property_name}");
    }

    /**
     * <<magic>> Generic Setter.
     *
     * @throws Smarty_Exception
     */
    public function __set($property_name, $value)
    {
        throw new Exception("Write access to undefined property '{$property_name}'");
    }

    /**
     * <<magic>> Generic Methods.
     *
     * @throws Smarty_Exception
     */
    public function __call($name, $args)
    {
        throw new Exception("Call of undefined method '{$name}'");
    }

    /**
     * <<magic>> Generic Methods.
     *
     * @throws Smarty_Exception
     */

    public function __destruct()
    {
//        echo "\n<br>" . get_class($this) . " destructed <br>\n";
    }
}
