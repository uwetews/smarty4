<?php
namespace Smarty\Parser\Source\Language\Smarty\Node\Operator;

use Smarty\Node;

/**
 * Class Condition
 *
 * @package Smarty\Parser\Source\Language\Smarty\Node\Operator
 */
class Condition extends Node
{
    /**
     * Node name
     *
     * @var string
     */
    public $name = 'Condition';
    /**
     * node group
     */
    public $nodeGroup = 'logical';

    /**
     * Normalized operator as string
     *
     * @var string
     */
    public $operator = '';

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
    private $translation = array('==='        => ' === ',
                                 '=='         => ' == ',
                                 '!='         => ' != ',
                                 '<='         => ' <= ',
                                 '<'          => ' < ',
                                 '>='         => ' >= ',
                                 '>'          => ' > ',
                                 'eq'         => ' == ',
                                 'ne'         => ' != ',
                                 'le'         => ' <= ',
                                 'lte'        => ' <= ',
                                 'lt'         => ' < ',
                                 'ge'         => ' >= ',
                                 'gte'        => ' >= ',
                                 'gt'         => ' > ',
                                 'instanceof' => ' instanceof ',
    );

    /**
     * set value and translate to code
     *
     * @param string $operator
     *
     * @throws Smarty_Compiler_Exception_MissingCode
     * @return $this
     */
    public function setValue($operator)
    {
        $this->value = $operator;
        $operator = str_replace(' ', '', strtolower(trim($operator)));
        if (isset($this->translation[$operator])) {
            $this->operator = str_replace(' ', '', $this->translation[$operator]);
            $this->code = $this->translation[$operator];
        } else {
            throw new Smarty_Compiler_Exception_MissingCode(get_class($this), $this->source);
        }
        return $this;
    }
}