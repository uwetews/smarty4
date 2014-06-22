<?php
/**
 * Smarty Compiler Template Node Expression Operator Greater
 *
 * @package Smarty\Compiler
 * @author  Uwe Tews
 */

/**
 * Binary Condition Node
 *
 * @package Smarty\Compiler
 */
namespace Smarty\Nodes\Internal;

use Smarty\Nodes\Node;

/**
 * Class Condition
 *
 * @package Smarty\Nodes\Internal
 */
class Condition extends Node
{
    /**
     * node group
     */
    public $nodeGroup = 'condition';

    /**
     * Normalized condition as string
     *
     * @var string
     */
    public $condition = '';

    /**
     * Compiled output
     *
     * @var string
     */
    public $code = '';

    /**
     * Translation table for input to compiled output
     *
     * @var array
     */
    private $translation = array('=='         => '==',
                                 'eq'         => '==',
                                 '!='         => '!=',
                                 'ne'         => '!=',
                                 '<>'         => '!=',
                                 '>'          => '>',
                                 'gt'         => '>',
                                 '<'          => '<',
                                 'lt'         => '<',
                                 '>='         => '>=',
                                 'ge'         => '>=',
                                 'gte'        => '>=',
                                 '<='         => '<=',
                                 'le'         => '<=',
                                 'lte'        => '<=',
                                 '==='        => '===',
                                 '!=='        => '!==',
                                 'instanceof' => 'instanceof',
    );

    /**
     * set value and translate to code
     *
     * @param $condition
     *
     * @throws Smarty_Compiler_Exception_MissingCode
     * @internal param string $value
     * @return $this
     */
    public function setValue($condition)
    {
        $this->value = $condition;
        $condition = str_replace(' ', '', strtolower(trim($condition)));
        if (isset($this->translation[$condition])) {
            $this->condition = str_replace(' ', '', $this->translation[$condition]);
            $this->code = $this->translation[$condition];
        } else {
            throw new Smarty_Compiler_Exception_MissingCode(get_class($this), $this->source);
        }
        return $this;
    }
}