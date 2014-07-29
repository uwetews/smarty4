<?php
namespace Smarty\Tool\Parser\Peg\InternalTool;

Use Smarty\Template\Context;
Use Smarty\Compiler;
Use Smarty\Parser;
use Smarty\Tool\Parser\Peg\Nodes\ParserCompiler;
use Smarty\Tool\Parser\Peg\Nodes\Text;

/**
 * Class PegParser
 *
 * @package Smarty\Nodes\Template
 */
class ParserGenerator extends Parser
{
    /**
     * @var null|Generator
     */
    public $parser = null;

    /**
     * @var string
     */
    public $filename = '';

    /**
     * @var null|Generator
     */
    public $context = null;
    /**
     * @var string
     */
    public $filetime = '';

    /**
     * @var string
     */
    public $whitespacePattern = '/[\s\t]*(([#][^\r\n]*)?([\r\n]+[\s\t]*))*/';

    public $rules = array(
        "attrvalue" => array(
            "_name"     => "attrvalue",
            "_param" => array(
                0 => array(
                    "_param" => true,
                    "_silent"   => 2,
                    "_type"     => "whitespace"
                ),
                1 => array(
                    "_param" => array(
                        0 => array(
                            "_param" => "/(?<true>true)|(?<false>false)|(?<null>null)|(?<v1>(('[^']*')|(\"[^\"]*\")|\\d+|\\w+))/",
                            "_type"   => "rx"
                        ),
                        1 => array(
                            "_param" => array(
                                0 => array(
                                    "_param" => "(",
                                    "_type"    => "literal"
                                ),
                                1 => array(
                                    "_param" => "attr",
                                    "_tag"     => "sub",
                                    "_type"    => "recurse"
                                ),
                                2 => array(
                                    "_param" => ")",
                                    "_type"    => "literal"
                                )
                            ),
                            "_type"     => "sequence"
                        )
                    ),
                    "_type"   => "option"
                )
            ),
            "_type"     => "sequence",
            "_actions"  => array(
                "_match"  => array(
                    "sub" => array(
                        "attrvalue_sub" => true
                    )
                ),
                "_finish" => array(
                    "attrvalue___FINISH" => true
                )
            )
        ),
        "attrentry" => array(
            "_name"     => "attrentry",
            "_param" => array(
                0 => array(
                    "_param" => true,
                    "_silent"   => 2,
                    "_type"     => "whitespace"
                ),
                1 => array(
                    "_param" => "Name",
                    "_tag"     => "key",
                    "_type"    => "recurse"
                ),
                2 => array(
                    "_param" => true,
                    "_silent"   => 2,
                    "_type"     => "whitespace"
                ),
                3 => array(
                    "_min"      => 0,
                    "_param" => array(
                        0 => array(
                            "_param" => "=",
                            "_type"    => "literal"
                        ),
                        1 => array(
                            "_param" => true,
                            "_silent"   => 2,
                            "_type"     => "whitespace"
                        ),
                        2 => array(
                            "_param" => "attrvalue",
                            "_tag"     => "val",
                            "_type"    => "recurse"
                        )
                    ),
                    "_type"     => "sequence"
                )
            ),
            "_type"     => "sequence",
            "_actions"  => array(
                "_match" => array(
                    "key" => array(
                        "attrentry_key" => true
                    ),
                    "val" => array(
                        "attrentry_val" => true
                    )
                )
            )
        ),
        "attr"      => array(
            "_name"     => "attr",
            "_param" => array(
                0 => array(
                    "_param" => "attrentry",
                    "_type"    => "recurse"
                ),
                1 => array(
                    "_max"      => null,
                    "_min"      => 0,
                    "_param" => array(
                        0 => array(
                            "_param" => ",",
                            "_type"    => "literal"
                        ),
                        1 => array(
                            "_param" => "attrentry",
                            "_type"    => "recurse"
                        )
                    ),
                    "_type"     => "sequence"
                )
            ),
            "_type"     => "sequence",
            "_actions"  => array(
                "_all" => array(
                    "attr___ALL" => true
                )
            )
        ),
        "Name"      => array(
            "_name"   => "Name",
            "_param" => "/\\w+/",
            "_type"   => "rx"
        ),
        "Header"    => array(
            "_name"   => "Header",
            "_param" => "/\\s*\\/\\*!\\* /",
            "_type"   => "rx"
        ),
        "End"       => array(
            "_name"   => "End",
            "_param" => "/\\s*\\*\\//",
            "_silent" => 1,
            "_type"   => "rx"
        ),
        "Comment"   => array(
            "_name"   => "Comment",
            "_param" => "/[\\s\\t]*(([#][^\\r\\n]*)?([\\r\\n]+[\\s\\t]*))* /",
            "_type"   => "rx"
        ),
        "Text"      => array(
            "_name"    => "Text",
            "_param"  => "/([\\S\\s]+(?=([^\\S\\r\\n]\\/\\*!\\*)))|[\\S\\s]+/",
            "_type"    => "rx",
            "_actions" => array(
                "_start" => array(
                    "Text___START" => true
                ),
                "_all"   => array(
                    "Text___ALL" => true
                )
            )
        ),
        "Parser"    => array(
            "_name"     => "Parser",
            "_param" => array(
                0  => array(
                    "_silent"  => 2,
                    "_param" => "Header",
                    "_type"    => "recurse"
                ),
                1  => array(
                    "_param" => true,
                    "_silent"   => 2,
                    "_type"     => "whitespace"
                ),
                2  => array(
                    "_param" => "<pegparser",
                    "_type"    => "literal"
                ),
                3  => array(
                    "_param" => false,
                    "_type"     => "whitespace"
                ),
                4  => array(
                    "_param" => "Name",
                    "_type"    => "recurse"
                ),
                5  => array(
                    "_param" => ">",
                    "_type"    => "literal"
                ),
                6  => array(
                    "_max"     => null,
                    "_min"     => 0,
                    "_param" => "Attribute",
                    "_type"    => "recurse"
                ),
                7  => array(
                    "_max"     => null,
                    "_min"     => 0,
                    "_param" => "Node",
                    "_type"    => "recurse"
                ),
                8  => array(
                    "_param" => true,
                    "_silent"   => 2,
                    "_type"     => "whitespace"
                ),
                9  => array(
                    "_param" => "</pegparser>",
                    "_type"    => "literal"
                ),
                10 => array(
                    "_param" => true,
                    "_silent"   => 2,
                    "_type"     => "whitespace"
                ),
                11 => array(
                    "_min"     => 0,
                    "_param" => "End",
                    "_type"    => "recurse"
                )
            ),
            "_type"     => "sequence",
            "_actions"  => array(
                "_start"  => array(
                    "Parser___START" => true
                ),
                "_match"  => array(
                    "Attribute" => array(
                        "Parser_Attribute" => true
                    ),
                    "Node"      => array(
                        "Parser_Node" => true
                    )
                ),
                "_finish" => array(
                    "Parser___FINISH" => true
                )
            )
        ),
        "Attribute" => array(
            "_name"     => "Attribute",
            "_param" => array(
                0 => array(
                    "_param" => true,
                    "_silent"   => 2,
                    "_type"     => "whitespace"
                ),
                1 => array(
                    "_param" => "<attribute>",
                    "_type"    => "literal"
                ),
                2 => array(
                    "_param" => "attr",
                    "_type"    => "recurse"
                ),
                3 => array(
                    "_param" => "</attribute>",
                    "_type"    => "literal"
                ),
                4 => array(
                    "_param" => true,
                    "_silent"   => 2,
                    "_type"     => "whitespace"
                )
            ),
            "_type"     => "sequence",
            "_actions"  => array(
                "_match"  => array(
                    "attr" => array(
                        "Attribute_attr" => true
                    )
                ),
                "_finish" => array(
                    "Attribute___FINISH" => true
                )
            )
        ),
        "Node"      => array(
            "_name"     => "Node",
            "_param" => array(
                0 => array(
                    "_param" => true,
                    "_silent"   => 2,
                    "_type"     => "whitespace"
                ),
                1 => array(
                    "_param" => "/\\s*\\<node\\s+(?<nodename>\\w+)\\>/",
                    "_type"   => "rx"
                ),
                2 => array(
                    "_max"     => null,
                    "_min"     => 0,
                    "_param" => "Attribute",
                    "_type"    => "recurse"
                ),
                3 => array(
                    "_param" => "Rule",
                    "_type"    => "recurse"
                ),
                4 => array(
                    "_max"     => null,
                    "_min"     => 0,
                    "_silent"  => 1,
                    "_param" => "Action",
                    "_type"    => "recurse"
                ),
                5 => array(
                    "_param" => "</node>",
                    "_type"    => "literal"
                ),
                6 => array(
                    "_param" => true,
                    "_silent"   => 2,
                    "_type"     => "whitespace"
                )
            ),
            "_type"     => "sequence",
            "_actions"  => array(
                "_start"  => array(
                    "Node___START" => true
                ),
                "_match"  => array(
                    "Rule"      => array(
                        "Node_Rule" => true
                    ),
                    "Action"    => array(
                        "Node_Action" => true
                    ),
                    "nodename"  => array(
                        "Node_nodename" => true
                    ),
                    "Attribute" => array(
                        "Node_Attribute" => true
                    )
                ),
                "_finish" => array(
                    "Node___FINISH" => true
                )
            )
        ),
        "Rule"      => array(
            "_name"     => "Rule",
            "_param" => array(
                0 => array(
                    "_param" => true,
                    "_silent"   => 2,
                    "_type"     => "whitespace"
                ),
                1 => array(
                    "_param" => "<rule>",
                    "_type"    => "literal"
                ),
                2 => array(
                    "_param" => true,
                    "_silent"   => 2,
                    "_type"     => "whitespace"
                ),
                3 => array(
                    "_param" => "Sequence",
                    "_type"    => "recurse"
                ),
                4 => array(
                    "_param" => true,
                    "_silent"   => 2,
                    "_type"     => "whitespace"
                ),
                5 => array(
                    "_param" => "</rule>",
                    "_type"    => "literal"
                ),
                6 => array(
                    "_param" => true,
                    "_silent"   => 2,
                    "_type"     => "whitespace"
                )
            ),
            "_type"     => "sequence",
            "_actions"  => array(
                "_match"  => array(
                    "Sequence" => array(
                        "Rule_Sequence" => true
                    )
                ),
                "_finish" => array(
                    "Rule___FINISH" => true
                )
            )
        ),
        "Action"    => array(
            "_name"     => "Action",
            "_param" => array(
                0 => array(
                    "_param" => true,
                    "_silent"   => 2,
                    "_type"     => "whitespace"
                ),
                1 => array(
                    "_param" => "/\\<action\\s+(?<funcname>\\w+)(\\((?<argument>\\w+)\\))?\\>/",
                    "_type"   => "rx"
                ),
                2 => array(
                    "_param" => true,
                    "_silent"   => 2,
                    "_type"     => "whitespace"
                ),
                3 => array(
                    "_param" => "/(\\{(?:(?>[^{}]+|(?R))*)?\\})/",
                    "_tag"    => "code",
                    "_type"   => "rx"
                ),
                4 => array(
                    "_param" => true,
                    "_silent"   => 2,
                    "_type"     => "whitespace"
                ),
                5 => array(
                    "_param" => "</action>",
                    "_type"    => "literal"
                ),
                6 => array(
                    "_param" => true,
                    "_silent"   => 2,
                    "_type"     => "whitespace"
                )
            ),
            "_type"     => "sequence",
            "_actions"  => array(
                "_match"  => array(
                    "code" => array(
                        "Action_code" => true
                    )
                ),
                "_finish" => array(
                    "Action___FINISH" => true
                )
            )
        ),
        "PHP"       => array(
            "_name"     => "PHP",
            "_param" => array(
                0 => array(
                    "_param" => "/.[\\n\\t ]* /",
                    "_type"   => "rx"
                ),
                1 => array(
                    "_param" => "/(\\{|\\}|[^\\n\\}\\{]+)* /",
                    "_silent" => 1,
                    "_tag"    => "b",
                    "_type"   => "rx"
                )
            ),
            "_type"     => "sequence",
            "_actions"  => array(
                "_match" => array(
                    "b" => array(
                        "PHP_b" => true
                    )
                )
            )
        ),
        "Arguments" => array(
            "_name"     => "Arguments",
            "_param" => array(
                0 => array(
                    "_param" => "(",
                    "_type"    => "literal"
                ),
                1 => array(
                    "_param" => "Name",
                    "_tag"     => "attr",
                    "_type"    => "recurse"
                ),
                2 => array(
                    "_min"      => 0,
                    "_param" => array(
                        0 => array(
                            "_param" => "=",
                            "_type"    => "literal"
                        ),
                        1 => array(
                            "_param" => array(
                                0 => array(
                                    "_param" => "Name",
                                    "_tag"     => "value",
                                    "_type"    => "recurse"
                                ),
                                1 => array(
                                    "_param" => "Arguments",
                                    "_tag"     => "value",
                                    "_type"    => "recurse"
                                )
                            ),
                            "_type"   => "option"
                        )
                    ),
                    "_type"     => "sequence"
                ),
                3 => array(
                    "_max"      => null,
                    "_min"      => 0,
                    "_param" => array(
                        0 => array(
                            "_param" => ",",
                            "_type"    => "literal"
                        ),
                        1 => array(
                            "_param" => "Name",
                            "_tag"     => "attr",
                            "_type"    => "recurse"
                        ),
                        2 => array(
                            "_min"      => 0,
                            "_param" => array(
                                0 => array(
                                    "_param" => "=",
                                    "_type"    => "literal"
                                ),
                                1 => array(
                                    "_param" => array(
                                        0 => array(
                                            "_param" => "Name",
                                            "_tag"     => "value",
                                            "_type"    => "recurse"
                                        ),
                                        1 => array(
                                            "_param" => "Arguments",
                                            "_tag"     => "value",
                                            "_type"    => "recurse"
                                        )
                                    ),
                                    "_type"   => "option"
                                )
                            ),
                            "_type"     => "sequence"
                        )
                    ),
                    "_type"     => "sequence"
                ),
                4 => array(
                    "_param" => ")",
                    "_type"    => "literal"
                )
            ),
            "_type"     => "sequence",
            "_actions"  => array(
                "_finish" => array(
                    "Arguments___FINISH" => true
                )
            )
        ),
        "Option"    => array(
            "_name"     => "Option",
            "_param" => array(
                0 => array(
                    "_param" => true,
                    "_type"     => "whitespace"
                ),
                1 => array(
                    "_param" => "Token",
                    "_tag"     => "result",
                    "_type"    => "recurse"
                ),
                2 => array(
                    "_max"      => null,
                    "_min"      => 0,
                    "_param" => array(
                        0 => array(
                            "_param" => true,
                            "_type"     => "whitespace"
                        ),
                        1 => array(
                            "_param" => "|",
                            "_type"    => "literal"
                        ),
                        2 => array(
                            "_param" => true,
                            "_type"     => "whitespace"
                        ),
                        3 => array(
                            "_param" => "Token",
                            "_tag"     => "option",
                            "_type"    => "recurse"
                        )
                    ),
                    "_type"     => "sequence"
                )
            ),
            "_type"     => "sequence",
            "_actions"  => array(
                "_match"  => array(
                    "result" => array(
                        "Option_result" => true
                    ),
                    "option" => array(
                                            "Option_option" => true
                    )
                ),
                "_finish" => array(
                    "Option___FINISH" => true
                )
            )
        ),
        "Sequence"  => array(
            "_name"     => "Sequence",
            "_param" => array(
                0 => array(
                    "_param" => "Option",
                    "_tag"     => "result",
                    "_type"    => "recurse"
                ),
                1 => array(
                    "_max"     => null,
                    "_min"     => 0,
                    "_param" => "Option",
                    "_tag"     => "sequence",
                    "_type"    => "recurse"
                )
            ),
            "_type"     => "sequence",
            "_actions"  => array(
                "_match"  => array(
                    "result"   => array(
                        "Sequence_result" => true
                    ),
                    "sequence" => array(
                        "Sequence_sequence" => true
                    )
                ),
                "_finish" => array(
                    "Sequence___FINISH" => true
                )
            )
        ),
        "Token"     => array(
            "_name"     => "Token",
            "_param" => array(
                0 => array(
                    "_param" => "/((?<silent>\\.+)|(?<pla>&)|(?<nla>\\!))?((?<tag>\\w+):)?/",
                    "_type"   => "rx",
                    "_min"   => 0
                ),
                1 => array(
                    "_param" => array(
                        0 => array(
                            "_param" => "/(?<rx>\\G(\\/|~|@|%|§)(((\\\\\\\\)*\\\\\\2)|.*?(?=(\\\\|\\2)))*\\2)|((?<osp>_\\?)|(?<wsp>_))|(?<node>\\w+)|(?<literal>(\"[^\"]*\")|('[^']*'))|(\\\$(?<expression>\\w+))/",
                            "_type"   => "rx"
                        ),
                        1 => array(
                            "_param" => array(
                                0 => array(
                                    "_param" => "(",
                                    "_type"    => "literal"
                                ),
                                1 => array(
                                    "_param" => true,
                                    "_silent"   => 2,
                                    "_type"     => "whitespace"
                                ),
                                2 => array(
                                    "_param" => "Sequence",
                                    "_type"    => "recurse"
                                ),
                                3 => array(
                                    "_param" => true,
                                    "_silent"   => 2,
                                    "_type"     => "whitespace"
                                ),
                                4 => array(
                                    "_param" => ")",
                                    "_type"    => "literal"
                                )
                            ),
                            "_type"     => "sequence"
                        )
                    ),
                    "_type"   => "option"
                ),
                2 => array(
                    "_param" => "/((?<quest>\\?)|(?<any>\\*)|(?<must>\\+?)|(\\{(?<min>\\d+)?,(?<max>\\d+)?\\}))?/",
                    "_type"   => "rx",
                    "_min"   => 0
                )
            ),
            "_type"     => "sequence",
            "_actions"  => array(
                "_start"  => array(
                    "Token___START" => true
                ),
                "_match"  => array(
                    "Sequence" => array(
                        "Token_Sequence" => true
                    )
                ),
                "_finish" => array(
                    "Token___FINISH" => true
                )
            )
        ),
        "File"      => array(
            "_max"      => null,
            "_min"      => 0,
            "_name"     => "File",
            "_param" => array(
                0 => array(
                    "_silent"  => 1,
                    "_param" => "Text",
                    "_type"    => "recurse"
                ),
                1 => array(
                    "_max"     => null,
                    "_min"     => 0,
                    "_silent"  => 1,
                    "_param" => "Parser",
                    "_type"    => "recurse"
                )
            ),
            "_type"     => "sequence",
            "_actions"  => array(
                "_start" => array(
                    "File___START" => true
                ),
                "_all"   => array(
                    "File___ALL" => true
                )
            )
        )
    );


    /**
     * Parser rules and action for node 'attrvalue'
     *  Rule: ->  <node attrvalue> <rule>  .._? (  /(?<true>true)|(?<false>false)|(?<null>null)|(?<v1>(('[^']*')|("[^"]*")|\d+|\w+))/ | (  '(' sub:attr ')' ) ) </rule>  <action sub> {
     * $result['value'] = $subres['_attr'];
     * } </action>  <action _finish> {
     * $mr = $result['_matchres'];
     * if (isset($mr['v1']) && !empty($mr['v1'])) {
     * $result['value'] = trim($mr['v1'], "'\"");
     * }
     * if (isset($mr['true']) && !empty($mr['true'])) {
     * $result['value'] = true;
     * }
     * if (isset($mr['false']) && !empty($mr['false'])) {
     * $result['value'] = false;
     * }
     * if (isset($mr['null']) && !empty($mr['null'])) {
     * $result['value'] = null;
     * }
     * $result['_matchres'] = array();
     * } </action> </node>  <-

     */

    public function attrvalue_sub(&$result, $subres)
    {
        $result['value'] = $subres['_attr'];
    }

    public function attrvalue___FINISH(&$result)
    {
        $mr = $result['_matchres'];
        if (isset($mr['v1']) && !empty($mr['v1'])) {
            $result['value'] = trim($mr['v1'], "'\"");
        }
        if (isset($mr['true']) && !empty($mr['true'])) {
            $result['value'] = true;
        }
        if (isset($mr['false']) && !empty($mr['false'])) {
            $result['value'] = false;
        }
        if (isset($mr['null']) && !empty($mr['null'])) {
            $result['value'] = null;
        }
        $result['_matchres'] = array();
    }

    /**
     * Parser rules and action for node 'attrentry'
     *  Rule: ->  <node attrentry> <rule>  .._? key:Name .._? (  '=' .._? val:attrvalue )? </rule>  <action key> {
     * $result['key'] = $subres->_text;
     * $result['value'] = array($result['key'] => true);
     * } </action>  <action val> {
     * $result['value'][$result['key']] = $subres['value'];
     * } </action> </node>  <-

     */

    public function attrentry_key(&$result, $subres)
    {
        $result['key'] = $subres['_text'];
        $result['value'] = array($result['key'] => true);
    }

    public function attrentry_val(&$result, $subres)
    {
        $result['value'][$result['key']] = $subres['value'];
    }


    /**
     * Parser rules and action for node 'Name'
     *  Rule: ->  <node Name> <rule>  /\w+/ </rule> </node>  <-

     */

    /**
     * Parser rules and action for node 'Header'
     *  Rule: ->  <node Header> <rule>  /\s*\/\*!\* / </rule> </node>  <-

     */

    /**
     * Parser rules and action for node 'End'
     *  Rule: ->  <node End> <rule>  ./\s*\*\// </rule> </node>  <-

     */

    /**
     * Parser rules and action for node 'Comment'
     *  Rule: ->  <node Comment> <rule>  /[\s\t]*(([#][^\r\n]*)?([\r\n]+[\s\t]*))* / </rule> </node>  <-

     */

    /**
     * Parser rules and action for node 'attr'
     *  Rule: ->  <node attr> <rule>  attrentry (  ',' attrentry )* </rule>  <action _all> {
     * if (!isset($result['_attr'])) {
     * $result['_attr'] = array();
     * }
     * $result['_attr'] = array_merge($result['_attr'], $subres['value']);
     * } </action> </node>  <-

     */

    public function attr___ALL(&$result, $subres)
    {
        if (!isset($result['_attr'])) {
            $result['_attr'] = array();
        }
        $result['_attr'] = array_merge($result['_attr'], $subres['value']);
    }

    /**
     * Parser rules and action for node 'Text'
     *  Rule: ->  <node Text> <rule>  /([\S\s]+(?=([^\S\r\n]\/\*!\*)))|[\S\s]+/ </rule>  <action _start> {
     * $result->_node = new \Smarty\Tool\Parser\Peg\Nodes\Text ($this, null);
     * } </action>  <action _all> {
     * $result['_node']['_text'] = $subres['_text'];
     * } </action> </node>  <-

     */

    public function Text___START(&$result)
    {
        $result['_node'] = new Text ($this, null);
    }

    public function Text___ALL(&$result, $subres)
    {
        $result['_node']->_text = $subres['_text'];
    }

    /**
     * Parser rules and action for node 'Parser'
     *  Rule: ->  <node Parser> <rule>  ..Header .._? '<pegparser' _ Name '>' Attribute* Node* .._? '</pegparser>' .._? End? </rule>  <action _start> {
     * $result['_node'] = new \Smarty\Tool\Parser\Peg\Nodes\ParserCompiler ($this, null);
     * } </action>  <action Attribute> {
     * if (!isset($result['_attr'])) {
     * $result['_attr'] = array();
     * }
     * $result['_attr'] = array_merge($result['_attr'], $subres['_attr']);
     * } </action>  <action Node> {
     * $subres['_nodedef']['rule']['_name'] = $subres['_nodedef']['name'];
     * ksort($subres['_nodedef']['rule']);
     * $result['_node']->nodes[$subres['_nodedef']['name']] = $subres['_nodedef']['rule'];
     * $result['_node']->comments[$subres['_nodedef']['name']] = $subres['_text'];
     * if (isset($subres['_attr'])) {
     * $result['_node']->attributes[$subres['_nodedef']['name']] = $subres['_attr'];
     * }
     * if (isset($subres['_nodedef']['actions'])) {
     * $result['_node']->actions[$subres['_nodedef']['name']] = $subres['_nodedef']['actions'];
     * }
     * } </action>  <action _finish> {
     * $i = 1;
     * } </action> </node>  <-

     */

    public function Parser___START(&$result)
    {
        $result['_node'] = new ParserCompiler ($this, null);
    }

    public function Parser_Attribute(&$result, $subres)
    {
        if (!isset($result['_attr'])) {
            $result['_attr'] = array();
        }
        $result['_attr'] = array_merge($result['_attr'], $subres['_attr']);
    }

    public function Parser_Node(&$result, $subres)
    {
        $subres['_nodedef']['rule']['_name'] = $subres['_nodedef']['name'];
        ksort($subres['_nodedef']['rule']);
        $result['_node']->nodes[$subres['_nodedef']['name']] = $subres['_nodedef']['rule'];
        $result['_node']->comments[$subres['_nodedef']['name']] = $subres['_text'];
        if (isset($subres['_attr'])) {
            $result['_node']->attributes[$subres['_nodedef']['name']] = $subres['_attr'];
        }
        if (isset($subres['_nodedef']['actions'])) {
            $result['_node']->actions[$subres['_nodedef']['name']] = $subres['_nodedef']['actions'];
        }
    }

    public function Parser___FINISH(&$result)
    {
        $i = 1;
    }

    /**
     * Parser rules and action for node 'Attribute'
     *  Rule: ->  <node Attribute> <rule>  .._? '<attribute>' attr '</attribute>' .._? </rule>  <action attr> {
     * $result['_attr'] = $subres['_attr'];
     * } </action>  <action _finish> {
     * $i=1;
     * } </action> </node>  <-

     */

    public function Attribute_attr(&$result, $subres)
    {
        $result['_attr'] = $subres['_attr'];
    }

    public function Attribute___FINISH(&$result)
    {
        $i = 1;
    }

    /**
     * Parser rules and action for node 'Node'
     *  Rule: ->  <node Node> <rule>  .._? /\s*\<node\s+(?<nodename>\w+)\>/ Attribute* Rule .Action* '</node>' .._? </rule>  <action _start> {
     * $i=1;
     * } </action>  <action Rule> {
     * $subres['_rule']['_name'] = $result['nodename'];
     * $result['_nodedef']['rule'] = array_merge($result['_nodedef']['rule'], $subres['_rule']);
     * } </action>  <action Action> {
     * if (!isset($result['_nodedef']['actions'])) {
     * $result['_nodedef']['actions'] = array();
     * }
     * $index = count($result['_nodedef']['actions']);
     * $result['_nodedef']['actions'][$index]['funcname'] = $subres['_matchres']['funcname'];
     * $result['_nodedef']['actions'][$index]['code'] = $subres['code'];
     * if (isset($subres['_matchres']['argument'])) {
     * $result['_nodedef']['actions'][$index]['argument'] = $subres['_matchres']['argument'];
     * }
     * unset($subres['_matchres']);
     * } </action>  <action nodename> {
     * $result['nodename'] = $subres['_matchres']['nodename'];
     * $result['_nodedef']['name'] = $result['nodename'];
     * $result['_nodedef']['rule'] = array();
     * unset($subres['_matchres']);
     * } </action>  <action Attribute> {
     * if (!isset($result['_nodedef']['rule']['_attr'])) {
     * $result['_nodedef']['rule']['_attr'] = array();
     * }
     * $result['_nodedef']['rule']['_attr'] = array_merge($result['_nodedef']['rule']['_attr'], $subres['_attr']);
     * } </action>  <action _finish> {
     * ksort($result['_nodedef']['rule']);
     * } </action> </node>  <-

     */

    public function Node___START(&$result)
    {
        $i = 1;
    }

    public function Node_Rule(&$result, $subres)
    {
        $subres['_rule']['_name'] = $result['nodename'];
        $result['_nodedef']['rule'] = array_merge($result['_nodedef']['rule'], $subres['_rule']);
    }

    public function Node_Action(&$result, $subres)
    {
        if (!isset($result['_nodedef']['actions'])) {
            $result['_nodedef']['actions'] = array();
        }
        $index = count($result['_nodedef']['actions']);
        $result['_nodedef']['actions'][$index]['funcname'] = $subres['_matchres']['funcname'];
        $result['_nodedef']['actions'][$index]['code'] = $subres['code'];
        if (isset($subres['_matchres']['argument'])) {
            $result['_nodedef']['actions'][$index]['argument'] = $subres['_matchres']['argument'];
        }
        unset($subres['_matchres']);
    }

    public function Node_nodename(&$result, $subres)
    {
        $result['nodename'] = $subres['_matchres']['nodename'];
        $result['_nodedef']['name'] = $result['nodename'];
        $result['_nodedef']['rule'] = array();
        unset($subres['_matchres']);
    }

    public function Node_Attribute(&$result, $subres)
    {
        if (!isset($result['_nodedef']['rule']['_attr'])) {
            $result['_nodedef']['rule']['_attr'] = array();
        }
        $result['_nodedef']['rule']['_attr'] = array_merge($result['_nodedef']['rule']['_attr'], $subres['_attr']);
    }

    public function Node___FINISH(&$result)
    {
        ksort($result['_nodedef']['rule']);
    }

    /**
     * Parser rules and action for node 'Rule'
     *  Rule: ->  <node Rule> <rule>  .._? '<rule>' .._? Sequence .._? '</rule>' .._? </rule>  <action Sequence> {
     * $result['_rule'] = $subres['_rule'];
     * } </action>  <action _finish> {
     * $i=1;
     * } </action> </node>  <-

     */

    public function Rule_Sequence(&$result, $subres)
    {
        $result['_rule'] = $subres['_rule'];
    }

    public function Rule___FINISH(&$result)
    {
        $i = 1;
    }

    /**
     * Parser rules and action for node 'Action'
     *  Rule: ->  <node Action> <rule>  .._? /\<action\s+(?<funcname>\w+)(\((?<argument>\w+)\))?\>/ .._? code:/(\{(?:(?>[^{}]+|(?R))*)?\})/ .._? '</action>' .._? </rule>  <action code> {
     * $result['code'] = $subres['_text'];
     * } </action>  <action _finish> {
     * $i=1;
     * } </action> </node>  <-

     */

    public function Action_code(&$result, $subres)
    {
        $result['code'] = $subres['_text'];
    }

    public function Action___FINISH(&$result)
    {
        $i = 1;
    }
    public function Action___START(&$result)
    {
        $i = 1;
    }

    /**
     * Parser rules and action for node 'PHP'
     *  Rule: ->  <node PHP> <rule>  /.[\n\t ]* / .b:/(\{|\}|[^\n\}\{]+)* / </rule>  <action b> {
     * $result['_text'] = trim($subres['_text']);
     * } </action> </node>  <-

     */

    public function PHP_b(&$result, $subres)
    {
        $result['_text'] = trim($subres['_text']);
    }

    /**
     * Parser rules and action for node 'Arguments'
     *  Rule: ->  <node Arguments> <rule>  '(' attr:Name (  '=' value:Name | value:Arguments )? (  ',' attr:Name (  '=' value:Name | value:Arguments )? )* ')' </rule>  <action _finish> {
     * $i=1;
     * } </action> </node>  <-

     */

    public function Arguments___FINISH(&$result)
    {
        $i = 1;
    }

    /**
     * Parser rules and action for node 'Option'
     *  Rule: ->  <node Option> <rule>  _? result:Token (  _? '|' _? option:Token )* </rule>  <action result> {
     * $result['_rule'] = $subres['_rule'];
     * } </action>  <action option> {
     * ksort($subres['_rule']);
     * if($result['_rule']['_type'] != 'option') {
     * ksort($result['_rule']);
     * $r = $result['_rule'];
     * $result['_rule'] = array('_type' => 'option', '_param' => array($r, $subres['_rule']));
     * } else {
     * $result['_rule']['_param'][] = $subres['_rule'];
     * }
     * } </action>  <action _finish> {
     * $i=1;
     * } </action> </node>  <-

     */

    public function Option_result(&$result, $subres)
    {
        $result['_rule'] = $subres['_rule'];
    }

    public function Option_option(&$result, $subres)
    {
        ksort($subres['_rule']);
        if (isset($result['_rule']['_type']) && $result['_rule']['_type'] != 'option') {
            ksort($result['_rule']);
            $r = $result['_rule'];
            $result['_rule'] = array('_type' => 'option', '_param' => array($r, $subres['_rule']));
        } else {
            $result['_rule']['_param'][] = $subres['_rule'];
        }
    }

    public function Option___FINISH(&$result)
    {
        $i = 1;
    }

    /**
     * Parser rules and action for node 'Sequence'
     *  Rule: ->  <node Sequence> <rule>  result:Option sequence:Option* </rule>  <action result> {
     * $result['_rule'] = $subres['_rule'];
     * } </action>  <action sequence> {
     * ksort($subres['_rule']);
     * if($result['_rule']['_type'] != 'sequence') {
     * ksort($result['_rule']);
     * $r = $result['_rule'];
     * $result['_rule'] = array('_type' => 'sequence', '_param' => array($r, $subres['_rule']));
     * } else {
     * $result['_rule']['_param'][] = $subres['_rule'];
     * }
     * } </action>  <action _finish> {
     * $i=1;
     * } </action> </node>  <-

     */

    public function Sequence_result(&$result, $subres)
    {
        $result['_rule'] = $subres['_rule'];
    }

    public function Sequence_sequence(&$result, $subres)
    {
        ksort($subres['_rule']);
        if (isset($result['_rule']['_type']) && $result['_rule']['_type'] != 'sequence') {
            ksort($result['_rule']);
            $r = $result['_rule'];
            $result['_rule'] = array('_type' => 'sequence', '_param' => array($r, $subres['_rule']));
        } else {
            $result['_rule']['_param'][] = $subres['_rule'];
        }
    }

    public function Sequence___FINISH(&$result)
    {
        $i = 1;
    }

    /**
     * Parser rules and action for node 'Token'
     *  Rule: ->  <node Token> <rule>  /((?<silent>\.+)|(?<pla>&)|(?<nla>\!))?((?<tag>\w+):)?/ (  /(?<rx>\G(\/|~|@|%|§)(((\\\\)*\\\2)|.*?(?=(\\|\2)))*\2)|((?<osp>_\?)|(?<wsp>_))|(?<node>\w+)|(?<literal>("[^"]*")|('[^']*'))|(\$(?<expression>\w+))/ | (  '(' .._? Sequence .._? ')' ) ) /((?<quest>\?)|(?<any>\*)|(?<must>\+?)|(\{(?<min>\d+)?,(?<max>\d+)?\}))?/ </rule>  <action _start> {
     * $result['_rule'] = array();
     * } </action>  <action Sequence> {
     * $result['_rule'] = $subres['_rule'];
     * } </action>  <action _finish> {
     * $mr = $result['_matchres'];
     * if (isset($mr['osp']) && !empty($mr['osp'])) {
     * $result['_rule']['_type'] = 'whitespace';
     * $result['_rule']['_param'] = true;
     * }
     * if (isset($mr['wsp']) && !empty($mr['wsp'])) {
     * $result['_rule']['_type'] = 'whitespace';
     * $result['_rule']['_param'] = false;
     * }
     * if (isset($mr['node']) && !empty($mr['node'])) {
     * $result['_rule']['_type'] = 'recurse';
     * $result['_rule']['_param'] = $mr['node'];
     * }
     * if (isset($mr['expression']) && !empty($mr['expression'])) {
     * $result['_rule']['_type'] = 'expression';
     * $result['_rule']['_param'] = $mr['expression'];
     * }
     * if (isset($mr['literal']) && !empty($mr['literal'])) {
     * $result['_rule']['_type'] = 'literal';
     * $result['_rule']['_param'] = trim($mr['literal'],"'\"");
     * }
     * if (isset($mr['rx']) && !empty($mr['rx'])) {
     * $result['_rule']['_type'] = 'rx';
     * $result['_rule']['_param'] = $mr['rx'];
     * }
     * if (isset($mr['silent']) && !empty($mr['silent'])) {
     * $result['_rule']['_silent'] = strlen($mr['silent']);
     * }
     * if (isset($mr['pla']) && !empty($mr['pla'])) {
     * $result['_rule']['_pla'] = true;
     * }
     * if (isset($mr['nla']) && !empty($mr['nla'])) {
     * $result['_rule']['_nla'] = true;
     * }
     * if (isset($mr['tag']) && !empty($mr['tag'])) {
     * $result['_rule']['_tag'] =$mr['tag'];
     * }
     * if (isset($mr['quest']) && !empty($mr['quest'])) {
     * $result['_rule']['_min'] = 0;
     * } elseif (isset($mr['any']) && !empty($mr['any'])) {
     * $result['_rule']['_min'] = 0;
     * $result['_rule']['_max'] = null;
     * } elseif (isset($mr['must']) && !empty($mr['must'])) {
     * $result['_rule']['_max'] = null;
     * } else {
     * if (isset($mr['min']) && !empty($mr['min'])) {
     * $result['_rule']['_min'] = $mr['min'];
     * $result['_rule']['_max'] = null;
     * }
     * if (isset($mr['max']) && !empty($mr['max'])) {
     * $result['_rule']['_max'] = $mr['max'];
     * }
     * }
     * $result['_matchres'] = array();
     * } </action> </node>  <-

     */

    public function Token___START(&$result)
    {
        $result['_rule'] = array();
    }

    public function Token_Sequence(&$result, $subres)
    {
        $result['_rule'] = $subres['_rule'];
    }

    public function Token___FINISH(&$result)
    {
        $mr = $result['_matchres'];
        if (isset($mr['osp']) && !empty($mr['osp'])) {
            $result['_rule']['_type'] = 'whitespace';
            $result['_rule']['_param'] = true;
        }
        if (isset($mr['wsp']) && !empty($mr['wsp'])) {
            $result['_rule']['_type'] = 'whitespace';
            $result['_rule']['_param'] = false;
        }
        if (isset($mr['node']) && !empty($mr['node'])) {
            $result['_rule']['_type'] = 'recurse';
            $result['_rule']['_param'] = $mr['node'];
        }
        if (isset($mr['expression']) && !empty($mr['expression'])) {
            $result['_rule']['_type'] = 'expression';
            $result['_rule']['_param'] = $mr['expression'];
        }
        if (isset($mr['literal']) && !empty($mr['literal'])) {
            $result['_rule']['_type'] = 'literal';
            $result['_rule']['_param'] = trim($mr['literal'], "'\"");
        }
        if (isset($mr['rx']) && !empty($mr['rx'])) {
            $result['_rule']['_type'] = 'rx';
            $result['_rule']['_param'] = $mr['rx'];
        }
        if (isset($mr['silent']) && !empty($mr['silent'])) {
            $result['_rule']['_silent'] = strlen($mr['silent']);
        }
        if (isset($mr['pla']) && !empty($mr['pla'])) {
            $result['_rule']['_pla'] = true;
        }
        if (isset($mr['nla']) && !empty($mr['nla'])) {
            $result['_rule']['_nla'] = true;
        }
        if (isset($mr['tag']) && !empty($mr['tag'])) {
            $result['_rule']['_tag'] = $mr['tag'];
        }
        if (isset($mr['quest']) && !empty($mr['quest'])) {
            $result['_rule']['_min'] = 0;
        } elseif (isset($mr['any']) && !empty($mr['any'])) {
            $result['_rule']['_min'] = 0;
            $result['_rule']['_max'] = null;
        } elseif (isset($mr['must']) && !empty($mr['must'])) {
            $result['_rule']['_max'] = null;
        } else {
            if (isset($mr['min']) && !empty($mr['min'])) {
                $result['_rule']['_min'] = $mr['min'];
                $result['_rule']['_max'] = null;
            }
            if (isset($mr['max']) && !empty($mr['max'])) {
                $result['_rule']['_max'] = $mr['max'];
            }
        }
        $result['_matchres'] = array();
    }

    /**
     * Parser rules and action for node 'File'
     *  Rule: ->  <node File> <rule>  (  .Text .Parser* )* </rule>  <action _start> {
     * $result['_nodes']= array();
     * } </action>  <action _all> {
     * if (isset($subres->_node)) {
     * $result['_nodes'][] = $subres['_node'];
     * }
     * } </action> </node>  <-

     */

    public function File___START(&$result)
    {
        $result['_nodes'] = array();
    }

    public function File___ALL(&$result, $subres)
    {
        if (isset($subres['_node'])) {
            $result['_nodes'][] = $subres['_node'];
        }
    }

    /**
     * @param $ruleName
     *
     * @return mixed
     * @throws \Smarty_Parser_Peg_Exception_NoRule
     */
    public function getRuleAsArray($ruleName)
    {
        if (isset($this->rules[$ruleName])) {
            $rule = $this->rules[$ruleName];
            $rule['_ruleParser'] = $this;
        } else {
            throw new \Smarty_Parser_Peg_Exception_NoRule($ruleName, 0, $this->context);
        }
        return $rule;
    }

    public function getMatchMethod($ruleName, $quiet = false) {
      return false;
    }


    /**
     * Constructor
     *
     * @param \Smarty_Compiler|\Smarty_Compiler_CompilerCore $compiler compiler object
     * @param \Smarty_Template_Context                       $context
     */
    function __construct(Compiler $compiler, Context $context)
    {
        $this->parser = $this;
        $this->context = $context;
        if (isset($this->rules)) {
            foreach ($this->rules as $name => $rule) {
                $this->rulePegParserArray[$name] = $this;
            }
        }
        if (isset($this->matchMethods)) {
            foreach ($this->matchMethods as $name => $rule) {
                $this->rulePegParserArray[$name] = $this;
            }
        }
        $this->trace = true;
        if ($this->trace) {
            $this->traceFile = fopen('php://output', 'w');
        }
    }

    /**
     * @param $infile
     *
     * @return mixed
     */
    public function compileFile($infile)
    {
        $this->filename = $infile;
        $this->filetime = filemtime($infile);
        $string = file_get_contents($infile);
        return $this->compile($string);
    }

    /**
     * @param $string
     *
     * @return mixed
     */
    public function compile($string)
    {
        $this->setSource($string);
        $result = $this->parser->parse('File');
        //        $result = $this->match_File();
        $output = '';
        foreach ($result['_nodes'] as $node) {
            $output .= $node->compile($this->filename, $this->filetime);
        }
        return $output;
    }

    /**
     * @param $string
     * @param $outfile
     */
    public function compileStringToFile($string, $outfile)
    {
        $string = $this->compile($string);
        file_put_contents($outfile, $string);
    }
}

