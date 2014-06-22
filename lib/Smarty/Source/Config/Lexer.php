<?php
/**
 * Smarty Config Lexer
 * This is the lexer to break the config file source into tokens
 *
 * @package    Smarty
 * @subpackage Config
 * @author     Uwe Tews
 */

/**
 * Smarty Compiler Config Lexer
 */
class Smarty_Source_Config_Lexer extends Smarty_Compiler_Lexer
{
    const BOM = 1;
    const START = 2;
    const VALUE = 3;
    const NAKED_STRING_VALUE = 4;
    const COMMENT = 5;
    const SECTION = 6;
    const TRIPPLE = 7;
    public $smarty_token_names = array( // Text for parser error messages
    );
    private $_yy_state = 1; // end function
    private $_yy_stack = array();

    /**
     * @param $compiler
     * @param $context
     */
    function __construct($compiler, $context)
    {
        parent::__construct($compiler, $context);
    }

    /**
     * @param $state
     */
    public function yybegin($state)
    {
        $this->_yy_state = $state;
        if ($this->yyTraceFILE) {
            fprintf($this->yyTraceFILE, "%sState set %s\n", $this->yyTracePrompt, isset($this->state_name[$this->_yy_state]) ? $this->state_name[$this->_yy_state] : $this->_yy_state);
        }
    }

    /**
     * @return bool
     * @throws Exception
     */
    public function yylex1()
    {
        $tokenMap = array(
            1 => 0,
            2 => 0,
        );
        if ($this->source_ptr >= ($this->mbstring_overload ? mb_strlen($this->source, 'latin1') : strlen($this->source))) {
            return false; // end of input
        }
        $yy_global_pattern = "/\G(\xEF\xBB\xBF|\xFE\xFF|\xFF\xFE)|\G([\s\S]?)/iS";

        do {
            if ($this->mbstring_overload ? preg_match($yy_global_pattern, mb_substr($this->source, $this->source_ptr, 2000000000, 'latin1'), $yymatches) : preg_match($yy_global_pattern, $this->source, $yymatches, null, $this->source_ptr)) {
                $yysubmatches = $yymatches;
                $yymatches = array_filter($yymatches, 'strlen'); // remove empty sub-patterns
                if (!count($yymatches)) {
                    throw new Exception('Error: lexing failed because a rule matched' .
                                        ' an empty string.  Input "' . substr($this->source,
                                                                              $this->source_ptr, 5) . '... state BOM');
                }
                next($yymatches); // skip global match
                $this->token = key($yymatches); // token number
                if ($tokenMap[$this->token]) {
                    // extract sub-patterns for passing to lex function
                    $yysubmatches = array_slice($yysubmatches, $this->token + 1,
                                                $tokenMap[$this->token]);
                } else {
                    $yysubmatches = array();
                }
                $this->value = current($yymatches); // token value
                $this->line = $this->current_line;
                $r = $this->{'yy_r1_' . $this->token}($yysubmatches);
                if ($r === null) {
                    $this->source_ptr += ($this->mbstring_overload ? mb_strlen($this->value, 'latin1') : strlen($this->value));
                    $this->current_line += substr_count($this->value, "\n");
                    // accept this token
                    return true;
                } elseif ($r === true) {
                    // we have changed state
                    // process this token in the new state
                    return $this->yylex();
                } elseif ($r === false) {
                    $this->source_ptr += ($this->mbstring_overload ? mb_strlen($this->value, 'latin1') : strlen($this->value));
                    $this->current_line += substr_count($this->value, "\n");
                    if ($this->source_ptr >= ($this->mbstring_overload ? mb_strlen($this->source, 'latin1') : strlen($this->source))) {
                        return false; // end of input
                    }
                    // skip this token
                    return $this->yylex();
                    //continue;
                }
            } else {
                throw new Exception('Unexpected input at line' . $this->line .
                                    ': ' . $this->source[$this->source_ptr]);
            }
            break;
        } while (true);
    } // end function

    /**
     * @return mixed
     */
    public function yylex()
    {
        return $this->{'yylex' . $this->_yy_state}();
    }

    /**
     * @param $yy_subpatterns
     *
     * @return bool
     */
    function yy_r1_1($yy_subpatterns)
    {

        $this->yypushstate(self::START);
        return false;
    }

    /**
     * @param $state
     */
    public function yypushstate($state)
    {
        if ($this->yyTraceFILE) {
            fprintf($this->yyTraceFILE, "%sState push %s\n", $this->yyTracePrompt, isset($this->state_name[$this->_yy_state]) ? $this->state_name[$this->_yy_state] : $this->_yy_state);
        }
        array_push($this->_yy_stack, $this->_yy_state);
        $this->_yy_state = $state;
        if ($this->yyTraceFILE) {
            fprintf($this->yyTraceFILE, "%snew State %s\n", $this->yyTracePrompt, isset($this->state_name[$this->_yy_state]) ? $this->state_name[$this->_yy_state] : $this->_yy_state);
        }
    }

    /**
     * @param $yy_subpatterns
     *
     * @return bool
     */
    function yy_r1_2($yy_subpatterns)
    {

        $this->yypushstate(self::START);
        return true;
    }

/**
     * @return bool
     * @throws Exception
     */
    public function yylex2()
    {
        $tokenMap = array(
            1 => 0,
            2 => 0,
            3 => 0,
            4 => 0,
            5 => 0,
            6 => 0,
            7 => 0,
            8 => 0,
        );
        if ($this->source_ptr >= ($this->mbstring_overload ? mb_strlen($this->source, 'latin1') : strlen($this->source))) {
            return false; // end of input
        }
        $yy_global_pattern = "/\G(#|;)|\G(\\[)|\G(\\])|\G(=)|\G([ \t\r]+)|\G(\n)|\G([0-9]*[a-zA-Z_]\\w*)|\G([\S\s])/iS";

        do {
            if ($this->mbstring_overload ? preg_match($yy_global_pattern, mb_substr($this->source, $this->source_ptr, 2000000000, 'latin1'), $yymatches) : preg_match($yy_global_pattern, $this->source, $yymatches, null, $this->source_ptr)) {
                $yysubmatches = $yymatches;
                $yymatches = array_filter($yymatches, 'strlen'); // remove empty sub-patterns
                if (!count($yymatches)) {
                    throw new Exception('Error: lexing failed because a rule matched' .
                                        ' an empty string.  Input "' . substr($this->source,
                                                                              $this->source_ptr, 5) . '... state START');
                }
                next($yymatches); // skip global match
                $this->token = key($yymatches); // token number
                if ($tokenMap[$this->token]) {
                    // extract sub-patterns for passing to lex function
                    $yysubmatches = array_slice($yysubmatches, $this->token + 1,
                                                $tokenMap[$this->token]);
                } else {
                    $yysubmatches = array();
                }
                $this->value = current($yymatches); // token value
                $this->line = $this->current_line;
                $r = $this->{'yy_r2_' . $this->token}($yysubmatches);
                if ($r === null) {
                    $this->source_ptr += ($this->mbstring_overload ? mb_strlen($this->value, 'latin1') : strlen($this->value));
                    $this->current_line += substr_count($this->value, "\n");
                    // accept this token
                    return true;
                } elseif ($r === true) {
                    // we have changed state
                    // process this token in the new state
                    return $this->yylex();
                } elseif ($r === false) {
                    $this->source_ptr += ($this->mbstring_overload ? mb_strlen($this->value, 'latin1') : strlen($this->value));
                    $this->current_line += substr_count($this->value, "\n");
                    if ($this->source_ptr >= ($this->mbstring_overload ? mb_strlen($this->source, 'latin1') : strlen($this->source))) {
                        return false; // end of input
                    }
                    // skip this token
                    return $this->yylex();
                    //continue;
                }
            } else {
                throw new Exception('Unexpected input at line' . $this->line .
                                    ': ' . $this->source[$this->source_ptr]);
            }
            break;
        } while (true);
    }

    /**
     * @param $yy_subpatterns
     */
    function yy_r2_1($yy_subpatterns)
    {

        $parser_class = $this->parser_class;
        $this->token = $parser_class::CONFIG_COMMENTSTART;
        $this->yypushstate(self::COMMENT);
    }

    /**
     * @param $yy_subpatterns
     */
    function yy_r2_2($yy_subpatterns)
    {

        $parser_class = $this->parser_class;
        $this->token = $parser_class::CONFIG_OPENB;
        $this->yypushstate(self::SECTION);
    }

    /**
     * @param $yy_subpatterns
     */
    function yy_r2_3($yy_subpatterns)
    {

        $parser_class = $this->parser_class;
        $this->token = $parser_class::CONFIG_CLOSEB;
    }

    /**
     * @param $yy_subpatterns
     */
    function yy_r2_4($yy_subpatterns)
    {

        $parser_class = $this->parser_class;
        $this->token = $parser_class::CONFIG_EQUAL;
        $this->yypushstate(self::VALUE);
    }

        /**
     * @param $yy_subpatterns
     *
     * @return bool
     */
    function yy_r2_5($yy_subpatterns)
    {

        return false;
    } // end function

    /**
     * @param $yy_subpatterns
     */
    function yy_r2_6($yy_subpatterns)
    {

        $parser_class = $this->parser_class;
        $this->token = $parser_class::CONFIG_NEWLINE;
    }

    /**
     * @param $yy_subpatterns
     */
    function yy_r2_7($yy_subpatterns)
    {

        $parser_class = $this->parser_class;
        $this->token = $parser_class::CONFIG_ID;
    }

    /**
     * @param $yy_subpatterns
     */
    function yy_r2_8($yy_subpatterns)
    {

        $parser_class = $this->parser_class;
        $this->token = $parser_class::CONFIG_OTHER;
    }

/**
     * @return bool
     * @throws Exception
     */
    public function yylex3()
    {
        $tokenMap = array(
            1 => 0,
            2 => 0,
            3 => 0,
            4 => 0,
            5 => 0,
            6 => 0,
            7 => 0,
            8 => 0,
            9 => 0,
        );
        if ($this->source_ptr >= ($this->mbstring_overload ? mb_strlen($this->source, 'latin1') : strlen($this->source))) {
            return false; // end of input
        }
        $yy_global_pattern = "/\G([ \t\r]+)|\G(\\d+\\.\\d+(?=[ \t\r]*[\n#;]))|\G(\\d+(?=[ \t\r]*[\n#;]))|\G(\"\"\")|\G('[^'\\\\]*(?:\\\\.[^'\\\\]*)*'(?=[ \t\r]*[\n#;]))|\G(\"[^\"\\\\]*(?:\\\\.[^\"\\\\]*)*\"(?=[ \t\r]*[\n#;]))|\G([a-zA-Z]+(?=[ \t\r]*[\n#;]))|\G([^\n]+?(?=[ \t\r]*\n))|\G(\n)/iS";

        do {
            if ($this->mbstring_overload ? preg_match($yy_global_pattern, mb_substr($this->source, $this->source_ptr, 2000000000, 'latin1'), $yymatches) : preg_match($yy_global_pattern, $this->source, $yymatches, null, $this->source_ptr)) {
                $yysubmatches = $yymatches;
                $yymatches = array_filter($yymatches, 'strlen'); // remove empty sub-patterns
                if (!count($yymatches)) {
                    throw new Exception('Error: lexing failed because a rule matched' .
                                        ' an empty string.  Input "' . substr($this->source,
                                                                              $this->source_ptr, 5) . '... state VALUE');
                }
                next($yymatches); // skip global match
                $this->token = key($yymatches); // token number
                if ($tokenMap[$this->token]) {
                    // extract sub-patterns for passing to lex function
                    $yysubmatches = array_slice($yysubmatches, $this->token + 1,
                                                $tokenMap[$this->token]);
                } else {
                    $yysubmatches = array();
                }
                $this->value = current($yymatches); // token value
                $this->line = $this->current_line;
                $r = $this->{'yy_r3_' . $this->token}($yysubmatches);
                if ($r === null) {
                    $this->source_ptr += ($this->mbstring_overload ? mb_strlen($this->value, 'latin1') : strlen($this->value));
                    $this->current_line += substr_count($this->value, "\n");
                    // accept this token
                    return true;
                } elseif ($r === true) {
                    // we have changed state
                    // process this token in the new state
                    return $this->yylex();
                } elseif ($r === false) {
                    $this->source_ptr += ($this->mbstring_overload ? mb_strlen($this->value, 'latin1') : strlen($this->value));
                    $this->current_line += substr_count($this->value, "\n");
                    if ($this->source_ptr >= ($this->mbstring_overload ? mb_strlen($this->source, 'latin1') : strlen($this->source))) {
                        return false; // end of input
                    }
                    // skip this token
                    return $this->yylex();
                    //continue;
                }
            } else {
                throw new Exception('Unexpected input at line' . $this->line .
                                    ': ' . $this->source[$this->source_ptr]);
            }
            break;
        } while (true);
    }

    /**
     * @param $yy_subpatterns
     *
     * @return bool
     */
    function yy_r3_1($yy_subpatterns)
    {

        return false;
    }

    /**
     * @param $yy_subpatterns
     */
    function yy_r3_2($yy_subpatterns)
    {

        $parser_class = $this->parser_class;
        $this->token = $parser_class::CONFIG_FLOAT;
        $this->yypopstate();
    }

    public function yypopstate()
    {
        if ($this->yyTraceFILE) {
            fprintf($this->yyTraceFILE, "%sState pop %s\n", $this->yyTracePrompt, isset($this->state_name[$this->_yy_state]) ? $this->state_name[$this->_yy_state] : $this->_yy_state);
        }
        $this->_yy_state = array_pop($this->_yy_stack);
        if ($this->yyTraceFILE) {
            fprintf($this->yyTraceFILE, "%snew State %s\n", $this->yyTracePrompt, isset($this->state_name[$this->_yy_state]) ? $this->state_name[$this->_yy_state] : $this->_yy_state);
        }
    }

    /**
     * @param $yy_subpatterns
     */
    function yy_r3_3($yy_subpatterns)
    {

        $parser_class = $this->parser_class;
        $this->token = $parser_class::CONFIG_INT;
        $this->yypopstate();
    }

    /**
     * @param $yy_subpatterns
     */
    function yy_r3_4($yy_subpatterns)
    {

        $parser_class = $this->parser_class;
        $this->token = $parser_class::CONFIG_TRIPPLE_QUOTES;
        $this->yypushstate(self::TRIPPLE);
    }

    /**
     * @param $yy_subpatterns
     */
    function yy_r3_5($yy_subpatterns)
    {

        $parser_class = $this->parser_class;
        $this->token = $parser_class::CONFIG_SINGLE_QUOTED_STRING;
        $this->yypopstate();
    }

        /**
     * @param $yy_subpatterns
     */
    function yy_r3_6($yy_subpatterns)
    {

        $parser_class = $this->parser_class;
        $this->token = $parser_class::CONFIG_DOUBLE_QUOTED_STRING;
        $this->yypopstate();
    } // end function

    /**
     * @param $yy_subpatterns
     *
     * @return bool
     */
    function yy_r3_7($yy_subpatterns)
    {

        if (!$this->context->smarty->config_booleanize || !in_array(strtolower($this->value), Array("true", "false", "on", "off", "yes", "no"))) {
            $this->yypopstate();
            $this->yypushstate(self::NAKED_STRING_VALUE);
            return true; //reprocess in new state
        } else {
            $parser_class = $this->parser_class;
            $this->token = $parser_class::CONFIG_BOOL;
            $this->yypopstate();
        }
    }

    /**
     * @param $yy_subpatterns
     */
    function yy_r3_8($yy_subpatterns)
    {

        $parser_class = $this->parser_class;
        $this->token = $parser_class::CONFIG_NAKED_STRING;
        $this->yypopstate();
    }

        /**
     * @param $yy_subpatterns
     */
    function yy_r3_9($yy_subpatterns)
    {

        $parser_class = $this->parser_class;
        $this->token = $parser_class::CONFIG_NAKED_STRING;
        $this->value = "";
        $this->yypopstate();
    } // end function

/**
     * @return bool
     * @throws Exception
     */
    public function yylex4()
    {
        $tokenMap = array(
            1 => 0,
        );
        if ($this->source_ptr >= ($this->mbstring_overload ? mb_strlen($this->source, 'latin1') : strlen($this->source))) {
            return false; // end of input
        }
        $yy_global_pattern = "/\G([^\n]+?(?=[ \t\r]*\n))/iS";

        do {
            if ($this->mbstring_overload ? preg_match($yy_global_pattern, mb_substr($this->source, $this->source_ptr, 2000000000, 'latin1'), $yymatches) : preg_match($yy_global_pattern, $this->source, $yymatches, null, $this->source_ptr)) {
                $yysubmatches = $yymatches;
                $yymatches = array_filter($yymatches, 'strlen'); // remove empty sub-patterns
                if (!count($yymatches)) {
                    throw new Exception('Error: lexing failed because a rule matched' .
                                        ' an empty string.  Input "' . substr($this->source,
                                                                              $this->source_ptr, 5) . '... state NAKED_STRING_VALUE');
                }
                next($yymatches); // skip global match
                $this->token = key($yymatches); // token number
                if ($tokenMap[$this->token]) {
                    // extract sub-patterns for passing to lex function
                    $yysubmatches = array_slice($yysubmatches, $this->token + 1,
                                                $tokenMap[$this->token]);
                } else {
                    $yysubmatches = array();
                }
                $this->value = current($yymatches); // token value
                $this->line = $this->current_line;
                $r = $this->{'yy_r4_' . $this->token}($yysubmatches);
                if ($r === null) {
                    $this->source_ptr += ($this->mbstring_overload ? mb_strlen($this->value, 'latin1') : strlen($this->value));
                    $this->current_line += substr_count($this->value, "\n");
                    // accept this token
                    return true;
                } elseif ($r === true) {
                    // we have changed state
                    // process this token in the new state
                    return $this->yylex();
                } elseif ($r === false) {
                    $this->source_ptr += ($this->mbstring_overload ? mb_strlen($this->value, 'latin1') : strlen($this->value));
                    $this->current_line += substr_count($this->value, "\n");
                    if ($this->source_ptr >= ($this->mbstring_overload ? mb_strlen($this->source, 'latin1') : strlen($this->source))) {
                        return false; // end of input
                    }
                    // skip this token
                    return $this->yylex();
                    //continue;
                }
            } else {
                throw new Exception('Unexpected input at line' . $this->line .
                                    ': ' . $this->source[$this->source_ptr]);
            }
            break;
        } while (true);
    }

    /**
     * @param $yy_subpatterns
     */
    function yy_r4_1($yy_subpatterns)
    {

        $parser_class = $this->parser_class;
        $this->token = $parser_class::CONFIG_NAKED_STRING;
        $this->yypopstate();
    }

/**
     * @return bool
     * @throws Exception
     */
    public function yylex5()
    {
        $tokenMap = array(
            1 => 0,
            2 => 0,
            3 => 0,
        );
        if ($this->source_ptr >= ($this->mbstring_overload ? mb_strlen($this->source, 'latin1') : strlen($this->source))) {
            return false; // end of input
        }
        $yy_global_pattern = "/\G([ \t\r]+)|\G([^\n]+?(?=[ \t\r]*\n))|\G(\n)/iS";

        do {
            if ($this->mbstring_overload ? preg_match($yy_global_pattern, mb_substr($this->source, $this->source_ptr, 2000000000, 'latin1'), $yymatches) : preg_match($yy_global_pattern, $this->source, $yymatches, null, $this->source_ptr)) {
                $yysubmatches = $yymatches;
                $yymatches = array_filter($yymatches, 'strlen'); // remove empty sub-patterns
                if (!count($yymatches)) {
                    throw new Exception('Error: lexing failed because a rule matched' .
                                        ' an empty string.  Input "' . substr($this->source,
                                                                              $this->source_ptr, 5) . '... state COMMENT');
                }
                next($yymatches); // skip global match
                $this->token = key($yymatches); // token number
                if ($tokenMap[$this->token]) {
                    // extract sub-patterns for passing to lex function
                    $yysubmatches = array_slice($yysubmatches, $this->token + 1,
                                                $tokenMap[$this->token]);
                } else {
                    $yysubmatches = array();
                }
                $this->value = current($yymatches); // token value
                $this->line = $this->current_line;
                $r = $this->{'yy_r5_' . $this->token}($yysubmatches);
                if ($r === null) {
                    $this->source_ptr += ($this->mbstring_overload ? mb_strlen($this->value, 'latin1') : strlen($this->value));
                    $this->current_line += substr_count($this->value, "\n");
                    // accept this token
                    return true;
                } elseif ($r === true) {
                    // we have changed state
                    // process this token in the new state
                    return $this->yylex();
                } elseif ($r === false) {
                    $this->source_ptr += ($this->mbstring_overload ? mb_strlen($this->value, 'latin1') : strlen($this->value));
                    $this->current_line += substr_count($this->value, "\n");
                    if ($this->source_ptr >= ($this->mbstring_overload ? mb_strlen($this->source, 'latin1') : strlen($this->source))) {
                        return false; // end of input
                    }
                    // skip this token
                    return $this->yylex();
                    //continue;
                }
            } else {
                throw new Exception('Unexpected input at line' . $this->line .
                                    ': ' . $this->source[$this->source_ptr]);
            }
            break;
        } while (true);
    }

    /**
     * @param $yy_subpatterns
     *
     * @return bool
     */
    function yy_r5_1($yy_subpatterns)
    {

        return false;
    }

        /**
     * @param $yy_subpatterns
     */
    function yy_r5_2($yy_subpatterns)
    {

        $parser_class = $this->parser_class;
        $this->token = $parser_class::CONFIG_NAKED_STRING;
    } // end function

    /**
     * @param $yy_subpatterns
     */
    function yy_r5_3($yy_subpatterns)
    {

        $parser_class = $this->parser_class;
        $this->token = $parser_class::CONFIG_NEWLINE;
        $this->yypopstate();
    }

/**
     * @return bool
     * @throws Exception
     */
    public function yylex6()
    {
        $tokenMap = array(
            1 => 0,
            2 => 0,
        );
        if ($this->source_ptr >= ($this->mbstring_overload ? mb_strlen($this->source, 'latin1') : strlen($this->source))) {
            return false; // end of input
        }
        $yy_global_pattern = "/\G(\\.)|\G(.*?(?=[\.=[\]\r\n]))/iS";

        do {
            if ($this->mbstring_overload ? preg_match($yy_global_pattern, mb_substr($this->source, $this->source_ptr, 2000000000, 'latin1'), $yymatches) : preg_match($yy_global_pattern, $this->source, $yymatches, null, $this->source_ptr)) {
                $yysubmatches = $yymatches;
                $yymatches = array_filter($yymatches, 'strlen'); // remove empty sub-patterns
                if (!count($yymatches)) {
                    throw new Exception('Error: lexing failed because a rule matched' .
                                        ' an empty string.  Input "' . substr($this->source,
                                                                              $this->source_ptr, 5) . '... state SECTION');
                }
                next($yymatches); // skip global match
                $this->token = key($yymatches); // token number
                if ($tokenMap[$this->token]) {
                    // extract sub-patterns for passing to lex function
                    $yysubmatches = array_slice($yysubmatches, $this->token + 1,
                                                $tokenMap[$this->token]);
                } else {
                    $yysubmatches = array();
                }
                $this->value = current($yymatches); // token value
                $this->line = $this->current_line;
                $r = $this->{'yy_r6_' . $this->token}($yysubmatches);
                if ($r === null) {
                    $this->source_ptr += ($this->mbstring_overload ? mb_strlen($this->value, 'latin1') : strlen($this->value));
                    $this->current_line += substr_count($this->value, "\n");
                    // accept this token
                    return true;
                } elseif ($r === true) {
                    // we have changed state
                    // process this token in the new state
                    return $this->yylex();
                } elseif ($r === false) {
                    $this->source_ptr += ($this->mbstring_overload ? mb_strlen($this->value, 'latin1') : strlen($this->value));
                    $this->current_line += substr_count($this->value, "\n");
                    if ($this->source_ptr >= ($this->mbstring_overload ? mb_strlen($this->source, 'latin1') : strlen($this->source))) {
                        return false; // end of input
                    }
                    // skip this token
                    return $this->yylex();
                    //continue;
                }
            } else {
                throw new Exception('Unexpected input at line' . $this->line .
                                    ': ' . $this->source[$this->source_ptr]);
            }
            break;
        } while (true);
    }

    /**
     * @param $yy_subpatterns
     */
    function yy_r6_1($yy_subpatterns)
    {

        $parser_class = $this->parser_class;
        $this->token = $parser_class::CONFIG_DOT;
    }

        /**
     * @param $yy_subpatterns
     */
    function yy_r6_2($yy_subpatterns)
    {

        $parser_class = $this->parser_class;
        $this->token = $parser_class::CONFIG_SECTION;
        $this->yypopstate();
    } // end function

/**
     * @return bool
     * @throws Exception
     */
    public function yylex7()
    {
        $tokenMap = array(
            1 => 0,
            2 => 0,
        );
        if ($this->source_ptr >= ($this->mbstring_overload ? mb_strlen($this->source, 'latin1') : strlen($this->source))) {
            return false; // end of input
        }
        $yy_global_pattern = "/\G(\"\"\"(?=[ \t\r]*[\n#;]))|\G([\S\s])/iS";

        do {
            if ($this->mbstring_overload ? preg_match($yy_global_pattern, mb_substr($this->source, $this->source_ptr, 2000000000, 'latin1'), $yymatches) : preg_match($yy_global_pattern, $this->source, $yymatches, null, $this->source_ptr)) {
                $yysubmatches = $yymatches;
                $yymatches = array_filter($yymatches, 'strlen'); // remove empty sub-patterns
                if (!count($yymatches)) {
                    throw new Exception('Error: lexing failed because a rule matched' .
                                        ' an empty string.  Input "' . substr($this->source,
                                                                              $this->source_ptr, 5) . '... state TRIPPLE');
                }
                next($yymatches); // skip global match
                $this->token = key($yymatches); // token number
                if ($tokenMap[$this->token]) {
                    // extract sub-patterns for passing to lex function
                    $yysubmatches = array_slice($yysubmatches, $this->token + 1,
                                                $tokenMap[$this->token]);
                } else {
                    $yysubmatches = array();
                }
                $this->value = current($yymatches); // token value
                $this->line = $this->current_line;
                $r = $this->{'yy_r7_' . $this->token}($yysubmatches);
                if ($r === null) {
                    $this->source_ptr += ($this->mbstring_overload ? mb_strlen($this->value, 'latin1') : strlen($this->value));
                    $this->current_line += substr_count($this->value, "\n");
                    // accept this token
                    return true;
                } elseif ($r === true) {
                    // we have changed state
                    // process this token in the new state
                    return $this->yylex();
                } elseif ($r === false) {
                    $this->source_ptr += ($this->mbstring_overload ? mb_strlen($this->value, 'latin1') : strlen($this->value));
                    $this->current_line += substr_count($this->value, "\n");
                    if ($this->source_ptr >= ($this->mbstring_overload ? mb_strlen($this->source, 'latin1') : strlen($this->source))) {
                        return false; // end of input
                    }
                    // skip this token
                    return $this->yylex();
                    //continue;
                }
            } else {
                throw new Exception('Unexpected input at line' . $this->line .
                                    ': ' . $this->source[$this->source_ptr]);
            }
            break;
        } while (true);
    }

    /**
     * @param $yy_subpatterns
     */
    function yy_r7_1($yy_subpatterns)
    {

        $parser_class = $this->parser_class;
        $this->token = $parser_class::CONFIG_TRIPPLE_QUOTES_END;
        $this->yypopstate();
        $this->yypushstate(self::START);
    }

    /**
     * @param $yy_subpatterns
     */
    function yy_r7_2($yy_subpatterns)
    {

        if ($this->mbstring_overload) {
            $to = mb_strlen($this->source, 'latin1');
        } else {
            $to = strlen($this->source);
        }
        preg_match("/\"\"\"[ \t\r]*[\n#;]/", $this->source, $match, PREG_OFFSET_CAPTURE, $this->source_ptr);
        if (isset($match[0][1])) {
            $to = $match[0][1];
        } else {
            $this->compiler->error("missing or misspelled literal closing tag");
        }
        if ($this->mbstring_overload) {
            $this->value = mb_substr($this->source, $this->source_ptr, $to - $this->source_ptr, 'latin1');
        } else {
            $this->value = substr($this->source, $this->source_ptr, $to - $this->source_ptr);
        }
        $parser_class = $this->parser_class;
        $this->token = $parser_class::CONFIG_TRIPPLE_TEXT;
    }
}
