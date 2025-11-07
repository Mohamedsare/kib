<section class="section" style="padding-top: 2rem;">
    <div class="container">
        <div class="section-header">
            <h1 style="font-size: 2.5rem; color: var(--primary-color); margin-bottom: 0.5rem;">Nos Services</h1>
            <p style="font-size: 1.2rem; color: var(--text-light);">Personnalisation de tous types d'objets selon vos besoins</p>
        </div>
        
        <?php if (count($services) > 0): ?>
        <div class="services-grid">
            <?php foreach ($services as $service): ?>
            <div class="service-card" style="transition: transform 0.3s, box-shadow 0.3s;">
                <div class="service-image">
                    <?php if ($service['image_id']): ?>
                        <img src="<?= AssetHelper::upload('services/' . $service['image_id'] . '.jpg') ?>" alt="<?= htmlspecialchars($service['title']) ?>">
                    <?php else: ?>
                        <div class="placeholder-image" style="display: flex; align-items: center; justify-content: center; font-size: 3rem; color: var(--primary-color);"><?= strtoupper(substr($service['title'], 0, 1)) ?></div>
                    <?php endif; ?>
                </div>
                <div class="service-content">
                    <?php if (!empty($service['category_name'])): ?>
                        <span style="background: var(--primary-color); color: white; padding: 0.25rem 0.75rem; border-radius: 12px; font-size: 0.75rem; display: inline-block; margin-bottom: 0.5rem;"><?= htmlspecialchars($service['category_name']) ?></span>
                    <?php endif; ?>
                    <h3 style="margin-bottom: 0.75rem;"><?= htmlspecialchars($service['title']) ?></h3>
                    <p style="color: var(--text-light); line-height: 1.6;"><?= htmlspecialchars($service['description'] ?? 'Description en attente...') ?></p>
                    <?php if (!empty($service['price_base']) && $service['price_base'] > 0): ?>
                        <p style="font-size: 1.25rem; font-weight: 700; color: var(--primary-color); margin: 1rem 0;">
                            À partir de <strong><?= number_format($service['price_base'], 0, ',', ' ') ?> FCFA</strong>
                        </p>
                    <?php endif; ?>
                    <a href="<?= AssetHelper::getBasePath() ?>/contact" class="btn btn-primary" style="margin-top: 1rem;">Demander un devis gratuit</a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php else: ?>
        <div style="background: white; padding: 4rem 2rem; border-radius: 12px; text-align: center; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
            <div style="font-size: 5rem; margin-bottom: 1rem;">🎯</div>
            <h2>Services de Personnalisation</h2>
            <p style="color: var(--text-light); margin: 1rem 0 2rem; line-height: 1.8;">
                Nous offrons la personnalisation d'une large gamme d'objets pour répondre à tous vos besoins professionnels et personnels.
            </p>
            
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem; margin-top: 2rem; text-align: left;">
                <div style="padding: 1.5rem; background: var(--bg-light); border-radius: 8px;">
                    <h3 style="color: var(--primary-color); margin-bottom: 0.5rem;">👕 Maillots</h3>
                    <p>Personnalisation de maillots sportifs, équipes, événements</p>
                </div>
                <div style="padding: 1.5rem; background: var(--bg-light); border-radius: 8px;">
                    <h3 style="color: var(--primary-color); margin-bottom: 0.5rem;">☕ Gobelets</h3>
                    <p>Gobelets personnalisés pour entreprise, événements, cadeaux</p>
                </div>
                <div style="padding: 1.5rem; background: var(--bg-light); border-radius: 8px;">
                    <h3 style="color: var(--primary-color); margin-bottom: 0.5rem;">📇 Cartes de visite</h3>
                    <p>Impression professionnelle de cartes de visite</p>
                </div>
                <div style="padding: 1.5rem; background: var(--bg-light); border-radius: 8px;">
                    <h3 style="color: var(--primary-color); margin-bottom: 0.5rem;">📱 Pochettes téléphone</h3>
                    <p>Étuis et pochettes téléphone personnalisés</p>
                </div>
                <div style="padding: 1.5rem; background: var(--bg-light); border-radius: 8px;">
                    <h3 style="color: var(--primary-color); margin-bottom: 0.5rem;">🔑 Porte-clés</h3>
                    <p>Porte-clés personnalisés, promotionnels, souvenirs</p>
                </div>
                <div style="padding: 1.5rem; background: var(--bg-light); border-radius: 8px;">
                    <h3 style="color: var(--primary-color); margin-bottom: 0.5rem;">🏷️ Badges</h3>
                    <p>Badges et écussons personnalisés</p>
                </div>
            </div>
            
            <div style="margin-top: 2rem;">
                <a href="<?= AssetHelper::getBasePath() ?>/contact" class="btn btn-primary btn-large">Demander un devis gratuit</a>
            </div>
        </div>
        <?php endif; ?>
    </div>
</section>