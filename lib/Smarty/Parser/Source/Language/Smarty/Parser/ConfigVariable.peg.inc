<?php
namespace Smarty\Parser\Source\Language\Smarty\Parser;

use Smarty\Parser\Source\Laguage\Smarty\Nodes;

/**
 * Class PegParser
 *
 * @package Smarty\Source\Smarty\Nodes\Smarty
 */
class ConfigVariableParser
{
    public $parser = null;
    /*!*
    <pegparser ConfigVariable>
   #
    # Config variable
    #
    #                -> name can be nested variable                    -> array access
        <node Configvar>
            <attribute>hash</attribute>
            <rule> Hatch (varname:Id | (OpenC varname:Variable CloseC))+    varname:Arrayindex*</rule>
        </node>
    </pegparser>

    */
    public function __construct ($parser) {
        $this->parser = $parser;
    }
}
