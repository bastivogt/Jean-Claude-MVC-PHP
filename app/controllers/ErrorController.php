<?php

class ErrorController {
    public function _404() {
        return view("error/404", [
            "title" => "404 - Page not found"
        ]);
    }

    public function _403() {
        return view("error/404", [
            "title" => "403 - Access forbidden"
        ]);
    }
}