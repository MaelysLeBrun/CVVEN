// Fonctions utilitaires globales
document.addEventListener('alpine:init', () => {
    // Store global pour les notifications
    Alpine.store('notifications', {
        items: [],
        add(message, type = 'info') {
            const id = Date.now();
            this.items.push({ id, message, type });
            setTimeout(() => {
                this.remove(id);
            }, 5000);
        },
        remove(id) {
            this.items = this.items.filter(item => item.id !== id);
        }
    });

    // Store pour le panier de réservations (futur usage)
    Alpine.store('reservation', {
        selectedDates: null,
        selectedRoom: null,
        setDates(debut, fin) {
            this.selectedDates = { debut, fin };
        },
        setRoom(room) {
            this.selectedRoom = room;
        },
        clear() {
            this.selectedDates = null;
            this.selectedRoom = null;
        }
    });
});

// Animations au scroll
document.addEventListener('DOMContentLoaded', () => {
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate-fade-in');
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);

    // Observer tous les éléments avec la classe 'animate-on-scroll'
    document.querySelectorAll('.card, .alert').forEach((el) => {
        observer.observe(el);
    });
});

// Fonction pour valider les dates
function validateDates(dateDebut, dateFin) {
    const debut = new Date(dateDebut);
    const fin = new Date(dateFin);
    const today = new Date();
    today.setHours(0, 0, 0, 0);

    if (debut < today) {
        return { valid: false, message: 'La date de début ne peut pas être dans le passé' };
    }

    if (fin <= debut) {
        return { valid: false, message: 'La date de fin doit être après la date de début' };
    }

    return { valid: true };
}

// Smooth scroll pour les ancres
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        const href = this.getAttribute('href');
        if (href !== '#' && href !== '') {
            e.preventDefault();
            const target = document.querySelector(href);
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        }
    });
});

// Confirmation avant déconnexion
const logoutLinks = document.querySelectorAll('a[href*="logout"]');
logoutLinks.forEach(link => {
    link.addEventListener('click', (e) => {
        if (!confirm('Êtes-vous sûr de vouloir vous déconnecter ?')) {
            e.preventDefault();
        }
    });
});

// Auto-dismiss des alertes après 5 secondes
setTimeout(() => {
    document.querySelectorAll('.alert-dismissible').forEach(alert => {
        const closeBtn = alert.querySelector('.btn-close');
        if (closeBtn) {
            closeBtn.click();
        }
    });
}, 5000);

console.log('🏨 CVVEN Hôtel - Application chargée avec Alpine.js');

