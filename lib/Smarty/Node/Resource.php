<?php
namespace Smarty\Node;

use Smarty\Compiler\Target\Language\Php\Format;

/**
 * Class Node
 *
 * @package Smarty\Nodes\Resource
 */
class Resource extends Format
{
    /**
     * Node name
     *
     * @var string
     */
    public $name = 'Resource';

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
     *
     */
    public function  cleanup()
    {
        parent::cleanup();
        $this->compiler = null;
        if (isset($this->templateNode)) {
            $this->templateNode->cleanup();
            $this->templateNode = null;
        }
        if (!empty($this->subtreeNodes)) {
            $this->cleanupNodeArray($this->subtreeNodes);
        }
    }
}