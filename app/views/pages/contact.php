<section class="section">
    <div class="container">
        <div class="section-header" style="margin-bottom: 3rem;">
            <h1 style="font-size: 2.5rem; color: var(--primary-color); margin-bottom: 0.5rem;">Contactez-nous</h1>
            <p style="font-size: 1.2rem; color: var(--text-light);">Nous sommes disponibles pour discuter de votre
                projet</p>
        </div>

        <div class="info-section">
            <div class="info-icon">
                <i class="fas fa-clock"></i>
            </div>
            <div class="info-content">
                <h3><i class="fas fa-headset"></i> Besoin d'informations ?</h3>
                <p>
                    Notre équipe est à votre disposition du <strong>lundi au vendredi de 8h à 18h</strong>,
                    et le <strong>samedi de 9h à 13h</strong>. N'hésitez pas à nous contacter par téléphone,
                    email, WhatsApp ou en remplissant le formulaire ci-dessous.
                </p>
            </div>
        </div>

        <div class="contact-wrapper">
            <div class="contact-form-wrapper">
                <div class="form-header">
                    <h2>💼 Demander un devis</h2>
                    <p>Remplissez ce formulaire et nous vous répondrons dans les plus brefs délais</p>
                </div>

                <form id="contactForm" class="contact-form">
                    <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">

                    <div class="form-row">
                        <div class="form-group">
                            <label for="name">
                                <span class="label-icon">👤</span>
                                Nom complet *
                            </label>
                            <input type="text" id="name" name="name" placeholder="Ex: Jean Dupont" required>
                        </div>

                        <div class="form-group">
                            <label for="email">
                                <span class="label-icon">📧</span>
                                Email *
                            </label>
                            <input type="email" id="email" name="email" placeholder="Ex: jean@exemple.com" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="phone">
                                <span class="label-icon">📱</span>
                                Téléphone *
                            </label>
                            <input type="tel" id="phone" name="phone" placeholder="Ex: +226 71 44 47 17" required>
                        </div>

                        <div class="form-group">
                            <label for="company">
                                <span class="label-icon">🏢</span>
                                Entreprise
                            </label>
                            <input type="text" id="company" name="company" placeholder="Nom de l'entreprise">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="service">
                            <span class="label-icon">🎯</span>
                            Type de service souhaité *
                        </label>
                        <select id="service" name="service" required>
                            <option value="">Sélectionnez un service</option>
                            <option value="maillots">Maillots personnalisés</option>
                            <option value="gobelets">Gobelets personnalisés</option>
                            <option value="cartes">Cartes de visite</option>
                            <option value="pochettes">Pochettes téléphone</option>
                            <option value="porte-cles">Porte-clés</option>
                            <option value="badges">Badges</option>
                            <option value="autre">Autre</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="quantity">
                            <span class="label-icon">📊</span>
                            Quantité approximative
                        </label>
                        <input type="number" id="quantity" name="quantity" placeholder="Ex: 100" min="1">
                    </div>

                    <div class="form-group">
                        <label for="deadline">
                            <span class="label-icon">📅</span>
                            Date de livraison souhaitée
                        </label>
                        <input type="date" id="deadline" name="deadline">
                    </div>

                    <div class="form-group">
                        <label for="message">
                            <span class="label-icon">💬</span>
                            Détails du projet *
                        </label>
                        <textarea id="message" name="message" rows="5"
                            placeholder="Décrivez votre projet en détail (couleurs, dimensions, logo, etc.)"
                            required></textarea>
                    </div>

                    <div class="form-checkbox">
                        <input type="checkbox" id="newsletter" name="newsletter">
                        <label for="newsletter">Je souhaite recevoir des offres et actualités de KIB</label>
                    </div>

                    <button type="submit" class="btn btn-primary btn-large btn-submit">
                        <span class="btn-text">Envoyer la demande</span>
                        <span class="btn-loader" style="display: none;">⚡</span>
                    </button>
                </form>
            </div>

            <div class="contact-info">
                <div class="contact-item">
                    <div class="contact-icon">
                        <i class="fas fa-phone"></i>
                    </div>
                    <div>
                        <h3>Téléphone</h3>
                        <p><a
                                href="tel:<?= $settings['phone_number'] ?? '' ?>"><?= $settings['phone_number'] ?? '' ?></a>
                        </p>
                    </div>
                </div>

                <div class="contact-item">
                    <div class="contact-icon">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <div>
                        <h3>Email</h3>
                        <p><a href="mailto:<?= $settings['email'] ?? '' ?>"><?= $settings['email'] ?? '' ?></a></p>
                    </div>
                </div>

                <div class="contact-item">
                    <div class="contact-icon">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <div>
                        <h3>Adresse</h3>
                        <p><?= $settings['address'] ?? '' ?></p>
                    </div>
                </div>

                <div class="contact-item">
                    <div class="contact-icon">
                        <i class="fab fa-whatsapp"></i>
                    </div>
                    <div>
                        <h3>WhatsApp</h3>
                        <p>
                            <a href="https://wa.me/<?= $settings['whatsapp_number'] ?? '' ?>" class="btn btn-primary"
                                target="_blank">
                                <i class="fab fa-whatsapp"></i> Nous écrire sur WhatsApp
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Carte de localisation -->
    <div class="container" style="margin-top: 3rem;">
        <div class="section-header" style="margin-bottom: 2rem;">
            <h2 style="font-size: 2rem; color: var(--primary-color); margin-bottom: 0.5rem;">
                <i class="fas fa-map-marker-alt"></i> Notre localisation
            </h2>
            <p style="color: var(--text-light);">Visitez-nous à notre bureau à Ouagadougou</p>
        </div>

        <div class="map-container">
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3888.0!2d-1.5333!3d12.3714!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMTLCsDIyJzE3LjAiTiAxwrAzMiczMi4wIlc!5e0!3m2!1sfr!2sbf!4v1234567890123!5m2!1sfr!2sbf&z=14"
                width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                referrerpolicy="no-referrer-when-downgrade" title="Localisation KIB à Ouagadougou">
            </iframe>
        </div>

        <div style="text-align: center; margin-top: 1.5rem; color: var(--text-light); font-size: 0.9rem;">
            <p><i class="fas fa-info-circle"></i> Pour obtenir l'adresse exacte, <a
                    href="<?= AssetHelper::getBasePath() ?>/contact"
                    style="color: var(--primary-color); text-decoration: none; font-weight: 600;">contactez-nous</a></p>
        </div>
    </div>
</section>

<style>
.contact-wrapper {
    max-width: 1000px;
    margin: 0 auto;
    display: grid;
    grid-template-columns: 1fr;
    gap: 3rem;
}

.contact-info {
    display: flex;
    flex-direction: column;
    gap: 2rem;
}

.contact-info h3 {
    font-size: 1.1rem;
    color: var(--text-dark);
    font-weight: 600;
    margin-bottom: 0.5rem;
}

.contact-info p {
    color: var(--text-light);
    font-size: 0.95rem;
}

.contact-info a {
    color: var(--primary-color);
    text-decoration: none;
    font-weight: 500;
    transition: all 0.3s ease;
}

.contact-info a:hover {
    color: var(--secondary-color);
    text-decoration: underline;
}

.map-container {
    width: 100%;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
    background: var(--white);
    padding: 0;
    margin: 0;
}

.contact-item {
    display: flex;
    gap: 1.5rem;
}

/* Section Info moderne */
.info-section {
    background: linear-gradient(135deg, rgba(37, 99, 235, 0.08), rgba(37, 99, 235, 0.03));
    padding: 2.5rem;
    border-radius: 20px;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
    margin-bottom: 3rem;
    display: flex;
    align-items: flex-start;
    gap: 1.5rem;
    border: 1px solid rgba(37, 99, 235, 0.15);
    position: relative;
    overflow: hidden;
}

.info-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 4px;
    height: 100%;
    background: linear-gradient(180deg, var(--primary-color), var(--secondary-color));
}

.info-icon {
    font-size: 2.5rem;
    color: var(--primary-color);
    display: flex;
    align-items: center;
    justify-content: center;
    width: 70px;
    height: 70px;
    background: linear-gradient(135deg, rgba(37, 99, 235, 0.1), rgba(37, 99, 235, 0.05));
    border-radius: 16px;
    flex-shrink: 0;
    box-shadow: 0 4px 15px rgba(37, 99, 235, 0.2);
}

.info-content {
    flex: 1;
}

.info-content h3 {
    font-size: 1.5rem;
    color: var(--primary-color);
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.info-content h3 i {
    font-size: 1.3rem;
}

.info-content p {
    color: var(--text-light);
    line-height: 1.8;
    font-size: 1.05rem;
}

.info-content strong {
    color: var(--text-dark);
    font-weight: 600;
}

/* Section Réseaux sociaux */
.social-section {
    background: linear-gradient(135deg, rgba(37, 99, 235, 0.05), rgba(37, 99, 235, 0.02));
    padding: 2rem;
    border-radius: 16px;
    margin-top: 3rem;
}

.social-section h3 {
    font-size: 1.3rem;
    color: var(--primary-color);
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
}

.social-icons-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
    gap: 1rem;
}

.social-icon {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 1.5rem;
    background: white;
    border-radius: 12px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
    text-decoration: none;
    color: var(--text-dark);
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    border: 2px solid transparent;
}

.social-icon:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    border-color: var(--primary-color);
}

.social-icon i {
    font-size: 2rem;
    margin-bottom: 0.5rem;
}

.social-icon span {
    font-size: 0.9rem;
    font-weight: 600;
    color: var(--text-dark);
}

.social-icon:hover i {
    transform: scale(1.1);
}

/* Couleurs spécifiques pour chaque réseau */
.social-icon:nth-child(1) i {
    color: #1877f2;
    /* Facebook */
}

.social-icon:nth-child(2) i {
    color: #e4405f;
    /* Instagram */
}

.social-icon:nth-child(3) i {
    color: #000000;
    /* TikTok */
}

.social-icon:nth-child(4) i {
    color: #25d366;
    /* WhatsApp */
}

.contact-icon {
    font-size: 1.8rem;
    color: var(--primary-color);
    display: flex;
    align-items: center;
    justify-content: center;
    width: 50px;
    height: 50px;
    background: linear-gradient(135deg, rgba(37, 99, 235, 0.1), rgba(37, 99, 235, 0.05));
    border-radius: 12px;
    flex-shrink: 0;
}

.contact-item h3 {
    margin-bottom: 0.5rem;
}

.contact-item a {
    color: var(--primary-color);
    text-decoration: none;
}

.form-header {
    text-align: center;
    margin-bottom: 2.5rem;
}

.form-header h2 {
    font-size: 2.5rem;
    background: linear-gradient(135deg, var(--primary-color), #1e40af);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    margin-bottom: 0.5rem;
    font-weight: 700;
}

.form-header p {
    color: var(--text-light);
    font-size: 1.1rem;
}

.contact-form-wrapper {
    position: relative;
}

.contact-form {
    background: linear-gradient(135deg, rgba(255, 255, 255, 0.98), rgba(248, 250, 252, 0.98));
    padding: 2.5rem;
    border-radius: 20px;
    box-shadow: 0 10px 50px rgba(0, 0, 0, 0.08);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.8);
}

.form-row {
    display: grid;
    grid-template-columns: 1fr;
    gap: 1.5rem;
}

.form-group {
    margin-bottom: 1.75rem;
}

.form-group label {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin-bottom: 0.75rem;
    font-weight: 600;
    color: var(--text-dark);
    font-size: 0.95rem;
}

.label-icon {
    font-size: 1.2rem;
}

.form-group input,
.form-group textarea,
.form-group select {
    width: 100%;
    padding: 1rem 1.25rem;
    border: 2px solid #e2e8f0;
    border-radius: 12px;
    font-size: 1rem;
    font-family: inherit;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    background: white;
}

.form-group input:focus,
.form-group textarea:focus,
.form-group select:focus {
    outline: none;
    border-color: var(--primary-color);
    box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    transform: translateY(-1px);
}

.form-group input::placeholder,
.form-group textarea::placeholder {
    color: #94a3b8;
}

.form-group select {
    cursor: pointer;
    appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%23334155' d='M6 9L1 4h10z'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 1rem center;
    padding-right: 3rem;
}

.form-checkbox {
    display: flex;
    align-items: flex-start;
    gap: 0.75rem;
    margin-bottom: 2rem;
}

.form-checkbox input[type="checkbox"] {
    width: 20px;
    height: 20px;
    cursor: pointer;
    accent-color: var(--primary-color);
    margin-top: 2px;
}

.form-checkbox label {
    font-weight: 400;
    color: var(--text-light);
    cursor: pointer;
}

.btn-submit {
    width: 100%;
    padding: 1.25rem 2rem;
    font-size: 1.1rem;
    font-weight: 700;
    border-radius: 50px;
    background: linear-gradient(135deg, var(--primary-color), #1e40af);
    box-shadow: 0 8px 25px rgba(37, 99, 235, 0.4);
    position: relative;
    overflow: hidden;
}

.btn-submit:hover {
    transform: translateY(-3px);
    box-shadow: 0 12px 35px rgba(37, 99, 235, 0.5);
}

.btn-submit:active {
    transform: translateY(-1px);
}

.btn-loader {
    animation: spin 1s linear infinite;
}

@keyframes spin {
    from {
        transform: rotate(0deg);
    }

    to {
        transform: rotate(360deg);
    }
}

@media (min-width: 768px) {
    .contact-wrapper {
        grid-template-columns: 1fr 1.5fr;
    }

    /* Réorganiser pour desktop : formulaire à gauche, infos à droite */
    .contact-wrapper>.contact-info {
        order: 1;
    }

    .contact-wrapper>.contact-form-wrapper {
        order: 2;
    }

    .form-row {
        grid-template-columns: 1fr 1fr;
    }

    .contact-form {
        padding: 3rem;
    }

    .contact-info {
        display: flex;
        flex-direction: column;
        gap: 2rem;
        padding-top: 0;
    }
}

/* Mobile : formulaire d'abord, infos en bas */
@media (max-width: 767px) {
    .contact-wrapper {
        display: flex;
        flex-direction: column;
    }

    .contact-info {
        order: 2;
        margin-top: 3rem;
        padding-top: 2rem;
        border-top: 2px solid var(--border);
    }

    .contact-form-wrapper {
        order: 1;
    }

    .map-container iframe {
        height: 350px;
    }

    .section-header h2 {
        font-size: 1.5rem !important;
    }

    .social-icons-grid {
        grid-template-columns: repeat(2, 1fr);
    }

    /* Section Info responsive */
    .info-section {
        flex-direction: column;
        align-items: center;
        text-align: center;
        padding: 2rem;
    }

    .info-icon {
        width: 60px;
        height: 60px;
        font-size: 2rem;
    }

    .info-content h3 {
        font-size: 1.25rem;
        justify-content: center;
    }

    .info-content p {
        font-size: 1rem;
    }
}

@media (min-width: 1024px) {
    .form-header h2 {
        font-size: 3rem;
    }

    .contact-form {
        padding: 3.5rem;
    }
}
</style>

<script>
document.getElementById('contactForm').addEventListener('submit', async function(e) {
    e.preventDefault();

    const submitBtn = this.querySelector('.btn-submit');
    const btnText = submitBtn.querySelector('.btn-text');
    const btnLoader = submitBtn.querySelector('.btn-loader');

    // Afficher le loader
    btnText.style.display = 'none';
    btnLoader.style.display = 'inline-block';
    submitBtn.disabled = true;
    submitBtn.style.opacity = '0.7';

    const formData = new FormData(this);
    const data = Object.fromEntries(formData);

    try {
        const response = await fetch(window.APP_BASE_PATH + '/api/contact', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        });

        const result = await response.json();

        if (result.success) {
            // Animation de succès
            submitBtn.style.background = 'linear-gradient(135deg, #10b981, #059669)';
            btnText.textContent = '✓ Message envoyé !';
            btnText.style.display = 'inline-block';
            btnLoader.style.display = 'none';

            setTimeout(() => {
                alert(
                    '✅ Votre demande de devis a été envoyée avec succès ! Nous vous répondrons dans les plus brefs délais.'
                );
                this.reset();

                // Réinitialiser le bouton
                submitBtn.style.background = '';
                btnText.textContent = 'Envoyer la demande';
                submitBtn.disabled = false;
                submitBtn.style.opacity = '1';
            }, 1500);
        } else {
            // Erreur
            alert('❌ Erreur : ' + (result.error || 'Une erreur est survenue'));
            btnText.style.display = 'inline-block';
            btnLoader.style.display = 'none';
            submitBtn.disabled = false;
            submitBtn.style.opacity = '1';
        }
    } catch (error) {
        alert('❌ Une erreur est survenue. Veuillez réessayer.');
        btnText.style.display = 'inline-block';
        btnLoader.style.display = 'none';
        submitBtn.disabled = false;
        submitBtn.style.opacity = '1';
    }
});
</script>