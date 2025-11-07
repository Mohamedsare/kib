<?php
// Contrôleur pour le backoffice admin
class AdminController {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
        // Déjà vérifié par le middleware requireEditor
    }
    
    // Dashboard
    public function dashboard() {
        $stats = $this->getDashboardStats();
        
        $title = 'Dashboard - KIB Admin';
        $pageTitle = 'Dashboard';
        $active = 'dashboard';
        ob_start();
        include __DIR__ . '/../views/admin/dashboard.php';
        $content = ob_get_clean();
        include __DIR__ . '/../views/layouts/admin.php';
    }
    
    // Page services
    public function services() {
        $title = 'Services - KIB Admin';
        $pageTitle = 'Gestion des Services';
        $active = 'services';
        ob_start();
        include __DIR__ . '/../views/admin/services.php';
        $content = ob_get_clean();
        include __DIR__ . '/../views/layouts/admin.php';
    }
    
    // Page portfolio
    public function portfolio() {
        $title = 'Portfolio - KIB Admin';
        $pageTitle = 'Gestion du Portfolio';
        $active = 'portfolio';
        ob_start();
        include __DIR__ . '/../views/admin/portfolio.php';
        $content = ob_get_clean();
        include __DIR__ . '/../views/layouts/admin.php';
    }
    
    // Page messages
    public function messages() {
        $title = 'Messages - KIB Admin';
        $pageTitle = 'Messages de contact';
        $active = 'messages';
        ob_start();
        include __DIR__ . '/../views/admin/messages.php';
        $content = ob_get_clean();
        include __DIR__ . '/../views/layouts/admin.php';
    }
    
    // Page paramètres
    public function settings() {
        if (!Auth::isAdmin()) {
            Response::redirect('/admin/dashboard');
        }
        
        $title = 'Paramètres - KIB Admin';
        $pageTitle = 'Paramètres du site';
        $active = 'settings';
        ob_start();
        include __DIR__ . '/../views/admin/settings.php';
        $content = ob_get_clean();
        include __DIR__ . '/../views/layouts/admin.php';
    }
    
    // Page analytics
    public function analytics() {
        if (!Auth::isAdmin()) {
            Response::redirect('/admin/dashboard');
        }
        
        $title = 'Analytics - KIB Admin';
        $pageTitle = 'Statistiques';
        $active = 'analytics';
        ob_start();
        include __DIR__ . '/../views/admin/analytics.php';
        $content = ob_get_clean();
        include __DIR__ . '/../views/layouts/admin.php';
    }
    
    // Page utilisateurs
    public function users() {
        if (!Auth::isAdmin()) {
            Response::redirect('/admin/dashboard');
        }
        
        $title = 'Utilisateurs - KIB Admin';
        $pageTitle = 'Gestion des utilisateurs';
        $active = 'users';
        ob_start();
        include __DIR__ . '/../views/admin/users.php';
        $content = ob_get_clean();
        include __DIR__ . '/../views/layouts/admin.php';
    }
    
    // Récupérer les statistiques du dashboard
    private function getDashboardStats() {
        $stats = [];
        
        // Nombre de messages non lus
        $stmt = $this->db->query("SELECT COUNT(*) as count FROM contacts WHERE status = 'new'");
        $stats['unread_messages'] = $stmt->fetch()['count'];
        
        // Nombre de demandes de devis en attente
        $stmt = $this->db->query("SELECT COUNT(*) as count FROM quotes WHERE status = 'pending'");
        $stats['pending_quotes'] = $stmt->fetch()['count'];
        
        // Nombre total de services
        $stmt = $this->db->query("SELECT COUNT(*) as count FROM services");
        $stats['total_services'] = $stmt->fetch()['count'];
        
        // Nombre total de réalisations
        $stmt = $this->db->query("SELECT COUNT(*) as count FROM realizations");
        $stats['total_realizations'] = $stmt->fetch()['count'];
        
        // Vues aujourd'hui
        $today = date('Y-m-d');
        $stmt = $this->db->prepare("SELECT COUNT(*) as count FROM analytics_events 
            WHERE DATE(created_at) = ? AND event_type = 'page_view'");
        $stmt->execute([$today]);
        $stats['today_views'] = $stmt->fetch()['count'];
        
        // Utilisateurs en ligne (simulation - dans production utiliser Redis/Sessions)
        $stmt = $this->db->query("SELECT COUNT(DISTINCT session_id) as count FROM analytics_events 
            WHERE created_at >= DATE_SUB(NOW(), INTERVAL 15 MINUTE)");
        $stats['users_online'] = $stmt->fetch()['count'];
        
        return $stats;
    }
}
