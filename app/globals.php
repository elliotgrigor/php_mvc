<?php

$GLOBALS['routes']     = array();
$GLOBALS['flash_msgs'] = array();


function redirect($route) {
    return header("Location: $route");
}

function url_to($route_name, $arg = null) {
    if ($arg !== null) {
        return $GLOBALS['routes'][$route_name] . '/' . $arg;
    }

    return $GLOBALS['routes'][$route_name];
}

function flash($message) {
    array_push($GLOBALS['flash_msgs'], $message);
}

function get_flashed_messages() {
    $messages = $GLOBALS['flash_msgs'];

    // return and remove the messages
    if (!empty($messages)) {
        $GLOBALS['flash_msgs'] = array();
        return $messages;
    }

    return null;
}