<?php

/**
 * Smarty Internal Plugin
 *
 * @package Smarty\Exception
 */
namespace Smarty\Exception;

use Smarty\Exception;

/**
 * Smarty compiler exception class
 *
 * @package Smarty\Exception
 */
class Compiler extends Exception
{

    public $no_escape = true;

    /**
     * @return string
     */
    public function __toString()
    {
        // TODO
        // NOTE: PHP does escape \n and HTML tags on return. For this reasion we echo the message.
        // This needs to be investigated later.
        echo "Compiler: {$this->message}";

        return '';
    }
}
