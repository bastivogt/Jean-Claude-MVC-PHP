<?php

require_once "../bootstrap.php";

$uri = $_SERVER["REQUEST_URI"];
$method = $_SERVER["REQUEST_METHOD"];
d($uri);
d($method);
d($router->getRoutes());





// $router->accessQuery($method, $uri);
$router->execute($method, $uri);

