<?php

// autoload classes
spl_autoload_register(function ($class) {
    $classes_dir     = ROOT_DIR . "classes/$class.php";
    $models_dir      = ROOT_DIR . "models/$class.php";
    $controllers_dir = ROOT_DIR . "controllers/$class.php";

    if (file_exists($classes_dir))     require_once $classes_dir;
    if (file_exists($models_dir))      require_once $models_dir;
    if (file_exists($controllers_dir)) require_once $controllers_dir;
});