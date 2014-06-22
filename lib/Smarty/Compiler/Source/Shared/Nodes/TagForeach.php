<?php

namespace Smarty\Compiler\Source\Shared\Nodes;

use Smarty\Node;

/**
 * Class Foreach_
 *
 * @package Smarty\Source\Smarty\Nodes\foreachTag
 */
class TagForeach extends Node
{
    /**
     * Node name
     *
     * @var string
     */
    public $name = 'TagForeach';
    /**
     * Tag name
     *
     * @var string
     */
    public $tag = null;

    public $attributes = null;
    public $from = null;
    public $key = null;
    public $item = null;
    public $body = null;
    public $else = null;

    public $result = null;

    /**
     * Constructor
     *
     * @param Smarty_Compiler_Parser $parser parser object
     * @param string                 $type   dummy parameter
     *
     * @internal param \Node|null $parentNode optional parent node
     */
    public function __construct($parser)
    {
        parent::__construct($parser);

        // for {foreach} we are done
        if ($this->tag == 'foreach') {
            return false;
        }
    }

    function setResult($result)
    {
        $this->attributes = $result->_attr['attributes'];
        if (isset($result->key)) {
            $this->from = $result->from->node;
        }
        if (isset($result->key)) {
            $this->key = $result->key->node;
        }
        if (isset($result->item)) {
            $this->item = $result->item->node;
        }
        if (isset($result->else)) {
            $this->else = $result->else->node;
        }
        if (isset($result->body)) {
            $this->body = $result->body->node;
        }
    }
}