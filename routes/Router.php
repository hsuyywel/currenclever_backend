<?php
class Router {
    private $routes = [];

    public function addRoute($method, $path, $handler) {
        $this->routes[] = [
            'method' => $method,
            'path' => $path,
            'handler' => $handler
        ];
    }

    public function handleRequest($uri, $method) {
        foreach ($this->routes as $route) {
            if ($route['method'] === $method && $this->matchPath($route['path'], $uri)) {
                if (is_array($route['handler'])) {
                    // Handle controller method calls
                    $controller = new $route['handler'][0]();
                    return $controller->{$route['handler'][1]}();
                } else if (is_callable($route['handler'])) {
                    // Handle closure/callable functions
                    return $route['handler']();
                }
            }
        }
        
        http_response_code(404);
        echo json_encode(['error' => 'Route not found']);
        exit;
    }

    private function matchPath($routePath, $requestUri) {
        // Remove leading and trailing slashes
        $routePath = trim($routePath, '/');
        $requestUri = trim($requestUri, '/');
        
        // Split paths into segments
        $routeSegments = explode('/', $routePath);
        $uriSegments = explode('/', $requestUri);
        
        // If different number of segments, not a match
        if (count($routeSegments) !== count($uriSegments)) {
            return false;
        }
        
        // Compare each segment
        for ($i = 0; $i < count($routeSegments); $i++) {
            if ($routeSegments[$i] !== $uriSegments[$i]) {
                return false;
            }
        }
        
        return true;
    }
}