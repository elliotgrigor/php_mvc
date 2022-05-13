<?php

// set the app's root directory
define('ROOT_DIR', __DIR__  . '/../');

// initialise the application
require_once ROOT_DIR . 'app/init.php';

// handle the incoming request
Router::requestHandler();