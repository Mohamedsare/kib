<?php
// Point d'entrée de l'application pour le dossier public

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Charger l'autoloader
require_once __DIR__ . '/../app/core/Autoloader.php';

// Démarrer les sessions
Session::start();

// Initialiser la base de données
$db = Database::getInstance();

// Créer le router
$router = new Router();

// Inclure les routes
require_once __DIR__ . '/../app/routes/web.php';

// Exécuter le router
$router->resolve();