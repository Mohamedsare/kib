<?php
// Middleware d'authentification
function requireAuth() {
    Session::start();
    
    if (!Auth::check()) {
        http_response_code(401);
        echo json_encode(['error' => 'Authentification requise']);
        exit;
    }
    
    return true;
}

// Middleware pour admin uniquement
function requireAdmin() {
    requireAuth();
    
    if (!Auth::isAdmin()) {
        http_response_code(403);
        echo json_encode(['error' => 'Accès refusé']);
        exit;
    }
    
    return true;
}

// Middleware pour éditeur ou admin
function requireEditor() {
    requireAuth();
    
    if (!Auth::isEditor()) {
        http_response_code(403);
        echo json_encode(['error' => 'Accès refusé']);
        exit;
    }
    
    return true;
}
