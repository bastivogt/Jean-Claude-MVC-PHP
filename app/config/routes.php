<?php

require_once basePath("app/controllers/HomeController.php");

$router = new Router();

$router->get("/", "HomeController@index");
$router->get("/contact/", "HomeController@contact");
$router->get("/hello/friend/:name/", "HomeController@hello");

