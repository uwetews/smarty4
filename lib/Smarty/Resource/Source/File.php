<?php

/**
 * Smarty Resource Source File Plugin
 *
 * @package Smarty\Resource\Source
 * @author  Uwe Tews
 * @author  Rodney Rehm
 */
namespace Smarty\Resource\Source;

use Smarty\Exception;
use Smarty\Context;

/**
 * Smarty Resource Source File Plugin
 * Implements the file system as resource for Smarty templates
 *
 * @package Smarty\Resource\Source
 */
class File //extends Smarty_Exception_Magic
{

    /**
     * Flag if source needs no compiler
     *
     * @var bool
     */
    public $uncompiled = false;

    /**
     * Flag if source needs to be always recompiled
     *
     * @var bool
     */
    public $recompiled = false;

    /**
     * This resource allows relative path
     *
     * @var true
     */
    public $_allowRelativePath = true;

    /**
     * populate Source Object with meta data from Resource
     *
     * @param Context $context
     */
    public function populate(Context $context)
    {
        $context->filepath = $this->buildFilepath($context);

        if ($context->filepath !== false) {
            if (is_object($context->smarty->securityPolicy)) {
                $context->smarty->securityPolicy->isTrustedResourceDir($context->filepath);
            }
            $context->uid = sha1($context->filepath);
        }
    }

    /**
     * build template filepath by traversing the template_dir array
     *
     * @param Context $context
     *
     * @throws DefaultHandlerNotCallable
     * @throws IllegalRelativePath
     * @throws RelativeSourceNotFound
     * @return string           fully qualified filepath
     */
    public function buildFilepath(Context $context)
    {
        $file = $context->name;

        // go relative to a given template?
        $_file_is_dotted = $file[0] == '.' && ($file[1] == '.' || $file[1] == '/' || $file[1] == '\\');
        if ($_file_is_dotted && isset($context->parent) &&
            ($context->parent->_usage == \Smarty::IS_SMARTY_TPL_CLONE || $context->parent->_usage == \Smarty::IS_TEMPLATE)
        ) {
            if (!isset($context->parent->context->handler->_allowRelativePath)) {
                throw new IllegalRelativePath($file, $context->parent->context->type);
            }
            // get absolute path relative to given template
            $file = dirname($context->parent->context->filepath) . '/' . $file;
            $_file_exact_match = true;
            // TODO  can this be remove?
            if (!preg_match('/^([\/\\\\]|[a-zA-Z]:[\/\\\\])/', $file)) {
                // the path gained from the parent template is relative to the current working directory
                // as expansions (like include_path) have already been done
                $file = getcwd() . '/' . $file;
            }
        } else {
            if (!isset($_file_exact_match) && ($file[0] == '/' || $file[0] == '\\' || ($file[1] == ':' && preg_match('/^([a-zA-Z]:[\/\\\\])/', $file)))) {
                // was absolute path
                $_file_exact_match = true;
            }
        }
        // process absolute path
        if (isset($_file_exact_match)) {
            if ($this->fileExists($file, $context)) {
                return $this->normalizePath($file);
            } else {
                if ($_file_is_dotted) {
                    throw new RelativeSourceNotFound($context->type, $file);
                }
            }
            return false;
        }

        // get source directories
        if ($context->_usage == \Smarty::IS_CONFIG) {
            $_directories = $context->getConfigDir();
        } else {
            $_directories = $context->getTemplateDir();
        }
        // template_dir index?
        if ($file[0] == '[' && preg_match('#^\[(?P<key>[^\]]+)\](?P<file>.+)$#', $file, $match)) {
            $_directory = null;
            // try string indexes
            if (isset($_directories[$match['key']])) {
                $_directory = $_directories[$match['key']];
            } elseif (is_numeric($match['key'])) {
                // try numeric index
                $match['key'] = (int) $match['key'];
                if (isset($_directories[$match['key']])) {
                    $_directory = $_directories[$match['key']];
                } else {
                    // try at location index
                    $keys = array_keys($_directories);
                    $_directory = $_directories[$keys[$match['key']]];
                }
            }

            if ($_directory) {
                $_file = substr($file, strpos($file, ']') + 1);
                $_filepath = $_directory . $_file;
                if ($this->fileExists($_filepath, $context)) {
                    $_filepath = $this->normalizePath($_filepath);
                    return $_filepath;
                }
            }
        }

        foreach ($_directories as $_directory) {
            $_filepath = $_directory . $file;
            if ($this->fileExists($_filepath, $context)) {
                if ($_file_is_dotted) {
                    return $this->normalizePath($_filepath);
                } else {
                    return $_filepath;
                }
            }
        }

        // try current working directory
        if ($this->fileExists($file, $context)) {
            return $this->normalizePath($file);
        }

        // no source file found check default handler
        if ($context->_usage == \Smarty::IS_CONFIG) {
            $_default_handler = $context->smarty->default_config_handler_func;
        } else {
            $_default_handler = $context->smarty->default_template_handler_func;
        }
        if ($_default_handler) {
            if (!is_callable($_default_handler)) {
                if ($context->smarty->_usage == \Smarty::IS_CONFIG) {
                    throw new DefaultHandlerNotCallable('config');
                } else {
                    throw new DefaultHandlerNotCallable('template');
                }
            }
            $_content = '';
            $_timestamp = null;
            $_filepath = call_user_func_array($_default_handler, array($context->type, $context->name, &$_content, &$_timestamp, $context->smarty));
            if (is_string($_filepath)) {
                if ($this->fileExists($_filepath, $context)) {
                    return $this->normalizePath($_filepath);
                }
                return false;
            } elseif ($_filepath === true) {
                $context->content = $_content;
                $context->timestamp = $_timestamp;
                $context->exists = true;
                return $_filepath;
            }
        }

        // give up
        return false;
    }

    /**
     * test is file exists and save timestamp
     *
     * @param  string  $file file name
     * @param  Context $context
     *
     * @return bool   true if file exists
     */
    public function fileExists($file, Context $context)
    {
        if ($context->exists = is_file($file)) {
            $context->timestamp = filemtime($file);
        }
        return $context->exists;
    }

    /**
     * Normalize Paths "foo/../bar" to "bar"
     *
     * @param  string $path path to normalize
     *
     * @return string  normalized path
     */
    function normalizePath($path)
    {
        if (strpos($path, '\\') !== false) {
            $path = str_replace('\\', '/', $path);
        }
        $out = array();
        foreach (explode('/', $path) as $i => $fold) {
            if ($fold == '' || $fold == '.') {
                continue;
            }
            if ($fold == '..' && $i > 0 && end($out) != '..') {
                array_pop($out);
            } else {
                $out[] = $fold;
            }
        }
        return ($path{0} == '/' ? '/' : '') . join('/', $out);
    }

    /**
     * read file content
     *
     * @param Context $context
     *
     * @return boolean false|string
     */
    public function getContent(Context $context)
    {
        if ($context->exists) {
            return file_get_contents($context->filepath);
        }
        return false;
    }

    /**
     * Determine basename for compiled filename
     *
     * @param Context $context
     *
     * @return string resource's basename
     */
    public function getBasename(Context $context)
    {
        $_file = $context->name;
        if (($_pos = strpos($_file, ']')) !== false) {
            $_file = substr($_file, $_pos + 1);
        }

        return basename($_file);
    }

    /**
     * return unique name for this resource
     *
     * @param \Smarty         $smarty           Smarty instance
     * @param  string         $templateResource resource_name to make unique
     * @param  \Smarty | null $parent
     *
     * @return string unique resource name
     */
    public function buildUniqueResourceName(\Smarty $smarty, $templateResource, $parent = null)
    {
        if ($parent == null) {
            return get_class($this) . '#' . $templateResource;
        } else {
            if ($parent->_usage == \Smarty::IS_SMARTY_TPL_CLONE && isset($parent->context->handler->_allowRelativePath)
                && $templateResource[0] == '.' && ($templateResource[1] == '.' || $templateResource[1] == '/' || $templateResource[1] == '\\')
            ) {
                // return key for relative path
                return $smarty->_joined_template_dir . '#' . dirname($parent->context->filepath) . '/' . $templateResource;
            } else {
                return false;
            }
        }
    }
}
