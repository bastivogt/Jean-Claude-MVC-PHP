<?php

class HomeController {


    public function index() {
        return view("home/index", [
            "title" => "<h1>HomeController#index</h1>"
        ]);
    }

    public function contact() {
        return view("home/contact", [
            "title" => "HomeController#contact"
        ]);
    }

    public function hello($name) {
        return view("home/hello", [
            "title" => "HomeController#hello",
            "name" => $name
        ]);
    }
}