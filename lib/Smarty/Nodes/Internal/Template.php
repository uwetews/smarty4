<?php
/**
 * Smarty Compiler Template Node Template
 *
 * @package Smarty\Compiler
 * @author  Uwe Tews
 */
namespace Smarty\Nodes\Internal;

use Smarty\Nodes\Node;

/**
 * Smarty Compiler Template Node
 * This is the root node of a template
 *
 * @package Smarty\Compiler
 */
class Template extends node
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
     * @var Smarty_Template_scope
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
    public $language = '';

    /**
     * Constructor
     *
     * @param $parser
     * @param $nodeType
     *
     * @internal param \Smarty_Compiler_CompilerCore $compiler
     */
    function __construct($parser)
    {
        parent::__construct($parser);
        $this->language = $parser->context->getTargetLanguage();
        //        $this->template_scope = $this->compiler->instanceTemplateScope($parser->context);
        //        $this->addFileDependency($parser->context);
        //        $this->templateClass = $this->compiler->getUniqueTemplateClassName();
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

    public function  cleanup()
    {
        $this->targetNode = null;
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