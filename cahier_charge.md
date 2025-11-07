# Cahier des charges

**Projet :** Site web de publicité et service de personnalisation d'objets

**Technologie cible :** PHP + MySQL(aucun framework)

**Public cible :** Burkina Faso (clients particuliers et petites/professionnels)

---

## 1. Contexte & objectifs

**Contexte :**
Une petite entreprise burkinabè vient d'ouvrir et propose la personnalisation d'objets : maillots, habits (tout type), cartes de visite, pochettes de téléphones, gobelets, porte-clés, badges, etc. Elle souhaite un site web pour :
- Faire la publicité des services et réalisations.
- Montrer un catalogue / portfolio attractif et mobile-first.
- Permettre aux visiteurs de contacter instantanément (WhatsApp / téléphone) ou via formulaire.
- Montrer des tarifs indicatifs selon l'objet et options.
- Avoir un backoffice complet pour gérer le contenu, produits, commandes, statistiques en temps réel, backups, paramètres.

**Objectifs principaux :**
- Attirer et convertir des visiteurs locaux.
- Rendre la prise de contact très facile (WhatsApp & formulaire).
- Afficher réalisations et tarifs de façon claire.
- Permettre une administration complète et sécurisée.
- Optimiser pour mobile, SEO et performance.

---

## 2. Périmètre fonctionnel (haut niveau)

### Front-office (visiteurs sans authentification)
- Page d'accueil (hero percutant, CTA WhatsApp, carrousel réalisations).
- Page "Nos services" (liste des services + images d'illustration, description, CTA).
- Page "Réalisations / Portfolio" (galerie filtrable par catégorie : maillots, gobelets, etc.).
- Page "Tarifs" (tarifs indicatifs par catégorie et options; calculateur simple de prix).
- Page "À propos" (histoire, équipe, machines, localisation, horaires, photos).
- Page "Contact" (formulaire de contact + coordonnées + bouton WhatsApp + numéro cliquable pour mobiles).
- Barre ou module "Demander un devis" (CTA omniprésent).
- Footer (informations légales, réseaux sociaux, adresse, inscription newsletter).

### Authentification & comptes
- Authentification complète (inscription, login, mot de passe oublié, réinitialisation).
- Rôles : Admin (super), Manager / Éditeur, Support.
- Les utilisateurs ne sont **pas** obligés d'avoir un compte pour consulter le site ou contacter l'entreprise.

### Back-office (Admin Panel)
- Dashboard d'accueil avec résumé KPIs (visites, conversions, messages non lus, commandes en attente).
- Gestion CRUD : Services, Catégories, Réalisations (portfolio), Tarifs/Offres, Équipe, Machines, Pages CMS (À propos, FAQ), Bannières/carrousels, Témoignages.
- Gestion des messages / demandes de contact / demandes de devis.
- Gestion des utilisateurs et permissions.
- Gestion des médias (upload, compression, redimensionnement automatique, suppression).
- Statistiques en temps réel et historique (voir section dédiée).
- Paramètres du site (WhatsApp, téléphone, adresse, email, SEO global, tracking codes).
- Export / import et backup complet de la base de données (.sql zip).
- Journal d'activités (audit): actions des admins, connexions.

### API & Asynchronisme
- Backend RESTful JSON API pour toutes les ressources (endpoints pour fetch/CRUD).
- Tous les endpoints conçus pour être asynchrones (AJAX / Fetch depuis le front).
- Endpoints sécurisés via tokens CSRF/session + JWT pour API si besoin.

### Sécurité & disponibilité
- Protection contre injections SQL (requêtes préparées / ORM).
- Protection XSS (escaping, CSP), CSRF tokens, validation côté serveur et client.
- Limitation de taux (rate limiting) sur endpoints sensibles (login, contact).
- WAF et règles basiques pour bloquer attaques communes.
- Stratégies basiques anti-DDoS (limit requests, CDN, mettre en place Cloudflare ou service équivalent).
- Sauvegardes automatiques et export manuel depuis backoffice.

---

## 3. Exigences non-fonctionnelles

### Performance & cache
- Mobile-first, responsive design.
- Utiliser cache côté serveur : APCu ou Redis (sessions, fragments HTML, pages statiques) + headers HTTP (Cache-Control) pour assets.
- Système de cache natif PHP/MySQL (ex: mécanisme de cache file-based ou Redis) pour pages intensivement visitées.
- Minimisation des assets (CSS/JS), lazy-loading des images, compression (gzip/brotli).

### SEO
- Balises meta (title, description), balisage OpenGraph et Twitter Card.
- URLs propres (SEO-friendly), sitemap.xml dynamique, robots.txt.
- Schema.org (Product, LocalBusiness, BreadcrumbList) pour améliorer affichage dans recherche.
- Texte indexable et accessible, structure H1..H3.

### Accessibilité
- Respecter WCAG2 AA basique : contrastes, labels, formulaires accessibles, navigation clavier.

### Internationalisation
- Site en français (priorité). Prévoir système de traduction si extension future (i18n).

### Logs & monitoring
- Logs applicatifs, erreurs (Sentry ou équivalent), monitoring uptime.

---

## 4. Architecture technique recommandée

- **Backend :** PHP 8.1+ (MVC).
- **Base données :** MySQL 8 (schéma relationnel).
- **Cache :** (cache natif php/mysql).

- **Stockage média :** Local (public/uploads) ou S3-compatible (min.io) si scale.
- **Realtime analytics :** WebSocket / Pusher / Laravel Echo + Redis pour le nombre d'utilisateurs en ligne et pages vues en direct.
- **Serveur :** LAMP/LEMP (Nginx recommandé) ou hébergement mutualisé (si budget limité).
- **protection DDOS :**  protection DDoS.
- **Backups :** export .sql + compress + stockage sur espace sécurisé .

---

## 5. Base de données (proposition de schéma simplifié)

### Tables principales

**users**
- id (PK)
- name
- email
- password_hash
- role (admin, editor, support)
- phone
- created_at
- updated_at

**services**
- id
- title
- slug
- description
- price_base (decimal) — prix de base indicatif
- pricing_meta (json) — options et coefficients
- image_id
- active (bool)
- created_at
- updated_at

**categories**
- id
- name
- slug
- created_at
- updated_at

**realizations (portfolio)**
- id
- title
- description
- category_id
- images (json ou table images séparée)
- client_name (nullable)
- created_at

**images**
- id
- filename
- path
- width
- height
- mimetype
- size
- created_at

**contacts/messages**
- id
- name
- email
- phone
- message
- source (contact_form, quick_quote)
- status (new, read, answered)
- created_at

**quotes / orders (demandes de devis)**
- id
- customer_name
- customer_contact
- items (json) // objets à personnaliser + options
- total_estimated
- status (pending, accepted, rejected, completed)
- created_at

**site_settings**
- id
- key
- value (text/json)

**analytics_events** (agrégation pour statistiques)
- id
- session_id
- ip
- user_agent
- country
- city
- path
- referrer
- event_type (page_view, click)
- created_at

**activity_logs**
- id
- user_id
- action
- meta (json)
- created_at

---

## 6. Endpoints API (exemples)

**Public**
- `GET /api/services` — liste des services
- `GET /api/services/{slug}` — détail service
- `GET /api/portfolio?category=x` — galerie filtrée
- `POST /api/contact` — envoi message contact
- `POST /api/quote` — demander un devis (items + contact)
- `GET /api/prices?object=maillot&options=...` — calcul prix indicatif

**Auth / Admin (JWT/session)**
- `POST /api/login`
- `POST /api/logout`
- `GET /api/admin/dashboard`
- `CRUD /api/admin/services`
- `CRUD /api/admin/portfolio`
- `GET /api/admin/analytics/realtime`
- `POST /api/admin/backup` — déclenchement / téléchargement backup

Tous les endpoints doivent répondre JSON et supporter CORS/CSRF selon usage.

---

## 7. Fonctionnalités spécifiques détaillées

### 7.1 Galerie & Portfolio
- Galerie en maçonnerie (masonry grid) avec filtres par type.
- Chaque réalisation a page dédiée (carousel d'images, description, techniques utilisées).
- Lazy loading et images WebP (si possible) pour réduire poids.

### 7.2 Module Tarifs / Calculateur
- Tarifs de base par catégorie + options (impression couleur, quantité, finition).
- Calculateur côté client qui interroge `/api/prices` pour retourner estimation.
- Possibilité de laisser demande de devis avec détails (fichiers optionnels upload).

### 7.3 Contact / Devis
- Formulaire simple (nom, email, téléphone, message, fichier attached optionnel).
- Validation côté front et back.
- Notifications par email et backoffice (vue messages non lus).
- Bouton WhatsApp : lien `https://wa.me/<phone>?text=...` ou `https://api.whatsapp.com/send?phone=` pour mobiles.

### 7.4 Auth & Permissions
- Password hashing sécurisé (bcrypt/argon2).
- 2FA possible en option (Google Authenticator) pour comptes admin.
- Gestion des droits granulaires via middleware.

### 7.5 Backoffice - Statistiques en temps réel
- Implémentation via WebSockets (Laravel Echo) ou Pusher :
  - Compteur d'utilisateurs en ligne (incrémentation via Redis per session).
  - Dernières pages visitées (flux live) avec IP, pays, ville, user-agent.
  - Vue historique par jour/semaines (charting).
- Respecter confidentialité : masquer IPs partiellement si requis et respecter RGPD-like considerations.

### 7.6 Sauvegardes
- Endpoint pour créer backup compressé (.sql.gz) et le télécharger.
- Planification cron pour backups automatiques (quotidien/hebdomadaire selon besoin).

### 7.7 Sécurité anti-attaque & anti-DDOS
- Config de serveur (limit_conn, limit_req pour Nginx)

- Protection brute-force login (verrous, captchas, blacklist IPs).
- Validation & sanitation de tous les uploads (types autorisés, taille max, virus scan si possible).

---

## 8. UX/UI & Design

- Design moderne, minimaliste et visuel (photos grandes, carrousels professionnels).
- Palette couleurs à définir (1 couleur principale + 2 secondaires).
- Typographie lisible sur mobile.
- CTA visibles (WhatsApp / Demander devis) sur toutes les pages.
- Animations légères (entrées, carrousels) mais performance priorisée.

---

## 9. SEO & Content

- Contenu localisé : mots-clés liés au Burkina Faso, villes (Ouagadougou), "personnalisation d'objets", "maillots personnalisés".
- Pages service optimisées pour mots-clés (titre H1, meta description unique).
- Blog / actualités (optionnel) pour poser du contenu et améliorer SEO local.

---

## 10. Tests & Validation


---

## 11. Déploiement & Maintenance

- Plan de maintenance : sauvegardes régulières, mises à jour sécurité PHP/MySQL/framework.

---

## 12. Livrables attendus



---

## 13. Priorisation des fonctionnalités (MVP)

**MVP (lancer vite, utile)**
1. Pages publiques : Accueil, Services, Portfolio, À propos, Contact.
2. Bouton WhatsApp & téléphone cliquable.
3. Formulaire contact (stockage & notification).
4. Backoffice minimal : CRUD Services + Portfolio + Messages.
5. Tarifs de base et petit calculateur.
6. Auth Admin simple.

**Fonctionnalités à ajouter ensuite**
- Realtime analytics & users en ligne.
- Export/Backup automatique.
- Blog/SEO content manager.
-
---

## 14. Exemples de bonnes pratiques techniques (rapide)


- Toujours valider/échapper l'entrée utilisateur avant rendu.
- Utiliser HTTPS partout (Let's Encrypt si besoin).
- Limiter taille des uploads et générer miniatures côté serveur.

---

## 15. Annexes : Exemple SQL (création simplifiée)

```sql
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

CREATE TABLE services (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(200) NOT NULL,
  slug VARCHAR(200) UNIQUE NOT NULL,
  description TEXT,
  price_base DECIMAL(10,2) DEFAULT 0.00,
  pricing_meta JSON,
  image_id INT,
  active TINYINT(1) DEFAULT 1,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NULL ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE realizations (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(255),
  description TEXT,
  category_id INT,
  images JSON,
  client_name VARCHAR(150),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

---

## 16. Sujets à valider / Questions client

- Liste exacte des catégories d'objets et options tarifaires (ex : impression DTG, sérigraphie, broderie).
- Taux TVA / taxes locales ou notions de prix (si besoin inclure dans tarifs).
- Numéro WhatsApp officiel et message d'ouverture par défaut.
- Hébergement préféré (budget, fournisseur).
- Quelle langue(s) exacte(s) : uniquement français ? (on peut prévoir mooré + dioula si ciblage local très fort).

---

## 17. Étapes suivantes recommandées (pragmatiques)

1. Atelier de cadrage : définir catégories, tarifs de base, images initiales pour le portfolio.
2. Valider maquettage (3 écrans : mobile, desktop, tablette).
3. Développement MVP (front public + backoffice minimal).
4. Tests & déploiement.
5. Phase 2 : analytics en temps réel, backup automatique, optimisation SEO.

---

## 18. Autres suggestions à intégrer (optionnelles mais utiles)

- Module de chat en direct (intercom-like) couplé à WhatsApp.
- Option de commande en ligne simple (commande -> paiement mobile money) pour paiement d'acompte.
- Intégration d'avis clients (+ microformats pour SEO).
- Générateur de mockups : afficher aperçu du design sur objet.

---

> Si tu veux, je peux :
> - Générer un sitemap et l'arborescence détaillée des pages.
> - Créer des wireframes (mobile-first) ou maquettes UI.
> - Rédiger les spécifications API détaillées (liste complète des endpoints avec payloads).
  



  ** nom du site KIB**( Kadass International Business)

**Fin du cahier des charges**

