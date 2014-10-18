<?php
/**
 * Test script for the Smarty compiler
 *
 * It displays a form in which a template source code can be entered.
 * The template source will be compiled, rendered and the result is displayed.
 * The compiled code is displayed as well
 *
 * @author Uwe Tews
 * @package SmartyTestScripts
 */

 function ErrorHandler($errno, $errstr)
{
    echo '<br>error ' . $errno . ' ' . $errstr . '<br>';
}

class A {
    public $b =1;
    public $n = 'hallo';
    public function loop() {
        return array(5,6,7);
    }
}
//phpinfo();
$start = microtime(true);
//set_error_handler('ErrorHandler');
//require('../../distribution/libs/SmartyBC.class.php');
//$smarty = new SmartyBC();
require_once '../../lib/SplClassLoader.php';
$classLoader = new SplClassLoader();
$classLoader->register();
$smarty = new Smarty('./MyConfig.xml');
$time = microtime(true);
echo '<br>startup time '. ($time-$start);
echo '<br>memory ' . memory_get_usage();
echo '<br> memory peak ' . memory_get_peak_usage() . '<br><br>';
//Smarty::muteExpectedErrors();
//$smarty->php_handling = Smarty::PHP_QUOTE;
//$smarty->setErrorReporting(E_ALL);
error_reporting(E_ALL | E_STRICT);
//$smarty->addPluginsDir('./plugins');
//$smarty->addPluginsDir('../PHPunit/PHPunitplugins');
//$smarty->setPluginsDir('../PHPunit/PHPunitplugins');
//$smarty->addPluginsDir( "./../../distribution/demo/plugins/");
//$smarty->addTemplateDir('../PHPunit/templates');
//$smarty->setTemplateDir('../PHPunit/templates');
//$smarty->setConfigDir('../PHPunit/configs');

/* $smarty->setTemplateDir( array(
            'root' => '../PHPunit/templates',
            '../PHPunit/templates_2',
            '../PHPunit/templates_3',
            '../PHPunit/templates_4',
        ));
*/
//$smarty->setCacheLifetime(400);
//$smarty->caching = 1;
//$smarty->cache_modified_check = true;
// $smarty->security=true;;
// $smarty->enableSecurity();
//$smarty->loadFilter('output', 'trimwhitespace');
// $smarty->loadFilter("variable", "htmlspecialchars");
// $smarty->loadFilter('pre', 'translate');
//$smarty->cache_id = 'uwe|tews';
// $smarty->left_delimiter = '[%';
// $smarty->right_delimiter = '%]';
//$smarty->use_sub_dirs = true;
//$smarty->error_unassigned = Smarty::UNASSIGNED_EXCEPTION;
//Smarty_Compiler::parserdebug = true;
//$smarty->locking_timeout = 10;
//$smarty->setCaching(1);
$smarty->assign('a', array(1,2,3,4,5));
$smarty->assign('bar', 'hallo');
$smarty->assign('foo', true);
$smarty->assign('u', new A);
$smarty->force_compile = true;
$smarty->display('bug.tpl');

function trace ($data)
{
    echo '<br>trace :'.$data.'<br>';
}

echo '<br>memory ' . memory_get_usage();
echo '<br> memory peak ' . memory_get_peak_usage();
echo '<br>' . (microtime(true) - $start);
echo '<br>' . (microtime(true) - $time);
