<?php

Namespace Smarty\Tool\Parser\Peg\Nodes;

/**
 * Class Node
 *
 * @package Smarty\Tool\Parser\Peg\Nodes
 */
class Text
{
    public $type = 'text';
    public $name = 'Text';

    /**
     * @return mixed
     */
    public function compile()
    {
        return $this->_text;
    }
}

