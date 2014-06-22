<?php
/**
 * Smarty Compiler Template Node Expression Value Special Variable
 *
 * @package Smarty\Compiler
 * @author  Uwe Tews
 */

/**
 * Special Variable Value Node
 *
 * @package Smarty\Compiler
 */
namespace Smarty\Nodes\Value;

use Smarty\Nodes\Node;

/**
 * Class SpecialVariable
 *
 * @package Smarty\Nodes\Value
 */
class SpecialVariable extends Variable
{

    /**
     * @param       $parser
     * @param array $indexArray
     */
    public function __construct($parser, $indexArray = array())
    {
        parent::__construct($parser);
        foreach ($indexArray as $index) {
            $this->addArrayIndex(new Value_Singlequote($parser, "'" . $index . "'"));
        }
    }
}