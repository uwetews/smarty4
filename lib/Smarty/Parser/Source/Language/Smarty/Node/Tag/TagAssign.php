<?php
namespace Smarty\Parser\Source\Language\Smarty\Node\Tag;

use Smarty\Node\Tag;

/**
 * Class TagAssign
 *
 * @package Smarty\Parser\Source\Language\Smarty\Node\Tag
 */
class TagAssign extends Tag
{
    /**
     * Node name
     *
     * @var string
     */
    public $name = 'TagAssign';
    /**
     * Rule name
     *
     * @var string
     */
    public $ruleName = 'TagAssign';
    /**
     * Parser node name (defaults to node name)
     *
     * @var string
     */
    public $parserNode = 'TagAssign';

    /**
     * Compiler class name (defaults to node name)
     *
     * @var string
     */
    public $compilerClass = 'TagAssign';

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