<?= $this->extend('hotel/layout') ?>

<?= $this->section('content') ?>

<div class="container py-4">
    <!-- En-tête -->
    <div class="mb-5">
        <a href="<?= base_url('/') ?>" class="btn btn-outline-secondary mb-3">
            ← Retour à l'accueil
        </a>
        <h1 class="display-4 fw-bold mb-2">Mes Réservations</h1>
        <p class="lead text-muted">Visualisez toutes vos réservations à l'Hôtel CVVEN</p>
    </div>

    <?php if (empty($reservations)): ?>
        <!-- Aucune réservation -->
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center py-5">
                <div style="font-size: 3rem; margin-bottom: 20px;">😴</div>
                <h4 class="fw-bold mb-3">Aucune réservation pour le moment</h4>
                <p class="text-muted mb-4">Vous n'avez pas encore réservé de chambre à notre hôtel.</p>
                <a href="<?= base_url('/') ?>" class="btn btn-primary btn-lg px-5">
                    Réserver une chambre
                </a>
            </div>
        </div>
    <?php else: ?>
        <!-- Liste des réservations -->
        <div class="row g-4">
            <?php foreach ($reservations as $reservation): ?>
                <div class="col-lg-6">
                    <div class="card border-0 shadow h-100">
                        <!-- En-tête de la carte -->
                        <div class="card-header bg-primary text-white">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h5 class="mb-1">Chambre N° <?= esc($reservation['chamb_numero']) ?></h5>
                                    <small class="opacity-75"><?= esc($reservation['type_libelle']) ?></small>
                                </div>
                                <span class="badge bg-light text-primary fs-6">
                                    <?php
                                    $dateDebut = new DateTime($reservation['reser_dateDebut']);
                                    $dateFin = new DateTime($reservation['reser_dateFin']);
                                    $nuits = $dateDebut->diff($dateFin)->days;
                                    echo $nuits . ' nuit' . ($nuits > 1 ? 's' : '');
                                    ?>
                                </span>
                            </div>
                        </div>

                        <!-- Corps de la carte -->
                        <div class="card-body">
                            <!-- Détails de la chambre -->
                            <div class="mb-4 pb-3 border-bottom">
                                <h6 class="text-muted mb-3">📍 Détails de la chambre</h6>
                                <p class="mb-2">
                                    <strong>Localisation :</strong> <?= esc($reservation['chamb_emplacement']) ?>
                                </p>
                                <p class="mb-0 text-muted small">
                                    <?= esc($reservation['type_desc']) ?>
                                </p>
                            </div>

                            <!-- Dates de la réservation -->
                            <div class="mb-4 pb-3 border-bottom">
                                <h6 class="text-muted mb-3">📅 Dates de séjour</h6>
                                <div class="row">
                                    <div class="col-6">
                                        <p class="mb-1">
                                            <small class="text-muted">Arrivée</small><br>
                                            <strong><?= date('d/m/Y', strtotime($reservation['reser_dateDebut'])) ?></strong>
                                        </p>
                                    </div>
                                    <div class="col-6">
                                        <p class="mb-0">
                                            <small class="text-muted">Départ</small><br>
                                            <strong><?= date('d/m/Y', strtotime($reservation['reser_dateFin'])) ?></strong>
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- Statut de la réservation -->
                            <div>
                                <h6 class="text-muted mb-3">✓ Statut</h6>
                                <?php
                                $dateDebut = new DateTime($reservation['reser_dateDebut']);
                                $dateFin = new DateTime($reservation['reser_dateFin']);
                                $maintenant = new DateTime();

                                if ($dateFin < $maintenant) {
                                    $statut = 'Terminée';
                                    $couleur = 'secondary';
                                    $icone = '✓';
                                } elseif ($dateDebut <= $maintenant && $dateFin > $maintenant) {
                                    $statut = 'En cours';
                                    $couleur = 'success';
                                    $icone = '🏨';
                                } else {
                                    $statut = 'À venir';
                                    $couleur = 'info';
                                    $icone = '📅';
                                }
                                ?>
                                <span class="badge bg-<?= $couleur ?> fs-6">
                                    <?= $icone ?> <?= $statut ?>
                                </span>
                            </div>
                        </div>

                        <!-- Pied de page -->
                        <div class="card-footer bg-light">
                            <a href="<?= base_url('chambre/' . $reservation['chamb_id']) ?>" class="btn btn-sm btn-outline-primary">
                                Voir la chambre
                            </a>
                            <?php if ($dateDebut > $maintenant): ?>
                                <button class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#annulerModal<?= $reservation['chamb_id'] ?>">
                                    Annuler
                                </button>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Statistiques -->
        <div class="row mt-5 g-3">
            <div class="col-md-3">
                <div class="card border-0 shadow-sm text-center">
                    <div class="card-body">
                        <div class="display-6 text-primary mb-2">
                            <?= count($reservations) ?>
                        </div>
                        <small class="text-muted">Réservation<?= count($reservations) > 1 ? 's' : '' ?> totale<?= count($reservations) > 1 ? 's' : '' ?></small>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm text-center">
                    <div class="card-body">
                        <div class="display-6 text-success mb-2">
                            <?php
                            $maintenant = new DateTime();
                            $count = 0;
                            foreach ($reservations as $r) {
                                $dateFin = new DateTime($r['reser_dateFin']);
                                if ($dateFin >= $maintenant) $count++;
                            }
                            echo $count;
                            ?>
                        </div>
                        <small class="text-muted">Réservation<?= $count > 1 ? 's' : '' ?> à venir</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm text-center">
                    <div class="card-body">
                        <div class="display-6 text-info mb-2">
                            <?php
                            $nuits = 0;
                            foreach ($reservations as $r) {
                                $d1 = new DateTime($r['reser_dateDebut']);
                                $d2 = new DateTime($r['reser_dateFin']);
                                $nuits += $d1->diff($d2)->days;
                            }
                            echo $nuits;
                            ?>
                        </div>
                        <small class="text-muted">Nuit<?= $nuits > 1 ? 's' : '' ?> réservée<?= $nuits > 1 ? 's' : '' ?></small>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm text-center">
                    <div class="card-body">
                        <a href="<?= base_url('/') ?>" class="btn btn-primary w-100">
                            Réserver une chambre
                        </a>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<?= $this->endSection() ?>
