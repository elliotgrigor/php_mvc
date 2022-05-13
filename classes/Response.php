<?php

class Response
{
    public $code = 200;
    
    public function send($body, $status_code = null) {
        $this->setStatus($status_code);
        echo $body;
    }

    public function view($view_path, $data = null) {
        return ViewEngine::render($view_path, $data);
    }

    private function setStatus($status_code) {
        is_null($status_code)
        ? http_response_code($this->code)
        : http_response_code($status_code);
    }
}