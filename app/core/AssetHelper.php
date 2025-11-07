<?php
// Helper pour générer les chemins d'assets
class AssetHelper {
    private static $basePath = null;
    
    // Obtenir le chemin de base de l'application
    public static function getBasePath() {
        if (self::$basePath !== null) {
            return self::$basePath;
        }
        
        $scriptName = $_SERVER['SCRIPT_NAME'];
        
        // Dans notre cas : /kib/public/index.php
        // On veut juste : /kib
        $baseDir = dirname($scriptName);
        
        // Retirer "/public" du chemin si présent
        if (strpos($baseDir, '/public') !== false) {
            $baseDir = str_replace('/public', '', $baseDir);
        }
        
        // Si on est à la racine, retourner /
        if ($baseDir === '/' || $baseDir === '\\') {
            self::$basePath = '/';
        } else {
            self::$basePath = rtrim($baseDir, '/\\');
        }
        
        return self::$basePath;
    }
    
    // Générer le chemin d'un asset
    public static function asset($path) {
        $basePath = self::getBasePath();
        return $basePath . '/assets/' . ltrim($path, '/');
    }
    
    // Générer le chemin d'un upload
    public static function upload($path) {
        $basePath = self::getBasePath();
        return $basePath . '/uploads/' . ltrim($path, '/');
    }
}
