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
namespace Smarty\Parser\Source\Shared\Node;

use Smarty\Node;

/**
 * Class Unilog
 *
 * @package Smarty\Nodes\Internal
 */
class Unilog extends Node
{
    /**
     * Node name
     *
     * @var string
     */
    public $name = 'Unilog';

    /**
     * node group
     */
    public $nodeGroup = 'logop';

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
    private $translation = array('!'   => ' !',
                                 'not' => ' !',
                                 '~'   => ' ~',

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