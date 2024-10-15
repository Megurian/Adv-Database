<?php
spl_autoload_register('AutoLoader');

function AutoLoader($class) {
    $path = __DIR__ . "/";
    $extension = ".class.php";
    $fullpath = $path . $class . $extension;

    include_once $fullpath;
}
