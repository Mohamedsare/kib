<?php
// Contrôleur API pour les ressources publiques
class ApiController {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }
    
    // GET /api/services
    public function getServices() {
        $category = $_GET['category'] ?? null;
        
        if ($category) {
            $stmt = $this->db->prepare("SELECT s.*, c.name as category_name FROM services s 
                LEFT JOIN categories c ON s.category_id = c.id 
                WHERE s.active = 1 AND c.slug = ? ORDER BY s.title");
            $stmt->execute([$category]);
        } else {
            $stmt = $this->db->query("SELECT s.*, c.name as category_name FROM services s 
                LEFT JOIN categories c ON s.category_id = c.id 
                WHERE s.active = 1 ORDER BY s.title");
        }
        
        $services = $stmt->fetchAll();
        
        return Response::json($services);
    }
    
    // GET /api/services/{slug}
    public function getService($params) {
        $slug = $params['slug'] ?? '';
        
        $stmt = $this->db->prepare("SELECT s.*, c.name as category_name FROM services s 
            LEFT JOIN categories c ON s.category_id = c.id 
            WHERE s.slug = ? AND s.active = 1");
        $stmt->execute([$slug]);
        $service = $stmt->fetch();
        
        if (!$service) {
            return Response::json(['error' => 'Service non trouvé'], 404);
        }
        
        return Response::json($service);
    }
    
    // GET /api/portfolio
    public function getPortfolio() {
        $category = $_GET['category'] ?? null;
        
        if ($category) {
            $stmt = $this->db->prepare("SELECT r.*, c.name as category_name FROM realizations r 
                LEFT JOIN categories c ON r.category_id = c.id 
                WHERE c.slug = ? ORDER BY r.created_at DESC");
            $stmt->execute([$category]);
        } else {
            $stmt = $this->db->query("SELECT r.*, c.name as category_name FROM realizations r 
                LEFT JOIN categories c ON r.category_id = c.id 
                ORDER BY r.created_at DESC");
        }
        
        $realizations = $stmt->fetchAll();
        
        return Response::json($realizations);
    }
    
    // POST /api/contact
    public function contact() {
        $data = json_decode(file_get_contents('php://input'), true);
        
        $name = trim($data['name'] ?? '');
        $email = trim($data['email'] ?? '');
        $phone = trim($data['phone'] ?? '');
        $message = trim($data['message'] ?? '');
        
        if (empty($name) || empty($email) || empty($message)) {
            return Response::json(['error' => 'Champs obligatoires manquants'], 400);
        }
        
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return Response::json(['error' => 'Email invalide'], 400);
        }
        
        $stmt = $this->db->prepare("INSERT INTO contacts (name, email, phone, message, source) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$name, $email, $phone, $message, 'contact_form']);
        
        return Response::json(['success' => true, 'message' => 'Message envoyé avec succès']);
    }
    
    // POST /api/quote
    public function requestQuote() {
        $data = json_decode(file_get_contents('php://input'), true);
        
        $customerName = trim($data['customer_name'] ?? '');
        $customerEmail = trim($data['customer_email'] ?? '');
        $customerPhone = trim($data['customer_phone'] ?? '');
        $items = $data['items'] ?? [];
        $notes = trim($data['notes'] ?? '');
        
        if (empty($customerName) || empty($items)) {
            return Response::json(['error' => 'Informations incomplètes'], 400);
        }
        
        $totalEstimated = $this->calculateTotal($items);
        
        $stmt = $this->db->prepare("INSERT INTO quotes (customer_name, customer_email, customer_phone, items, total_estimated, notes) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$customerName, $customerEmail, $customerPhone, json_encode($items), $totalEstimated, $notes]);
        
        return Response::json([
            'success' => true,
            'message' => 'Demande de devis envoyée',
            'estimated_total' => $totalEstimated
        ]);
    }
    
    // GET /api/prices
    public function getPrices() {
        $object = $_GET['object'] ?? '';
        $options = json_decode($_GET['options'] ?? '[]', true);
        
        if (empty($object)) {
            return Response::json(['error' => 'Objet requis'], 400);
        }
        
        $stmt = $this->db->prepare("SELECT * FROM services WHERE slug = ? AND active = 1");
        $stmt->execute([$object]);
        $service = $stmt->fetch();
        
        if (!$service) {
            return Response::json(['error' => 'Service non trouvé'], 404);
        }
        
        $basePrice = $service['price_base'];
        $pricingMeta = json_decode($service['pricing_meta'] ?? '{}', true);
        
        $total = $this->calculatePriceWithOptions($basePrice, $pricingMeta, $options);
        
        return Response::json([
            'service' => $service['title'],
            'base_price' => $basePrice,
            'total' => $total,
            'currency' => 'FCFA'
        ]);
    }
    
    // Calculer le prix avec options
    private function calculatePriceWithOptions($basePrice, $meta, $options) {
        $total = $basePrice;
        
        if (isset($meta['options'])) {
            foreach ($options as $option) {
                if (isset($meta['options'][$option])) {
                    $total += $meta['options'][$option];
                }
            }
        }
        
        return $total;
    }
    
    // Calculer le total pour une commande
    private function calculateTotal($items) {
        $total = 0;
        
        foreach ($items as $item) {
            $serviceId = $item['service_id'] ?? null;
            $quantity = $item['quantity'] ?? 1;
            
            if ($serviceId) {
                $stmt = $this->db->prepare("SELECT price_base, pricing_meta FROM services WHERE id = ?");
                $stmt->execute([$serviceId]);
                $service = $stmt->fetch();
                
                if ($service) {
                    $basePrice = $service['price_base'];
                    $pricingMeta = json_decode($service['pricing_meta'] ?? '{}', true);
                    
                    $itemPrice = $this->calculatePriceWithOptions($basePrice, $pricingMeta, $item['options'] ?? []);
                    $total += $itemPrice * $quantity;
                }
            }
        }
        
        return $total;
    }
}
