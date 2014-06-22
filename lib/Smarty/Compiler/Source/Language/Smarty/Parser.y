/**
* Smarty Internal Plugin Template Parser
*
* This is the template parser
* 
* 
* @package Smarty
* @subpackage Compiler
* @author Uwe Tews
*/
%stack_size 500
%name SMARTY_
%declare_class {/**
 * Smarty Internal Plugin Template_parser
 *
 * This is the template parser.
 * It is generated from the internal.template_parser.y file
 * @package Smarty
 * @subpackage Compiler
 * @author Uwe Tews
*/
class Smarty_Compiler_Source_Language_Smarty_Parser extends Smarty_Compiler_Parser
}
%include_class
{
    // states whether the parse was successful or not
    public  $prefix_number = 0;
    public  $block_nesting_level = 0;
    private $strip = false;
    private $text_is_php = false;
    private $is_xml = false;
    private $asp_tags = null;
    private $php_handling = null;
    private $security = null;

    function __construct($compiler, $context) {
       parent::__construct($compiler, $context);
        if ($this->security = isset($context->smarty->security_policy)) {
            $this->php_handling = $context->smarty->security_policy->php_handling;
        } else {
            $this->php_handling = $context->smarty->php_handling;
        }
       $this->asp_tags = (ini_get('asp_tags') != '0');
    }
    /**
     *
     */

}


%token_prefix SMARTY_

%parse_accept
{
    $this->successful = !$this->internalError;
    $this->internalError = false;
    $this->retvalue = $this->_retvalue;
    //echo $this->retvalue."\n\n";
}

%syntax_error
{
    $this->internalError = true;
    $this->yymajor = $yymajor;
    // expected token from parser
    $error_text = "<br> Syntax error :Unexpected '<b>{$this->lex->value}</b>'";
    if (count($this->yy_get_expected_tokens($yymajor)) <= 4) {
        foreach ($this->yy_get_expected_tokens($yymajor) as $token) {
            $exp_token = $this->yyTokenName[$token];
            if (isset($this->lex->smarty_token_names[$exp_token])) {
                // token type from lexer
                $expect[] = "'<b>{$this->lex->smarty_token_names[$exp_token]}</b>'";
            } else {
                // otherwise internal token name
                $expect[] = $this->yyTokenName[$token];
            }
        }
        $error_text .= ', expected one of: ' . implode(' , ', $expect) . '<br>';
    }
    $this->compiler->error($error_text, null, $this);
}

%stack_overflow
{
    $this->internalError = true;
    $this->compiler->error("Stack overflow in template parser");
}
%left VERT.
%left COLON.

//
// complete template
//
start(res) ::= template. {
    res = null;
}

//
// loop over template elements
//
                      // single template element
template       ::= template_element. {
}

                      // loop of elements
template       ::= template template_element. {
}

                      // empty template
template       ::= . 

//
// template elements
//
                      // Template init
template_element ::= TEMPLATEINIT(i). {
}

// tag link
template_element ::= smartytag(n). {
    if (n !== null) {
        $this->currentNode->addSubTree(n);
    }
}

// close tag
template_element ::= closetag(n). {
    if (n !== null) {
        $this->currentNode->addSubTree(n);
    }
}

// text element
template_element ::= text(t). {
    $this->currentNode->addSubTree(t);
}

                      // '<?php' tag
template_element ::= PHPSTARTTAG(st). {
    if ($this->php_handling == Smarty::PHP_PASSTHRU) {
        $this->compiler->template_code->php("echo '<?php';\n");
    } elseif ($this->php_handling == Smarty::PHP_QUOTE) {
        $this->compiler->template_code->php("echo '&lt;?php';\n");
    } elseif ($this->php_handling == Smarty::PHP_ALLOW) {
        if (!($this->context->smarty instanceof Smarty_Smarty2BC)) {
            $this->compiler->error (self::Err3);
        }
        $this->text_is_php = true;
    }
}

                      // '?>' tag
template_element ::= PHPENDTAG. {
    if ($this->is_xml) {
        $this->is_xml = false;
        $this->compiler->template_code->php("echo '?>';\n");
    } elseif ($this->php_handling == Smarty::PHP_PASSTHRU) {
        $this->compiler->template_code->php("echo '?>';\n");
    } elseif ($this->php_handling == Smarty::PHP_QUOTE) {
        $this->compiler->template_code->php("echo '?&gt;';\n");
    } elseif ($this->php_handling == Smarty::PHP_ALLOW) {
        $this->text_is_php = false;
    }
}

                      // '<%' tag
template_element ::= ASPSTARTTAG(st). {
    if ($this->php_handling == Smarty::PHP_PASSTHRU) {
        $this->compiler->template_code->php("echo '<%';\n");
    } elseif ($this->php_handling == Smarty::PHP_QUOTE) {
        $this->compiler->template_code->php("echo '&lt;%';\n");
    } elseif ($this->php_handling == Smarty::PHP_ALLOW) {
        if ($this->asp_tags) {
            if (!($this->compiler->template instanceof SmartyBC)) {
                $this->compiler->error (self::Err3);
            }
            $this->text_is_php = true;
        } else {
            $this->compiler->template_code->php("echo '<%';\n");
        }
    } elseif ($this->php_handling == Smarty::PHP_REMOVE) {
        if (!$this->asp_tags) {
            $this->compiler->template_code->php("echo '<%';\n");
        }
    }
}
  
                      // '%>' tag
template_element ::= ASPENDTAG(et). {
    if ($this->php_handling == Smarty::PHP_PASSTHRU) {
        $this->compiler->template_code->php("echo '%>';\n");
    } elseif ($this->php_handling == Smarty::PHP_QUOTE) {
        $this->compiler->template_code->php("echo '%&gt;';\n");
    } elseif ($this->php_handling == Smarty::PHP_ALLOW) {
        if ($this->asp_tags) {
            $this->text_is_php = false;
        } else {
            $this->compiler->template_code->php("echo '%>';\n");
        }
    } elseif ($this->php_handling == Smarty::PHP_REMOVE) {
        if (!$this->asp_tags) {
            $this->compiler->template_code->php("echo '%>';\n");
        }
    }
}

template_element ::= FAKEPHPSTARTTAG(o). {
    if ($this->strip) {
        $this->compiler->template_code->php('echo ')->string(preg_replace('![\t ]*[\r\n]+[\t ]*!', '', o))->raw(";\n");
    } else {
        $this->compiler->template_code->php('echo ')->string(o)->raw(";\n");
    }
}

                      // XML tag
template_element ::= XMLTAG. {
    $this->is_xml = true; 
    $this->compiler->template_code->php("echo '<?xml';\n");
}

                      // strip on
template_element ::= STRIPON(d). {
    $this->strip = true;
}
                      // strip off
template_element ::= STRIPOFF(d). {
    $this->strip = false;
}


// smarty tag
smartytag(res)  ::= tag(t) RDEL. {
    if (false === t->finishTag()) {
        res = null;
    } else {
        res = t;
    }
}

// print tag
tag(res)  ::= LDEL expr(e). {
        res = $this->instanceNode('print')->addSubTree(e);
}
// assign tag (statemen)
tag(res)           ::= LDEL statement(s).{
    res = s;
}

// standard tag
tag(res)           ::= LDEL ID(i).{
    res = $this->instanceTagNode(i)->initTag();
}


// tag attributes
tag(res)        ::= tag(t) variable(e). {
        res = t->addAttribute(null, e);
}
tag(res)        ::= tag(t) value(e). {
        res = t->addAttribute(null, e);
}
tag(res)        ::= tag(t) expr(e). {
        res = t->addAttribute(null, e);
}
tag(res)  ::= tag(t) ID(i) EQUALASSIGN expr(e). {
        res = t->addAttribute(i, e);
}
tag(res)  ::= tag(t) ID(i) EQUALASSIGN ID(i2). {
        res = t->addAttribute(i, $this->instanceNode('string')->setValue(i2, true));
}

tag(res)  ::= tag(t) NUMBER(n) EQUALASSIGN expr(e). {
        res = t->addAttribute(n, e);
}

tag(res)  ::= tag(t) NUMBER(n) EQUALASSIGN ID(i2). {
        res = t->addAttribute(n, $this->instanceNode('string')->setValue(i2, true));
}

tag(res)  ::= tag(t) ID(id). {
        res = t->addOption(id);
}

// tag modifier
tag(res)        ::= tag(t) modifier(m). {
        res = t->addModifier(m);
}

// tokens to be skipped
tag(res)        ::= tag(t) SPACE. {
        res = t;
}

// closing tag
closetag(res)           ::= LDELSLASH ID(i) RDEL. {
    res = $this->processCloseTag(i);
}

// Text node
text(res)       ::= TEXT(t). {
    res = $this->instanceNode('text')->addText(t);
}

text(res)       ::= text(t) TEXT(t1). {
    res = t->addText(t1);
}


statement(res)    ::= variable(v) EQUALASSIGN variable(e). {
        res = $this->instanceNode('statement')->setValue(v)->addSubTree(e);
}
statement(res)    ::= variable(v) EQUALASSIGN value(e). {
        res = $this->instanceNode('statement')->setValue(v)->addSubTree(e);
}
statement(res)    ::= variable(v) EQUALASSIGN expr(e). {
        res = $this->instanceNode('statement')->setValue(v)->addSubTree(e);
}


// operators

operator(res)   ::= CONDITION(c). {
    res = $this->instanceNode('condition')->setValue(c);
}

operator(res)   ::= MATH(m). {
    res = $this->instanceNode('math')->setValue(m);
}
operator(res)   ::= UNIMATH(m). {
    res = $this->instanceNode('unimath')->setValue(m);
}
operator(res)   ::= LOGOP(l). {
    res = $this->instanceNode('logop')->setValue(l);
}
operator(res)   ::= namedOperator(no) SPACE. {
    res = no;
}

// named operator
namedOperator(res) ::= SPACE ID(i). {
    res = $this->instanceNode('namedoperator')->addNameSegment(i);
}
namedOperator(res) ::= namedOperator(no) SPACE ID(i). {
    res = no->addNameSegment(i);
}


//
//  Static
//
static(res)      ::= varOrString(c) DOUBLECOLON chainElement(e).  {
    res = $this->instanceNode('static')->setValue(c)->addSubTree(e);
}
static(res)      ::= static(s) PTR chainElement(e). {
    res = s->addSubTree(e);
}


//
// object
//
object(res)      ::= variable(v) PTR chainElement(e). {
    res = $this->instanceNode('object')->setValue(v)->addSubTree(e);
}
object(res)      ::= object(o) PTR chainElement(e). {
    res = o->addSubTree(e);
}

chainElement(res)      ::= ID(i). {
    res = $this->instanceNode('string')->setValue(f, true);
}
chainElement(res)      ::= variable(v). {
    res = v;
}
chainElement(res)      ::=  method(m). {
    res = v;
}


//
// ternary
//
//ternary(res)        ::= OPENP expr(v) CLOSEP  QMARK DOLLAR ID(e1) COLON  expr(e2). {
//    res = v.' ? '. $this->compiler->compileVariable("'".e1."'") . ' : '.e2;
//}

//ternary(res)        ::= OPENP expr(v) CLOSEP  QMARK  expr(e1) COLON  expr(e2). {
//    res = v.' ? '.e1.' : '.e2;
//}

expr(res)       ::= fvalue(v1). {
    res = $this->instanceNode('expression')->addSubTree(v1);
}

expr(res)       ::= expr(e) operator(o) value(v). {
    res = e->addSubTree(array(o, v));
}

                 // value
uvalue(res)       ::= variable(v). {
    res = v;
}

                 // numeric
uvalue(res)       ::= NUMBER(n). {
    res = $this->instanceNode('number')->setValue(n);
}

                  // expression
uvalue(res)       ::= OPENP expr(e) CLOSEP. {
    res = $this->instanceNode('subexpression')->addSubTree(e);
}

uvalue(res)       ::= object(o). {
    res = o;
}

uvalue(res)       ::= static(s). {
    res = s;
}

value(res)       ::= modifier(m). {
    res = m;
}



value(res)       ::= OPENP ID(i) CLOSEP value(v). {
    res = $this->instanceNode('typecast')->setValue(i)->addSubTree(v);
}


value(res)       ::= array(a). {
    res = a;
}

                 // null
value(res)       ::= NULL. {
    res = $this->instanceNode('null');
}

                 // boolean
value(res)       ::= BOOLEAN(b). {
        if (preg_match('~^true$~i', b)) {
            res = $this->instanceNode('boolean')->setValue(true);
        } else {
            res = $this->instanceNode('boolean')->setValue(false);
        }
}


                  // singele quoted string
value(res)       ::= SINGLEQUOTESTRING(t). {
    res = $this->instanceNode('string')->setValue(t);
}

                  // double quoted string
value(res)       ::= doublequoted(s). {
    res = s;
}

value(res)       ::= function(f). {
    res = f;
}


value(res)      ::= UNILOG(l) uvalue(v). {
    res = $this->instanceNode('expression')->addSubTree(array($this->instanceNode('unilog')->setValue(l), v));
}

value(res)      ::= uvalue(v). {
    res = v;
}

fvalue(res)    ::= UNIMATH(m) uvalue(v). {
    res = $this->instanceNode('expression')->addSubTree(array($this->instanceNode('unimath')->setValue(m), v));
}
fvalue(res)    ::= uvalue(v). {
    res = v;
}
fvalue(res)    ::= value(v). {
    res = v;
}


//value(res)      ::= value(v1) namedoperator(o) value(v2). {
//
//}

//value(res)    ::= IDINCDEC(v). {
//    $len = strlen(v);
//    res = '$_scope->_tpl_vars->' . substr(v,1,$len-3) . '->value' . substr(v,$len-2);
//}

                  // static class access
//value(res)       ::= ID(c)static(s). {
//    if (!$this->security || isset($this->context->smarty->_registered['class'][c]) || $this->context->smarty->security_policy->isTrustedStaticClass(c, $this->compiler)) {
//        if (isset($this->context->smarty->_registered['class'][c])) {
//            res = $this->context->smarty->_registered['class'][c].s;
//        } else {
//            res = c.s;
//        }
//    } else {
//        $this->compiler->error ("static class '".c."' is undefined or not allowed by security setting");
//    }
//}

                  // namespace class access
//value(res)       ::= NAMESPACE(c) static(s). {
//    res = c.s;
//}

                  // name space constant
//value(res)       ::= NAMESPACE(c). {
//    res = c;
//}

//value(res)    ::= DOLLAR ID(i) static(s). {
//    res = $this->compiler->compileVariable(i).s;
//}

                  // Smarty tag
value(res)       ::= smartytag(st). {
    res = st;
}



//
// variables 
//
variable(res)    ::= DOLLAR. {
    res = $this->instanceNode('variable');
}
variable(res)    ::= HATCH. {
    res = $this->instanceNode('configvariable');
}
variable(res)    ::=  variable(v) ID(i). {
    res = v->addNameSegment($this->instanceNode('string')->setValue(i, true));
}
variable(res)    ::=  variable(v) variable(v1). {
    res = v->addNameSegment(v1);
}
variable(res)    ::= variable(v) LDEL expr(e) RDEL. {
   res = v->addNameSegment(e);
}
variable(res)    ::= variable(v) arrayindex(ai). {
    res = v->addArrayIndex(ai);
}
variable(res)    ::= object(o). {
    res = o;
}

variable(res)    ::= variable(v) OPENB ID(i) CLOSEB. {
    res = v->addArrayIndex($this->instanceNode('specialvariable', array('section', i, 'index')));
}
variable(res)    ::= variable(v) OPENB ID(i) DOT ID(i2) CLOSEB. {
    res = v->addArrayIndex($this->instanceNode('specialvariable', array('section', i, i2)));
}
variable(res)    ::= variable(v) AT ID(p). {
    res = v->setPropertyName(p);
}

//
//  array index
//
arrayindex(res)    ::= DOT ID(i). {
    res = $this->instanceNode('string')->setValue(i);
}
arrayindex(res)    ::= DOT NUMBER(n). {
    res = $this->instanceNode('number' ,n);
}
arrayindex(res)    ::= DOT LDEL expr(e) RDEL. {
    res = e;
}
arrayindex(res)    ::= DOT variable(v2). {

    res = v2;
}
arrayindex(res)    ::= OPENB variable(e) CLOSEB. {
    res = e;
}
arrayindex(res)    ::= OPENB value(e) CLOSEB. {
    res = e;
}
arrayindex(res)    ::= OPENB expr(e) CLOSEB. {
    res = e;
}




//
// function
//
function(res)       ::= parameter(f) CLOSEP. {
    res = f;
}
function_init(res)       ::= varOrString(n) OPENP. {
    res = $this->instanceNode('internal_function')->setValue(n);
}

//
// method
//
method(res)       ::= parameter(f) CLOSEP. {
    res = f;
}
method_init(res)       ::= varOrString(n) OPENP. {
    res = $this->instanceNode('method')->setValue(n);
}

// get function/method root node
parameter(res)       ::= function_init(f). {
    res = f;
}
parameter(res)       ::= method_init(f). {
    res = f;
}
// add parameter
parameter(res)       ::= parameter(f) expr(e). {
    res = f->addParameter(e);
}
// comma is noop
parameter(res)       ::= parameter(f) COMMA. {
    res = f;
}

//function(res)     ::= ID(f) OPENP params(p) CLOSEP. {
//    if (!$this->security || $this->context->smarty->security_policy->isTrustedPhpFunction(f, $this->compiler)) {
//        if (strcasecmp(f,'isset') === 0 || strcasecmp(f,'empty') === 0 || strcasecmp(f,'array') === 0 || is_callable(f)) {
//            $func_name = strtolower(f);
//            if ($func_name == 'isset') {
//                if (count(p) == 0) {
//                    $this->compiler->error ('Illegal number of paramer in "isset()"');
//                }
//                $par = implode(',',p);
//                preg_match('/\$_scope->_tpl_vars->([0-9]*[a-zA-Z_]\w*)(.*)/',$par,$match);
//                if (isset($match[1])) {
//                   $search = array('/\$_scope->_tpl_vars->([0-9]*[a-zA-Z_]\w*)/','/->value.*/');
//                    $replace = array('$this->_getVariable(\'\1\', null, false, false)','');
//                    $this->prefix_number++;
//                    $code = new Smarty_Compiler_Code();
//                    $code->iniTagCode($this->compiler);
//                    $code->php("\$_tmp{$this->prefix_number} = "  .preg_replace($search, $replace, $par) . ';')->newline();
//                    $this->compiler->prefix_code[] = $code;
//                    $isset_par = '$_tmp'.$this->prefix_number.$match[2];
//                } else {
//                    $this->prefix_number++;
//                    $code = new Smarty_Compiler_Code();
//                    $code->iniTagCode($this->compiler);
//                    $code->php("\$_tmp{$this->prefix_number} = " . $par . ';')->newline();
//                    $this->compiler->prefix_code[] = $code;
//                    $isset_par = '$_tmp'.$this->prefix_number;
//                }
//                res = f . "(". $isset_par .")";
//            } elseif (in_array($func_name,array('empty','reset','current','end','prev','next'))){
//                if (count(p) != 1) {
//                    $this->compiler->error ("Illegal number of paramer in \"{$func_name}\"");
//                }
//                res = $func_name.'('.p[0].')';
//            } else {
//                res = f . "(". implode(',',p) .")";
//            }
//        } else {
//            $this->compiler->error ("unknown function \"" . f . "\"");
//        }
//    }
//}

//
// namespace function
//
//function(res)     ::= NAMESPACE(f) OPENP params(p) CLOSEP. {
//    if (!$this->security || $this->context->smarty->security_policy->isTrustedPhpFunction(f, $this->compiler)) {
//        if (is_callable(f)) {
//            res = f . "(". implode(',',p) .")";
//        } else {
//            $this->compiler->error ("unknown function \"" . f . "\"");
//        }
//    }
//}


//
// modifier
//
modifier(res)  ::= value(v) VERT ID(i). {
    res = $this->instanceNode('modifier')->setValue(i)->addSubTree(v);
}

modifier(res)  ::= value(v) VERT AT ID(i). {
    res = $this->instanceNode('modifier')->setValue(i)->addSubTree(v);
}

modifier(res)  ::= modifier(m) COLON value(v). {
    res = m->addParameter(v);
}


//
// ARRAY element assignment
//
array(res)           ::=  OPENB arrayelements(a) CLOSEB.  {
    res = a;
}

arrayelements(res)   ::= . {
    res =  $this->instanceNode('array');
}
arrayelements(res)           ::=  arrayelements(a) expr(e).  {
    res = a->addSubTree(e);
}

arrayelements(res)           ::=  arrayelements(a) expr(e1) APTR expr(e2).  {
    res = a->addSubTree($this->instanceNode('arrayindex', e1, e2));
}

arrayelements(res)           ::=  arrayelements(a) ID(i) APTR expr(e2).  {
    res = a->addSubTree($this->instanceNode('arrayindex', $this->instanceNode('string')->setValue(i), e2));
}

arrayelements(res)           ::=  arrayelements(a) COMMA.  {
    res = a;
}



//
// double quoted strings
//
doublequoted(res) ::= QUOTE QUOTE. {
    res = $this->instanceNode('string');
}

doublequoted(res) ::= QUOTE. {
   res = $this->instanceNode('doublequote');
}

doublequoted(res) ::= doublequoted(s) QUOTE. {
   res = s;
}

doublequoted(res) ::= doublequoted(s) TEXT(t). {
   res = s->addSubTree($this->instanceNode('string')->setValue('"' . t . '"' , true, false));
}

doublequoted(res) ::= doublequoted(s) BACKTICK BACKTICK. {
   res = s;
}

doublequoted(res) ::= doublequoted(s) BACKTICK expr(e) BACKTICK. {
   res = s->addSubTree(e);
}

doublequoted(res) ::= doublequoted(s) smartytag(t). {
   res = s->addSubTree(t);
}

// variable or string token
varOrString(res)       ::= ID(i). {
    res = $this->instanceNode('string')->setValue(f, true);
}
varOrString(res)   ::= variable(f). {
     res = f;
}


