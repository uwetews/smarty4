<?php
/**
 * Smarty Compiler Template Node Tag
 *
 * @package Smarty\Compiler
 * @author  Uwe Tews
 */

/**
 * Tag Node
 *
 * @package Smarty\Compiler
 */
namespace Smarty\Node;

use Smarty\Parser;
use Smarty\Parser\Token;
use Smarty\Node;

/**
 * Class Tag
 *
 * @package Smarty\Source\Node
 */
class Tag extends Node
{

    /**
     * Tag source string
     *
     * @var null|string
     */
    public $tag = null;

    /**
     * node group
     */
    public $nodeGroup = 'tag';

    /**
     * value type
     *
     * @var string
     */
    public $valueType = 'tag';

    /**
     * Node configuration section

     */

    /**
     * Array of required tag attribute names
     *
     * @var array
     */
    public $requiredAttributes = array();

    /**
     * Array of optional tag attribute names
     *
     * @var array
     */
    public $optionalAttributes = array();

    /**
     * Array of short tag attribute names
     *
     * @var array
     */
    public $shorttagAttributes = array();

    /**
     * Array of allowed tag options
     * nocache option is allowed by default for tags
     *
     * @var array
     */
    public $allowedOptions = array('nocache' => true,);

    /**
     * Array of assigned attributes
     *
     * @var array
     */
    public $tagAttributes = array();

    /**
     * Array of selected tag options
     *
     * @var array bool
     */
    public $tagOptions = array();

    /**
     * Array of prefix nodes
     *
     * @var Node [] array   of nodes
     */
    public $prefixNodes = array();

    /**
     * Array of postfix nodes
     *
     * @var Node [] array   of nodes
     */
    public $postfixNodes = array();

    /**
     * Flag true while accepts more shorttag attributes
     *
     * @var boolean
     */
    private  $acceptShortTags = false;

    /**
     * Number of shorttag attributes
     *
     * @var int
     */
    private $numberShortTags = 0;

    /**
     * Number of assigned shorttag attributes
     *
     * @var int
     */
    private $countShortTags = 0;

    /**
     * Constructor
     *
     * @param \Smarty\Parser       $parser parser context object
     */
    public function __construct(Parser $parser, $name = null)
    {
        parent::__construct($parser, $name);
        if (isset($this->nodeAttributes['required'])) {
            $this->requiredAttributes = $this->nodeAttributes['required'];
        }
        if (isset($this->nodeAttributes['optional'])) {
            $this->optionalAttributes = $this->nodeAttributes['optional'];
        }
        if (isset($this->nodeAttributes['shorttag'])) {
            $this->shorttagAttributes = $this->nodeAttributes['shorttag'];
            $this->acceptShortTags = true;
            $this->numberShortTags = count($this->shorttagAttributes);
        }
    }

    /**
     * Set tag attribute
     *
     * @param array $tagAttribute
     */
    public function setTagAttribute($tagAttribute) {
        $this->tagAttributes[$tagAttribute[0]] = $tagAttribute[1];
        $this->acceptShortTags = false;
    }

    /**
     * Set tag option
     *
     * @param string $tagOption
     */
    public function setTagOption($tagOption) {
        $this->tagOptions[$tagOption] = true;
    }

    /**
     * Get tag option
     *
     * @param string $tagOption
     *
     * @return bool
     */
    public function getTagOption($tagOption) {
        if (isset($this->tagOptions[$tagOption])) {
            return $this->tagOptions[$tagOption];
        } else {
            return false;
        }
    }
}