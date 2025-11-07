<?php
// Gestion de la connexion à la base de données
class Database {
    private static $instance = null;
    private $connection;
    
    private function __construct() {
        $config = require __DIR__ . '/../../config/database.php';
        
        try {
            $dsn = "mysql:host={$config['host']};dbname={$config['dbname']};charset={$config['charset']}";
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ];
            
            $this->connection = new PDO($dsn, $config['username'], $config['password'], $options);
        } catch (PDOException $e) {
            die("Erreur de connexion : " . $e->getMessage());
        }
    }
    
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    public function getConnection() {
        return $this->connection;
    }
    
    public function query($sql, $params = []) {
        try {
            if (empty($params)) {
                // Si pas de paramètres, utiliser query() directement
                $stmt = $this->connection->query($sql);
            } else {
                // Si paramètres, utiliser prepare()
                $stmt = $this->connection->prepare($sql);
                $stmt->execute($params);
            }
            return $stmt;
        } catch (PDOException $e) {
            error_log("Erreur SQL : " . $e->getMessage());
            // Retourner un PDOStatement vide plutôt que false
            return new class {
                public function fetchAll() { return []; }
                public function fetch() { return false; }
            };
        }
    }
}
