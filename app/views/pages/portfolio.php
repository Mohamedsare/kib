<section class="section">
    <div class="container">
        <div class="section-header">
            <h1>Notre Portfolio</h1>
            <p>Découvrez nos réalisations</p>
        </div>
        
        <!-- Filtres -->
        <div class="portfolio-filters">
            <a href="<?= AssetHelper::getBasePath() ?>/portfolio" class="filter-btn <?= !$activeCategory ? 'active' : '' ?>">Tous</a>
            <?php foreach ($categories as $category): ?>
                <a href="<?= AssetHelper::getBasePath() ?>/portfolio?category=<?= $category['slug'] ?>" 
                   class="filter-btn <?= $activeCategory === $category['slug'] ? 'active' : '' ?>">
                    <?= htmlspecialchars($category['name']) ?>
                </a>
            <?php endforeach; ?>
        </div>
        
        <div class="portfolio-grid">
            <?php foreach ($realizations as $realization): ?>
            <div class="portfolio-item">
                <?php 
                $images = json_decode($realization['images'] ?? '[]', true);
                $firstImage = $images[0] ?? null;
                ?>
                <?php if ($firstImage): ?>
                    <img src="/uploads/realizations/<?= $firstImage ?>" alt="<?= htmlspecialchars($realization['title']) ?>">
                <?php else: ?>
                    <div class="placeholder-image"><?= substr($realization['title'], 0, 2) ?></div>
                <?php endif; ?>
                <div class="portfolio-overlay">
                    <h4><?= htmlspecialchars($realization['title']) ?></h4>
                    <?php if (!empty($realization['description'])): ?>
                        <p><?= htmlspecialchars(substr($realization['description'], 0, 100)) ?>...</p>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        
        <?php if (empty($realizations)): ?>
            <div class="empty-state" style="text-align: center; padding: 4rem 2rem; background: white; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                <div style="font-size: 5rem; margin-bottom: 1rem;">🎨</div>
                <h3>Notre Portfolio</h3>
                <p style="color: #64748b; margin: 1rem 0 2rem;">
                    <?php if ($activeCategory): ?>
                        Aucune réalisation dans la catégorie "<?= htmlspecialchars(ucfirst($activeCategory)) ?>" pour le moment.
                    <?php else: ?>
                        Découvrez nos réalisations de personnalisation d'objets pour nos clients.
                    <?php endif; ?>
                </p>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem; margin-top: 2rem; text-align: left;">
                    <div style="padding: 1rem; background: var(--bg-light); border-radius: 8px;">
                        <h4 style="margin-bottom: 0.5rem;">✅ Qualité premium</h4>
                        <p style="font-size: 0.9rem; color: #64748b;">Matériaux de haute qualité pour un rendu professionnel</p>
                    </div>
                    <div style="padding: 1rem; background: var(--bg-light); border-radius: 8px;">
                        <h4 style="margin-bottom: 0.5rem;">🎯 Sur mesure</h4>
                        <p style="font-size: 0.9rem; color: #64748b;">Chaque projet est adapté à vos besoins</p>
                    </div>
                    <div style="padding: 1rem; background: var(--bg-light); border-radius: 8px;">
                        <h4 style="margin-bottom: 0.5rem;">⚡ Rapide</h4>
                        <p style="font-size: 0.9rem; color: #64748b;">Délais respectés pour votre satisfaction</p>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>

<style>
.portfolio-filters {
    display: flex;
    gap: 1rem;
    margin-bottom: 2rem;
    flex-wrap: wrap;
    justify-content: center;
}

.filter-btn {
    padding: 0.5rem 1.5rem;
    border: 2px solid var(--border);
    border-radius: 25px;
    text-decoration: none;
    color: var(--text-dark);
    transition: all 0.3s;
}

.filter-btn:hover,
.filter-btn.active {
    background: var(--primary-color);
    color: var(--white);
    border-color: var(--primary-color);
}

.empty-state {
    text-align: center;
    padding: 3rem 0;
    color: var(--text-light);
}
</style>
