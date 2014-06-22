<?php

/**
 * Created by PhpStorm.
 * User: Uwe Tews
 * Date: 17.11.13
 * Time: 08:13
 */
class Smarty_Compiler_Lexer extends \Smarty_Exception_Magic
{
    /**
     * Source text
     *
     * @var string
     */
    public $source = '';

    /**
     * Processed source bytes
     *
     * @var int
     */
    public $source_ptr = 0;

    /**
     * Token type
     *
     * @var int
     */
    public $token = null;

    /**
     * Token value
     *
     * @var string
     */
    public $value = '';

    /**
     * Source line
     *
     * @var int
     */
    public $line = 1;

    /**
     * Current source line
     *
     * @var int
     */
    public $current_line = 1;

    /**
     * Internal lexer state
     *
     * @var int
     */
    public $state = 1;

    /**
     * Compiler object
     *
     * @var object
     */
    public $compiler = null;

    /**
     * Context object
     *
     * @var Context
     */
    public $context = null;

    /**
     *Parser class name
     *
     * @var string
     */
    public $parser_class = '';

    /**
     * Laguage configuration object
     *
     * @var object
     */
    public $configuration = null;

    /**
     * mbstring overload flag
     *
     * @var int
     */
    public $mbstring_overload = 0;

    /**
     * Trace output file pointer
     *
     * @var file
     */
    public $yyTraceFILE = null;

    /**
     * Trace promt for line end
     *
     * @var string
     */
    public $yyTracePrompt = '<br>';

    /**
     * @param $compiler
     * @param $context
     */
    public function __construct($compiler, $context)
    {
        $this->compiler = $compiler;
        $this->context = $context;
        $this->mbstring_overload = ini_get('mbstring.func_overload') & 2;
    }

    public function PrintTrace()
    {
        $this->yyTraceFILE = fopen('php://output', 'w');
    }
}
