<?php
/*
 * This is autoload function
 */

define('LIB_PATH', $_SERVER['DOCUMENT_ROOT'].'lib/');

spl_autoload_register(function($class) {
            $path = str_replace('\\', DIRECTORY_SEPARATOR, $class);

            $file = LIB_PATH . $path . '.php';
            if (file_exists($file)) {
                require_once($file);
                return true;
            }
            
            return false;
        });
