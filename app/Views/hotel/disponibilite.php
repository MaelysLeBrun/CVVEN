<?= $this->extend('hotel/layout') ?>

<?= $this->section('content') ?>

<div class="container py-4">
    <!-- En-tête -->
    <div class="mb-5">
        <a href="<?= base_url('/') ?>" class="btn btn-outline-secondary mb-3">
            ← Retour à l'accueil
        </a>
        <h1 class="display-4 fw-bold mb-3">Disponibilité - <?= esc($type['type_libelle']) ?></h1>
        <p class="lead text-muted"><?= esc($type['type_desc']) ?></p>
    </div>

    <!-- Informations de la recherche -->
    <div class="alert alert-info d-flex align-items-center mb-4">
        <div class="flex-grow-1">
            <?php if ($dateDebut && $dateFin): ?>
                <h5 class="mb-2"><i class="bi bi-calendar-check"></i> Période sélectionnée :</h5>
                <p class="mb-0">
                    Du <strong><?= date('d/m/Y', strtotime($dateDebut)) ?></strong> 
                    au <strong><?= date('d/m/Y', strtotime($dateFin)) ?></strong>
                </p>
            <?php else: ?>
                <h5 class="mb-0">Toutes les chambres de ce type</h5>
            <?php endif; ?>
        </div>
        <div>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#changeDateModal">
                Modifier les dates
            </button>
        </div>
    </div>

    <!-- Résultat de la disponibilité -->
    <div class="card border-0 shadow-sm mb-5">
        <div class="card-body p-4">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h3 class="fw-bold mb-2">
                        <?= $nombreDisponible ?> <?= $nombreDisponible > 1 ? 'chambres disponibles' : 'chambre disponible' ?>
                    </h3>
                    <?php if ($nombreDisponible > 0): ?>
                        <p class="text-success mb-0">
                            ✓ Des chambres sont disponibles pour votre séjour
                        </p>
                    <?php else: ?>
                        <p class="text-danger mb-0">
                            ✗ Aucune chambre disponible pour cette période
                        </p>
                    <?php endif; ?>
                </div>
                <div class="col-md-4 text-end">
                    <div class="display-3 <?= $nombreDisponible > 0 ? 'text-success' : 'text-danger' ?>">
                        <?= $nombreDisponible > 0 ? '✓' : '✗' ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Liste des chambres disponibles -->
    <?php if ($nombreDisponible > 0): ?>
        <h2 class="fw-bold mb-4">Chambres disponibles</h2>
        <div class="row g-4">
            <?php foreach ($chambres as $chambre): ?>
                <div class="col-lg-4 col-md-6">
                    <div class="card border-0 shadow h-100">
                        <div class="position-relative overflow-hidden">
                            <img src="<?= base_url('assets/images/chambres/chambre' . $chambre['chamb_numero'] . '.jpg') ?>" 
                                 class="card-img-top" 
                                 alt="Chambre <?= esc($chambre['chamb_numero']) ?>"
                                 style="height: 250px; object-fit: cover;"
                                 onerror="this.src='https://placehold.co/600x400/0d6efd/white?text=Chambre+<?= $chambre['chamb_numero'] ?>'">
                            <span class="badge bg-success position-absolute top-0 end-0 m-3 fs-6">
                                Disponible
                            </span>
                        </div>
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title fw-bold mb-3">
                                Chambre N° <?= esc($chambre['chamb_numero']) ?>
                            </h5>
                            <div class="mb-3">
                                <p class="mb-2">
                                    <span class="badge bg-light text-dark border">
                                        <i class="bi bi-geo-alt"></i> <?= esc($chambre['chamb_emplacement']) ?>
                                    </span>
                                </p>
                                <p class="text-muted">
                                    <?= esc($chambre['type_desc']) ?>
                                </p>
                            </div>
                            <div class="mt-auto">
                                <a href="<?= base_url('chambre/' . $chambre['chamb_id']) ?><?= $dateDebut && $dateFin ? '?date_debut=' . $dateDebut . '&date_fin=' . $dateFin : '' ?>" 
                                   class="btn btn-primary w-100">
                                    Réserver cette chambre
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <!-- Suggestions alternatives -->
        <div class="alert alert-warning">
            <h5 class="alert-heading">Aucune chambre disponible</h5>
            <p class="mb-0">Nous vous suggérons de :</p>
            <ul class="mb-0 mt-2">
                <li>Modifier vos dates de séjour</li>
                <li>Consulter d'autres types de chambres</li>
                <li>Nous contacter directement pour plus d'options</li>
            </ul>
        </div>
        <div class="text-center mt-4">
            <a href="<?= base_url('/') ?>" class="btn btn-primary btn-lg">
                Voir tous les types de chambres
            </a>
        </div>
    <?php endif; ?>
</div>

<!-- Modal pour modifier les dates -->
<div class="modal fade" id="changeDateModal" tabindex="-1" aria-labelledby="changeDateModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="changeDateModalLabel">
                    Modifier les dates
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('disponibilite/' . $type['type_id']) ?>" method="get">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="date_debut" class="form-label fw-bold">Date d'arrivée</label>
                        <input type="date" class="form-control" id="date_debut" name="date_debut" 
                               value="<?= $dateDebut ?>" min="<?= date('Y-m-d') ?>" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="date_fin" class="form-label fw-bold">Date de départ</label>
                        <input type="date" class="form-control" id="date_fin" name="date_fin" 
                               value="<?= $dateFin ?>" min="<?= date('Y-m-d', strtotime('+1 day')) ?>" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">Rechercher</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<?= $this->endSection() ?>
