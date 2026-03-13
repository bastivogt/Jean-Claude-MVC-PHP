<?php


class Router {
    protected $routes;

    public function __construct()
    {
        $this->routes = [];
    }

    public function error(int $code) {
        http_response_code($code);
        require basePath("app/controllers/ErrorController.php");
        $errorController = new ErrorController();
        
        $method = "_" . $code;
        if(method_exists($errorController, $method)) {
            echo call_user_func([$errorController, $method]);
        }
    }


    protected function registerRoute(string $method, string $uri, string $controller) {
        $this->routes[] = [
            "method" => $method,
            "uri" => $uri,
            "controller" => $controller
        ];
    }


    public function get(string $uri, string $controller): void {
        $this->registerRoute("GET", $uri, $controller);
    }

    public function post(string $uri, string $controller): void {
        $this->registerRoute("POST", $uri, $controller);
    }

    public function put(string $uri, string $controller): void {
        $this->registerRoute("PUT", $uri, $controller);
    }

    public function delete(string $uri, string $controller): void {
        $this->registerRoute("DELETE", $uri, $controller);
    }

    protected function executeController(string $controller, array $params = []) {
        $arr = explode("@", $controller);
        if(class_exists($arr[0])) {
            $ctrl = new $arr[0]();
            if(method_exists($ctrl, $arr[1])) {
                //echo call_user_func([$ctrl, $arr[1]]);
                echo call_user_func_array([$ctrl, $arr[1]], $params);
            }else {
                dd("Method '$arr[1]' does not exist in '$arr[0]'!");
            }
        }
    }

    protected function matchRoute(string $routeUri, string $reqUri): array|bool {
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
        }
        d($pos);
        if($match && $pos) {
            $params = array_slice($reqA, $pos);
            
            
        }
        // d($params);
        return [
            $match,
            $params
        ];

    }


    // public function getRoute(string $method, string $uri): array|bool {
    //     foreach($this->routes as $route) {
    //         if($route["method"] === $method && $route["uri"] === $uri) {
    //             return $route;
    //         }
    //     }
    //     return false;
    // }








    public function execute(string $method, string $uri): mixed {
        $params = false;
        $currentRoute = false;
        foreach($this->routes as $route) {
            if($route["method"] === strtoupper($method)) {
                $params = $this->matchRoute($route["uri"], $uri);
                if($params[0] === true) {
                    $currentRoute = $route;
                    break;
                }

            }
        }
        if($currentRoute) {
            return $this->executeController($currentRoute["controller"], $params[1]);
        }
        return $this->error(404);
    }


    public function getRoutes(): array {
        return [...$this->routes];
    }

}