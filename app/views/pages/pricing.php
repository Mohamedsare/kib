<section class="section">
    <div class="container">
        <div class="section-header">
            <h1>Nos Tarifs</h1>
            <p>Tarifs indicatifs par catégorie</p>
        </div>
        
        <div class="pricing-grid">
            <?php 
            $currentCategory = null;
            foreach ($services as $service): 
                if ($currentCategory !== $service['category_name']):
                    $currentCategory = $service['category_name'];
                    if ($currentCategory !== null):
                        echo '</div></div>'; // Close previous category
                    endif;
            ?>
            <div class="pricing-category">
                <h2><?= htmlspecialchars($currentCategory) ?></h2>
                <div class="pricing-list">
            <?php endif; ?>
                    
                    <div class="pricing-item">
                        <div class="pricing-header">
                            <h3><?= htmlspecialchars($service['title']) ?></h3>
                            <?php if ($service['price_base'] > 0): ?>
                                <span class="price-tag">À partir de <?= number_format($service['price_base'], 0, ',', ' ') ?> FCFA</span>
                            <?php endif; ?>
                        </div>
                        <p class="pricing-description"><?= htmlspecialchars($service['description']) ?></p>
                        
                        <?php 
                        $pricingMeta = json_decode($service['pricing_meta'] ?? '{}', true);
                        if (!empty($pricingMeta['options'])):
                        ?>
                            <div class="pricing-options">
                                <h4>Options disponibles :</h4>
                                <ul>
                                    <?php foreach ($pricingMeta['options'] as $option => $price): ?>
                                        <li><?= htmlspecialchars($option) ?> : +<?= number_format($price, 0, ',', ' ') ?> FCFA</li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endif; ?>
                        
                        <div class="pricing-action">
                            <a href="<?= AssetHelper::getBasePath() ?>/contact" class="btn btn-primary">Demander un devis</a>
                        </div>
                    </div>
            <?php endforeach; ?>
                </div>
            </div>
        </div>
        
        <div class="pricing-note" style="margin-top: 3rem; padding: 2rem; background: white; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
            <h3 style="margin-bottom: 1rem;">💰 Comment fonctionnent nos tarifs ?</h3>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem; margin-top: 1.5rem;">
                <div>
                    <h4 style="color: var(--primary-color); margin-bottom: 0.5rem;">📦 Quantité</h4>
                    <p>Plus vous commandez, moins c'est cher ! Tarifs dégressifs selon la quantité.</p>
                </div>
                <div>
                    <h4 style="color: var(--primary-color); margin-bottom: 0.5rem;">🎨 Personnalisation</h4>
                    <p>Impression simple, sérigraphie, broderie, vinyle - chaque technique a son prix.</p>
                </div>
                <div>
                    <h4 style="color: var(--primary-color); margin-bottom: 0.5rem;">📅 Délai</h4>
                    <p>Réalisations express disponibles avec majoration pour urgence.</p>
                </div>
            </div>
            
            <div style="margin-top: 2rem; padding: 1.5rem; background: var(--bg-light); border-radius: 8px;">
                <p><strong>ℹ️ Note importante :</strong> Les prix affichés sont indicatifs et peuvent varier selon la quantité, les matériaux et les options choisies. <strong>Contactez-nous pour un devis personnalisé gratuit.</strong></p>
            </div>
            
            <div style="margin-top: 2rem; text-align: center;">
                <a href="<?= AssetHelper::getBasePath() ?>/contact" class="btn btn-primary btn-large">Obtenir un devis personnalisé</a>
            </div>
        </div>
    </div>
</section>

<style>
.pricing-grid {
    max-width: 900px;
    margin: 0 auto;
}

.pricing-category {
    margin-bottom: 3rem;
}

.pricing-category h2 {
    font-size: 1.75rem;
    margin-bottom: 1.5rem;
    padding-bottom: 0.5rem;
    border-bottom: 3px solid var(--primary-color);
}

.pricing-item {
    background: var(--white);
    border: 1px solid var(--border);
    border-radius: 12px;
    padding: 1.5rem;
    margin-bottom: 1rem;
}

.pricing-header {
    display: flex;
    justify-content: space-between;
    align-items: start;
    margin-bottom: 1rem;
    gap: 1rem;
}

.pricing-header h3 {
    flex: 1;
}

.price-tag {
    background: var(--primary-color);
    color: var(--white);
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-weight: 600;
    font-size: 0.9rem;
}

.pricing-description {
    color: var(--text-light);
    margin-bottom: 1rem;
}

.pricing-options {
    margin-top: 1rem;
    padding: 1rem;
    background: var(--bg-light);
    border-radius: 8px;
}

.pricing-options h4 {
    font-size: 0.9rem;
    margin-bottom: 0.5rem;
}

.pricing-options ul {
    list-style: none;
}

.pricing-options li {
    padding: 0.25rem 0;
    font-size: 0.9rem;
}

.pricing-action {
    margin-top: 1rem;
}

.pricing-note {
    margin-top: 3rem;
    padding: 1.5rem;
    background: var(--bg-light);
    border-radius: 8px;
    text-align: center;
}

@media (min-width: 768px) {
    .pricing-header {
        flex-direction: row;
    }
}
</style>
