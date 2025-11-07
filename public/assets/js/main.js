// JavaScript principal
document.addEventListener('DOMContentLoaded', function() {
    // Mobile menu toggle
    const mobileMenuToggle = document.getElementById('mobileMenuToggle');
    const navMenu = document.getElementById('navMenu');
    
    if (mobileMenuToggle) {
        const mobileMenuOverlay = document.getElementById('mobileMenuOverlay');
        
        mobileMenuToggle.addEventListener('click', function() {
            // Toggle l'état du menu
            this.classList.toggle('active');
            navMenu.classList.toggle('active');
            
            // Afficher/masquer l'overlay
            if (mobileMenuOverlay) {
                mobileMenuOverlay.classList.toggle('active');
            }
            
            // Empêcher le scroll du body quand le menu est ouvert
            if (navMenu.classList.contains('active')) {
                document.body.style.overflow = 'hidden';
            } else {
                document.body.style.overflow = '';
            }
        });
        
        // Fermer le menu si on clique sur l'overlay
        if (mobileMenuOverlay) {
            mobileMenuOverlay.addEventListener('click', function() {
                mobileMenuToggle.classList.remove('active');
                navMenu.classList.remove('active');
                this.classList.remove('active');
                document.body.style.overflow = '';
            });
        }
        
        // Fermer le menu si on clique sur un lien
        const navLinks = navMenu.querySelectorAll('a');
        navLinks.forEach(link => {
            link.addEventListener('click', function() {
                mobileMenuToggle.classList.remove('active');
                navMenu.classList.remove('active');
                if (mobileMenuOverlay) {
                    mobileMenuOverlay.classList.remove('active');
                }
                document.body.style.overflow = '';
            });
        });
        
        // Bouton de fermeture dans le menu
        const menuCloseBtn = document.getElementById('menuCloseBtn');
        if (menuCloseBtn) {
            menuCloseBtn.addEventListener('click', function() {
                mobileMenuToggle.classList.remove('active');
                navMenu.classList.remove('active');
                if (mobileMenuOverlay) {
                    mobileMenuOverlay.classList.remove('active');
                }
                document.body.style.overflow = '';
            });
        }
    }
    
    // Gestion de la navigation au scroll
    initScrollNavigation();
    
    // Initialiser le carrousel hero
    initHeroCarousel();
    
    // Track page views
    trackPageView();
    
    // Lazy load images
    lazyLoadImages();
});

// Navigation qui disparaît au scroll vers le bas et réapparaît au scroll vers le haut
function initScrollNavigation() {
    const header = document.querySelector('.header');
    if (!header) return;
    
    let lastScroll = 0;
    let ticking = false;
    
    window.addEventListener('scroll', function() {
        if (!ticking) {
            window.requestAnimationFrame(function() {
                const currentScroll = window.pageYOffset;
                
                if (currentScroll <= 0) {
                    // En haut de la page
                    header.classList.remove('header-hide');
                    header.classList.add('header-visible');
                } else if (currentScroll > lastScroll && currentScroll > 100) {
                    // Scroll vers le bas (masquer)
                    header.classList.add('header-hide');
                    header.classList.remove('header-visible');
                } else if (currentScroll < lastScroll) {
                    // Scroll vers le haut (afficher)
                    header.classList.remove('header-hide');
                    header.classList.add('header-visible');
                }
                
                lastScroll = currentScroll;
                ticking = false;
            });
            ticking = true;
        }
    });
}

// Carrousel Hero Professionnel
function initHeroCarousel() {
    const slides = document.querySelectorAll('.hero-slide');
    const prevBtn = document.querySelector('.hero-nav-prev');
    const nextBtn = document.querySelector('.hero-nav-next');
    const indicators = document.querySelectorAll('.hero-indicator');
    
    if (slides.length === 0) return;
    
    let currentSlide = 0;
    let autoPlayInterval;
    
    // Fonction pour changer de slide
    function goToSlide(index) {
        // Retirer la classe active de toutes les slides
        slides.forEach(slide => slide.classList.remove('active'));
        indicators.forEach(indicator => indicator.classList.remove('active'));
        
        // Ajouter la classe active à la slide courante
        currentSlide = index;
        slides[currentSlide].classList.add('active');
        indicators[currentSlide].classList.add('active');
    }
    
    // Slide suivante
    function nextSlide() {
        const nextIndex = (currentSlide + 1) % slides.length;
        goToSlide(nextIndex);
    }
    
    // Slide précédente
    function prevSlide() {
        const prevIndex = (currentSlide - 1 + slides.length) % slides.length;
        goToSlide(prevIndex);
    }
    
    // Auto-play
    function startAutoPlay() {
        autoPlayInterval = setInterval(nextSlide, 6000); // Change toutes les 6 secondes
    }
    
    function stopAutoPlay() {
        if (autoPlayInterval) {
            clearInterval(autoPlayInterval);
        }
    }
    
    // Événements pour les boutons de navigation
    if (nextBtn) {
        nextBtn.addEventListener('click', function() {
            nextSlide();
            stopAutoPlay();
            startAutoPlay();
        });
    }
    
    if (prevBtn) {
        prevBtn.addEventListener('click', function() {
            prevSlide();
            stopAutoPlay();
            startAutoPlay();
        });
    }
    
    // Événements pour les indicateurs
    indicators.forEach((indicator, index) => {
        indicator.addEventListener('click', function() {
            goToSlide(index);
            stopAutoPlay();
            startAutoPlay();
        });
    });
    
    // Pause au survol
    const heroContainer = document.querySelector('.hero-slider-container');
    if (heroContainer) {
        heroContainer.addEventListener('mouseenter', stopAutoPlay);
        heroContainer.addEventListener('mouseleave', startAutoPlay);
    }
    
    // Démarrer l'auto-play
    startAutoPlay();
}

// Tracker une vue de page
function trackPageView() {
    fetch('/api/track', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            path: window.location.pathname,
            referrer: document.referrer,
            event_type: 'page_view'
        })
    }).catch(err => console.error('Tracking error:', err));
}

// Lazy load des images
function lazyLoadImages() {
    const images = document.querySelectorAll('img[data-src]');
    
    const imageObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const img = entry.target;
                img.src = img.dataset.src;
                img.removeAttribute('data-src');
                observer.unobserve(img);
            }
        });
    });
    
    images.forEach(img => imageObserver.observe(img));
}
