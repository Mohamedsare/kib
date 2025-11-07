<?php
// Contrôleur API pour l'administration
class ApiAdminController {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }
    
    // GET /api/admin/dashboard
    public function dashboard() {
        $stats = [];
        
        $stmt = $this->db->query("SELECT COUNT(*) as count FROM contacts WHERE status = 'new'");
        $stats['unread_messages'] = $stmt->fetch()['count'];
        
        $stmt = $this->db->query("SELECT COUNT(*) as count FROM quotes WHERE status = 'pending'");
        $stats['pending_quotes'] = $stmt->fetch()['count'];
        
        $stmt = $this->db->query("SELECT COUNT(*) as count FROM services WHERE active = 1");
        $stats['active_services'] = $stmt->fetch()['count'];
        
        $stmt = $this->db->query("SELECT COUNT(*) as count FROM realizations");
        $stats['total_realizations'] = $stmt->fetch()['count'];
        
        // Statistiques de vues sur 7 derniers jours
        $stmt = $this->db->query("SELECT DATE(created_at) as date, COUNT(*) as views 
            FROM analytics_events 
            WHERE event_type = 'page_view' AND created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)
            GROUP BY DATE(created_at)
            ORDER BY date ASC");
        $stats['views_by_day'] = $stmt->fetchAll();
        
        return Response::json(['stats' => $stats]);
    }
    
    // CRUD Services
    public function services() {
        $stmt = $this->db->query("SELECT s.*, c.name as category_name FROM services s 
            LEFT JOIN categories c ON s.category_id = c.id ORDER BY s.created_at DESC");
        
        return Response::json($stmt->fetchAll());
    }
    
    public function createService() {
        $data = json_decode(file_get_contents('php://input'), true);
        
        $title = $data['title'] ?? '';
        $description = $data['description'] ?? '';
        $priceBase = $data['price_base'] ?? 0;
        $categoryId = $data['category_id'] ?? null;
        $active = $data['active'] ?? 1;
        
        if (empty($title)) {
            return Response::json(['error' => 'Titre requis'], 400);
        }
        
        $slug = $this->generateSlug($title);
        $pricingMeta = json_encode($data['pricing_meta'] ?? []);
        
        $stmt = $this->db->prepare("INSERT INTO services (title, slug, description, price_base, category_id, pricing_meta, active) 
            VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$title, $slug, $description, $priceBase, $categoryId, $pricingMeta, $active]);
        
        $serviceId = $this->db->lastInsertId();
        
        $stmt = $this->db->prepare("SELECT s.*, c.name as category_name FROM services s 
            LEFT JOIN categories c ON s.category_id = c.id WHERE s.id = ?");
        $stmt->execute([$serviceId]);
        
        return Response::json($stmt->fetch(), 201);
    }
    
    public function updateService($params) {
        $id = $params['id'] ?? null;
        $data = json_decode(file_get_contents('php://input'), true);
        
        if (!$id) {
            return Response::json(['error' => 'ID requis'], 400);
        }
        
        $title = $data['title'] ?? '';
        $description = $data['description'] ?? '';
        $priceBase = $data['price_base'] ?? 0;
        $categoryId = $data['category_id'] ?? null;
        $active = $data['active'] ?? 1;
        
        if (empty($title)) {
            return Response::json(['error' => 'Titre requis'], 400);
        }
        
        $slug = $this->generateSlug($title);
        $pricingMeta = json_encode($data['pricing_meta'] ?? []);
        
        $stmt = $this->db->prepare("UPDATE services SET title = ?, slug = ?, description = ?, price_base = ?, 
            category_id = ?, pricing_meta = ?, active = ? WHERE id = ?");
        $stmt->execute([$title, $slug, $description, $priceBase, $categoryId, $pricingMeta, $active, $id]);
        
        $stmt = $this->db->prepare("SELECT s.*, c.name as category_name FROM services s 
            LEFT JOIN categories c ON s.category_id = c.id WHERE s.id = ?");
        $stmt->execute([$id]);
        
        return Response::json($stmt->fetch());
    }
    
    public function deleteService($params) {
        $id = $params['id'] ?? null;
        
        if (!$id) {
            return Response::json(['error' => 'ID requis'], 400);
        }
        
        $stmt = $this->db->prepare("DELETE FROM services WHERE id = ?");
        $stmt->execute([$id]);
        
        return Response::json(['success' => true]);
    }
    
    // CRUD Portfolio
    public function portfolio() {
        $stmt = $this->db->query("SELECT r.*, c.name as category_name FROM realizations r 
            LEFT JOIN categories c ON r.category_id = c.id ORDER BY r.created_at DESC");
        
        return Response::json($stmt->fetchAll());
    }
    
    public function createRealization() {
        $data = json_decode(file_get_contents('php://input'), true);
        
        $title = $data['title'] ?? '';
        $description = $data['description'] ?? '';
        $categoryId = $data['category_id'] ?? null;
        $images = json_encode($data['images'] ?? []);
        $clientName = $data['client_name'] ?? null;
        $featured = $data['featured'] ?? 0;
        
        $stmt = $this->db->prepare("INSERT INTO realizations (title, description, category_id, images, client_name, featured) 
            VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$title, $description, $categoryId, $images, $clientName, $featured]);
        
        $realizationId = $this->db->lastInsertId();
        
        $stmt = $this->db->prepare("SELECT r.*, c.name as category_name FROM realizations r 
            LEFT JOIN categories c ON r.category_id = c.id WHERE r.id = ?");
        $stmt->execute([$realizationId]);
        
        return Response::json($stmt->fetch(), 201);
    }
    
    public function updateRealization($params) {
        $id = $params['id'] ?? null;
        $data = json_decode(file_get_contents('php://input'), true);
        
        if (!$id) {
            return Response::json(['error' => 'ID requis'], 400);
        }
        
        $title = $data['title'] ?? '';
        $description = $data['description'] ?? '';
        $categoryId = $data['category_id'] ?? null;
        $images = json_encode($data['images'] ?? []);
        $clientName = $data['client_name'] ?? null;
        $featured = $data['featured'] ?? 0;
        
        $stmt = $this->db->prepare("UPDATE realizations SET title = ?, description = ?, category_id = ?, 
            images = ?, client_name = ?, featured = ? WHERE id = ?");
        $stmt->execute([$title, $description, $categoryId, $images, $clientName, $featured, $id]);
        
        $stmt = $this->db->prepare("SELECT r.*, c.name as category_name FROM realizations r 
            LEFT JOIN categories c ON r.category_id = c.id WHERE r.id = ?");
        $stmt->execute([$id]);
        
        return Response::json($stmt->fetch());
    }
    
    public function deleteRealization($params) {
        $id = $params['id'] ?? null;
        
        if (!$id) {
            return Response::json(['error' => 'ID requis'], 400);
        }
        
        $stmt = $this->db->prepare("DELETE FROM realizations WHERE id = ?");
        $stmt->execute([$id]);
        
        return Response::json(['success' => true]);
    }
    
    // Messages
    public function messages() {
        $stmt = $this->db->query("SELECT * FROM contacts ORDER BY created_at DESC");
        return Response::json($stmt->fetchAll());
    }
    
    public function updateMessage($params) {
        $id = $params['id'] ?? null;
        $data = json_decode(file_get_contents('php://input'), true);
        
        $status = $data['status'] ?? 'read';
        
        $stmt = $this->db->prepare("UPDATE contacts SET status = ? WHERE id = ?");
        $stmt->execute([$status, $id]);
        
        return Response::json(['success' => true]);
    }
    
    public function deleteMessage($params) {
        $id = $params['id'] ?? null;
        
        $stmt = $this->db->prepare("DELETE FROM contacts WHERE id = ?");
        $stmt->execute([$id]);
        
        return Response::json(['success' => true]);
    }
    
    // Analytics
    public function analytics() {
        // Statistiques en temps réel
        $stmt = $this->db->query("SELECT COUNT(DISTINCT session_id) as count FROM analytics_events 
            WHERE created_at >= DATE_SUB(NOW(), INTERVAL 15 MINUTE)");
        $online = $stmt->fetch()['count'];
        
        // Dernières pages visitées
        $stmt = $this->db->query("SELECT path, country, city, created_at FROM analytics_events 
            WHERE event_type = 'page_view' 
            ORDER BY created_at DESC LIMIT 20");
        $recentViews = $stmt->fetchAll();
        
        // Top pages
        $stmt = $this->db->query("SELECT path, COUNT(*) as views FROM analytics_events 
            WHERE event_type = 'page_view' AND created_at >= DATE_SUB(NOW(), INTERVAL 24 HOUR)
            GROUP BY path ORDER BY views DESC LIMIT 10");
        $topPages = $stmt->fetchAll();
        
        return Response::json([
            'online' => $online,
            'recent_views' => $recentViews,
            'top_pages' => $topPages
        ]);
    }
    
    // Backup
    public function backup() {
        $config = require __DIR__ . '/../../config/database.php';
        
        $filename = 'backup_' . date('Y-m-d_H-i-s') . '.sql';
        $backupPath = __DIR__ . '/../../backups/' . $filename;
        
        if (!is_dir(__DIR__ . '/../../backups')) {
            mkdir(__DIR__ . '/../../backups', 0755, true);
        }
        
        $command = sprintf(
            'mysqldump -u%s -p%s %s > %s',
            $config['username'],
            $config['password'],
            $config['dbname'],
            $backupPath
        );
        
        exec($command, $output, $return);
        
        if ($return === 0) {
            return Response::json([
                'success' => true,
                'filename' => $filename,
                'download_url' => '/backups/' . $filename
            ]);
        } else {
            return Response::json(['error' => 'Erreur lors du backup'], 500);
        }
    }
    
    // Settings
    public function getSettings() {
        $stmt = $this->db->query("SELECT * FROM site_settings");
        $rows = $stmt->fetchAll();
        
        $settings = [];
        foreach ($rows as $row) {
            $settings[$row['setting_key']] = $row['setting_value'];
        }
        
        return Response::json($settings);
    }
    
    public function updateSettings() {
        $data = json_decode(file_get_contents('php://input'), true);
        
        foreach ($data as $key => $value) {
            $stmt = $this->db->prepare("UPDATE site_settings SET setting_value = ? WHERE setting_key = ?");
            $stmt->execute([$value, $key]);
        }
        
        return Response::json(['success' => true]);
    }
    
    // Générer un slug
    private function generateSlug($text) {
        $text = strtolower($text);
        $text = str_replace(' ', '-', $text);
        $text = preg_replace('/[^a-z0-9-]/', '', $text);
        $text = preg_replace('/-+/', '-', $text);
        return trim($text, '-');
    }
}
