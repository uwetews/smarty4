<?php
namespace Smarty\Compiler\Source\Language\Smarty\Parser;

use Smarty\Compiler\Source\Laguage\Smarty\Nodes;

/**
 * Class PegParser
 *
 * @package Smarty\Source\Smarty\Nodes\Smarty
 */
class ConfigVariableParser
{
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
}
