<?php

class HomeController {


    public function index() {
        return view("home/index", [
            "title" => "HomeController#index"
        ]);
    }

    public function contact() {
        return "HomeController@contact";
    }

    public function hello($name) {
        return view("home/hello", [
            "title" => "HomeController#hello",
            "name" => $name
        ]);
    }
}