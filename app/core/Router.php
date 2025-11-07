<?php
// Système de routage
class Router {
    private $routes = [];
    private $middlewares = [];
    
    // Ajouter une route GET
    public function get($path, $handler) {
        $this->addRoute('GET', $path, $handler);
    }
    
    // Ajouter une route POST
    public function post($path, $handler) {
        $this->addRoute('POST', $path, $handler);
    }
    
    // Ajouter une route PUT
    public function put($path, $handler) {
        $this->addRoute('PUT', $path, $handler);
    }
    
    // Ajouter une route DELETE
    public function delete($path, $handler) {
        $this->addRoute('DELETE', $path, $handler);
    }
    
    // Ajouter un middleware
    public function middleware($middleware) {
        $this->middlewares[] = $middleware;
        return $this;
    }
    
    private function addRoute($method, $path, $handler) {
        $this->routes[] = [
            'method' => $method,
            'path' => $path,
            'handler' => $handler,
            'middlewares' => $this->middlewares
        ];
    }
    
    // Résoudre la route actuelle
    public function resolve() {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        
        // Nettoyer l'URI en retirant le chemin de base
        $scriptName = $_SERVER['SCRIPT_NAME'];
        $basePath = dirname($scriptName);
        
        // Retirer le basePath de l'URI s'il correspond
        if ($basePath !== '/' && $basePath !== '.') {
            if (strpos($uri, $basePath) === 0) {
                $uri = substr($uri, strlen($basePath));
            }
        }
        
        // Si l'URI commence par "/kib/" et qu'on est dans /kib/public, retirer "/kib"
        if (strpos($uri, '/kib/') === 0 && $basePath === '/kib/public') {
            $uri = substr($uri, 4); // Retirer "/kib"
        }
        
        // Nettoyer l'URI
        $uri = trim($uri, '/');
        
        // Retirer "index.php" ou autres parties inutiles
        $uri = str_replace(['public/index.php', 'index.php', 'public/'], '', $uri);
        $uri = trim($uri, '/');
        
        // Ajouter le slash initial
        if ($uri === '') {
            $uri = '/';
        } else {
            $uri = '/' . $uri;
        }
        
        
        // Rechercher la route correspondante
        foreach ($this->routes as $route) {
            if ($route['method'] === $method && $this->matchRoute($route['path'], $uri)) {
                $params = $this->extractParams($route['path'], $uri);
                
                // Exécuter les middlewares
                foreach ($route['middlewares'] as $middleware) {
                    if (!call_user_func($middleware)) {
                        return false;
                    }
                }
                
                // Exécuter le handler
                return $this->executeHandler($route['handler'], $params);
            }
        }
        
        // Route non trouvée
        http_response_code(404);
        echo "Route non trouvée : " . htmlspecialchars($uri);
        return false;
    }
    
    private function matchRoute($pattern, $uri) {
        $pattern = '#^' . preg_replace('#\{([\w]+)\}#', '([^/]+)', $pattern) . '$#';
        return preg_match($pattern, $uri);
    }
    
    private function extractParams($pattern, $uri) {
        preg_match('#^' . preg_replace('#\{([\w]+)\}#', '([^/]+)', $pattern) . '$#', $uri, $matches);
        preg_match_all('#\{([\w]+)\}#', $pattern, $keys);
        
        $params = [];
        foreach ($keys[1] as $index => $key) {
            $params[$key] = $matches[$index + 1] ?? null;
        }
        
        return $params;
    }
    
    private function executeHandler($handler, $params) {
        if (is_callable($handler)) {
            return call_user_func($handler, $params);
        }
        
        if (is_string($handler)) {
            [$controller, $method] = explode('@', $handler);
            $controllerFile = __DIR__ . "/../controllers/{$controller}.php";
            
            if (file_exists($controllerFile)) {
                require_once $controllerFile;
                $controllerInstance = new $controller();
                return call_user_func_array([$controllerInstance, $method], array_values($params));
            }
        }
        
        return false;
    }
}
