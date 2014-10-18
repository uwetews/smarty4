<?php

Namespace Smarty\Parser\Peg\Generator\Compiler\Nodes;

use Smarty\Compiler\Format;
use Smarty\Exception\Magic;

/**
 * Class Text
 *
 * @package Smarty\Parser\Peg\Generator\Compiler\Nodes
 */
class Action extends Magic
{
    /**
     * Action name
     *
     * @var string
     */
    public $name = '';

    /**
     * Option argument
     *
     * @var string
     */
    public $argument = '';

    /**
     * Node name
     *
     * @var string
     */
    public $nodeName = '';

    /**
     * PHP code string
     *
     * @var string
     */
    public $code = '';

    /**
     * PHP method string
     *
     * @var string
     */
    public $method = '';

    /**
     * @var Node
     */
    public $node = null;

    /**
     * @param Node $node
     */
    public function setNode(Node $node)
    {
        $this->node = $node;
    }

    /**
     * Set action name
     *
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Set action argument
     *
     * @param string $argument
     */
    public function setArgument($argument)
    {
        $this->argument = $argument;
    }

    /**
     * Set node name
     *
     * @param string $nodeName
     */
    public function setNodeName($nodeName)
    {
        $this->nodeName = $nodeName;
    }

    /**
     * Set action PHP code
     *
     * @param string $code
     */
    public function setCode($code)
    {
        $this->code = $code;
    }

    /**
     * @param Node $node
     */
    public function addActionToNode(Node $node)
    {
        $this->setNode($node);
        $this->setNodeName($node->name);
        switch ($this->name) {
            case '_start':
                $node->actions['_start'] = $this;
                break;
            case '_finish':
                $node->actions['_finish'] = $this;
                break;
            case '_init':
                $node->actions['_init'][$this->argument] = $this;
                break;
            case '_all':
                $node->actions['_all'] = $this;
                break;
            case '_expression';
                $node->actions['_expression'][$this->argument] = $this;
                break;
            default:
                $node->actions['match'][$this->name] = $this;
                break;
        }
    }

    /**
     * Set method PHP code
     *
     * @param string $code
     */
    public function setMethod($code)
    {
        $this->method = $code;
    }

    public function getMethod()
    {
        if (empty($this->method)) {
            switch ($this->name) {
                case '_start':
                    $this->setMethod("{$this->nodeName}_START");
                    break;
                case '_finish':
                    $this->setMethod("{$this->nodeName}_FINISH");
                    break;
                case '_all':
                    $this->setMethod("{$this->nodeName}_ALL");
                    break;
                case '_init':
                    $this->setMethod("{$this->nodeName}_INIT_{$this->argument}");
                    break;
                case '_expression';
                    $this->setMethod("{$this->nodeName}_EXP_{$this->argument}");
                    break;
                default:
                    $this->setMethod("{$this->nodeName}_MATCH_{$this->name}");
                    break;
            }
        }
        return $this->method;
    }

    /**
     * Compile action
     *
     * @param Format $target
     */
    public function compile(Format $target)
    {
        $target->code("public function {$this->getMethod()} ");
        switch ($this->name) {
            case '_start':
                $target->raw("(&\$nodeRes, \$previous)\n");
                break;
            case '_finish':
                $target->raw("(&\$nodeRes)\n");
                break;
            case '_init':
                $target->raw("(&\$rule)\n");
                break;
            case '_all':
                $target->raw("(&\$nodeRes, \$matchRes)\n");
                break;
            case '_expression';
                $target->raw("(&\$nodeRes)\n");
                break;
            default:
                $target->raw("(&\$nodeRes, \$matchRes)\n");
                break;
        }
        $target->formatPHP($this->code)
               ->newline();
        $target->formatCode();
    }
}

