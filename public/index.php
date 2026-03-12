<?php

require_once "../bootstrap.php";

$uri = $_SERVER["REQUEST_URI"];
$method = $_SERVER["REQUEST_METHOD"];
d($uri);
d($method);


$route = $router->getRoute($method, $uri);


// $router->accessQuery($method, $uri);
$router->execute($method, $uri);