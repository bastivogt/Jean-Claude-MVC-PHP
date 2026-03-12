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

    protected function getParams(string $reqUri, string $routeUri) {
        $params = [];
        if($reqUri === $routeUri) {
            return $params;
        }
        $position = 0;
        $routeUriArray = explode("/", $routeUri);
        $reqUriArry = explode("/", $reqUri);

        d($reqUriArry);
        dd($routeUriArray);
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

    protected function matchRoute($routeUri, $reqUri) {
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
        d($params);
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

    public function checkRoute($reqUri, $routeUri) {
        // $reqUriArray = explode("/", trim($reqUri, "/"));
        // $routeUriArray = explode("/", trim($routeUri, "/"));
        $routeUriArray = explode(":", trim($routeUri, "/"));
        dd($routeUri);
        dd($routeUriArray);
    }

    public function getRoute(string $method, string $uri): array|bool {
        foreach($this->routes as $route) {

            //$this->checkRoute($uri, $route["uri"]);
            if($route["method"] === $method && $route["uri"] === $uri) {
                return $route;
            }
        }
        return false;
    }

    public function accessQuery(string $method, string $uri) {
        $route = $this->getRoute($method, $uri);
        if($route) {
            $params = $this->getParams($uri, $route["uri"]);
            $this->executeController($route["controller"], $params);
            //require basePath($route["controller"]);
            return;
        }
        $this->error(404);
        return;
    }


    public function execute($method, $uri) {
        $params = false;
        $currentRoute = false;
        foreach($this->routes as $route) {
            $params = $this->matchRoute($route["uri"], $uri);
            if($params[0] === true) {
                $currentRoute = $route;
                break;
            }
        }
        if($currentRoute) {
            return $this->executeController($currentRoute["controller"], $params[1]);
        }
        return $this->error(404);
    }


    public function getRoutes() {
        return $this->routes;
    }

}