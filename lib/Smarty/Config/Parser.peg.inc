<?php
namespace Smarty\Nodes\Core;

use Smarty\Nodes;

/**
 * Class RuleRoot;
 *
 * @package Smarty\Nodes\Core
 */
class RuleRoot;
{
    /*!*
    <pegparser Config>
        <node Number>
            <attribute>hash</attribute>
            <rule>/[0-9]+(?:\.[0-9]+)?/</rule>
            <action _finish>
            {
                $nodeRes->node = new Nodes\Value\Number($nodeRes->_peg);
                $nodeRes->node->setValue($nodeRes->_text)->setTraceInfo($nodeRes->_lineno, $nodeRes->_text, $nodeRes->_startpos, $nodeRes->_endpos);
            }
            </action>
        </node>
        <node String>
            <attribute>hash</attribute>
            <rule>/'[^'\\]*(?:\\.[^'\\]*)*'/</rule>
            <action _finish>
            {
                $nodeRes->node = new Nodes\Value\String($nodeRes->_peg);
                $nodeRes->node->setValue($nodeRes->_text)->setTraceInfo($nodeRes->_lineno, $nodeRes->_text, $nodeRes->_startpos, $nodeRes->_endpos);
            }
            </action>
        </node>
        <node Boolean>
            <attribute>hash</attribute>
            <rule>/(true|false)(?![^a-zA-Z0-9])/</rule>
            <action _finish>
            {
                $nodeRes->node = new Nodes\Value\Boolean($nodeRes->_peg);
                $nodeRes->node->setValue($nodeRes->_text)->setTraceInfo($nodeRes->_lineno, $nodeRes->_text, $nodeRes->_startpos, $nodeRes->_endpos);
            }
            </action>
        </node>
        <node Null>
            <attribute>hash</attribute>
            <rule>/null(?![^a-zA-Z0-9])/</rule>
            <action _finish>
            {
                $nodeRes->node = new Nodes\Value\Null($nodeRes->_peg);
                $nodeRes->node->setTraceInfo($nodeRes->_lineno, $nodeRes->_text, $nodeRes->_startpos, $nodeRes->_endpos);
            }
            </action>
        </node>
            <node attrvalue>
                <rule> .._? ( /(?<true>true)|(?<false>false)|(?<null>null)|(?<v1>(('[^']*')|("[^"]*")|\d+|\w+))/ | ( '(' sub:attr ')' ) )</rule>
                <action sub> {
                        $nodeRes->value = $matchRes->_attr;
                    }
                </action>
                <action _finish>
                    {
                        $mr = $nodeRes->_matchres;
                        if (isset($mr['v1']) && !empty($mr['v1'])) {
                            $nodeRes->value = trim($mr['v1'], "'\"");
                        }
                        if (isset($mr['true']) && !empty($mr['true'])) {
                            $nodeRes->value = true;
                        }
                        if (isset($mr['false']) && !empty($mr['false'])) {
                            $nodeRes->value = false;
                        }
                        if (isset($mr['null']) && !empty($mr['null'])) {
                            $nodeRes->value = null;
                        }
                        $nodeRes->_matchres = array();
                    }
                </action>
            </node>


            <node attrentry>
                <rule> .._? key:Name .._?  '=' .._? val:attrvalue? </rule>
                <action key>
                {
                    $nodeRes->key = $matchRes->_text;
                }
                </action>
                <action val>
                {
                    $nodeRes->value[$nodeRes->key] = $matchRes->value;
                }
                </action>
             </node>


        <node Section>
            <rule>'<section' _ Id _? '>' Entry* '<section>'</rule>
        </node>

        <node Entry> Property
        <node AnyLiteral>
            # This combination of basic nodes is implemented for speed optimization
            <attribute>hash</attribute>
            <rule>/((?<number>([0-9]+(?:\.[0-9]+)?))|(?<string>('[^'\\]*(?:\\.[^'\\]*)*')|((?<null>null)|(?<bool>(true|false)))(?![^a-zA-Z0-9])))/</rule>
            <action _finish>
            {
                if (isset($nodeRes->_matchres['number'])) {
                    $nodeRes->node = new Nodes\Value\Number($nodeRes->_peg);
                } elseif (isset($nodeRes->_matchres['string'])) {
                    $nodeRes->node = new Nodes\Value\String($nodeRes->_peg);
                } elseif (isset($nodeRes->_matchres['bool'])) {
                    $nodeRes->node = new Nodes\Value\Boolean($nodeRes->_peg);
                } else {
                    $nodeRes->node = new Nodes\Value\Null($nodeRes->_peg);
                }
                $nodeRes->node->setValue($nodeRes->_text)->setTraceInfo($nodeRes->_lineno, $nodeRes->_text, $nodeRes->_startpos, $nodeRes->_endpos);
            }
            </action>
        </node>



        <node Id>
            <rule>/[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]* /</rule>
         </node>
        <node Attr>
            <rule>/[\S]+/</rule>
         </node>
        <node OpenP>
            <attribute>matchall</attribute>
            <rule>/\s*\(\s* /</rule>
         </node>
        <node OpenB>
            <attribute>matchall</attribute>
            <rule>/\s*\[\s* /</rule>
         </node>
        <node OpenC>
            <attribute>matchall</attribute>
            <rule>/\{\s* /</rule>
         </node>
         <node CloseP>
            <attribute>matchall</attribute>
            <rule>/\s*\)\s* /</rule>
         </node>
        <node CloseB>
            <attribute>matchall</attribute>
            <rule>/\s*\}/</rule>
         </node>
        <node CloseC>
            <attribute>matchall</attribute>
            <rule>/\s*\}/</rule>
         </node>
        <node Math>
            <attribute>matchall</attribute>
            <rule>/(\s*(?<op>(\*|\/|%))\s*)|(\s+(?<op2>mod)\s+)/</rule>
            <action op>
            {
                $nodeRes->_type = 'operator';
                $nodeRes->_subtype = 'math';
                $nodeRes->_compile = " {$matchRes->_matchres['op']} ";
                unset($matchRes->_matchres['op']);
            }
            </action>
            <action op2>
            {
                $nodeRes->_type = 'operator';
                $nodeRes->_subtype = 'math';
                $nodeRes->_compile = " {$matchRes->_matchres['op2']} ";
                unset($matchRes->_matchres['op2']);
            }
            </action>
        </node>
        <node Unimath>
            <attribute>matchall</attribute>
            <rule>/\s*(?<op>(\+|-))\s* /</rule>
            <action op>
            {
                $nodeRes->_type = 'operator';
                $nodeRes->_subtype = 'math';
                $nodeRes->_compile = " {$matchRes->_matchres['op']} ";
                unset($matchRes->_matchres['op']);
            }
            </action>
         </node>
        <node Condition>
            <attribute>matchall</attribute>
            <rule>/(\s*(?<op>(===|!==|==|!=|<>|<=|<|>=|>))\s*)|(\s+(?<op2>(eq|ne|ge|gte|gt|le|lte|lt|instanceof))\s+)/ </rule>
            <action op>
            {
                $nodeRes->_type = 'operator';
                $nodeRes->_subtype = 'bool';
                switch ($matchRes->_matchres['op']) {
                        case '<>':
                            $nodeRes->_compile = '!=';
                            break;
                        default:
                            $nodeRes->_compile = $matchRes->_matchres['op'];
                            break;
                }
                $nodeRes->_compile = ' ' . $nodeRes->_compile . ' ';
                unset($matchRes->_matchres['op']);
            }
            </action>
            <action op2>
            {
                $nodeRes->_type = 'operator';
                $nodeRes->_subtype = 'bool';
                switch ($matchRes->_matchres['op2']) {
                       case 'eq':
                            $nodeRes->_compile = '==';
                            break;
                        case 'ne':
                            $nodeRes->_compile = '==';
                            break;
                        case 'ge':
                        case 'gte':
                            $nodeRes->_compile = '>=';
                            break;
                        case 'gt':
                            $nodeRes->_compile = '>';
                            break;
                        case 'le':
                        case 'lte':
                            $nodeRes->_compile = '<=';
                            break;
                        case 'lt':
                            $nodeRes->_compile = '<';
                            break;
                        case 'lt':
                            $nodeRes->_compile = 'instanceof';
                            break;
                        default:
                            $nodeRes->_compile = $matchRes->_matchres['op2'];
                            break;
                }
                $nodeRes->_compile = ' ' . $nodeRes->_compile . ' ';
                unset($matchRes->_matchres['op2']);
            }
            </action>
        </node>
        <node NamedCondition>
            <attribute>matchall</attribute>
            <rule>/\s+is\s+(not\s+)?(((odd|even|div)\s+by)|in)\s+/ </rule>
        </node>
        <node NamedCondition2>
            <attribute>matchall</attribute>
            <rule>/\s+is\s+(not\s+)?(((odd|even|div)\s+by)|in)\s+/</rule>
        </node>
        <node Unilog>
            <attribute>matchall</attribute>
            <rule>/((!|~)\s*)|(not\s+)/</rule>
        </node>
           <node Logop>
            <attribute>matchall</attribute>
            <rule>/\s*((\|\||\|&&|&|^)\s*)|((and|or|xor)\s+)/</rule>
        </node>
           <node Dollar>
            <attribute>matchall</attribute>
            <rule>/\$/</rule>
        </node>
        <node Hatch>
            <attribute>matchall</attribute>
            <rule>/#/</rule>
        </node>
        <node Comma>
            <attribute>matchall</attribute>
            <rule>/\s*,\s* /</rule>
        </node>
        <node Ptr>
            <attribute>matchall</attribute>
            <rule>/->/</rule>
        </node>
        <node Is>
            <attribute>matchall</attribute>
            <rule>/\s*=\s* /</rule>
        </node>

        <node Function>
            <rule>(name:Id | name:Variable) parameter:Parameter</rule>
        </node>
        <node Parameter>
            <rule>OpenP  ( parameter:Expr (Comma parameter:Expr)*)? CloseP</rule>
        </node>
        <node Statement>
            <rule> var:Variable Is value:Expr _? </rule>
        </node>

        <node Modifier>
            <rule> value:Value &'|' ('|' name:Id (':' nodes:Value)*)+ </rule>
        </node>

        <node Value>
            <attribute>hash</attribute>
            <rule>  value:AnyLiteral | value:Variable | value:Array | value:Function | (OpenP value:Expr CloseP) </rule>
            <action value>
            {
                $nodeRes->node = $matchRes->node;
            }
            </action>
        </node>

        <node Array>
            <rule> ( 'array' OpenP element:Arrayelement* CloseP) | (OpenB _element:Arrayelement* CloseB) </rule>
        </node>

        <node  Arrayelement>
           <rule> ( index:Expr _? '=>' _?)? value:Expr Comma? </rule>
        </node>

        <node Product>
            <rule> operator:Unimath? left:Value  ( operator:Math operator:Unimath? right:Value )* </rule>
        </node>

        <node Sum>
            <rule> left:Product  ( operator:Unimath right:Product )* </rule>
        </node>
        <node Expr>
            <rule> value:Sum | value:Logexpr _? </rule>
        </node>

        <node Logexpr>
            <rule> (operator:Unilog left:Value)|(left:Value operator:NamedCondition?) ( (operator:Condition|operator:NamedCondition2) (operator:Unilog right:Value)|(right:Value operator:NamedCondition?) )* </rule>
        </node>

       <node Unexpected>
            <rule> /[\s\S]{1,30}/ </rule>
            <action _finish>

                {
                    $this->parserContext->compiler->error("unexpected '{$nodeRes['text']}'", $this->parserContext->line, $this);
                    }


            </action>
        </node>

    </pegparser>
    */
}

