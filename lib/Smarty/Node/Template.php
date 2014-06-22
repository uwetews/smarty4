<?php

namespace Smarty\Node;

use Smarty\Compiler\Target\Language\Php\Format;
use Smarty\Template\Context;
use Smarty\Parser\Token;
use Smarty\Parser;

/**
 * Class Node
 *
 * @package Smarty\Nodes\Template
 */
class Template extends Format
{
    /**
     * Node name
     *
     * @var string
     */
    public $name = 'Template';

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
     * Unique Template class name
     *
     * @var string
     */
    public $templateClass = '';

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
     * @param \Smarty\Parser       $parser parser context object
     * @param \Smarty\Parser\Token $token
     */
    function __construct(Parser $parser, $token = null)
    {
        parent::__construct($parser, null, $token);
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
        parent::cleanup();
        $this->template_scope = null;
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
