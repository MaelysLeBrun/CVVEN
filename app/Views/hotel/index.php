<?= $this->extend('hotel/layout') ?>

<?= $this->section('content') ?>

</div> <!-- Fermeture temporaire du container -->

<!-- Hero Section -->
<div class="text-white text-center py-5 mb-5 shadow position-relative overflow-hidden d-flex align-items-center" 
     style="background-image: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('<?= base_url('assets/images/hotel/hotelImage.png') ?>'); background-size: cover; background-position: center; height:80vh;">
    <div class="container py-4 position-relative" style="z-index: 1;">
        <h1 class="display-3 fw-bold mb-4">Bienvenue à l'Hôtel CVVEN</h1>
        <p class="lead mb-4">Votre destination de luxe et de confort pour un séjour inoubliable</p>
        <a href="#types-section" class="btn btn-light btn-lg px-5">
            Voir nos types de chambres
        </a>
    </div>
</div>

<div class="container"> <!-- Réouverture du container -->

<!-- Section Types de Chambres (Carrousel) -->
<section id="types-section" class="my-5 py-4 bg-light rounded-3">
    <div class="container">
        <h2 class="text-center fw-bold mb-2">Nos Types de Chambres</h2>
        <p class="text-center text-muted mb-5">Choisissez le type de chambre qui vous convient</p>
        
        <div id="typesCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-indicators">
                <?php foreach ($types as $index => $type): ?>
                    <button type="button" data-bs-target="#typesCarousel" data-bs-slide-to="<?= $index ?>" 
                            class="<?= $index === 0 ? 'active' : '' ?>" 
                            aria-current="<?= $index === 0 ? 'true' : 'false' ?>" 
                            aria-label="<?= esc($type['type_libelle']) ?>"></button>
                <?php endforeach; ?>
            </div>
            
            <div class="carousel-inner py-5">
                <?php foreach ($types as $index => $type): ?>
                    <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                        <div class="card border-0 shadow-lg mx-auto" style="max-width: 10000;">
                            <div class="row g-0">
                                <div class="col-md-6">
                                    <?php
                                    // Chercher l'image du type (supporte .jpg, .png, .jpeg, .webp)
                                    $imagePath = '';
                                    $extensions = ['jpg', 'jpeg', 'png', 'webp'];
                                    foreach ($extensions as $ext) {
                                        $checkPath = FCPATH . 'assets/images/chambres/type' . $type['type_id'] . '.' . $ext;
                                        if (file_exists($checkPath)) {
                                            $imagePath = base_url('assets/images/chambres/type' . $type['type_id'] . '.' . $ext);
                                            break;
                                        }
                                    }
                                    // Image par défaut si aucune trouvée
                                    if (empty($imagePath)) {
                                        $imagePath = 'https://placehold.co/400x300/0d6efd/white?text=' . urlencode($type['type_libelle']);
                                    }
                                    ?>
                                    <img src="<?= $imagePath ?>" 
                                         class="img-fluid h-100 w-100" 
                                         style="object-fit: cover; min-height: 400px;"
                                         alt="<?= esc($type['type_libelle']) ?>">
                                </div>
                                <div class="col-md-6">
                                    <div class="card-body p-5 d-flex flex-column h-100">
                                        <div>
                                            <span class="badge bg-primary mb-3">Type de chambre</span>
                                            <h3 class="card-title fw-bold mb-3"><?= esc($type['type_libelle']) ?></h3>
                                            <p class="card-text text-muted mb-4"><?= esc($type['type_desc']) ?></p>
                                        </div>
                                        <div class="mt-auto">
                                            <button type="button" class="btn btn-primary w-100 btn-lg" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#dateModal<?= $type['type_id'] ?>">
                                                <i class="bi bi-calendar-check"></i> Vérifier la disponibilité
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <button class="carousel-control-prev" type="button" data-bs-target="#typesCarousel" data-bs-slide="prev" style="width: 50px;">
                <span class="bg-dark rounded-circle p-3 d-inline-block">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                </span>
                <span class="visually-hidden">Précédent</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#typesCarousel" data-bs-slide="next" style="width: 50px;">
                <span class="bg-dark rounded-circle p-3 d-inline-block">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                </span>
                <span class="visually-hidden">Suivant</span>
            </button>
        </div>
    </div>
</section>

<!-- Modals pour sélectionner les dates par type avec Alpine.js -->
<?php foreach ($types as $type): ?>
    <div class="modal fade" id="dateModal<?= $type['type_id'] ?>" tabindex="-1" aria-labelledby="dateModalLabel<?= $type['type_id'] ?>" aria-hidden="true" 
         x-data="{ 
             dateDebut: '', 
             dateFin: '', 
             get nuits() { 
                 if (!this.dateDebut || !this.dateFin) return 0;
                 const d1 = new Date(this.dateDebut);
                 const d2 = new Date(this.dateFin);
                 return Math.max(0, Math.ceil((d2 - d1) / (1000 * 60 * 60 * 24)));
             },
             get isValid() {
                 return this.dateDebut && this.dateFin && this.nuits > 0;
             }
         }">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="dateModalLabel<?= $type['type_id'] ?>">
                        <i class="bi bi-calendar-check"></i> <?= esc($type['type_libelle']) ?>
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="<?= base_url('disponibilite/' . $type['type_id']) ?>" method="get">
                    <div class="modal-body p-4">
                        <p class="text-muted mb-4"><?= esc($type['type_desc']) ?></p>
                        
                        <div class="mb-3">
                            <label for="date_debut<?= $type['type_id'] ?>" class="form-label fw-bold">
                                <i class="bi bi-calendar-event"></i> Date d'arrivée
                            </label>
                            <input type="date" 
                                   class="form-control form-control-lg" 
                                   id="date_debut<?= $type['type_id'] ?>" 
                                   name="date_debut" 
                                   x-model="dateDebut"
                                   min="<?= date('Y-m-d') ?>" 
                                   required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="date_fin<?= $type['type_id'] ?>" class="form-label fw-bold">
                                <i class="bi bi-calendar-check"></i> Date de départ
                            </label>
                            <input type="date" 
                                   class="form-control form-control-lg" 
                                   id="date_fin<?= $type['type_id'] ?>" 
                                   name="date_fin" 
                                   x-model="dateFin"
                                   :min="dateDebut || '<?= date('Y-m-d', strtotime('+1 day')) ?>'" 
                                   required>
                        </div>
                        
                        <!-- Affichage dynamique du nombre de nuits -->
                        <div x-show="nuits > 0" class="alert alert-success small mb-3" x-transition>
                            <i class="bi bi-moon-stars"></i> 
                            <strong x-text="nuits"></strong> 
                            <span x-text="nuits > 1 ? 'nuits' : 'nuit'"></span> sélectionnée(s)
                        </div>
                        
                        <div class="alert alert-info small mb-0">
                            Sélectionnez vos dates pour voir les chambres disponibles de ce type
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-primary px-4" :disabled="!isValid">
                            <span x-show="isValid">Rechercher →</span>
                            <span x-show="!isValid">Sélectionnez les dates</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php endforeach; ?>

<!-- Features Section avec animations Alpine.js -->
<div class="container">
    <div class="row text-center g-4 my-5" x-data="{ activeFeature: null }">
        <div class="col-md-3 col-sm-6" 
             @mouseenter="activeFeature = 1" 
             @mouseleave="activeFeature = null">
            <div class="card border-0 shadow-sm h-100 transition-all" 
                 :class="activeFeature === 1 ? 'shadow-lg scale-105' : ''" 
                 style="transition: all 0.3s ease;">
                <div class="card-body p-4">
                    <i class="bi bi-door-open display-4 text-primary mb-3" 
                       :class="activeFeature === 1 ? 'animate-bounce' : ''"></i>
                    <h5 class="fw-bold">Chambres Luxueuses</h5>
                    <p class="text-muted small mb-0">Confort et élégance dans chaque chambre</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6" 
             @mouseenter="activeFeature = 2" 
             @mouseleave="activeFeature = null">
            <div class="card border-0 shadow-sm h-100 transition-all" 
                 :class="activeFeature === 2 ? 'shadow-lg scale-105' : ''" 
                 style="transition: all 0.3s ease;">
                <div class="card-body p-4">
                    <i class="bi bi-cup-hot display-4 text-primary mb-3"></i>
                    <h5 class="fw-bold">Restaurant Gastronomique</h5>
                    <p class="text-muted small mb-0">Cuisine raffinée et service impeccable</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6" 
             @mouseenter="activeFeature = 3" 
             @mouseleave="activeFeature = null">
            <div class="card border-0 shadow-sm h-100 transition-all" 
                 :class="activeFeature === 3 ? 'shadow-lg scale-105' : ''" 
                 style="transition: all 0.3s ease;">
                <div class="card-body p-4">
                    <i class="bi bi-water display-4 text-primary mb-3"></i>
                    <h5 class="fw-bold">Piscine & Spa</h5>
                    <p class="text-muted small mb-0">Détente et bien-être toute l'année</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6" 
             @mouseenter="activeFeature = 4" 
             @mouseleave="activeFeature = null">
            <div class="card border-0 shadow-sm h-100 transition-all" 
                 :class="activeFeature === 4 ? 'shadow-lg scale-105' : ''" 
                 style="transition: all 0.3s ease;">
                <div class="card-body p-4">
                    <i class="bi bi-geo-alt display-4 text-primary mb-3"></i>
                    <h5 class="fw-bold">Emplacement Idéal</h5>
                    <p class="text-muted small mb-0">Au cœur de la ville, proche de tout</p>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Call to Action Section -->
<div class="container">
    <div class="bg-gradient bg-primary text-white rounded-3 shadow-lg my-5 py-5 px-4">
        <div class="text-center">
            <h3 class="fw-bold mb-3">Prêt pour une expérience exceptionnelle ?</h3>
            <p class="mb-4 opacity-75">Réservez dès maintenant et profitez de nos offres exclusives</p>
            <div class="d-flex justify-content-center flex-wrap gap-3">
                <?php if (!session()->get('isLoggedIn')): ?>
                    <a href="<?= base_url('/login') ?>" class="btn btn-light btn-lg px-5">
                        Se connecter
                    </a>
                <?php endif; ?>
                <a href="#types-section" class="btn btn-outline-light btn-lg px-5">
                    Voir les types
                </a>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<?= $this->endSection() ?>