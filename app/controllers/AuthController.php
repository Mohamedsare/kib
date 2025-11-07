<?php
// Contrôleur d'authentification
class AuthController {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }
    
    // Afficher la page de connexion
    public function showLogin() {
        if (Auth::check()) {
            Response::redirect('/admin');
        }
        
        $title = 'Connexion - KIB Admin';
        ob_start();
        include __DIR__ . '/../views/auth/login.php';
        echo ob_get_clean();
    }
    
    // Traiter la connexion
    public function login() {
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        
        if (empty($email) || empty($password)) {
            Session::set('error', 'Veuillez remplir tous les champs');
            Response::redirect('/login');
        }
        
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();
        
        if ($user && password_verify($password, $user['password'])) {
            Auth::login($user);
            
            // Logger l'activité
            $this->logActivity($user['id'], 'login', ['email' => $email]);
            
            Response::redirect('/admin');
        } else {
            Session::set('error', 'Email ou mot de passe incorrect');
            Response::redirect('/login');
        }
    }
    
    // API login
    public function apiLogin($params) {
        $data = json_decode(file_get_contents('php://input'), true);
        
        $email = $data['email'] ?? '';
        $password = $data['password'] ?? '';
        
        if (empty($email) || empty($password)) {
            return Response::json(['error' => 'Identifiants requis'], 400);
        }
        
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();
        
        if ($user && password_verify($password, $user['password'])) {
            Auth::login($user);
            $this->logActivity($user['id'], 'login', ['email' => $email]);
            
            return Response::json([
                'success' => true,
                'user' => [
                    'id' => $user['id'],
                    'name' => $user['name'],
                    'email' => $user['email'],
                    'role' => $user['role']
                ]
            ]);
        }
        
        return Response::json(['error' => 'Identifiants invalides'], 401);
    }
    
    // Déconnexion
    public function logout() {
        if (Auth::check()) {
            $user = Auth::user();
            $this->logActivity($user['id'], 'logout', []);
        }
        
        Auth::logout();
        Response::redirect('/login');
    }
    
    // Logger une activité
    private function logActivity($userId, $action, $meta = []) {
        $stmt = $this->db->prepare("INSERT INTO activity_logs (user_id, action, meta) VALUES (?, ?, ?)");
        $stmt->execute([$userId, $action, json_encode($meta)]);
    }
}
