<?php
namespace Smarty;

use Smarty\Exception\ConfigNotFound;

/**
 * Class Config
 *
 * @package Smarty
 */
class Config extends CoreMethods
{
    /**
     * @var null|\Smarty
     */
    private $smarty = null;
    /**
     * Smarty default Xml configuration
     *
     * @var \DOMDocument
     */
    static $_smartyConfigXml = null;

    /**
     * Array of user Xml configuration
     *
     * @var array
     */
    protected $userConfigXml = array();

    protected $userActiveSections = array();
    /**
     * Array of user Xml configuration
     *
     * @var array
     */
    protected $contextConfigXml = array();

    /**
     * Parsed and merged configuration
     *
     * @var array
     */
    protected $configData = array();

    /**
     * Array with Smarty properties
     *
     * @var array
     */
    protected $properties = array();
    /**
     * Merged Xml configuration
     *
     * @var \DOMDocument
     */
    public $allXml = null;
    /**
     * xpath object
     *
     * @var \DOMXpath
     */
    public $xpath = null;

    /**
     * @var array
     */
    static $propertyMethod = array();

    protected $loadedSections = array();
    protected $loadedXmlFiles = array();
    protected $sourceConfig = array();

    /**
     * Create source object and populate is it source info
     *
     * @param         $userConfigXml
     * @param \Smarty $smarty
     *
     * @throws ConfigNotFound
     */
    public function __construct($userConfigXml, \Smarty $smarty = null)
    {
        $this->initInternals();
        $this->allXml = new \DOMDocument;
        $this->allXml->loadXML("<configFiles />");
        $this->xpath = new \DOMXpath($this->allXml);
        $this->smarty = $smarty;
        if (!isset(self::$_smartyConfigXml)) {
            self::$_smartyConfigXml = $this->_loadXml(dirname(__FILE__) . '/SmartyConfig.xml');
        }
        if ($userConfigXml) {
            $this->loadUserConfigXml($userConfigXml);
            foreach ($this->userConfigXml as $xml) {
                $this->addXml($xml);
            }
        }
        $this->addXml(self::$_smartyConfigXml);
//        $this->userActiveSections = $this->getActiveSectionNames($this->userConfigXml);
        //        $this->initPropertiesXml($this->xpath, array('init'), false, true);
//        $this->initPropertiesXml($this->xpath, array_merge(array('init'), $this->userActiveSections));
        $this->initPropertiesXml($this->xpath);
    }

    /**
     * @param $xml
     */
    private function addXml($xml)
    {
        $element = $xml->documentElement;
        $node = $this->allXml->importNode($element, true);
        $this->allXml->documentElement->appendChild($node);
    }


    /**
     * Parse property definitions
     *
     * @param array $config     configuration array
     * @param array $properties property information
     *
     * @return mixed
     */
    private function initPropertiesXml($xml, $activeSections = null, $overwrite = true, $getFromObj = false)
    {
        $prop = $this->getConfigPropertiesXml($xml, $activeSections);
        if ($prop) {
            foreach ($prop as $name => $value) {
                if ($overwrite || !isset($this->properties[$name])) {
                    if ($getFromObj && isset($this->smarty->$name)) {
                        $value = $this->smarty->$name;
                    }
                    if (false && isset(self::$propertyMethod[$name])) {
                        $this->setProperty($name, $value);
                    } else {
                        $this->properties[$name] = $value;
                    }
                }
            }
        }
    }

    /**
     * Parse property definitions
     *
     * @param array $config     configuration array
     * @param array $properties property information
     *
     * @return mixed
     */
    private function getConfigPropertiesXml($xml, $activeSections = null)
    {
        if (!empty($activeSections)) {
            $query = array();
            foreach ($activeSections as $section) {
                $query[] = "//configSection[@name='{$section}' and not(@disabled='true')]//properties//property";
            }
            $query = implode('|', $query);
        } else {
            $query = "//configSection[not(@disabled='true')]//properties//property";
        }
        $propValues = array();
            $xpath = $xml instanceof \DOMXpath ? $xml : new \DOMXpath($xml);
            $properties = $xpath->query($query);
            if ($properties->length) {
                $a = array();
                foreach ($properties as $node) {
                    foreach ($node->attributes as $attr) {
                        $a[$attr->nodeName] = $attr->nodeValue;
                    }
                    $propValues[$a['name']] = $a['value'];
                }
            }

        $prop = null;
        if (!empty($propValues)) {
            $c = '$prop = array(';
            foreach ($propValues as $name => $value) {
                $c .= "'{$name}'=>{$value},";
            }
            $c .= ');';
            $c = preg_replace(array("!>on,!", "!>off,!"), array('>true,', '>false,'), $c);
            eval ($c);
        }
        return $prop;
    }

    /**
     * Parse property definitions
     *
     * @param array $config     configuration array
     * @param array $properties property information
     *
     * @return mixed
     */
    private function initContextConfigData($xml, $name, $activeSections = null)
    {
        $xml = is_array($xml) ? $xml : array($xml);
        if (!empty($activeSections)) {
            $query = array();
            foreach ($activeSections as $section) {
                $query[] = "//configSection[@name='{$section}']//{$name}";
            }
            $query = implode('|', $query);
        } else {
            $query = "//{$name}";
        }
        foreach ($xml as $x) {
            $xpath = $x instanceof \DOMXpath ? $x : new \DOMXpath($x);
            $confItems = $xpath->query($query);
            if ($confItems->length) {
                foreach ($confItems as $item) {
                    if ($confScope = $item->getAttribute('scope')) {
                        if ($confScope == 'default') {
                            if (!isset($this->configData[$name]['default'])) {
                                $this->configData[$name]['default'] = $item->getAttribute('value');
                            }
                        } else {
                            $key = $item->getAttribute('key');
                            if (!isset($this->configData[$name][$confScope][$key])) {
                                $this->configData[$name][$confScope][$key] = $item->getAttribute('value');
                            }
                        }
                    }
                }
            }
        }
    }

    private function initInternals()
    {
        static $properties = array('templateDir'             => array(0 => './templates/'),
                                   'configDir'               => array(0 => './config/'),
                                   'compileDir'              => './templates_c/',
                                   '_joined_templateDir'     => './templates/',
                                   '_joined_compileDir'      => './config/',
                                   'compileDir'              => './templates_c/',
                                   'cacheDir'                => './cache/',
                                   'pluginsDir'              => array(0 => './plugins/'),
                                   'useSubDirs'              => false,
                                   'defaultResourceType'     => 'file',
                                   'defaultCompiledType'     => 'file',
                                   'defaultCacheType'        => 'file',
                                   'errorReporting'          => null,
                                   'debugging'               => false,
                                   'debuggingCtrl'           => 'NONE',
                                   'objectCaching'           => true,
                                   'developerMode'           => false,
                                   'enableTrace'             => false,
                                   'contextCaching'          => true,
                                   'allowAmbiguousResources' => false,
                                   'allowRelativePath'       => false,
                                   'disableCorePlugins'      => false,
                                   'templateResource'        => null,
                                   'filePerms'               => 0644,
                                   'dirPerms'                => 0771,
                                   'caching'                 => \Smarty::CACHING_OFF,
                                   'compileCheck'            => \Smarty::COMPILECHECK_ON,
                                   'charset'                 => 'UTF-8',
                                   'mbString'                => true,
        );
        foreach (array('templateDir' => array('set', 'add', 'get'),
                       'configDir'   => array('set', 'add', 'get'),
                       'pluginsDir'  => array('set', 'add', 'get'),
                       'compileDir'  => array('set'),
                       'cacheDir'    => array('set'),
                       'charset'     => array('set'),
                 ) as $prop => $val) {
            $method = ucfirst($prop);
            foreach ($val as $type) {
                self::$propertyMethod[$prop][$type] = array($this, $type . $method);
            }
        }
        if (true) {
            $this->properties = $properties;
            foreach ($properties as $prop => $value) {
                if (false && isset(self::$propertyMethod[$prop])) {
                    $this->setProperty($prop, $value);
                } else {
                    $this->properties[$prop] = $value;
                }
            }
        }
    }

    public function loadConfigSection($sections, $xml = null, $oldConfig = null, $xmlFile = null, $overwrite = false)
    {
        $xml = isset($xml) ? $xml : self::$_smartyConfigXml;
        $oldConf = ($hasOld = isset($oldConfig)) ? $oldConfig : $this->configData;
        $newSections = array();
        foreach ((array) $sections as $section) {
            if (!isset($this->loadedSections[$section])) {
                $newSections[] = $section;
                $this->loadedSections[$section] = true;
            }
        }
        if (!empty($newSections)) {
            if ($xmlFile !== null && !isset($this->loadedXmlFiles[$xmlFile])) {
                $xml = $this->_loadXml($xmlFile);
                $this->addXml($xml);
                $this->loadedXmlFiles[$xmlFile] = $xmlFile;
            }
            /**
             * $config = array();
             * $xpath = array();
             * foreach ($newSections as $key => $sec) {
             * $xpath[$key] = "//configSection[sectionName='{$sec}']";
             * }
             * $xpath = implode('|', $xpath);
             * */
            $xml = is_array($xml) ? $xml : array($xml);
            foreach ($xml as $x) {
                $this->initPropertiesXml($x, $newSections);
            }
            return;
        }
    }

    /**
     * Add template directory(s)
     *
     * @api
     *
     * @param  string|array $templateDir directory(s) of template sources
     * @param  string       $key         of the array element to assign the template dir to
     *
     * @return Smarty       current Smarty instance for chaining
     */
    public function addTemplateDir($templateDir, $key = null)
    {
        $this->_addDir($templateDir, $key, 'templateDir');
        return $this;
    }

    /**
     * Add  directory(s)
     *
     * @internal
     *
     * @param  string|array $dir     directory(s)
     * @param  string       $key     of the array element to assign the dir to
     * @param  string       $dirProp name of directory property
     * @param bool          $do_join true if joined directory property must be updated
     *
     * @return bool
     */
    private function _addDir($dir, $key = null, $dirProp, $do_join = true)
    {
        $prop = $this->getProperty($dirProp);
        // make sure we're dealing with an array
        $prop = (array) $prop;

        if (is_array($dir)) {
            foreach ($dir as $k => $v) {
                if (is_int($k)) {
                    // indexes are not merged but appended
                    $prop[] = $this->_checkDir($v);
                } else {
                    // string indexes are overridden
                    $prop[$k] = $this->_checkDir($v);
                }
            }
        } elseif ($key !== null) {
            // override directory at specified index
            $prop[$key] = $this->_checkDir($dir);
        } else {
            // append new directory
            $prop[] = $this->_checkDir($dir);
        }
        $this->setSaveProperty($dirProp, $prop);
        if ($do_join) {
            $this->setSaveProperty('_joined_' . $dirProp, join(DIRECTORY_SEPARATOR, $prop));
        }
        return false;
    }

    /**
     *  function to check directory path
     *
     * @param  string $path directory
     *
     * @return string           trimmed filepath
     */
    private function _checkDir($path)
    {
        return preg_replace('#(\w+)(/|\\\\){1,}#', '$1$2', rtrim($path, '/\\')) . '/';
    }

    /**
     * Get template directories
     *
     * @api
     *
     * @param  mixed $index of directory to get, null to get all
     *
     * @return array|string list of template directories, or directory of $index
     */
    public function getTemplateDir($index = null)
    {
        $templateDir = $this->getProperty('templateDir');
        if ($index !== null) {
            return isset($templateDir[$index]) ? $templateDir[$index] : null;
        }

        return (array) $templateDir;
    }

    /**
     * Set template directory
     *
     * @api
     *
     * @param  string|array $templateDir directory(s) of template sources
     *
     * @return Smarty       current Smarty instance for chaining
     */
    public function setTemplateDir($templateDir)
    {
        $this->_setDir($templateDir, 'templateDir');
        return $this;
    }

    /**
     * Set  directory
     *
     * @internal
     *
     * @param  string|array $dir     directory(s) of  sources
     * @param  string       $dirProp name of directory property
     * @param bool          $do_join true if joined directory property must be updated
     */
    private function _setDir($dir, $dirProp, $do_join = true)
    {
        $prop = array();
        foreach ((array) $dir as $k => $v) {
            $prop[$k] = $this->_checkDir($v);
        }
        $this->setSaveProperty($dirProp, $prop);
        if ($do_join) {
            $this->setSaveProperty('_joined_' . $dirProp, join(DIRECTORY_SEPARATOR, $prop));
        }
    }

    /**
     * Add config directory(s)
     *
     * @api
     *
     * @param  string|array $configDir directory(s) of config sources
     * @param  string       $key       of the array element to assign the config dir to
     *
     * @return Smarty       current Smarty instance for chaining
     */
    public function addConfigDir($configDir, $key = null)
    {
        $this->_addDir($configDir, $key, 'configDir', false);
        return $this;
    }

    /**
     * Get config directory
     *
     * @api
     *
     * @param  mixed $index of directory to get, null to get all
     *
     * @return array|string configuration directory
     */
    public function getConfigDir($index = null)
    {
        $configDir = $this->getProperty('configDir');
        if ($index !== null) {
            return isset($configDir[$index]) ? $configDir[$index] : null;
        }

        return (array) $configDir;
    }

    /**
     * Set config directory
     *
     * @api
     *
     * @param  array|string $configDir directory(s) of configuration sources
     *
     * @return Smarty       current Smarty instance for chaining
     */
    public function setConfigDir($configDir)
    {
        $this->_setDir($configDir, 'configDir', true);
        return $this;
    }

    /**
     * Adds directory of plugin files
     *
     * @api
     *
     * @param  string|array $pluginsDir plugin folder names
     *
     * @return Smarty       current Smarty instance for chaining
     */
    public function addPluginsDir($pluginsDir)
    {
        $this->_addDir($pluginsDir, null, 'pluginsDir', false);
        $pluginsDir = $this->getProperty('pluginsDir');
        $this->setSaveProperty('pluginsDir', array_unique($pluginsDir));
        return $this;
    }

    /**
     * Set plugins directory
     *
     * @api
     *
     * @param  string|array $pluginsDir directory(s) of plugins
     *
     * @return Smarty       current Smarty instance for chaining
     */
    public function setPluginsDir($pluginsDir)
    {
        $this->_setDir($pluginsDir, 'pluginsDir', false);
        return $this;
    }

    /**
     * Set compile directory
     *
     * @api
     *
     * @param  string $compileDir directory to store compiled templates in
     *
     * @return Smarty current Smarty instance for chaining
     */
    public function setCompileDir($compileDir)
    {
        $this->_setMutedDir($compileDir, 'compileDir');
        return $this;
    }

    /**
     * Set  muted directory
     *
     * @internal
     *
     * @param  string $dir     directory
     * @param  string $dirProp name of directory property
     *
     * @return bool
     */
    private function _setMutedDir($dir, $dirProp)
    {
        $prop = $this->_checkDir($dir);
        $this->setSaveProperty($dirProp, $prop);
        if (!isset(\Smarty::$_muted_directories[$prop])) {
            \Smarty::$_muted_directories[$prop] = null;
        }

        return false;
    }

    /**
     * Set cache directory
     *
     * @api
     *
     * @param  string $cacheDir directory to store cached templates in
     *
     * @return Smarty current Smarty instance for chaining
     */
    public function setCacheDir($cacheDir)
    {
        $this->_setMutedDir($cacheDir, 'cacheDir');
        return $this;
    }

    /**
     * Set property value
     *
     * @param string $property  name
     * @param mixed  $value
     * @param bool   $overwrite if set (default) overwrite existing value
     */
    public function setProperty($property, $value, $overwrite = true)
    {
        if ($overwrite || !isset($this->properties[$property])) {
            if (isset(self::$propertyMethod[$property]['set'])) {
                $set = self::$propertyMethod[$property]['set'][1];
                if (is_array($value) && count($value) > 1 && isset(self::$propertyMethod[$property]['add'])) {
                    $add = self::$propertyMethod[$property]['add'][1];
                    $first = true;
                    foreach ($value as $value) {
                        if ($first) {
                            $this->$set($value);
                            $first = false;
                        } else {
                            $this->$add($value);
                        }
                    }
                    return;
                }
                $this->$set($value);
                return;
            }
            $this->properties[$property] = $value;
        }
    }

    /**
     * @param $property
     * @param $value
     */
    public function setSaveProperty($property, $value)
    {
        $this->properties[$property] = $value;
    }

    /**
     * @param $property
     *
     * @return null
     */
    public function getProperty($property)
    {
        return isset($this->properties[$property]) ? $this->properties[$property] : null;
    }

    /**
     * @param $charset
     */
    public function setCharset($charset)
    {
        $this->setSaveProperty('charset', $charset);
        if (is_callable('mb_internal_encoding')) {
            mb_internal_encoding($charset);
            $mbString = true;
        } else {
            $mbString = false;
        }
        $this->setSaveProperty('mbString', $mbString);
    }

    /**
     * Load Xml configuration file
     *
     * @param string $file XML file name
     *
     * @throws Exception\ConfigNotFound
     * @throws Exception\ConfigXmlError
     * @return \SimpleXMLElement
     */
    public function _loadXml($file)
    {
        if (is_file($file)) {
            $configXml = new \DOMDocument;
            $loaded = $configXml->load($file, LIBXML_NOBLANKS);
            if (!$loaded) {
                throw new Exception\ConfigXmlError($file);
            }
        } else {
            throw new Exception\ConfigNotFound($file);
        }
        return $configXml;
    }

    /**
     * Load user configuration XML file(s) and set properties
     *
     * @param  array|string $userConfigXml single or array of files
     * @param bool          $overwrite     if true replace old configuration
     *
     * @throws ConfigNotFound
     */
    public function loadUserConfigXml($userConfigXml, $overwrite = false)
    {
        if ($overwrite) {
            $this->userConfigXml = array();
        }
        foreach ((array) $userConfigXml as $xmlFile) {
            $this->userConfigXml[] = $file = $this->_loadXml($xmlFile);
        }
    }

    /**
     * Run a method while parsing the configuration
     *
     * @param array $config    configuration array
     * @param array $methodDef array with method definitions
     *
     * @return array
     */
    private function configRunMethod($config, $methodDef)
    {
        return $config;
    }

    /**
     * Register a special property method like getter/setter
     *
     * @param string $method name
     * @param array  $callback
     **/
    public function registerPropertyMethod($method, $callback)
    {
        self::$propertyMethod[$method] = $callback;
    }

    /**
     * @param $extensions
     */
    private function configRegisterExtensions($extensions)
    {
        foreach ($extensions as $function => $extension) {
            switch ($function) {
                case 'loadExtension':
                    $this->loadExtension($extension['parameter']);
                    break;
                case 'runExtension':
                    $objectName = isset($extension['objectName']) ? $extension['objectName'] : null;
                    $className = isset($extension['className']) ? $extension['className'] : null;
                    $availability = isset($extension['availability']) ? $extension['availability'] : null;
                    $methods = isset($extension['methods']) ? $extension['methods'] : null;
                    $sharedObj = isset($extension['sharedObj']) ? $extension['sharedObj'] : null;
                    $overwrite = isset($extension['overwrite']) ? $extension['overwrite'] : null;
                    $this->loadExtension($objectName, $className, $availability, $methods, $sharedObj, $overwrite);
                    break;
                default:
                    //TODO Exception
            }
        }
    }

    /**
     * @param         $xpath
     * @param Context $context
     * @param null    $xml
     * @param array   $config
     *
     * @return bool
     */
    public function _getConfigDataByContext($name)
    {
        if (!isset($this->configData[$name])) {
            $this->initContextConfigData($this->xpath, $name);
        }
        $config = $this->configData[$name];
        $value = isset($config['default']) ? $config['default'] : false;
        $ext = pathinfo($this->name, PATHINFO_EXTENSION);
        if (isset($config['fileExtension'][$ext])) {
            $value = $config['fileExtension'][$ext];
        } elseif (isset($config['resource'][$this->type])) {
            $value = $config['resource'][$this->type];
        }
        return $value;
    }

    public function _getConfigData($name)
    {
        $value = $this->configData[$name];
        return $value;
    }
}
