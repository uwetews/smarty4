<?php

Namespace Smarty\Tool\Parser\Peg\Nodes;

/**
 * Class Text
 *
 * @package Smarty\Tool\Parser\Peg\Nodes
 */
class Text
{
    /**
     * @var string
     */
    public $type = 'text';
    /**
     * @var string
     */
    public $name = 'Text';

    /**
     * Compile returns just the plain text
     *
     * @return string
     */
    public function compile()
    {
        return $this->_text;
    }
}

