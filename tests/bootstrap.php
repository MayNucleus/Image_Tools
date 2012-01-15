<?php
error_reporting(E_ALL|E_STRICT);

// set app paths and environments
define('BASE_PATH', $_SERVER['DOCUMENT_ROOT']);
define('APPLICATION_ENV', 'testing');

spl_autoload_register(function($class)
{
    $path = str_replace('\\', DIRECTORY_SEPARATOR, $class);
    foreach (array('lib', 'tests') as $dir_prefix) {
        $file = BASE_PATH . $dir_prefix . DIRECTORY_SEPARATOR . $path . '.php';
        if (file_exists($file)) {
            require_once($file);
            return true;
        }
    }
    return false;
});
