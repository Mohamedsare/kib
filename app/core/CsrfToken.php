<?php
// Protection CSRF
class CsrfToken {
    // Générer un token CSRF
    public static function generate() {
        Session::start();
        
        if (!Session::has('csrf_token')) {
            Session::set('csrf_token', bin2hex(random_bytes(32)));
        }
        
        return Session::get('csrf_token');
    }
    
    // Vérifier le token
    public static function verify($token) {
        Session::start();
        return Session::has('csrf_token') && hash_equals(Session::get('csrf_token'), $token);
    }
    
    // Obtenir le token
    public static function get() {
        return self::generate();
    }
}
