<?php
/**
 * Created by PhpStorm.
 * User: Uwe Tews
 * Date: 11.09.2014
 * Time: 23:08
 */

namespace Smarty;
use Smarty\Exception\Magic;

/**
 * Class CoreMethods
 *
 * @package Smarty
 */
class CoreMethods extends Magic {

    /**
     * Callback for all extension methods for this class
     *
     * @var array
     */
    public $extensions = array();

    public function _absolutePath($path, $baseDir) {
        if($path[0] == '.') {
            $path = $baseDir . $path;
        }
        return $path;
    }

    /**
     * @param $objectName
     *
     * @throws Exception\MissingClass
     */
    public function loadExtension($name, $className = null, $availability = null, $methods = null, $sharedObj = false, $overwrite = false){
        if (is_array($name)){
            $a = $name;
            while (list($key, $val) = each($a)) {
                $$key = $val;
            }
        }
        if ($className !== null) {
            $this->registerExtension($name, $className, $availability, $methods, $sharedObj, $overwrite);
        }
       $myClass = get_class($this);
       if (isset(\Smarty::$allExtensions[$myClass][$name])) {
           $extObj = \Smarty::$allExtensions[$myClass][$name];
           if ($extObj['sharedObj'] && isset(\Smarty::$sharedExtensions[$name])) {
              $this->extensions = array_merge($this->extensions, \Smarty::$sharedExtensions[$name]['callbacks']);
            } elseif ($this->classExists($extObj['className'],'Extension loader')) {
               $obj = new $extObj['className'];
               $methods = (isset($extObj['methods'])) ? $extObj['methods'] : get_class_methods($obj);
               foreach ($methods as $method) {
                   $callbacks[$method] = array($obj, $method);
               }
               $this->extensions = array_merge($this->extensions, $callbacks);
               if ($extObj['sharedObj']) {
                   \Smarty::$sharedExtensions[$name]['callbacks'] = $callbacks;
               }
           }
       } else {
           //TODO exception
       }
    }

    /**
     * @param      $className
     * @param      $name
     * @param      $availability
     * @param null $methods
     * @param bool $sharedObj
     * @param bool $overwrite
     */
    public function registerExtension ($name, $className, $availability, $methods = null, $sharedObj = false, $overwrite = false){
        if (is_array($name)){
            $a = $name;
            while (list($key, $val) = each($a)) {
                $$key = $val;
            }
        }
        foreach ((array)$availability as $targetClass) {
            if ($overwrite || !isset(\Smarty::$allExtensions[$targetClass][$name]))
            \Smarty::$allExtensions[$targetClass][$name]['className'] = $className;
            \Smarty::$allExtensions[$targetClass][$name]['methods'] = $methods;
            \Smarty::$allExtensions[$targetClass][$name]['sharedObj'] = $sharedObj;
         }
}
    /**
     * Check if class exists
     *
     * @param string $class     class name
     * @param bool   $exception flag if exception shall be thrown (default true)
     *
     * @throws MissingClass
     * @return bool return status
     */
    public function classExists($class, $location = null, $exception = true)
    {
        if (class_exists($class)) {
            return true;
        }
        if ($exception) {
            throw new \Smarty\Exception\MissingClass($class, $location);
        }
        return false;
    }


} 