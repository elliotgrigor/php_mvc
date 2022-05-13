<?php

// set the views path
define('VIEW_DIR', ROOT_DIR . '/views/');

// set the header/footer partial paths
define('HEADER_PARTIAL', VIEW_DIR . '/partials/_header.php');
define('FOOTER_PARTIAL', VIEW_DIR . '/partials/_footer.php');

// set database credentials
define('DATABASE', [
    'host'     => 'localhost',
    'db_name'  => 'php_app',
    'username' => 'vagrant',
    'password' => 'y9Zfj0X9@',
]);