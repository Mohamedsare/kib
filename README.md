# KIB - Kadass International Business

Site web de publicité et service de personnalisation d'objets au Burkina Faso.

## 🚀 Installation

### Prérequis
- PHP 8.1 ou supérieur
- MySQL 8
- Apache/Nginx avec mod_rewrite
- XAMPP, WAMP ou MAMP (pour développement local)

### Étapes d'installation

1. **Cloner/Copier le projet**
```bash
cd C:\xampp\htdocs\kib
```

2. **Créer la base de données**
```bash
# Via phpMyAdmin ou ligne de commande MySQL
mysql -u root -p < database/schema.sql
```

Ou importez le fichier `database/schema.sql` via phpMyAdmin.

3. **Configurer la base de données**
Éditez `config/database.php` avec vos paramètres :
```php
return [
    'host' => 'localhost',
    'dbname' => 'kib_db',
    'username' => 'root',
    'password' => '',
    'charset' => 'utf8mb4'
];
```

4. **Configurer l'application**
Éditez `config/app.php` avec vos informations :
```php
'whatsapp' => '+226XXXXXXXX',
'phone' => '+226XXXXXXXX',
'email' => 'contact@kib.bf',
```

5. **Créer les dossiers nécessaires**
```bash
mkdir public/uploads
mkdir public/uploads/services
mkdir public/uploads/realizations
mkdir backups
chmod -R 755 public/uploads
```

6. **Accéder à l'application**
- Front-office : http://localhost/kib/public/
- Back-office : http://localhost/kib/public/login
  - Email : admin@kib.bf
  - Mot de passe : admin123 ⚠️ À changer en production !

## 📁 Structure du projet

```
kib/
├── app/
│   ├── controllers/      # Contrôleurs MVC
│   ├── core/            # Classes de base (Database, Router, etc.)
│   ├── middleware/       # Middlewares (Auth, API)
│   └── views/           # Templates et vues
├── assets/
│   ├── css/            # Styles CSS
│   └── js/             # JavaScript
├── config/             # Configuration
├── database/           # Schéma SQL
├── public/             # Point d'entrée web
└── backups/            # Sauvegardes (auto-créé)
```

## 🎯 Fonctionnalités

### Front-office
- ✅ Page d'accueil avec hero et statistiques
- ✅ Catalogue de services
- ✅ Portfolio de réalisations (filtrable)
- ✅ Page de tarifs
- ✅ Formulaire de contact
- ✅ Page à propos
- ✅ Bouton WhatsApp flottant
- ✅ Design responsive (mobile-first)

### Back-office
- ✅ Tableau de bord avec statistiques en temps réel
- ✅ Gestion CRUD Services
- ✅ Gestion CRUD Portfolio/Réalisations
- ✅ Gestion des messages de contact
- ✅ Analytics et statistiques
- ✅ Paramètres du site
- ✅ Système de backup

### API REST
- ✅ Endpoints publics (services, portfolio, contact)
- ✅ Endpoints admin sécurisés
- ✅ Authentification JWT/Session

## 🔐 Sécurité

- Protection CSRF
- Protection XSS
- Requêtes préparées (SQL injection)
- Hachage de mots de passe (bcrypt)
- Rate limiting (à configurer)
- Protection DDoS basique

## 📝 Notes importantes

⚠️ **SÉCURITÉ** : Changez le mot de passe par défaut de l'admin en production !
⚠️ **Configuration** : Configurez les numéros WhatsApp et téléphone dans `config/app.php`
⚠️ **Uploads** : Le dossier `public/uploads` doit avoir les permissions en écriture

## 🛠️ Développement

L'application est construite sans framework, en PHP pur avec :
- Architecture MVC
- Routing personnalisé
- PDO pour la base de données
- Sessions PHP pour l'authentification

## 📞 Support

Pour toute question, contactez-nous.

## 📄 Licence

Propriété de KIB - Kadass International Business
