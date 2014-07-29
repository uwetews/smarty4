<?php
namespace Smarty;

use Smarty\Exception\Magic;

/**
 * Class PegParser
 *
 * @package Smarty
 */
class PegParser// extends Magic
{
    /**
     * Parser object
     *
     * @var Parser
     */
    public $parser = null;

    /**
     * Flag if a valid compiled Peg Parser class
     *
     * @var bool
     */
    public $valid = false;

    /**
     * Array of match method names for rules of this Peg Parser
     *
     * @var null|array
     */
    public $matchMethods = null;

    /**
     * Array of node attributes
     *
     * @var array
     */
    public $nodeAttributes = array();

    /**
     * Constructor
     *
     * @param Parser $parser parser object
     */
    public function __construct (Parser $parser) {
        $this->parser = $parser;
    }

}
