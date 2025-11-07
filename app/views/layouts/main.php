<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'KIB - Kadass International Business' ?></title>
    <meta name="description" content="<?= $description ?? 'Personnalisation d\'objets au Burkina Faso' ?>">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="<?= AssetHelper::asset('css/style.css') ?>">
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="container">
            <nav class="navbar">
                <div class="logo">
                    <a href="<?= AssetHelper::getBasePath() ?>/">KIB</a>
                    <span class="logo-subtitle">Kadass International Business</span>
                </div>
                
                <button class="mobile-menu-toggle" id="mobileMenuToggle">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
                
                <div class="mobile-menu-overlay" id="mobileMenuOverlay"></div>
                
                <ul class="nav-menu" id="navMenu">
                    <li class="menu-close-header">
                        <button class="menu-close-btn" id="menuCloseBtn">
                            <i class="fas fa-times"></i> Fermer
                        </button>
                    </li>
                    <li><a href="<?= AssetHelper::getBasePath() ?>/">Accueil</a></li>
                    <li><a href="<?= AssetHelper::getBasePath() ?>/services">Services</a></li>
                    <li><a href="<?= AssetHelper::getBasePath() ?>/portfolio">Portfolio</a></li>
                    <li><a href="<?= AssetHelper::getBasePath() ?>/tarifs">Tarifs</a></li>
                    <li><a href="<?= AssetHelper::getBasePath() ?>/a-propos">À propos</a></li>
                    <li><a href="<?= AssetHelper::getBasePath() ?>/contact">Contact</a></li>
                    <li class="cta-nav"><a href="<?= AssetHelper::getBasePath() ?>/contact" class="btn-primary">Demander un devis</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <!-- Main Content -->
    <main class="main-content">
        <?php 
        echo $content ?? ''; 
        ?>
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h3>KIB</h3>
                    <p>Votre spécialiste en personnalisation d'objets au Burkina Faso</p>
                </div>
                
                <div class="footer-section">
                    <h4>Navigation</h4>
                    <ul>
                        <li><a href="<?= AssetHelper::getBasePath() ?>/services">Services</a></li>
                        <li><a href="<?= AssetHelper::getBasePath() ?>/portfolio">Portfolio</a></li>
                        <li><a href="<?= AssetHelper::getBasePath() ?>/tarifs">Tarifs</a></li>
                        <li><a href="<?= AssetHelper::getBasePath() ?>/contact">Contact</a></li>
                    </ul>
                </div>
                
                <div class="footer-section">
                    <h4>Contact</h4>
                    <ul>
                        <li>
                            <i class="fas fa-phone"></i>
                            <a href="tel:<?= $settings['phone_number'] ?? '' ?>"><?= $settings['phone_number'] ?? '' ?></a>
                        </li>
                        <li>
                            <i class="fas fa-envelope"></i>
                            <a href="mailto:<?= $settings['email'] ?? '' ?>"><?= $settings['email'] ?? '' ?></a>
                        </li>
                        <li>
                            <i class="fas fa-map-marker-alt"></i>
                            <?= $settings['address'] ?? '' ?>
                        </li>
                    </ul>
                </div>
                
                <div class="footer-section">
                    <h4>Réseaux sociaux</h4>
                    <div class="social-links">
                        <?php if (!empty($settings['facebook_url'])): ?>
                            <a href="<?= $settings['facebook_url'] ?>" target="_blank" title="Facebook">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                        <?php endif; ?>
                        <?php if (!empty($settings['instagram_url'])): ?>
                            <a href="<?= $settings['instagram_url'] ?>" target="_blank" title="Instagram">
                                <i class="fab fa-instagram"></i>
                            </a>
                        <?php endif; ?>
                        <?php if (!empty($settings['tiktok_url'])): ?>
                            <a href="<?= $settings['tiktok_url'] ?>" target="_blank" title="TikTok">
                                <i class="fab fa-tiktok"></i>
                            </a>
                        <?php endif; ?>
                        <?php if (!empty($settings['whatsapp_number'])): ?>
                            <a href="https://wa.me/<?= $settings['whatsapp_number'] ?? '' ?>" target="_blank" title="WhatsApp">
                                <i class="fab fa-whatsapp"></i>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            
            <div class="footer-bottom">
                <p>&copy; <?= date('Y') ?> KIB - Kadass International Business. Tous droits réservés.</p>
            </div>
        </div>
    </footer>

    <!-- WhatsApp Float Button -->
    <a href="https://wa.me/<?= $settings['whatsapp_number'] ?? '' ?>?text=Bonjour,%20je%20souhaite%20en%20savoir%20plus%20sur%20vos%20services" 
       class="whatsapp-float" target="_blank" title="Contactez-nous sur WhatsApp">
        <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M16 0C7.164 0 0 7.164 0 16c0 2.82.724 5.463 1.992 7.765L0 32l8.435-1.92C10.7 31.217 13.245 32 16 32c8.836 0 16-7.164 16-16S24.836 0 16 0zm0 29.003c-2.248 0-4.36-.604-6.173-1.647L8.294 26.63l-4.67 1.065 1.204-4.327A12.995 12.995 0 013.004 16C3.003 8.82 8.82 3.003 16 3.003S28.997 8.82 28.997 16 23.18 29.003 16 29.003z" fill="#fff"/>
            <path d="M23.872 18.867c-.316-.157-1.872-.924-2.163-1.03-.29-.105-.502-.157-.714.157-.212.314-.824 1.03-1.01 1.241-.186.212-.372.234-.69.078-.316-.158-1.338-.494-2.55-1.572-.943-.839-1.582-1.877-1.768-2.193-.186-.315-.02-.486.14-.641.144-.14.316-.372.473-.556.157-.186.21-.315.315-.525.105-.21.053-.393-.027-.556-.078-.163-.71-1.712-.974-2.344-.256-.617-.517-.534-.974-.525-.454-.01-.783-.018-1.006.08-.224.105-.403.31-.53.602-.212.467-.81 1.888-.81 3.848 0 1.96 1.427 4.465 1.626 4.778.2.314 2.812 4.686 6.902 6.535.954.428 1.699.686 2.277.877.978.319 1.868.274 2.57.166.785-.118 2.412-.988 2.748-1.943.344-.956.344-1.774.24-1.943-.105-.17-.392-.266-.708-.423z" fill="#fff"/>
        </svg>
    </a>

    <script>
        // Définir le chemin de base pour les requêtes AJAX
        window.APP_BASE_PATH = '<?= AssetHelper::getBasePath() ?>';
    </script>
    <script src="<?= AssetHelper::asset('js/main.js') ?>"></script>
</body>
</html>
