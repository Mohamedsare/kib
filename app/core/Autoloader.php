<?php
// Autoloader pour charger les classes automatiquement
spl_autoload_register(function ($class) {
    $baseDir = __DIR__ . '/../';
    
    // Convertir le namespace en chemin de fichier
    $parts = explode('\\', $class);
    $path = $baseDir . implode('/', $parts) . '.php';
    
    if (file_exists($path)) {
        require_once $path;
    }
});

// Charger les fichiers de base
require_once __DIR__ . '/Database.php';
require_once __DIR__ . '/Session.php';
require_once __DIR__ . '/Auth.php';
require_once __DIR__ . '/Response.php';
require_once __DIR__ . '/CsrfToken.php';
require_once __DIR__ . '/Router.php';
require_once __DIR__ . '/AssetHelper.php';

// Charger les middlewares
require_once __DIR__ . '/../middleware/AuthMiddleware.php';
require_once __DIR__ . '/../middleware/ApiMiddleware.php';
