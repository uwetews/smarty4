<?php
namespace Smarty\Parser\Source\Language\Smarty\Node\Tag;

use Smarty\Node\Tag;

/**
 * Class TagAssign
 *
 * @package Smarty\Parser\Source\Language\Smarty\Node\Tag
 */
class TagPluginFunction extends Tag
{
    /**
     * Node name
     *
     * @var string
     */
    public $name = 'TagPluginFunction';
    /**
     * Rule name
     *
     * @var string
     */
    public $ruleName = 'TagPluginFunction';
    /**
     * Parser node name (defaults to node name)
     *
     * @var string
     */
    public $parserNode = 'TagPluginFunction';

    /**
     * Compiler class name (defaults to node name)
     *
     * @var string
     */
    public $compilerClass = 'TagPluginFunction';

    /**
     * plugin name
     *
     * @var string
     */
    public $pluginName = '';

    /**
     * plugin function name
     *
     * @var string
     */
    public $pluginFunction = '';

    /**
     * Variable scope default local
     *
     * @var string
     */
    public $scope = 'local';

    /**
     * Get Variable scope
     *
     * @return string
     */
    public function getScope()
    {
        return $this->scope;
    }

    /**
     * Set variable scope
     *
     * @param string $scope
     */
    public function setScope($scope)
    {
        $this->scope = $scope;
    }

    /**
     * Check if parser rules for plugin exists, try to build dynamic or fall back to default

     */
    public function generatePluginParserRules()
    {
        $parserNode = 'Plugin' . ucfirst($this->pluginName);
        if (isset($this->parser->ruleArray[$parserNode]) && false === $this->parser->ruleArray[$parserNode]) {
            // no plugin specific rule, use default
            return;
        }
        if (isset($this->parser->ruleArray[$parserNode]) || isset($this->parser->rulePegParserArray[$parserNode])) {
            // set up parsing attributes of plugin
            $this->parserNode = $parserNode;
            $this->setNodeAttributes($this->parser->getNodeAttributes($this->parserNode));
            $this->decodeTagAttributes();
            return;
        }
        // get comment block of plugin
        $reflection = new \ReflectionFunction ($this->pluginFunction);
        $doc = $reflection->getDocComment();
        // does it contain the peg parser mark?
        if ($doc && preg_match('/\s*\/\*!\* /Sxs', $doc, $matches)) {
            // generate parser rules in the fly
            $class = $this->parser->generatorClass;
            if (class_exists($class)) {
                $compiler = new $class($this->parser->compiler, $this->parser->context);
                $rules = $compiler->compileDynamic($doc);
                unset($compiler);
                $this->parser->addDynamicRules($rules);
            }
            // set up parsing attributes of plugin
            $this->parserNode = $parserNode;
            $this->setNodeAttributes($this->parser->getNodeAttributes($this->parserNode));
            $this->decodeTagAttributes();
            return;
        } else {
            //fall back to default parser
            $this->parser->ruleArray[$parserNode] = false;
            return;
        }
    }
}