<?php
/**
 * unused old compiler stuff
 */
/**
 * Compile Tag
 * This is a call back from the lexer/parser
 * It executes the required compile plugin for the Smarty tag
 *
 * @param  string $tag       tag name
 * @param  array  $args      array with tag attributes
 * @param  array  $parameter array with compilation parameter
 *
 * @return string compiled code
 */
public function compilexTag($tag, $args, $parameter = array())
{
    // $args contains the attributes parsed and compiled by the lexer/parser
    // assume that tag does compile into code, but creates no HTML output
    $this->has_code = true;
    $this->has_output = false;
    // log tag/attributes
    //TODO mit trace back
    if (isset($this->context->smarty->get_used_tags) && $this->context->smarty->get_used_tags) {
        $this->context->smarty->used_tags[] = array($tag, $args);
    }
    // check nocache option flag
    if (in_array("'nocache'", $args) || in_array(array('nocache' => 'true'), $args)
        || in_array(array('nocache' => '"true"'), $args) || in_array(array('nocache' => "'true'"), $args)
    ) {
        $this->tag_nocache = true;
    }
    // tags with _ like load_config need processing
    if (strpos($tag, '_') === false || strpos($tag, 'Internal_') === 0) {
        $_tag = $tag;
    } else {
        $_tag = '';
        $parts = explode('_', $tag);
        foreach ($parts as $part) {
            $_tag .= ucfirst($part);
        }
    }
    // compile the smarty tag (required compile classes to compile the tag are autoloaded)
    if (($_output = $this->compileCoreTag($_tag, $args, $parameter)) === false) {
        if (isset($this->_templateFunctions[$tag])) {
            // template defined by {template} tag
            $args['_attr']['name'] = "'" . $tag . "'";
            $_output = $this->compileCoreTag('Call', $args, $parameter);
        }
    }
    if ($_output !== false) {
        if ($_output !== true) {
            // did we get compiled code
            if ($this->has_code) {
                // return compiled code
                return $_output;
            }
        }
        // tag did not produce compiled code
        return '';
    } else {
        // map_named attributes
        if (isset($args['_attr'])) {
            foreach ($args['_attr'] as $attribute) {
                if (is_array($attribute)) {
                    $args = array_merge($args, $attribute);
                }
            }
        }
        // not an internal compiler tag
        if (strlen($tag) < 6 || substr($tag, - 5) != 'close') {
            // check if tag is a registered object
            if (isset($this->context->smarty->_registered['object'][$tag]) && isset($parameter['object_method'])) {
                $method = $parameter['object_method'];
                if (!in_array($method, $this->context->smarty->_registered['object'][$tag][3]) &&
                    (empty($this->context->smarty->_registered['object'][$tag][1]) || in_array($method, $this->context->smarty->_registered['object'][$tag][1]))
                ) {
                    return $this->compileCoreTag('Internal_ObjectFunction', $args, $parameter, $tag, $method);
                } elseif (in_array($method, $this->context->smarty->_registered['object'][$tag][3])) {
                    return $this->compileCoreTag('Internal_ObjectBlockFunction', $args, $parameter, $tag, $method);
                } else {
                    $this->error('unallowed method "' . $method . '" in registered object "' . $tag . '"', $this->lex->taglineno);
                }
            }
            // check if tag is registered
            foreach (array(Smarty::PLUGIN_COMPILER, Smarty::PLUGIN_FUNCTION, Smarty::PLUGIN_BLOCK) as $plugin_type) {
                if (isset($this->context->smarty->_registered['plugin'][$plugin_type][$tag])) {
                    // if compiler function plugin call it now
                    if ($plugin_type == Smarty::PLUGIN_COMPILER) {
                        return $this->compileCoreTag('Internal_PluginCompiler', $args, $parameter, $tag);
                    }
                    // compile registered function or block function
                    if ($plugin_type == Smarty::PLUGIN_FUNCTION || $plugin_type == Smarty::PLUGIN_BLOCK) {
                        return $this->compileCoreTag('Internal_Registered' . ucfirst($plugin_type), $args, $parameter, $tag);
                    }
                }
            }
            // check plugins from plugins folder
            foreach (\Smarty_Compiler::$plugin_search_order as $plugin_type) {
                if ($plugin_type == Smarty::PLUGIN_COMPILER && $this->context->smarty->_loadPlugin('\Smarty_compiler_' . $tag) && (!isset($this->context->smarty->securityPolicy) || $this->context->smarty->securityPolicy->isTrustedTag($tag, $this))) {
                    $plugin = 'smarty_compiler_' . $tag;
                    if (is_callable($plugin) || class_exists($plugin, false)) {
                        return $this->compileCoreTag('Internal_PluginCompiler', $args, $parameter, $tag);
                    }
                    $this->error("Plugin '{{$tag}...}' not callable", $this->lex->taglineno);
                } else {
                    if ($function = $this->getPlugin($tag, $plugin_type)) {
                        if (!isset($this->context->smarty->securityPolicy) || $this->context->smarty->securityPolicy->isTrustedTag($tag, $this)) {
                            return $this->compileCoreTag('Internal_Plugin' . ucfirst($plugin_type), $args, $parameter, $tag, $function);
                        }
                    }
                }
            }
            if (is_callable($this->context->smarty->default_plugin_handler_func)) {
                $found = false;
                // look for already resolved tags
                foreach (\Smarty_Compiler::$plugin_search_order as $plugin_type) {
                    if (isset($this->default_handler_plugins[$plugin_type][$tag])) {
                        $found = true;
                        break;
                    }
                }
                if (!$found) {
                    // call default handler
                    foreach (\Smarty_Compiler::$plugin_search_order as $plugin_type) {
                        if ($this->getPluginFromDefaultHandler($tag, $plugin_type)) {
                            $found = true;
                            break;
                        }
                    }
                }
                if ($found) {
                    // if compiler function plugin call it now
                    if ($plugin_type == Smarty::PLUGIN_COMPILER) {
                        return $this->compileCoreTag('Internal_PluginCompiler', $args, $parameter, $tag);
                    } else {
                        return $this->compileCoreTag('Internal_Registered' . ucfirst($plugin_type), $args, $parameter, $tag);
                    }
                }
            }
        } else {
            // compile closing tag of block function
            $base_tag = substr($tag, 0, - 5);
            // check if closing tag is a registered object
            if (isset($this->context->smarty->_registered['object'][$base_tag]) && isset($parameter['object_method'])) {
                $method = $parameter['object_method'];
                if (in_array($method, $this->context->smarty->_registered['object'][$base_tag][3])) {
                    return $this->compileCoreTag('Internal_ObjectBlockFunction', $args, $parameter, $tag, $method);
                } else {
                    $this->error('unallowed closing tag method "' . $method . '" in registered object "' . $base_tag . '"', $this->lex->taglineno);
                }
            }
            // registered compiler plugin ?
            if (isset($this->context->smarty->_registered['plugin'][Smarty::PLUGIN_COMPILER][$tag])) {
                return $this->compileCoreTag('Internal_PluginCompilerclose', $args, $parameter, $tag);
            }
            // registered block tag ?
            if (isset($this->context->smarty->_registered['plugin'][Smarty::PLUGIN_BLOCK][$base_tag]) || isset($this->default_handler_plugins[Smarty::PLUGIN_BLOCK][$base_tag])) {
                return $this->compileCoreTag('Internal_RegisteredBlock', $args, $parameter, $tag);
            }
            // block plugin?
            if ($function = $this->getPlugin($base_tag, Smarty::PLUGIN_BLOCK)) {
                return $this->compileCoreTag('Internal_PluginBlock', $args, $parameter, $tag, $function);
            }
            if ($this->context->smarty->_loadPlugin('smarty_compiler_' . $tag)) {
                return $this->compileCoreTag('Internal_PluginCompilerclose', $args, $parameter, $tag);
            }
            $this->error("Plugin '{{$tag}...}' not callable", $this->lex->taglineno);
        }
        $this->error("unknown tag '{{$tag}...}'", $this->lex->taglineno);
    }
    return false;
}

/**
 * lazy loads internal compile plugin for tag and calls the compile method
 * compile objects cached for reuse.
 * class name format:  \Smarty_Compiler_Php_NodeCompiler_Tag_TagName
 *
 * @param  string $tag    tag name
 * @param  array  $args   list of tag attributes
 * @param  mixed  $param1 optional parameter
 * @param  mixed  $param2 optional parameter
 * @param  mixed  $param3 optional parameter
 *
 * @return string compiled code
 */
public function compileCoreTag($tag, $args, $param1 = null, $param2 = null, $param3 = null)
{
    // re-use object if already exists
    if (isset(self::$_tag_objects[$tag])) {
        // compile this tag
        return self::$_tag_objects[$tag]->compile($args, $this, $param1, $param2, $param3);
    }
    // check if tag allowed by security
    if (!isset($this->context->smarty->securityPolicy) || $this->context->smarty->securityPolicy->isTrustedTag($tag, $this)) {
        $class = '\Smarty_Compiler_Php_NodeCompiler_Tag_' . $tag;
        if (!class_exists($class, true)) {
            if (substr($tag, - 5) == 'close') {
                $base_class = substr($tag, 0, - 5);
                if (!class_exists($base_class, true)) {
                    return false;
                }
            } else {
                return false;
            }
        }
        self::$_tag_objects[$tag] = new $class;
        // compile this tag
        return self::$_tag_objects[$tag]->compile($args, $this, $param1, $param2, $param3);
    }
    // no internal compile plugin for this tag
    return false;
}
/**
 * Get node compiler object
 *
 * @param Node|\Smarty_Compiler_Node $node
 *
 * @return object node compiler object
 */
public function getNodeCompilerCallback(Node $node)
{
    if (isset($node->base_tag)) {
        $nodeType = $node->base_tag;
    } elseif (isset($node->tag)) {
        $nodeType = $node->tag;
    } else {
        $nodeType = $node->nodeType;
    }
    $language = $node->language;
    // already in cache?
    if (isset($this->tag_cache[$language][$nodeType])) {
        return $this->tag_cache[$language][$nodeType];
    }
    // get compiler class postfix from node
    return $this->tag_cache[$language][$nodeType] = false;
}
/**
 * Return callback of template function for tag or false if not defined
 *
 * @param string $tag tag name
 *
 * @return bool
 */
public function getTemplateFunctionCB($tag)
{
    return false;
}

/**
 * Instance plugin tag node or false if not defined
 *
 * @param $tag
 *
 * @return string $tag   tag name
 */
public function instancePluginTagNode($tag)
{
    return false;
}

