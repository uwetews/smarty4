<?php
namespace Smarty\Parser;

use Smarty\Parser;

/**
 * Class TraceBack
 *
 * @package Smarty\Parser
 */
class CompileCheck
{


    /**
     * Check if given Peg Parser for given name and node path is valid or must be recompiled
     *
     * @param  string     $name
     * @param  string     $ruleFilePrefix
     * @param null|string $parserFilePrefix
     * @param null|string $ruleFilePostfix
     * @param null|string $parserFilePostfix
     * @param bool        $force force compilation of rule parser
     *
     * @throws Exception\NoGeneratorClass
     * @return mixed
     */
    public function checkRule(Parser $parser, $name, $ruleFilePrefix, $parserFilePrefix = null, $ruleFilePostfix = null, $parserFilePostfix = null, $force = null)
    {
        $ruleFilePostfix = isset($ruleFilePostfix) ? $ruleFilePostfix : $parser->ruleFilePostfix;
        $ruleFilePath = $ruleFilePrefix . $name . $ruleFilePostfix;
        if (!is_file($ruleFilePath)) {
            return false;
        }
        $parserFilePrefix = isset($parserFilePrefix) ? $parserFilePrefix : $ruleFilePrefix;
        $parserFilePostfix = isset($parserFilePostfix) ? $parserFilePostfix : $parser->parserFilePostfix;
        $parserFilePath = $parserFilePrefix . $name . $parserFilePostfix;
        $parserMtime = 0;
        if (is_file($parserFilePath)) {
            $parserMtime = filemtime($parserFilePath);
        }
        $force = isset($force) ? $force : $parser->force_compile;
        if ($force || $parserMtime < filemtime($ruleFilePath)) {
            if ($parserMtime) {
                unlink($parserFilePath);
            }
            $class = $parser->generatorClass;
            if (class_exists($class)) {
                $compiler = new $class($parser->compiler, $parser->context);
                $parser->context->smarty->_writeFile($parserFilePath, $compiler->compileFile($ruleFilePath));
                $compiler->parser = null;
                $compiler->cleanup();
                unset($compiler);
                return true;
            } else {
                throw new Exception\NoGeneratorClass($class);
            }
        }
        return true;
    }

}