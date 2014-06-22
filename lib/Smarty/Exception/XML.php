<?php

/**
 * Smarty Exception Plugin
 *
 * @package Smarty\Exception
 */

/**
 * Smarty illegal resource exception
 *
 * @package Smarty\Exception
 */
class Smarty_Exception_XML extends Smarty_Exception_Runtime
{
    /**
     * @param string $message
     * @param int    $code
     * @param null   $par
     *
     * @internal param string $file
     * @internal param int|null $type
     */
    public function __construct($message, $code = 0, $par)
    {
        $xml = simplexml_load_file(__DIR__ . '/English/Execption.xml');
        $raw = $xml->$message;
        $message = sprintf($raw, $par);
        parent::__construct($message, 0);
    }
}
