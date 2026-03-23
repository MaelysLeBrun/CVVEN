<?= $this->extend('hotel/layout') ?>

<?= $this->section('content') ?>

<!-- En-tête -->
<div class="mb-5">
        <a href="<?= base_url('/') ?>" class="btn btn-outline-secondary mb-3">
            ← Retour à l'accueil
        </a>
        <h1 class="display-4 fw-bold mb-2">Mes Réservations</h1>
        <p class="lead text-muted">Visualisez toutes vos réservations à l'Hôtel CVVEN</p>
    </div>

    <!-- Messages flash -->
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle"></i> <?= session()->getFlashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('erreur')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle"></i> <?= session()->getFlashdata('erreur') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if (empty($reservations)): ?>
        <!-- Aucune réservation -->
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center py-5">
                <i class="bi bi-calendar-x display-3 text-muted d-block mb-4"></i>
                <h4 class="fw-bold mb-3">Aucune réservation pour le moment</h4>
                <p class="text-muted mb-4">Vous n'avez pas encore réservé de chambre à notre hôtel.</p>
                <a href="<?= base_url('reservation') ?>" class="btn btn-primary btn-lg px-5">
                    Réserver une chambre
                </a>
            </div>
        </div>
    <?php else: ?>
        <!-- Liste des réservations -->
        <div class="row g-4">
            <?php foreach ($reservations as $reservation): ?>
                <?php
                $dateDebut  = new DateTime($reservation['reser_dateDebut']);
                $dateFin    = new DateTime($reservation['reser_dateFin']);
                $maintenant = new DateTime();
                $nuits      = $dateDebut->diff($dateFin)->days;

                if ($dateFin < $maintenant) {
                    $statut  = 'Terminée';
                    $couleur = 'secondary';
                    $icone   = 'bi-check-circle';
                } elseif ($dateDebut <= $maintenant && $dateFin > $maintenant) {
                    $statut  = 'En cours';
                    $couleur = 'success';
                    $icone   = 'bi-house-door';
                } else {
                    $statut  = 'À venir';
                    $couleur = 'info';
                    $icone   = 'bi-calendar-event';
                }
                ?>
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
                                    <?= $nuits ?> nuit<?= $nuits > 1 ? 's' : '' ?>
                                </span>
                            </div>
                        </div>

                        <!-- Corps de la carte -->
                        <div class="card-body">
                            <!-- Détails de la chambre -->
                            <div class="mb-4 pb-3 border-bottom">
                                <h6 class="text-muted mb-3"><i class="bi bi-geo-alt"></i> Détails de la chambre</h6>
                                <p class="mb-2">
                                    <strong>Localisation :</strong> <?= esc($reservation['chamb_emplacement']) ?>
                                </p>
                                <p class="mb-0 text-muted small">
                                    <?= esc($reservation['type_desc']) ?>
                                </p>
                            </div>

                            <!-- Dates de la réservation -->
                            <div class="mb-4 pb-3 border-bottom">
                                <h6 class="text-muted mb-3"><i class="bi bi-calendar-check"></i> Dates de séjour</h6>
                                <div class="row">
                                    <div class="col-6">
                                        <small class="text-muted">Arrivée</small><br>
                                        <strong><?= date('d/m/Y à H:i', strtotime($reservation['reser_dateDebut'])) ?></strong>
                                    </div>
                                    <div class="col-6">
                                        <small class="text-muted">Départ</small><br>
                                        <strong><?= date('d/m/Y à H:i', strtotime($reservation['reser_dateFin'])) ?></strong>
                                    </div>
                                </div>
                            </div>

                            <!-- Statut -->
                            <div>
                                <h6 class="text-muted mb-3"><i class="bi bi-info-circle"></i> Statut</h6>
                                <span class="badge bg-<?= $couleur ?> fs-6">
                                    <i class="bi <?= $icone ?>"></i> <?= $statut ?>
                                </span>
                            </div>
                        </div>

                        <!-- Pied de page -->
                        <div class="card-footer bg-light d-flex justify-content-between align-items-center">
                            <a href="<?= base_url('chambre/' . $reservation['chamb_id']) ?>" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-eye"></i> Voir la chambre
                            </a>
                            <?php if ($dateDebut > $maintenant): ?>
                                <button class="btn btn-sm btn-outline-danger"
                                        data-bs-toggle="modal"
                                        data-bs-target="#annulerModal<?= $reservation['reser_id'] ?>">
                                    <i class="bi bi-x-circle"></i> Annuler
                                </button>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Modal de confirmation d'annulation -->
                <?php if ($dateDebut > $maintenant): ?>
                <div class="modal fade" id="annulerModal<?= $reservation['reser_id'] ?>" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header border-0">
                                <h5 class="modal-title fw-bold">Confirmer l'annulation</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body text-center py-3">
                                <i class="bi bi-exclamation-triangle text-warning display-4 d-block mb-3"></i>
                                <p class="mb-1">Voulez-vous annuler la réservation de la</p>
                                <p class="fw-bold mb-1">Chambre <?= esc($reservation['chamb_numero']) ?> — <?= esc($reservation['type_libelle']) ?></p>
                                <p class="text-muted small">
                                    Du <?= date('d/m/Y', strtotime($reservation['reser_dateDebut'])) ?>
                                    au <?= date('d/m/Y', strtotime($reservation['reser_dateFin'])) ?>
                                </p>
                            </div>
                            <div class="modal-footer border-0 justify-content-center">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                    Non, garder
                                </button>
                                <form method="post" action="<?= base_url('mes-reservations/annuler/' . $reservation['reser_id']) ?>">
                                    <?= csrf_field() ?>
                                    <button type="submit" class="btn btn-danger">
                                        <i class="bi bi-x-circle"></i> Oui, annuler
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>

            <?php endforeach; ?>
        </div>

        <!-- Statistiques -->
        <div class="row mt-5 g-3">
            <div class="col-md-4">
                <div class="card border-0 shadow-sm text-center">
                    <div class="card-body">
                        <div class="display-6 text-primary mb-2"><?= count($reservations) ?></div>
                        <small class="text-muted">Réservation<?= count($reservations) > 1 ? 's' : '' ?> totale<?= count($reservations) > 1 ? 's' : '' ?></small>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm text-center">
                    <div class="card-body">
                        <?php
                        $maintenant  = new DateTime();
                        $aVenir      = 0;
                        $totalNuits  = 0;
                        foreach ($reservations as $r) {
                            $d1 = new DateTime($r['reser_dateDebut']);
                            $d2 = new DateTime($r['reser_dateFin']);
                            if ($d2 >= $maintenant) $aVenir++;
                            $totalNuits += $d1->diff($d2)->days;
                        }
                        ?>
                        <div class="display-6 text-success mb-2"><?= $aVenir ?></div>
                        <small class="text-muted">À venir / en cours</small>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm text-center">
                    <div class="card-body">
                        <div class="display-6 text-info mb-2"><?= $totalNuits ?></div>
                        <small class="text-muted">Nuit<?= $totalNuits > 1 ? 's' : '' ?> réservée<?= $totalNuits > 1 ? 's' : '' ?></small>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-center mt-4">
            <a href="<?= base_url('reservation') ?>" class="btn btn-primary px-5">
                <i class="bi bi-plus-circle"></i> Nouvelle réservation
            </a>
        </div>

    <?php endif; ?>

<?= $this->endSection() ?>
