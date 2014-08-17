<?php

/**
 * Smarty Internal Plugin
 *
 * @package Exception
 */
namespace Smarty;
/**
 * Smarty runtime exception class
 * loads template source and displays line where error did occur
 *
 * @package Exception
 */
class Exception extends \Exception
{

    public $lineno;
    public $filename;
    public $source;
    public $parser;
    protected $rawMessage;
    protected $previous;

    /**
     * Constructor.
     * Set both the line number and the filename to false to
     * disable automatic guessing of the original template name
     * and line number.
     * Set the line number to -1 to enable its automatic guessing.
     * Set the filename to null to enable its automatic guessing.
     * By default, automatic guessing is enabled.
     *
     * @param string    $message  The error message
     * @param integer   $lineno   The template line where the error occurred
     * @param null      $context
     * @param null      $parser
     * @param Exception $previous The previous exception
     *
     * @internal param null $lex
     * @internal param \Smarty_Resource_Source_File $source The template source object
     */
    public function __construct($message, $lineno = - 1, $context = null, $parser = null, \Exception $previous = null)
    {
        if (version_compare(PHP_VERSION, '5.3.0', '<')) {
            $this->previous = $previous;
            parent::__construct('');
        } else {
            parent::__construct('', 0, $previous);
        }

        $this->lineno = $lineno;
        $this->context = $context;
        $this->parser = $parser;

        if ($this->context !== null) {
            $this->filename = $this->context->type . ':' . $this->context->filepath;
        }

        if (- 1 === $this->lineno || null === $this->filename) {
            //           $this->guessTemplateInfo();
        }

        $this->rawMessage = $message;

        $this->updateRepr();
    }

    protected function updateRepr()
    {
        $this->message = $this->rawMessage;

        $dot = false;
        if ('.' === substr($this->message, - 1)) {
            $this->message = substr($this->message, 0, - 1);
            $dot = true;
        }

        if ($this->filename) {
            if (is_string($this->filename) || (is_object($this->filename) && method_exists($this->filename, '__toString'))) {
                $filename = sprintf('"%s"', $this->filename);
            } else {
                $filename = json_encode($this->filename);
            }
            $this->message .= sprintf(' in %s', $filename);
        }

        if ($this->lineno && $this->lineno >= 0) {
            $this->message .= sprintf(' at line %d', $this->lineno);
        }

        if ($dot) {
            $this->message .= '.<br>';
        }
        if ($this->parser) {
            $match = preg_split("/\n/", $this->parser->parser->source);
            $this->message .= ' "' . trim(preg_replace('![\t\r\n]+!', ' ', $match[$this->lineno - 1])) . '" ';
        }
    }

    /**
     * Gets the raw message.
     *
     * @return string The raw message
     */
    public function getRawMessage()
    {
        return $this->rawMessage;
    }

    /**
     * Gets the filename where the error occurred.
     *
     * @return string The filename
     */
    public function getTemplateFile()
    {
        return $this->filename;
    }

    /**
     * Sets the filename where the error occurred.
     *
     * @param string $filename The filename
     */
    public function setTemplateFile($filename)
    {
        $this->filename = $filename;

        $this->updateRepr();
    }

    /**
     * Gets the template line where the error occurred.
     *
     * @return integer The template line
     */
    public function getTemplateLine()
    {
        return $this->lineno;
    }

    /**
     * Sets the template line where the error occurred.
     *
     * @param integer $lineno The template line
     */
    public function setTemplateLine($lineno)
    {
        $this->lineno = $lineno;

        $this->updateRepr();
    }

    public function guess()
    {
        $this->guessTemplateInfo();
        $this->updateRepr();
    }

    /**
     * @return bool
     */
    protected function guessTemplateInfo()
    {
        $template = null;
        $trace_template = null;

        if (version_compare(phpversion(), '5.3.6', '>=')) {
            $backtrace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS | DEBUG_BACKTRACE_PROVIDE_OBJECT);
        } else {
            $backtrace = debug_backtrace();
        }

        foreach ($backtrace as $trace) {
            if (isset($trace['object']) && $trace['object'] instanceof Smarty_Template) {
                if (null === $this->filename || $this->filename == $trace['object']->context->filepath) {
                    $trace_template = $trace;
                }
            }
        }

        if (null != $trace_template) {
            $template = $trace_template['object'];
        }
        // update template filename
        if (null !== $template && null === $this->filename) {
            $this->filename = $template->source->filepath;
        }

        if (null === $template || $this->lineno > - 1) {
            return false;
        }

        $r = new ReflectionObject($template);
        $file = $r->getFileName();

        $exceptions = array($e = $this);
        while (($e instanceof self || method_exists($e, 'getPrevious')) && $e = $e->getPrevious()) {
            $exceptions[] = $e;
        }

        while ($e = array_pop($exceptions)) {
            $traces = $e->getTrace();
            while ($trace = array_shift($traces)) {
                if (!isset($trace['file']) || !isset($trace['line']) || $file != $trace['file']) {
                    continue;
                }

                foreach ($template->_getSourceInfo() as $codeLine => $templateLine) {
                    if ($codeLine <= $trace['line']) {
                        // update template line
                        $this->lineno = $templateLine;

                        return false;
                    }
                }
            }
        }
    }

    /**
     * For PHP < 5.3.0, provides access to the getPrevious() method.
     *
     * @param string $method    The method name
     * @param array  $arguments The parameters to be passed to the method
     *
     * @return Exception The previous exception or null
     * @throws BadMethodCallException
     */
    public function __call($method, $arguments)
    {
        if ('getprevious' == strtolower($method)) {
            return $this->previous;
        }

        throw new BadMethodCallException(sprintf('Method "Twig_Error::%s()" does not exist.', $method));
    }
}
