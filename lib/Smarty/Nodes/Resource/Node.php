<?php
namespace Smarty\Nodes\Resource;

use Smarty\Compiler\Php\Format;

/**
 * Class Node
 *
 * @package Smarty\Nodes\Resource
 */
class Node extends Format
{
    /**
     * Node compiler class name
     *
     * @var string
     */
    public $compiler_class = 'Internal_Resource';

    /**
     * Context object
     *
     * @var Context
     */
    public $context = null;

    /**
     * Parser object
     *
     * @var object
     */
    public $parser = null;

    /**
     * Compiler object
     *
     * @var object
     */
    public $compiler = null;

    /**
     * content class name
     *
     * @var string
     */
    public $content_class = '';

    /**
     * config variables
     *
     * @var string
     */
    public $config_variables = array();

    /**
     * body node
     *
     * @var object
     */
    public $templateNode = null;

    /**
     * Context objects for inline templates
     *
     * @var array
     */
    public $inlineTemplateContext = array();

    /**
     * Inline template class names by uid
     *
     * @var array
     */
    public $inlineTemplateClass = array();

    /**
     * Constructor
     *
     * @param \Smarty\Parser
     *                         {
     *                         return new  $parser parser context object
     * @param string $nodeType node type
     */
    function __construct(\Smarty\Parser $parser, $nodeType)
    {
        parent::__construct($parser, $nodeType);
    }

    /**
     * @param $context
     */
    public function addInlineTemplate($context)
    {
        $this->inlineTemplateContext[] = $context;
        $this->inlineTemplateClass[$context->uid] = $this->compiler->getUniqueTemplateClassName();
    }

    /**
     * @param $uid
     *
     * @return bool
     */
    public function getInlineTemplateClass($uid)
    {
        return isset($this->inlineTemplateClass[$uid]) ? $this->inlineTemplateClass[$uid] : false;
    }

    /**
     * Call parser
     *
     * @return mixed
     */
    public function parse()
    {
        return $this->parser->parse('Resource');
    }

    /**
     *
     */
    public function  cleanup()
    {
        $this->compiler = null;
        $this->parser = null;
        $this->context = null;
        if (isset($this->templateNode)) {
            $this->templateNode->cleanup();
            $this->templateNode = null;
        }
        if (!empty($this->subtreeNodes)) {
            $this->cleanupNodeArray($this->subtreeNodes);
        }
    }
}