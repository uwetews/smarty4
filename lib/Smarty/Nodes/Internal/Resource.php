<?php
/**
 * Smarty Compiler Node Resource
 *
 * @package Smarty\Compiler
 * @author  Uwe Tews
 */

/**
 * Smarty Compiler Template Node
 * This is the root node of a resource
 *
 * @package Smarty\Compiler
 */
class Resource extends Smarty_Compiler_Format
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
     * @param $parser
     * @param $nodeType
     *
     * @internal param \Smarty_Compiler_CompilerCore $compiler
     */
    function __construct($parser, $nodeType)
    {
        parent::__construct($parser, $nodeType);
        //        $this->nodeType = $nodeType;
        //        $this->language = $parser->context->getTargetLanguage();
        //        $this->compiler = $parser->compiler;
        //        $this->context = $parser->context;
        //        $this->parser = $parser;
        //        $this->parser->rootNode = $this;
        //        $node = $this->parser->instanceBodyNode();
        //        $node->parentNode = $this;
        //        $this->templateClass = $node->templateClass;
        //        $this->templateNode = $this->parser->currentNode = $node;
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