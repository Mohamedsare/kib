<?php
// Contrôleur pour les pages publiques
class PageController {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }
    
    // Page d'accueil
    public function home() {
        try {
            // Récupérer les services actifs
            $stmt = $this->db->prepare("SELECT * FROM services WHERE active = 1 ORDER BY created_at DESC LIMIT 6");
            $stmt->execute();
            $services = $stmt->fetchAll();
            
            // Récupérer les réalisations featured
            $stmt = $this->db->prepare("SELECT * FROM realizations WHERE featured = 1 ORDER BY created_at DESC LIMIT 8");
            $stmt->execute();
            $realizations = $stmt->fetchAll();
            
            // Si aucune réalisation featured, prendre les dernières
            if (empty($realizations)) {
                $stmt = $this->db->prepare("SELECT * FROM realizations ORDER BY created_at DESC LIMIT 8");
                $stmt->execute();
                $realizations = $stmt->fetchAll();
            }
            
            // Récupérer les paramètres du site
            $settings = $this->getSettings();
            
            $title = 'Accueil - KIB';
            ob_start();
            include __DIR__ . '/../views/pages/home.php';
            $content = ob_get_clean();
            include __DIR__ . '/../views/layouts/main.php';
        } catch (Exception $e) {
            echo "Erreur : " . $e->getMessage();
            // Afficher quand même la page avec des données vides
            $services = [];
            $realizations = [];
            $settings = $this->getSettings();
            $title = 'Accueil - KIB';
            ob_start();
            include __DIR__ . '/../views/pages/home.php';
            $content = ob_get_clean();
            include __DIR__ . '/../views/layouts/main.php';
        }
    }
    
    // Page services
    public function services() {
        $stmt = $this->db->prepare("SELECT s.*, c.name as category_name FROM services s 
            LEFT JOIN categories c ON s.category_id = c.id 
            WHERE s.active = 1 ORDER BY s.title");
        $stmt->execute();
        $services = $stmt->fetchAll();
        
        $stmt = $this->db->prepare("SELECT * FROM categories ORDER BY name");
        $stmt->execute();
        $categories = $stmt->fetchAll();
        
        $settings = $this->getSettings();
        
        $title = 'Nos Services - KIB';
        ob_start();
        include __DIR__ . '/../views/pages/services.php';
        $content = ob_get_clean();
        include __DIR__ . '/../views/layouts/main.php';
    }
    
    // Page portfolio
    public function portfolio() {
        $category = $_GET['category'] ?? null;
        
        $sql = "SELECT r.*, c.name as category_name FROM realizations r 
            LEFT JOIN categories c ON r.category_id = c.id";
        
        if ($category) {
            $stmt = $this->db->prepare($sql . " WHERE c.slug = ? ORDER BY r.created_at DESC");
            $stmt->execute([$category]);
        } else {
            $stmt = $this->db->prepare($sql . " ORDER BY r.created_at DESC");
            $stmt->execute();
        }
        
        $realizations = $stmt->fetchAll();
        
        $stmt = $this->db->prepare("SELECT * FROM categories ORDER BY name");
        $stmt->execute();
        $categories = $stmt->fetchAll();
        
        $settings = $this->getSettings();
        
        $title = 'Portfolio - KIB';
        ob_start();
        include __DIR__ . '/../views/pages/portfolio.php';
        $content = ob_get_clean();
        include __DIR__ . '/../views/layouts/main.php';
    }
    
    // Page tarifs
    public function pricing() {
        try {
            $stmt = $this->db->prepare("SELECT s.*, c.name as category_name FROM services s 
                LEFT JOIN categories c ON s.category_id = c.id 
                WHERE s.active = 1 ORDER BY c.name, s.title");
            $stmt->execute();
            $services = $stmt->fetchAll();
        } catch (Exception $e) {
            $services = [];
        }
        
        $settings = $this->getSettings();
        
        $title = 'Tarifs - KIB';
        ob_start();
        include __DIR__ . '/../views/pages/pricing.php';
        $content = ob_get_clean();
        include __DIR__ . '/../views/layouts/main.php';
    }
    
    // Page à propos
    public function about() {
        $settings = $this->getSettings();
        
        $title = 'À propos - KIB';
        ob_start();
        include __DIR__ . '/../views/pages/about.php';
        $content = ob_get_clean();
        include __DIR__ . '/../views/layouts/main.php';
    }
    
    // Page contact
    public function contact() {
        $settings = $this->getSettings();
        $csrf = CsrfToken::generate();
        
        $title = 'Contact - KIB';
        ob_start();
        include __DIR__ . '/../views/pages/contact.php';
        $content = ob_get_clean();
        include __DIR__ . '/../views/layouts/main.php';
    }
    
    // Récupérer les paramètres du site
    private function getSettings() {
        $stmt = $this->db->prepare("SELECT * FROM site_settings");
        $stmt->execute();
        $rows = $stmt->fetchAll();
        
        $settings = [];
        foreach ($rows as $row) {
            $settings[$row['setting_key']] = $row['setting_value'];
        }
        
        return $settings;
    }
}
