<?php
namespace Smarty\Parser\Source\Language\Smarty\Node\Tag;

use Smarty\Node\Tag;

/**
 * Class TagInclude
 *
 * @package Smarty\Parser\Source\Language\Smarty\Node\Tag
 */
class TagInclude extends Tag
{
    /**
     * Node name
     *
     * @var string
     */
    public $name = 'TagInclude';
    /**
     * Rule name
     *
     * @var string
     */
    public $ruleName = 'TagInclude';
    /**
     * Parser node name (defaults to node name)
     *
     * @var string
     */
    public $parserNode = 'TagInclude';

    /**
     * Compiler class name (defaults to node name)
     *
     * @var string
     */
    public $compilerClass = 'TagInclude';

    /**
     * Variable scope default local
     *
     * @var string
     */
    public $scope = 'local';

    /**
     * Get Variable scope
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

}