<?php
/**
 * Smarty Compiler Template Node Identifier
 *
 * @package Smarty\Compiler
 * @author  Uwe Tews
 */

/**
 * Identifier Token Node
 *
 * @package Smarty\Compiler
 */
namespace Smarty\Nodes\Internal;

use Smarty\Nodes\Node;

/**
 * Class Identifier
 *
 * @package Smarty\Nodes\Internal
 */
class Identifier extends Node
{
    /**
     * Identifier name
     *
     * @var string
     */
    public $name = '';

    /**
     * Constructor
     *
     * @param object $parser parser object
     * @param string $name   tag name
     */
    public function __construct($parser, $name)
    {
        $this->name = $name;
        parent::__construct($parser);
    }
}