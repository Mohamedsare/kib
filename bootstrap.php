<?php
// Bootstrap de l'application KIB

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Démarrer la session
session_start();

// Déterminer le chemin de base
define('BASE_PATH', dirname(__FILE__));

// Charger l'autoloader
require_once BASE_PATH . '/app/core/Autoloader.php';

// Initialiser la base de données
$db = Database::getInstance();

// Créer le router
$router = new Router();

// Inclure les routes
require_once BASE_PATH . '/app/routes/web.php';

// Exécuter le router
$router->resolve();
