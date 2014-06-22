<?php
namespace Smarty\Nodes\Core;

use Smarty\Nodes;

/**
 * Class PegParser
 *
 * @package Smarty\Nodes\Core
 */
class PegParser
{
    /*!*
    <pegparser Config>
        <node Number>
            <attribute>hash</attribute>
            <rule>/[0-9]+(?:\.[0-9]+)?/</rule>
            <action _finish>
            {
                $result->node = new Nodes\Value\Number($result->_peg);
                $result->node->setValue($result->_text)->setTraceInfo($result->_lineno, $result->_text, $result->_startpos, $result->_endpos);
            }
            </action>
        </node>
        <node String>
            <attribute>hash</attribute>
            <rule>/'[^'\\]*(?:\\.[^'\\]*)*'/</rule>
            <action _finish>
            {
                $result->node = new Nodes\Value\String($result->_peg);
                $result->node->setValue($result->_text)->setTraceInfo($result->_lineno, $result->_text, $result->_startpos, $result->_endpos);
            }
            </action>
        </node>
        <node Boolean>
            <attribute>hash</attribute>
            <rule>/(true|false)(?![^a-zA-Z0-9])/</rule>
            <action _finish>
            {
                $result->node = new Nodes\Value\Boolean($result->_peg);
                $result->node->setValue($result->_text)->setTraceInfo($result->_lineno, $result->_text, $result->_startpos, $result->_endpos);
            }
            </action>
        </node>
        <node Null>
            <attribute>hash</attribute>
            <rule>/null(?![^a-zA-Z0-9])/</rule>
            <action _finish>
            {
                $result->node = new Nodes\Value\Null($result->_peg);
                $result->node->setTraceInfo($result->_lineno, $result->_text, $result->_startpos, $result->_endpos);
            }
            </action>
        </node>
            <node attrvalue>
                <rule> .._? ( /(?<true>true)|(?<false>false)|(?<null>null)|(?<v1>(('[^']*')|("[^"]*")|\d+|\w+))/ | ( '(' sub:attr ')' ) )</rule>
                <action sub> {
                        $result->value = $subres->_attr;
                    }
                </action>
                <action _finish>
                    {
                        $mr = $result->_matchres;
                        if (isset($mr['v1']) && !empty($mr['v1'])) {
                            $result->value = trim($mr['v1'], "'\"");
                        }
                        if (isset($mr['true']) && !empty($mr['true'])) {
                            $result->value = true;
                        }
                        if (isset($mr['false']) && !empty($mr['false'])) {
                            $result->value = false;
                        }
                        if (isset($mr['null']) && !empty($mr['null'])) {
                            $result->value = null;
                        }
                        $result->_matchres = array();
                    }
                </action>
            </node>


            <node attrentry>
                <rule> .._? key:Name .._?  '=' .._? val:attrvalue? </rule>
                <action key>
                {
                    $result->key = $subres->_text;
                }
                </action>
                <action val>
                {
                    $result->value[$result->key] = $subres->value;
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
                if (isset($result->_matchres['number'])) {
                    $result->node = new Nodes\Value\Number($result->_peg);
                } elseif (isset($result->_matchres['string'])) {
                    $result->node = new Nodes\Value\String($result->_peg);
                } elseif (isset($result->_matchres['bool'])) {
                    $result->node = new Nodes\Value\Boolean($result->_peg);
                } else {
                    $result->node = new Nodes\Value\Null($result->_peg);
                }
                $result->node->setValue($result->_text)->setTraceInfo($result->_lineno, $result->_text, $result->_startpos, $result->_endpos);
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
                $result->_type = 'operator';
                $result->_subtype = 'math';
                $result->_compile = " {$subres->_matchres['op']} ";
                unset($subres->_matchres['op']);
            }
            </action>
            <action op2>
            {
                $result->_type = 'operator';
                $result->_subtype = 'math';
                $result->_compile = " {$subres->_matchres['op2']} ";
                unset($subres->_matchres['op2']);
            }
            </action>
        </node>
        <node Unimath>
            <attribute>matchall</attribute>
            <rule>/\s*(?<op>(\+|-))\s* /</rule>
            <action op>
            {
                $result->_type = 'operator';
                $result->_subtype = 'math';
                $result->_compile = " {$subres->_matchres['op']} ";
                unset($subres->_matchres['op']);
            }
            </action>
         </node>
        <node Condition>
            <attribute>matchall</attribute>
            <rule>/(\s*(?<op>(===|!==|==|!=|<>|<=|<|>=|>))\s*)|(\s+(?<op2>(eq|ne|ge|gte|gt|le|lte|lt|instanceof))\s+)/ </rule>
            <action op>
            {
                $result->_type = 'operator';
                $result->_subtype = 'bool';
                switch ($subres->_matchres['op']) {
                        case '<>':
                            $result->_compile = '!=';
                            break;
                        default:
                            $result->_compile = $subres->_matchres['op'];
                            break;
                }
                $result->_compile = ' ' . $result->_compile . ' ';
                unset($subres->_matchres['op']);
            }
            </action>
            <action op2>
            {
                $result->_type = 'operator';
                $result->_subtype = 'bool';
                switch ($subres->_matchres['op2']) {
                       case 'eq':
                            $result->_compile = '==';
                            break;
                        case 'ne':
                            $result->_compile = '==';
                            break;
                        case 'ge':
                        case 'gte':
                            $result->_compile = '>=';
                            break;
                        case 'gt':
                            $result->_compile = '>';
                            break;
                        case 'le':
                        case 'lte':
                            $result->_compile = '<=';
                            break;
                        case 'lt':
                            $result->_compile = '<';
                            break;
                        case 'lt':
                            $result->_compile = 'instanceof';
                            break;
                        default:
                            $result->_compile = $subres->_matchres['op2'];
                            break;
                }
                $result->_compile = ' ' . $result->_compile . ' ';
                unset($subres->_matchres['op2']);
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
                $result->node = $subres->node;
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
                    $this->parserContext->compiler->error("unexpected '{$result['text']}'", $this->parserContext->line, $this);
                    }


            </action>
        </node>

    </pegparser>
    */
}

