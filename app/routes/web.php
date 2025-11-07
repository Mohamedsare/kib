<?php
// Définition de toutes les routes de l'application

// Routes publiques - Pages
$router->get('/', 'PageController@home');
$router->get('/services', 'PageController@services');
$router->get('/portfolio', 'PageController@portfolio');
$router->get('/tarifs', 'PageController@pricing');
$router->get('/a-propos', 'PageController@about');
$router->get('/contact', 'PageController@contact');

// Routes publiques - API
$router->get('/api/services', 'ApiController@getServices');
$router->get('/api/services/{slug}', 'ApiController@getService');
$router->get('/api/portfolio', 'ApiController@getPortfolio');
$router->post('/api/contact', 'ApiController@contact', 'apiMiddleware');
$router->post('/api/quote', 'ApiController@requestQuote', 'apiMiddleware');
$router->get('/api/prices', 'ApiController@getPrices');

// Routes d'authentification
$router->get('/login', 'AuthController@showLogin');
$router->post('/login', 'AuthController@login');
$router->post('/logout', 'AuthController@logout');
$router->post('/api/login', 'AuthController@apiLogin', 'apiMiddleware');

// Routes admin - Pages
$router->get('/admin', function() {
    requireEditor();
    Response::redirect('/admin/dashboard');
});
$router->get('/admin/dashboard', 'AdminController@dashboard', 'requireEditor');
$router->get('/admin/services', 'AdminController@services', 'requireEditor');
$router->get('/admin/portfolio', 'AdminController@portfolio', 'requireEditor');
$router->get('/admin/messages', 'AdminController@messages', 'requireEditor');
$router->get('/admin/settings', 'AdminController@settings', 'requireAdmin');
$router->get('/admin/analytics', 'AdminController@analytics', 'requireAdmin');
$router->get('/admin/users', 'AdminController@users', 'requireAdmin');

// Routes admin - API
$router->get('/api/admin/dashboard', 'ApiAdminController@dashboard', ['requireEditor', 'apiMiddleware']);
$router->get('/api/admin/services', 'ApiAdminController@services', ['requireEditor', 'apiMiddleware']);
$router->post('/api/admin/services', 'ApiAdminController@createService', ['requireEditor', 'apiMiddleware']);
$router->put('/api/admin/services/{id}', 'ApiAdminController@updateService', ['requireEditor', 'apiMiddleware']);
$router->delete('/api/admin/services/{id}', 'ApiAdminController@deleteService', ['requireEditor', 'apiMiddleware']);

$router->get('/api/admin/portfolio', 'ApiAdminController@portfolio', ['requireEditor', 'apiMiddleware']);
$router->post('/api/admin/portfolio', 'ApiAdminController@createRealization', ['requireEditor', 'apiMiddleware']);
$router->put('/api/admin/portfolio/{id}', 'ApiAdminController@updateRealization', ['requireEditor', 'apiMiddleware']);
$router->delete('/api/admin/portfolio/{id}', 'ApiAdminController@deleteRealization', ['requireEditor', 'apiMiddleware']);

$router->get('/api/admin/messages', 'ApiAdminController@messages', ['requireEditor', 'apiMiddleware']);
$router->put('/api/admin/messages/{id}', 'ApiAdminController@updateMessage', ['requireEditor', 'apiMiddleware']);
$router->delete('/api/admin/messages/{id}', 'ApiAdminController@deleteMessage', ['requireEditor', 'apiMiddleware']);

$router->get('/api/admin/analytics', 'ApiAdminController@analytics', ['requireAdmin', 'apiMiddleware']);
$router->post('/api/admin/backup', 'ApiAdminController@backup', ['requireAdmin', 'apiMiddleware']);

$router->get('/api/admin/settings', 'ApiAdminController@getSettings', ['requireAdmin', 'apiMiddleware']);
$router->post('/api/admin/settings', 'ApiAdminController@updateSettings', ['requireAdmin', 'apiMiddleware']);
