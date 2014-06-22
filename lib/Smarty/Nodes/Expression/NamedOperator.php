<?php
/**
 * Smarty Compiler Template Node Expression NamedOperator
 *
 * @package Smarty\Compiler
 * @author  Uwe Tews
 */

/**
 * Named Operator Node
 *
 * @package Smarty\Compiler
 */
namespace Smarty\Nodes\Internal;

use Smarty\Nodes\Node;

/**
 * Class NamedOperator
 *
 * @package Smarty\Nodes\Internal
 */
class NamedOperator extends Node
{
    /**
     * Named operator
     *
     * @var string
     */
    public $operator = '';

    /**
     * valid operators
     *
     * @var array
     */
    public $valid = array(
        'is_odd_by'      => true,
        'is_not_odd_by'  => true,
        'is_odd'         => true,
        'is_not_odd'     => true,
        'is_even_by'     => true,
        'is_not_even_by' => true,
        'is_even'        => true,
        'is_not_even'    => true,
        'is_div_by'      => true,
        'is_not_div_by'  => true,
        'is_in'          => true,
    );

    /**
     * Add operator name segment
     *
     * @param string $nameSegment
     *
     * @return Node  current node
     */
    public function addNameSegment($nameSegment)
    {
        $nameSegment = strtolower($nameSegment);
        if (empty($this->operator)) {
            $this->operator = $nameSegment;
        } else {
            $this->operator .= '_' . $nameSegment;
        }
        return $this;
    }
}