<?= $this->extend('hotel/layout') ?>

<?= $this->section('content') ?>

<!-- En-tête -->
<div class="mb-4">
    <a href="<?= base_url('/') ?>" class="btn btn-outline-secondary mb-3">
        <i class="bi bi-arrow-left"></i> Retour à l'accueil
    </a>
    <h1 class="display-5 fw-bold mb-1">Réservation de Chambre</h1>
    <p class="text-muted">Complétez le formulaire pour réserver votre chambre</p>
</div>

<!-- Messages -->
<?php if (session()->getFlashdata('erreur')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="bi bi-exclamation-triangle"></i> <?= session()->getFlashdata('erreur') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>
<?php if (session()->getFlashdata('erreurs')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong><i class="bi bi-exclamation-circle"></i> Erreurs :</strong>
        <ul class="mb-0 mt-2">
            <?php foreach (session()->getFlashdata('erreurs') as $erreur): ?>
                <li><?= esc($erreur) ?></li>
            <?php endforeach; ?>
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<div class="row g-4" x-data="{
    dateDebut: '<?= esc($dateDebut ?? '') ?>',
    dateFin: '<?= esc($dateFin ?? '') ?>',
    chambreId: '<?= esc($chambreSelectionnee ?? '') ?>',
    disponible: null,
    checking: false,
    get nuits() {
        if (!this.dateDebut || !this.dateFin) return 0;
        const d1 = new Date(this.dateDebut);
        const d2 = new Date(this.dateFin);
        return Math.max(0, Math.ceil((d2 - d1) / (1000 * 60 * 60 * 24)));
    },
    async checkDisponibilite() {
        if (!this.chambreId || !this.dateDebut || !this.dateFin) {
            this.disponible = null;
            return;
        }
        this.checking = true;
        try {
            const response = await fetch('<?= site_url('reservation/checkDisponibilite') ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: new URLSearchParams({
                    chamb_id: this.chambreId,
                    dateDebut: this.dateDebut,
                    dateFin: this.dateFin
                })
            });
            const data = await response.json();
            this.disponible = data.disponible;
        } catch (error) {
            this.disponible = false;
        } finally {
            this.checking = false;
        }
    }
}" @change="checkDisponibilite()" x-init="if (chambreId && dateDebut && dateFin) checkDisponibilite()">

    <!-- Formulaire -->
    <div class="col-lg-8">
        <div class="card border-0 shadow">
            <div class="card-header bg-primary text-white py-3">
                <h5 class="mb-0"><i class="bi bi-calendar-plus"></i> Votre Réservation</h5>
            </div>
            <div class="card-body p-4">
                <form method="post" action="<?= site_url('reservation/reserver') ?>">
                    <?= csrf_field() ?>

                    <!-- Vos coordonnées -->
                    <h6 class="fw-bold mb-3"><i class="bi bi-person-circle"></i> Vos coordonnées</h6>
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-muted">Nom</label>
                            <input type="text" class="form-control" value="<?= esc($user['user_nom'] ?? '') ?>" disabled>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-muted">Prénom</label>
                            <input type="text" class="form-control" value="<?= esc($user['user_prenom'] ?? '') ?>" disabled>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-muted">Email</label>
                            <input type="email" class="form-control" value="<?= esc($user['user_mail'] ?? '') ?>" disabled>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-muted">Téléphone</label>
                            <input type="tel" class="form-control" value="<?= esc($user['user_telephone'] ?? '') ?>" disabled>
                        </div>
                    </div>

                    <hr>

                    <!-- Dates du séjour -->
                    <h6 class="fw-bold mb-3 mt-4"><i class="bi bi-calendar3"></i> Dates du séjour</h6>
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label for="reser_dateDebut" class="form-label small fw-bold text-muted">Arrivée</label>
                            <input type="datetime-local"
                                   name="reser_dateDebut"
                                   id="reser_dateDebut"
                                   class="form-control"
                                   x-model="dateDebut"
                                   min="<?= date('Y-m-d\TH:i') ?>"
                                   required>
                        </div>
                        <div class="col-md-6">
                            <label for="reser_dateFin" class="form-label small fw-bold text-muted">Départ</label>
                            <input type="datetime-local"
                                   name="reser_dateFin"
                                   id="reser_dateFin"
                                   class="form-control"
                                   x-model="dateFin"
                                   :min="dateDebut || '<?= date('Y-m-d\TH:i', strtotime('+1 day')) ?>'"
                                   required>
                        </div>
                    </div>

                    <div x-show="nuits > 0" class="alert alert-info mb-4" x-transition>
                        <i class="bi bi-moon-stars"></i>
                        <strong>Durée du séjour :</strong>
                        <span x-text="nuits"></span> <span x-text="nuits > 1 ? 'nuits' : 'nuit'"></span>
                    </div>

                    <hr>

                    <!-- Sélection de la chambre -->
                    <h6 class="fw-bold mb-3 mt-4"><i class="bi bi-door-open"></i> Chambre</h6>
                    <select name="chamb_id"
                            id="chamb_id"
                            class="form-select mb-3"
                            x-model="chambreId"
                            required>
                        <option value="">-- Choisissez une chambre --</option>
                        <?php foreach ($chambres as $chambre): ?>
                            <option value="<?= esc($chambre['chamb_id']) ?>"
                                <?= ($chambreSelectionnee ?? '') === $chambre['chamb_id'] ? 'selected' : '' ?>>
                                Chambre <?= esc($chambre['chamb_numero']) ?> —
                                <?= esc($chambre['type_libelle']) ?> —
                                <?= esc($chambre['chamb_emplacement']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>

                    <!-- Statut disponibilité -->
                    <div x-show="disponible !== null && chambreId && dateDebut && dateFin"
                         :class="disponible ? 'alert alert-success' : 'alert alert-danger'"
                         x-transition>
                        <i :class="disponible ? 'bi bi-check-circle-fill' : 'bi bi-x-circle-fill'"></i>
                        <span x-text="disponible ? 'Chambre disponible pour ces dates' : 'Chambre non disponible pour ces dates'"></span>
                        <span x-show="checking" class="ms-2">
                            <span class="spinner-border spinner-border-sm"></span>
                        </span>
                    </div>

                    <!-- Bouton -->
                    <div class="d-grid mt-4">
                        <button type="submit"
                                class="btn btn-primary btn-lg fw-bold"
                                :disabled="!disponible || checking"
                                x-bind:disabled="!disponible || checking">
                            <i class="bi bi-check-circle"></i> Confirmer la réservation
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Sidebar chambres -->
    <div class="col-lg-4">
        <div class="card border-0 shadow" style="position: sticky; top: 20px;">
            <div class="card-header bg-primary text-white py-3">
                <h5 class="mb-0"><i class="bi bi-list-check"></i> Nos chambres</h5>
            </div>
            <div class="card-body p-0">
                <div class="list-group list-group-flush" style="max-height: 600px; overflow-y: auto;">
                    <?php if (!empty($chambres)): ?>
                        <?php foreach ($chambres as $chambre): ?>
                            <div class="list-group-item border-0 py-3 px-4">
                                <h6 class="mb-1 fw-bold">
                                    <i class="bi bi-door-open"></i> Chambre <?= esc($chambre['chamb_numero']) ?>
                                </h6>
                                <span class="badge bg-primary mb-1"><?= esc($chambre['type_libelle']) ?></span>
                                <p class="mb-1 small text-muted">
                                    <i class="bi bi-geo-alt"></i> <?= esc($chambre['chamb_emplacement']) ?>
                                </p>
                                <?php if ($chambre['chamb_remarque']): ?>
                                    <p class="mb-1 small text-success">
                                        <i class="bi bi-star"></i> <?= esc($chambre['chamb_remarque']) ?>
                                    </p>
                                <?php endif; ?>
                                <p class="mb-0 small text-muted"><?= esc($chambre['type_desc']) ?></p>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="text-center text-muted py-5">
                            <i class="bi bi-inbox display-5 d-block mb-3"></i>
                            <p class="mb-0">Aucune chambre disponible</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

</div>

<?= $this->endSection() ?>
