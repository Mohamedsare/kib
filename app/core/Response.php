<?php
// Gestionnaire de réponses HTTP
class Response {
    // Retourner une réponse JSON
    public static function json($data, $statusCode = 200) {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        exit;
    }
    
    // Retourner une vue
    public static function view($view, $data = []) {
        extract($data);
        $viewFile = __DIR__ . "/../views/{$view}.php";
        
        if (file_exists($viewFile)) {
            include $viewFile;
        } else {
            throw new Exception("Vue {$view} introuvable");
        }
    }
    
    // Redirection
    public static function redirect($url) {
        // Si l'URL ne commence pas par http:// ou https://, ajouter le chemin de base
        if (!preg_match('/^https?:\/\//', $url)) {
            // Ajouter le chemin de base si nécessaire
            if (strpos($url, '/kib') !== 0) {
                $basePath = AssetHelper::getBasePath();
                $url = $basePath . $url;
            }
        }
        header("Location: {$url}");
        exit;
    }
    
    // Erreur
    public static function error($message, $statusCode = 500) {
        http_response_code($statusCode);
        echo json_encode(['error' => $message]);
        exit;
    }
}
