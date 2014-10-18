<?php
namespace Smarty\Parser\Source\Language\Smarty\Node\Value;

use Smarty\Node;
class ArrayValue extends Node
{
    /**
     * Node name
     *
     * @var string
     */
    public $name = 'ArrayValue';
    /**
     * Rule name
     *
     * @var string
     */
    public $ruleName = 'ArrayValue';
    /**
     * Parser node name (defaults to node name)
     *
     * @var string
     */
    public $parserNode = 'Expression';

    /**
     * Compiler class name (defaults to node name)
     *
     * @var string
     */
    public $compilerClass = 'ArrayValue';

    /**
     * Array of key/value nodes
     *
     * @var array
     */
    public $keyValueNodes = array();

    /**
     * add array item of key/value nodes
     *
     * @param array $keyValueNodes array of key value node
     */
    public function setKeyValueNodes($keyValueNodes)
    {
        $this->keyValueNodes = $keyValueNodes;
    }


}