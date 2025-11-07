<!-- Hero Section -->
<section class="hero">
    <div class="hero-slider-container">
        <div class="hero-slider">
            <!-- Slide 1 -->
            <div class="hero-slide active">
                <div class="hero-slide-content">
                    <div class="hero-text">
                        <h1>Personnalisation et Conception d'objets sur mesure</h1>
                        <p class="hero-subtitle">
                            Maillots,Cartes de visite,Pochettes téléphone, Porte-clés, Badges, tout type d'objets
                        </p>
                        <p class="hero-description">
                            Transformez vos idées en réalité avec KIB - Votre partenaire de confiance au Burkina Faso
                        </p>
                        <div class="hero-cta">
                            <a href="<?= AssetHelper::getBasePath() ?>/contact" class="btn btn-primary">
                                Demander un devis gratuit
                            </a>
                            <a href="<?= AssetHelper::getBasePath() ?>/services" class="btn btn-secondary">
                                Nos services
                            </a>
                        </div>
                    </div>
                    <div class="hero-image">
                        <img src="public/assets/img/im1.jpeg" alt="Personnalisation d'objets" loading="lazy">
                    </div>
                </div>
            </div>

            <!-- Slide 2 -->
            <div class="hero-slide">
                <div class="hero-slide-content">
                    <div class="hero-text">
                        <h1>Qualité Premium & Livraison Rapide</h1>
                        <p class="hero-subtitle">
                            Impression haute qualité • Matériaux durables • Service rapide et fiable
                        </p>
                        <p class="hero-description">
                            Nous nous engageons à vous livrer des produits de qualité supérieure dans les meilleurs
                            délais
                        </p>
                        <div class="hero-cta">
                            <a href="<?= AssetHelper::getBasePath() ?>/portfolio" class="btn btn-primary">
                                Nos réalisations
                            </a>
                            <a href="<?= AssetHelper::getBasePath() ?>/tarifs" class="btn btn-secondary">
                                Consulter nos tarifs
                            </a>
                        </div>
                    </div>
                    <div class="hero-image">
                        <img src="public/assets/img/im5.jpeg" alt="Qualité Premium" loading="lazy">
                    </div>
                </div>
            </div>

            <!-- Slide 3 -->
            <div class="hero-slide">
                <div class="hero-slide-content">
                    <div class="hero-text">
                        <h1>Expertise Locale au Burkina Faso</h1>
                        <p class="hero-subtitle">
                            Prix compétitifs • Support client dédié
                        </p>
                        <p class="hero-description">
                            Une équipe passionnée qui comprend vos besoins et vous accompagne dans vos projets
                            personnalisés
                        </p>
                        <div class="hero-cta">
                            <a href="<?= AssetHelper::getBasePath() ?>/a-propos" class="btn btn-primary">
                                En savoir plus
                            </a>
                            <a href="<?= AssetHelper::getBasePath() ?>/contact" class="btn btn-secondary">
                                Nous contacter
                            </a>
                        </div>
                    </div>
                    <div class="hero-image">
                        <img src="public/assets/img/im3.jpeg" alt="Expertise Locale" loading="lazy">
                    </div>
                </div>
            </div>
        </div>

        <!-- Navigation du carrousel -->
        <button class="hero-nav hero-nav-prev" aria-label="Précédent">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M15 18l-6-6 6-6" />
            </svg>
        </button>
        <button class="hero-nav hero-nav-next" aria-label="Suivant">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M9 18l6-6-6-6" />
            </svg>
        </button>

        <!-- Indicateurs de pagination -->
        <div class="hero-indicators">
            <button class="hero-indicator active" data-slide="0"></button>
            <button class="hero-indicator" data-slide="1"></button>
            <button class="hero-indicator" data-slide="2"></button>
        </div>
    </div>

    <!-- Stats rapides -->
    <div class="hero-stats">
        <div class="container">
            <div class="stats-grid">
                <div class="stat-item">
                    <h3>500+</h3>
                    <p>Projets réalisés</p>
                </div>
                <div class="stat-item">
                    <h3>100+</h3>
                    <p>Clients satisfaits</p>
                </div>
                <div class="stat-item">
                    <h3>15+</h3>
                    <p>Types d'objets</p>
                </div>
                <div class="stat-item">
                    <h3> 2 ans</h3>
                    <p>D'expérience</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Services -->
<section class="services-preview section">
    <div class="container">
        <div class="section-header">
            <h2>Nos Services</h2>
            <p>Nous personnalisons tous types d'objets selon vos besoins</p>
        </div>

        <?php if (count($services) > 0): ?>
        <div class="services-grid">
            <?php foreach ($services as $service): ?>
            <div class="service-card">
                <div class="service-image">
                    <?php if ($service['image_id']): ?>
                    <img src="<?= AssetHelper::upload('services/' . $service['image_id'] . '.jpg') ?>"
                        alt="<?= htmlspecialchars($service['title']) ?>">
                    <?php else: ?>
                    <div class="placeholder-image"><?= strtoupper(substr($service['title'], 0, 2)) ?></div>
                    <?php endif; ?>
                </div>
                <div class="service-content">
                    <h3><?= htmlspecialchars($service['title']) ?></h3>
                    <p><?= htmlspecialchars(substr($service['description'] ?? '', 0, 100)) ?>...</p>
                    <?php if ($service['price_base'] > 0): ?>
                    <p class="price-tag">À partir de <?= number_format($service['price_base'], 0, ',', ' ') ?> FCFA</p>
                    <?php endif; ?>
                    <a href="<?= AssetHelper::getBasePath() ?>/services" class="btn btn-outline">Voir plus</a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php else: ?>
        <div class="empty-state" style="text-align: center; padding: 3rem; background: white; border-radius: 12px;">
            <h3>Nos Services</h3>
            <p style="color: #64748b;">Personnalisation de maillots, gobelets, cartes de visite, pochettes téléphone,
                porte-clés, badges et plus encore.</p>
            <a href="<?= AssetHelper::getBasePath() ?>/services" class="btn btn-primary"
                style="margin-top: 1rem;">Découvrir nos services</a>
        </div>
        <?php endif; ?>
    </div>
</section>

<!-- Réalisations featured -->
<section class="portfolio-preview section section-alt">
    <div class="container">
        <div class="section-header">
            <h2>Nos Réalisations</h2>
            <p>Découvrez quelques-unes de nos créations</p>
        </div>

        <?php if (count($realizations) > 0): ?>
        <div class="portfolio-grid">
            <?php foreach ($realizations as $realization): ?>
            <div class="portfolio-item">
                <?php 
                $images = json_decode($realization['images'] ?? '[]', true);
                $firstImage = $images[0] ?? null;
                ?>
                <?php if ($firstImage): ?>
                <img src="<?= AssetHelper::upload('realizations/' . $firstImage) ?>"
                    alt="<?= htmlspecialchars($realization['title']) ?>">
                <?php else: ?>
                <div class="placeholder-image">🎨</div>
                <?php endif; ?>
                <div class="portfolio-overlay">
                    <h4><?= htmlspecialchars($realization['title']) ?></h4>
                    <?php if (!empty($realization['description'])): ?>
                    <p style="font-size: 0.85rem; margin: 0.5rem 0;">
                        <?= htmlspecialchars(substr($realization['description'], 0, 60)) ?>...</p>
                    <?php endif; ?>
                    <a href="<?= AssetHelper::getBasePath() ?>/portfolio" class="btn btn-sm">Voir plus</a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php else: ?>
        <div class="empty-state" style="text-align: center; padding: 3rem; background: white; border-radius: 12px;">
            <div style="font-size: 4rem; margin-bottom: 1rem;">🎨</div>
            <h3>Nos Réalisations</h3>
            <p style="color: #64748b;">Découvrez quelques-unes de nos créations personnalisées pour nos clients.</p>
            <a href="<?= AssetHelper::getBasePath() ?>/portfolio" class="btn btn-primary" style="margin-top: 1rem;">Voir
                le portfolio complet</a>
        </div>
        <?php endif; ?>

        <div class="text-center" style="margin-top: 2rem;">
            <a href="<?= AssetHelper::getBasePath() ?>/portfolio" class="btn btn-primary">Voir tout le portfolio</a>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="cta-section section">
    <div class="container">
        <div class="cta-content">
            <h2>Prêt à personnaliser vos objets ?</h2>
            <p>Contactez-nous dès aujourd'hui pour discuter de votre projet</p>
            <div class="cta-buttons">
                <a href="<?= AssetHelper::getBasePath() ?>/contact" class="btn btn-primary btn-large">Demander un devis
                    gratuit</a>
                <a href="<?= AssetHelper::getBasePath() ?>/portfolio" class="btn btn-outline btn-large">Voir nos
                    réalisations</a>
            </div>
        </div>
    </div>
</section>