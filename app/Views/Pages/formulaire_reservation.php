<?= $this->extend('hotel/layout') ?>

<?= $this->section('content') ?>

<div class="container py-4">
    <!-- En-tête -->
    <div class="mb-5">
        <a href="<?= base_url('/') ?>" class="btn btn-outline-secondary mb-3">
            <i class="bi bi-arrow-left"></i> Retour à l'accueil
        </a>
        <h1 class="display-4 fw-bold mb-2">Réservation de Chambre</h1>
        <p class="lead text-muted">Complétez le formulaire pour réserver votre chambre</p>
    </div>

    <!-- Affichage des messages d'erreur généraux -->
    <?php if (session()->getFlashdata('erreur')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle"></i> <?= session()->getFlashdata('erreur') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <!-- Affichage des erreurs de validation -->
    <?php if (session()->getFlashdata('erreurs')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Erreurs de validation :</strong>
            <ul class="mb-0 mt-2">
                <?php foreach (session()->getFlashdata('erreurs') as $erreur): ?>
                    <li><?= $erreur ?></li>
                <?php endforeach; ?>
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="row">
        <!-- Formulaire de réservation -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="bi bi-calendar-plus"></i> Formulaire de Réservation</h5>
                </div>
                <div class="card-body p-4" x-data="{ 
                    dateDebut: '', 
                    dateFin: '',
                    get nuits() { 
                        if (!this.dateDebut || !this.dateFin) return 0;
                        const d1 = new Date(this.dateDebut);
                        const d2 = new Date(this.dateFin);
                        return Math.max(0, Math.ceil((d2 - d1) / (1000 * 60 * 60 * 24)));
                    }
                }">
                    <form method="post" action="<?= site_url('reservation/reserver') ?>">
                        <?= csrf_field() ?>
                        
                        <!-- Sélection de la chambre -->
                        <div class="mb-4">
                            <label for="chamb_id" class="form-label fw-bold">
                                <i class="bi bi-door-open"></i> Sélectionnez une chambre
                            </label>
                            <select name="chamb_id" id="chamb_id" class="form-select form-select-lg" required>
                                <option value="">Choisissez une chambre...</option>
                                <?php foreach ($chambres as $chambre): ?>
                                    <option value="<?= $chambre['chamb_id'] ?>">
                                        Chambre <?= $chambre['chamb_numero'] ?> - 
                                        <?= $chambre['type_libelle'] ?> - 
                                        <?= $chambre['chamb_emplacement'] ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Date de début -->
                        <div class="mb-4">
                            <label for="reser_dateDebut" class="form-label fw-bold">
                                <i class="bi bi-calendar-event"></i> Date et heure d'arrivée
                            </label>
                            <input type="datetime-local" 
                                   name="reser_dateDebut" 
                                   id="reser_dateDebut" 
                                   class="form-control form-control-lg" 
                                   x-model="dateDebut"
                                   min="<?= date('Y-m-d\TH:i') ?>"
                                   required>
                        </div>

                        <!-- Date de fin -->
                        <div class="mb-4">
                            <label for="reser_dateFin" class="form-label fw-bold">
                                <i class="bi bi-calendar-check"></i> Date et heure de départ
                            </label>
                            <input type="datetime-local" 
                                   name="reser_dateFin" 
                                   id="reser_dateFin" 
                                   class="form-control form-control-lg" 
                                   x-model="dateFin"
                                   :min="dateDebut || '<?= date('Y-m-d\TH:i', strtotime('+1 day')) ?>'"
                                   required>
                        </div>

                        <!-- Affichage dynamique du nombre de nuits -->
                        <div x-show="nuits > 0" class="alert alert-info" x-transition>
                            <i class="bi bi-moon-stars"></i> 
                            Durée du séjour : <strong x-text="nuits"></strong> 
                            <span x-text="nuits > 1 ? 'nuits' : 'nuit'"></span>
                        </div>

                        <!-- Bouton de soumission -->
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="bi bi-check-circle"></i> Confirmer la réservation
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Liste des chambres disponibles -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm sticky-top" style="top: 20px;">
                <div class="card-header bg-secondary text-white">
                    <h5 class="mb-0"><i class="bi bi-list-ul"></i> Chambres Disponibles</h5>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        <?php if (!empty($chambres)): ?>
                            <?php foreach ($chambres as $chambre): ?>
                                <div class="list-group-item">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <h6 class="mb-1 fw-bold">Chambre <?= $chambre['chamb_numero'] ?></h6>
                                            <p class="mb-1 small text-muted">
                                                <i class="bi bi-tag"></i> <?= $chambre['type_libelle'] ?>
                                            </p>
                                            <p class="mb-1 small">
                                                <i class="bi bi-geo-alt"></i> <?= $chambre['chamb_emplacement'] ?>
                                            </p>
                                            <?php if ($chambre['chamb_remarque']): ?>
                                                <p class="mb-0 small text-info">
                                                    <i class="bi bi-info-circle"></i> <?= $chambre['chamb_remarque'] ?>
                                                </p>
                                            <?php endif; ?>
                                        </div>
                                        <span class="badge bg-success">Disponible</span>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="list-group-item text-center text-muted py-4">
                                <i class="bi bi-exclamation-circle display-6"></i>
                                <p class="mb-0 mt-2">Aucune chambre disponible</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
