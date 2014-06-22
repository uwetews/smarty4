<?php

namespace Smarty\Nodes\Template;

use Smarty\Compiler\Php\Format;

/**
 * Class Node
 *
 * @package Smarty\Nodes\Template
 */
class Node extends Format
{
    /**
     * Node compiler class name
     *
     * @var string
     */
    public $compiler_class = 'Internal_Template';

    /**
     * Context object
     *
     * @var Context
     */
    public $context = null;

    /**
     * Template Scope object
     *
     * @var \Smarty_Template_Scope
     */
    public $template_scope = null;

    /**
     * Parser object
     *
     * @var object
     */
    public $parser = null;

    /**
     * content class name
     *
     * @var string
     */
    public $content_class = '';

    /**
     * Source code
     *
     * @var string
     */
    public $source = null;

    /**
     * flag for nocache section
     *
     * @var bool
     */
    public $nocache = false;

    /**
     * flag for nocache tag
     *
     * @var bool
     */
    public $tag_nocache = false;

    /**
     * file dependencies
     *
     * @var array
     */
    public $file_dependency = array();

    /**
     * config variables
     *
     * @var string
     */
    public $config_variables = array();

    /**
     * template function nodes
     *
     * @var array
     */
    public $templateFunctionNodes = array();

    /**
     * body node
     *
     * @var object
     */
    public $templateBodyNode = null;

    /**
     * Constructor
     *
     * @param \Smarty\Parser $parser   parser context object
     * @param string         $nodeType node type
     */
    function __construct(\Smarty\Parser $parser)
    {
        parent::__construct($parser);
        $this->template_scope = $parser->compiler->instanceTemplateScope($parser->context);
        $this->addFileDependency($parser->context);
        $this->templateClass = $parser->compiler->getUniqueTemplateClassName();
    }

    /**
     * Add resource info to fileDependency
     *
     * @param Context $context
     *
     * @return $this
     */
    public function addFileDependency(Context $context)
    {
        $this->file_dependency[$context->uid] = array($context->filepath, $context->timestamp, $context->type);
        return $this;
    }

    /**
     * Add template function node
     *
     * @param Node $node
     *
     * @return $this
     */
    public function addTemplateFunction(Node $node)
    {
        $this->templateFunctionNodes[] = $node;
        return $this;
    }

    /**
     *
     */
    public function  cleanup()
    {
        $this->template_scope = null;
        $this->parser = null;
        $this->context = null;
        if (isset($this->templateBodyNode)) {
            $this->templateBodyNode->cleanup();
            $this->templateBodyNode = null;
        }
        if (!empty($this->subtreeNodes)) {
            $this->cleanupNodeArray($this->subtreeNodes);
        }
        if (!empty($this->templateFunctionNodes)) {
            $this->cleanupNodeArray($this->templateFunctionNodes);
        }
    }
}
