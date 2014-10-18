<?php
/**
 * Created by PhpStorm.
 * User: Uwe Tews
 * Date: 21.08.2014
 * Time: 23:44
 */

namespace Smarty\Parser\Source\Language\Smarty;

Use Smarty\Parser\Peg\PegParser;

class ParserExtension extends PegParser
{

    /**
     * Sub tags of current tag while parsing
     *
     * @var array
     */
    public $currentSubTags = array();

    /**
     * Stack of sub tags while processing nested tags
     *
     * @var array
     */
    public $subTagsStack = array();

    public $bodyStack = array();

    public $currentBody = null;

    public function pushBody($body) {
        $this->bodyStack[] = $this->currentBody;
        $this->currentBody = $body;
    }

    public function popBody() {
        $this->currentBody = array_pop($this->bodyStack);
    }

    /**
     * Lookup and call tag node parser
     *
     * @param array $nodeRes
     *
     * @return bool
     */
    public function tagDispatcher(&$nodeRes)
    {
        // a subtag shall not be processed by dispatcher but while parsing the original tag
        if (isset($this->currentSubTags[$nodeRes['tagname']])) {
            return false;
        }
        // Reset position to LDel
        $this->pos = $nodeRes['_startpos'];
        $this->line = $nodeRes['_lineno'];

        $tag = $nodeRes['tagname'];
        if (!isset($this->context->smarty->securityPolicy) || $this->context->smarty->securityPolicy->isTrustedTag($tag, $this)) {
            if (isset($this->knownNodes['Tag'][ucfirst($tag)])) {
                // instance build in tag node
                $ruleName = 'Tag' . ucfirst($tag);
                if (!$tagNode = $this->compiler->instanceNode('Tag\\' . $ruleName, $this->compiler->context, $this, $ruleName, true)) {
                    $tagNode = $this->compiler->instanceNode('Tag', $this->compiler->context, $this, $ruleName);
                }
            } else {
                if (preg_match("/{$this->Ldel}\/{$tag}{$this->Rdel}/", $this->source, $matches)) {
                    //  block processing
                    return false;
                } else {
                    //  function
                    $plugin_type = 'function';
                    $ruleName = 'TagPluginFunction';
                }
                // load plugin
                if ($function = $this->compiler->getPlugin($tag, $plugin_type)) {
                    // instance plugin tag node
                    if (!$tagNode = $this->compiler->instanceNode('Tag\\' . $ruleName, $this->compiler->context, $this, $ruleName, true)) {
                        $tagNode = $this->compiler->instanceNode('Tag', $this->compiler->context, $this, $ruleName);
                    }
                    $tagNode->pluginName = $tag;
                    $tagNode->pluginFunction = $function;
                    $tagNode->generatePluginParserRules();
                } else {
                    // plugin not found
                    return false;
                }
            }
            // remember subtags in case of block tags
            $subTags = $tagNode->getNodeAttribute('subtags');
            if ($subTags !== false) {
                $this->subTagsStack[] = $this->currentSubTags;
                $this->currentSubTags = $subTags;
            }
            // parse tag rule
            $error = array();
            $previous = $this->resultDefault;
            $previous['node'] = $tagNode;
            $nodeRes = $this->matchRule($previous, $ruleName, $error);
            if (!empty($error)) {
                var_dump($error);
            }
            if ($nodeRes) {
                $nodeRes['node']->setTraceInfo($nodeRes['_lineno'], $nodeRes['_text'], $nodeRes['_startpos'], $nodeRes['_endpos']);
                $valid = true;
            } else {
                $valid = false;
            }
            // restore sub tags
            if ($subTags !== false) {
                $this->currentSubTags = array_pop($this->subTagsStack);
            }
            return $valid;
        } else {
            // tag not allowed by security
            return false;
        }
    }

} 