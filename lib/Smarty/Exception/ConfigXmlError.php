<?php
namespace Smarty\Exception;

/**
 * Class ConfigXmlError
 *
 * @package Smarty\Exception
 */
class ConfigXmlError extends Runtime
{
    /**
     *
     * @param string $file file path
     */
    public function __construct($file)
    {
        $message = sprintf("Config: Error syntax error in config file '%s'", $file);
        parent::__construct($message, 0);
    }
}
