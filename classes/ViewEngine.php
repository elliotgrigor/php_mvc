<?php

class ViewEngine
{
    private static $header = HEADER_PARTIAL;
    private static $footer = FOOTER_PARTIAL;

    public static function render($view_path, $data) {
        if (is_null($data)) unset($data);

        include_once self::$header;

        $view_file = VIEW_DIR . "$view_path.view.php";
        $err_file  = VIEW_DIR . "$view_path.err.php";

        if (file_exists($err_file)) {
            include_once $err_file;
        }
        else if (file_exists($view_file)) {
            include_once $view_file;
        }

        include_once self::$footer;
    }
}