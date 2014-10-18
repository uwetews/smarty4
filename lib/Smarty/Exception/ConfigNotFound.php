<?php
namespace Smarty\Exception;

/**
 * Class ConfigNotFound
 *
 * @package Smarty\Exception
 */
class ConfigNotFound extends Runtime
{
    /**
     *
     * @param string $file file path
     */
    public function __construct($file)
    {
        $message = sprintf("Config: Can not find config file '%s'", $file);
        parent::__construct($message, 0);
    }
}
