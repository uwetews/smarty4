<?php

/**
 * Smarty Context Object
 *
 * @package Smarty\Core
 * @author  Uwe Tews
 */

namespace Smarty\Template;

/**
 * Smarty Context Object
 * Storage for Source and Context properties
 *
 * @package Smarty\Core
 */
class Context //extends Smarty_Exception_Magic
{
    /**
     * key counter
     *
     * @var int
     */
    public static $_key_counter = 0;
    /**
     * Smarty object
     *
     * @var \Smarty
     */
    public $smarty = null;
    /**
     * Parent object
     *
     * @var object
     */
    public $parent = null;
    /**
     * resource filepath
     *
     * @var string| boolean false
     */
    public $filepath = false;
    /**
     * Resource Timestamp
     *
     * @var integer
     */
    public $timestamp = null;

    /**
     *  Source Resource specific properties
     */
    /**
     * Resource Existence
     *
     * @var boolean
     */
    public $exists = false;
    /**
     * usage of this resource
     *
     * @var mixed
     */
    public $_usage = \Smarty::IS_TEMPLATE;
    /**
     * Template name
     *
     * @var string
     */
    public $name = '';
    /**
     * Resource handler type
     *
     * @var string
     */
    public $type = 'file';
    /**
     * resource UID
     *
     * @var string
     */
    public $uid = '';
    /**
     * array of extends components
     *
     * @var array
     */
    public $components = array();
    /**
     * Object Source Resource handler
     *
     * @var object
     */
    public $handler = null;
    /**
     * caching mode
     *
     * @var int
     */
    public $caching = null;
    /**
     * compile id
     *
     * @var mixed
     */
    public $compileId = null;
    /**
     * cache id
     *
     * @var mixed
     */
    public $cacheId = null;
    /**
     * cache life time
     *
     * @var int
     */
    public $cacheLifetime = 0;
    /**
     * no_output_filter
     *
     * @var bool
     */
    public $no_output_filter = false;
    /**
     * scope_type
     *
     * @var int
     */
    public $scope_type = 0;
    /**
     * variable pairs
     *
     * @var array
     */
    public $data = null;
    /**
     * force cache
     *
     * @var bool
     */
    public $forceCaching = false;
    /**
     * storage for source content used by some resource
     *
     * @var string
     */
    public $content = null;
    /**
     * key number for this context object
     *
     * @var int
     */
    public $_key = null;
    /**
     * Source language name
     *
     * @var string
     */
    private $sourceLanguage = null;
    /**
     * Compiled language name
     *
     * @var string
     */
    private $targetLanguage = null;
    /**
     * compiler class name
     *
     * @varstring
     */
    private $compilerClass = null;
    /**
     * parser class name
     *
     * @var string
     */
    private $parserClass = null;
    /**
     * compiled class prefix
     *
     * @var string
     */
    private $compiledPrefix = null;
    /**
     * source class prefix
     *
     * @var string
     */
    private $sourcePrefix = null;

    /**
     * Create source object and populate is it source info
     *
     * @param Smarty $smarty smarty object
     * @param string $name   name part of template specification
     * @param string $type   type of source resource handler
     * @param object $parent
     * @param bool   $isConfig
     */
    public function __construct(\Smarty $smarty, $name, $type, $parent = null, $isConfig = false)
    {
        $this->forceCaching = $smarty->objectCaching;
        $this->smarty = $smarty;
        if ($isConfig) {
            $this->_usage = \Smarty::IS_CONFIG;
        }
        $this->name = $name;
        $this->type = $type;
        // get Resource handler
        if (isset(\Smarty::$_resource_cache[\Smarty::SOURCE][$type])) {
            $this->handler = \Smarty::$_resource_cache[\Smarty::SOURCE][$type];
        } else {
            $this->handler = $smarty->_loadResource(\Smarty::SOURCE, $type);
        }
        // parent needed in populate for relative template path
        $this->parent = $parent;
        $this->handler->populate($this);
        $this->_key = self::$_key_counter ++;
        return $this;
    }

    /**
     * wrapper to read source
     *
     * @return boolean false|string
     */
    public function getContent()
    {
        return $this->handler->getContent($this);
    }

    /**
     * @return int
     */
    public function getKey()
    {
        return $this->_key;
    }
    /**
     * @return array
     */
    public function compile()
    {
        $compiler = $this->smarty->instanceCompiler($this);
        return $this->compilerClass = isset($this->compilerClass) ? $this->compilerClass : (string) $this->smarty->smartyConfig->compiler->class;
    }

    /**
     * @return array
     */
    public function getCompilerClass()
    {
        return $this->compilerClass = isset($this->compilerClass) ? $this->compilerClass : (string) $this->smarty->smartyConfig->compiler->class;
    }

    /**
     * @return array
     */
    public function getParserClass()
    {
        return $this->parserClass = isset($this->parserClass) ? $this->parserClass : (string) $this->smarty->smartyConfig->parser->class;
    }

    /**
     * Get compiled class prefix
     *
     * @return string
     */
    public function getCompiledPrefix()
    {
        return isset($this->compiledPrefix) ? $this->compiledPrefix : ('Smarty\Compiler\Target\Language\\' . $this->getTargetLanguage() . '\\');
    }

    /**
     * Get compiled language name
     *
     * @return string
     */
    public function getTargetLanguage()
    {
        return $this->targetLanguage = isset($this->targetLanguage) ? $this->targetLanguage : $this->setTargetLanguage(isset($this->handler->targetLanguage) ? $this->handler->targetLanguage : (isset($this->smarty->targetLanguage) ? $this->smarty->targetLanguage : (string) $this->smarty->smartyConfig->targetLanguage));
    }

    /**
     * Set compiled language name
     *
     * @param string $targetLanguage
     *
     * @return string
     */
    public function setTargetLanguage($targetLanguage)
    {
        return $this->targetLanguage = ucfirst(strtolower($targetLanguage));
    }

    /**
     * Get source class prefix
     *
     * @return string
     */
    public function getSourcePrefix()
    {
        return isset($this->sourcePrefix) ? $this->sourcePrefix : ('Smarty\Compiler\Source\Language\\' . $this->getSourceLanguage() . '\\');
    }

    /**
     * Get source language name
     *
     * @return string
     */
    public function getSourceLanguage()
    {
        if (isset($this->sourceLanguage)) {
            return $this->sourceLanguage;
        } else {
            $language = ($this->_usage == \Smarty::IS_CONFIG ? 'config' : 'source') . 'Language';
            return $this->sourceLanguage = $this->setSourceLanguage(isset($this->handler->$language) ? $this->handler->$language : (isset($this->smarty->$language) ? $this->smarty->$language : (string) $this->smarty->smartyConfig->sourceLanguage));
        }
    }

    /**
     * Set source language name
     *
     * @param string $sourceLanguage
     *
     * @return string
     */
    public function setSourceLanguage($sourceLanguage)
    {
        return $this->sourceLanguage = ucfirst(strtolower($sourceLanguage));
    }

    /**
     * Get source language directory
     *
     * @return string
     */
    public function getSourceLanguageDir()
    {
        return __DIR__ . "/../Smarty/Parser/Source/Language/{$this->getSourceLanguage()}/";
    }
}
