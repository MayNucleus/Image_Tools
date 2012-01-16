<?php
error_reporting(E_ALL|E_STRICT);


spl_autoload_register(function($class)
{
    $path = str_replace('\\', DIRECTORY_SEPARATOR, $class);
    foreach (array('lib', 'tests') as $dir_prefix) {
        $file = '../'. $dir_prefix . DIRECTORY_SEPARATOR . $path . '.php';
        if (file_exists($file)) {
            return require_once($file);
        }
    }
});
