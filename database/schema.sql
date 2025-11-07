-- Base de données pour KIB (Kadass International Business)
-- Importez ce fichier via phpMyAdmin ou MySQL

-- Créer la base de données (optionnel si déjà créée manuellement)
CREATE DATABASE IF NOT EXISTS kib_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Utiliser la base de données
USE kib_db;

-- Table des utilisateurs
CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(150) NOT NULL,
  email VARCHAR(150) UNIQUE NOT NULL,
  password VARCHAR(255) NOT NULL,
  role VARCHAR(50) DEFAULT 'editor',
  phone VARCHAR(50),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NULL ON UPDATE CURRENT_TIMESTAMP
);

-- Table des catégories
CREATE TABLE categories (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  slug VARCHAR(100) UNIQUE NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NULL ON UPDATE CURRENT_TIMESTAMP
);

-- Table des services
CREATE TABLE services (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(200) NOT NULL,
  slug VARCHAR(200) UNIQUE NOT NULL,
  description TEXT,
  price_base DECIMAL(10,2) DEFAULT 0.00,
  pricing_meta JSON,
  image_id INT,
  active TINYINT(1) DEFAULT 1,
  category_id INT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NULL ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL
);

-- Table des images
CREATE TABLE images (
  id INT AUTO_INCREMENT PRIMARY KEY,
  filename VARCHAR(255) NOT NULL,
  path VARCHAR(255) NOT NULL,
  width INT,
  height INT,
  mimetype VARCHAR(100),
  size INT,
  alt_text VARCHAR(255),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table des réalisations (portfolio)
CREATE TABLE realizations (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(255),
  description TEXT,
  category_id INT,
  images JSON,
  client_name VARCHAR(150),
  featured TINYINT(1) DEFAULT 0,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NULL ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL
);

-- Table des messages de contact
CREATE TABLE contacts (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(150) NOT NULL,
  email VARCHAR(150) NOT NULL,
  phone VARCHAR(50),
  message TEXT NOT NULL,
  source VARCHAR(50) DEFAULT 'contact_form',
  status VARCHAR(20) DEFAULT 'new',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table des demandes de devis
CREATE TABLE quotes (
  id INT AUTO_INCREMENT PRIMARY KEY,
  customer_name VARCHAR(150) NOT NULL,
  customer_email VARCHAR(150),
  customer_phone VARCHAR(50),
  items JSON,
  total_estimated DECIMAL(10,2),
  status VARCHAR(20) DEFAULT 'pending',
  notes TEXT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NULL ON UPDATE CURRENT_TIMESTAMP
);

-- Table des paramètres du site
CREATE TABLE site_settings (
  id INT AUTO_INCREMENT PRIMARY KEY,
  setting_key VARCHAR(100) UNIQUE NOT NULL,
  setting_value TEXT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NULL ON UPDATE CURRENT_TIMESTAMP
);

-- Table des événements analytics
CREATE TABLE analytics_events (
  id INT AUTO_INCREMENT PRIMARY KEY,
  session_id VARCHAR(100),
  ip VARCHAR(45),
  user_agent TEXT,
  country VARCHAR(100),
  city VARCHAR(100),
  path VARCHAR(255),
  referrer TEXT,
  event_type VARCHAR(50) DEFAULT 'page_view',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  INDEX idx_created_at (created_at),
  INDEX idx_event_type (event_type)
);

-- Table des logs d'activités
CREATE TABLE activity_logs (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT,
  action VARCHAR(100),
  meta JSON,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL,
  INDEX idx_created_at (created_at)
);

-- Insertion des données initiales

-- Créer un utilisateur admin par défaut
-- Mot de passe: admin123 (changez-le en production!)
INSERT INTO users (name, email, password, role) VALUES
('Administrateur', 'admin@kib.bf', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin');

-- Insertion des catégories
INSERT INTO categories (name, slug) VALUES
('Maillots', 'maillots'),
('Gobelets', 'gobelets'),
('Cartes de visite', 'cartes-de-visite'),
('Pochettes téléphone', 'pochettes-telephone'),
('Porte-clés', 'porte-cles'),
('Badges', 'badges'),
('Habits', 'habits');

-- Insertion des paramètres du site
INSERT INTO site_settings (setting_key, setting_value) VALUES
('site_name', 'KIB - Kadass International Business'),
('whatsapp_number', '+226XXXXXXXX'),
('phone_number', '+226XXXXXXXX'),
('email', 'contact@kib.bf'),
('address', 'Ouagadougou, Burkina Faso'),
('facebook_url', ''),
('instagram_url', ''),
('twitter_url', ''),
('youtube_url', '');
