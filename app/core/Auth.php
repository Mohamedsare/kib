<?php
// Système d'authentification
class Auth {
    // Vérifier si l'utilisateur est connecté
    public static function check() {
        Session::start();
        return Session::has('user_id');
    }
    
    // Obtenir l'utilisateur actuel
    public static function user() {
        if (!self::check()) {
            return null;
        }
        
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([Session::get('user_id')]);
        
        return $stmt->fetch();
    }
    
    // Vérifier le rôle
    public static function hasRole($role) {
        $user = self::user();
        return $user && $user['role'] === $role;
    }
    
    // Vérifier si admin
    public static function isAdmin() {
        return self::hasRole('admin');
    }
    
    // Vérifier si éditeur ou admin
    public static function isEditor() {
        $user = self::user();
        return $user && in_array($user['role'], ['admin', 'editor']);
    }
    
    // Connecter un utilisateur
    public static function login($user) {
        Session::start();
        Session::regenerate();
        Session::set('user_id', $user['id']);
        Session::set('user_role', $user['role']);
        Session::set('user_name', $user['name']);
        Session::set('user_email', $user['email']);
    }
    
    // Déconnecter
    public static function logout() {
        Session::start();
        Session::destroy();
    }
}
