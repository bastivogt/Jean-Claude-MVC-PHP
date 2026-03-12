<?php

require "helpers.php";

function matchRoute($routeUri, $reqUri) {
    $routeA = explode("/", trim($routeUri, "/"));
    $reqA = explode("/", trim($reqUri, "/"));
    $pos = false;
    $match = true;
    $params = [];
    if(count($routeA) !== count($reqA)) {
        return false;
    }
    for($i = 0; $i < count($routeA); $i ++) {
        if(str_starts_with($routeA[$i], ":")) {
            $pos = $i;
            break;
        }
        if($routeA[$i] !== $reqA[$i]) {
            $match = false;
        }
        var_dump($routeA[$i]);    
    }
    if($match) {
        $params = array_slice($reqA, $pos);
        
    }
    return [
        $match,
        $params
    ];

}

$route = matchRoute("/hello/friend/:name/", "/hello/friend/seppel/");
var_dump($route);