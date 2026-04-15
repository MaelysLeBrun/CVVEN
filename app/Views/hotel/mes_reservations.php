<?= $this->extend('hotel/layout') ?>
<?= $this->section('content') ?>

<?php
function pensionBadgeMesRes(string $type): string {
    $map = [
        'pension_complete' => ['Pension complète', 'bi-brightness-high',  '#6B4226', 'rgba(184,134,11,0.12)',  'rgba(201,176,122,0.5)'],
        'demi_pension'     => ['Demi-pension',      'bi-cup-straw',        '#1e5a7a', 'rgba(44,110,138,0.12)',  'rgba(44,110,138,0.35)'],
        'sans_pension'     => ['Sans pension',      'bi-slash-circle',     '#7A7265', 'rgba(122,114,101,0.08)', '#DDD8CD'],
    ];
    [$label, $icon, $color, $bg, $border] = $map[$type] ?? $map['sans_pension'];
    return sprintf(
        '<span style="display:inline-flex;align-items:center;gap:4px;font-family:\'Outfit\',sans-serif;font-size:0.7rem;font-weight:600;background:%s;color:%s;border:1px solid %s;border-radius:50px;padding:0.22rem 0.65rem;"><i class="bi %s" style="font-size:0.65rem;"></i>%s</span>',
        $bg, $color, $border, $icon, $label
    );
}
?>

<!-- Page header -->
<div class="page-header">
    <div class="container">
        <a href="<?= base_url('/') ?>"
           style="display:inline-flex;align-items:center;gap:6px;color:rgba(255,255,255,0.6);font-size:0.85rem;font-family:'Outfit',sans-serif;text-decoration:none;margin-bottom:1rem;transition:color 0.3s;"
           onmouseover="this.style.color='#E8D8A8'"
           onmouseout="this.style.color='rgba(255,255,255,0.6)'">
            <i class="bi bi-arrow-left"></i> Retour à l'accueil
        </a>
        <h1>Mes Réservations</h1>
        <p class="lead">Gérez vos séjours dans les villages de vacances CVVEN</p>
    </div>
</div>

<div style="background-color:#EDE8DC;padding:3rem 0;min-height:60vh;">
    <div class="container">

        <!-- Flash messages -->
        <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
            <i class="bi bi-check-circle me-2"></i><?= session()->getFlashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('erreur')): ?>
        <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
            <i class="bi bi-exclamation-triangle me-2"></i><?= session()->getFlashdata('erreur') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php endif; ?>

        <?php if (empty($reservations)): ?>
        <!-- Empty state -->
        <div style="background:#F8F5EE;border:1px solid #DDD8CD;border-radius:16px;padding:4rem 2rem;text-align:center;box-shadow:0 2px 8px rgba(22,43,25,0.06);">
            <div style="width:80px;height:80px;background:#EDE8DC;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:2rem;color:#DDD8CD;margin:0 auto 1.5rem;">
                <i class="bi bi-calendar-x"></i>
            </div>
            <h4 style="font-family:'Cormorant Garamond',serif;font-size:1.8rem;font-weight:700;color:#162B19;margin-bottom:0.75rem;">
                Aucune réservation pour le moment
            </h4>
            <p style="font-family:'Outfit',sans-serif;font-size:0.9rem;color:#7A7265;max-width:400px;margin:0 auto 2rem;line-height:1.7;">
                Vous n'avez pas encore réservé d'hébergement. Parcourez nos types de chambres et planifiez votre prochain séjour en montagne.
            </p>
            <a href="<?= base_url('reservation') ?>"
               style="
                    display:inline-flex;align-items:center;gap:8px;
                    background:linear-gradient(135deg,#2A4A2E,#3A6341);
                    color:#fff;font-family:'Outfit',sans-serif;font-weight:600;font-size:0.9rem;
                    padding:0.85rem 2rem;border-radius:8px;text-decoration:none;
                    box-shadow:0 6px 20px rgba(22,43,25,0.25);transition:all 0.3s;
               "
               onmouseover="this.style.background='linear-gradient(135deg,#162B19,#2A4A2E)';this.style.color='#E8D8A8'"
               onmouseout="this.style.background='linear-gradient(135deg,#2A4A2E,#3A6341)';this.style.color='#fff'">
                <i class="bi bi-plus-circle"></i>
                Réserver un hébergement
            </a>
        </div>

        <?php else: ?>

        <!-- Reservations list -->
        <div class="row g-4">
            <?php foreach ($reservations as $reservation): ?>
                <?php
                $dateDebut  = new DateTime($reservation['reser_dateDebut']);
                $dateFin    = new DateTime($reservation['reser_dateFin']);
                $maintenant = new DateTime();
                $nuits      = $dateDebut->diff($dateFin)->days;

                if ($dateFin < $maintenant) {
                    $statut      = 'Terminée';
                    $statutClass = 'badge-terminee';
                    $icone       = 'bi-check-circle';
                    $headerColor = 'linear-gradient(135deg,#4a4540,#5a5248)';
                } elseif ($dateDebut <= $maintenant && $dateFin > $maintenant) {
                    $statut      = 'En cours';
                    $statutClass = 'badge-encours';
                    $icone       = 'bi-house-door';
                    $headerColor = 'linear-gradient(135deg,#2A4A2E,#3A6341)';
                } else {
                    $statut      = 'À venir';
                    $statutClass = 'badge-avenir';
                    $icone       = 'bi-calendar-event';
                    $headerColor = 'linear-gradient(135deg,#1e3a54,#2d5274)';
                }
                ?>
                <div class="col-lg-6">
                    <div style="
                        background:#F8F5EE;border:1px solid #DDD8CD;border-radius:14px;
                        overflow:hidden;height:100%;
                        box-shadow:0 2px 8px rgba(22,43,25,0.08);
                        transition:all 0.35s;display:flex;flex-direction:column;
                    "
                    onmouseover="this.style.transform='translateY(-4px)';this.style.boxShadow='0 12px 32px rgba(22,43,25,0.14)'"
                    onmouseout="this.style.transform='';this.style.boxShadow='0 2px 8px rgba(22,43,25,0.08)'">

                        <!-- Card header -->
                        <div style="background:<?= $headerColor ?>;padding:1.25rem 1.5rem;">
                            <div style="display:flex;justify-content:space-between;align-items:flex-start;">
                                <div>
                                    <div style="font-family:'Cormorant Garamond',serif;font-size:1.3rem;font-weight:700;color:#F8F5EE;margin-bottom:2px;">
                                        Chambre N°<?= esc($reservation['chamb_numero']) ?>
                                    </div>
                                    <div style="font-family:'Outfit',sans-serif;font-size:0.78rem;color:rgba(255,255,255,0.6);">
                                        <?= esc($reservation['type_libelle']) ?>
                                    </div>
                                </div>
                                <div style="
                                    background:rgba(255,255,255,0.12);
                                    border:1px solid rgba(255,255,255,0.2);
                                    border-radius:50px;
                                    padding:0.3rem 0.85rem;
                                    font-family:'Outfit',sans-serif;
                                    font-size:0.78rem;font-weight:600;
                                    color:rgba(255,255,255,0.9);
                                    white-space:nowrap;
                                ">
                                    <?= $nuits ?> nuit<?= $nuits > 1 ? 's' : '' ?>
                                </div>
                            </div>
                        </div>

                        <!-- Card body -->
                        <div style="padding:1.5rem;flex:1;">

                            <!-- Location row -->
                            <div style="display:flex;align-items:center;gap:8px;margin-bottom:1.25rem;padding-bottom:1.25rem;border-bottom:1px solid #EDE8DC;">
                                <div style="width:32px;height:32px;background:#EDE8DC;border-radius:8px;display:flex;align-items:center;justify-content:center;color:#C9B07A;font-size:0.85rem;flex-shrink:0;">
                                    <i class="bi bi-geo-alt"></i>
                                </div>
                                <div>
                                    <div style="font-family:'Outfit',sans-serif;font-size:0.72rem;color:#7A7265;letter-spacing:0.06em;text-transform:uppercase;">Emplacement</div>
                                    <div style="font-family:'Outfit',sans-serif;font-size:0.875rem;font-weight:500;color:#2C2416;">
                                        <?= esc($reservation['chamb_emplacement']) ?>
                                    </div>
                                </div>
                            </div>

                            <!-- Dates -->
                            <div style="margin-bottom:1.25rem;padding-bottom:1.25rem;border-bottom:1px solid #EDE8DC;">
                                <div style="font-family:'Outfit',sans-serif;font-size:0.72rem;color:#7A7265;letter-spacing:0.06em;text-transform:uppercase;margin-bottom:0.75rem;">
                                    <i class="bi bi-calendar3 me-1"></i>Dates du séjour
                                </div>
                                <div style="display:flex;gap:1rem;">
                                    <div style="flex:1;background:#EDE8DC;border-radius:8px;padding:0.75rem;text-align:center;">
                                        <div style="font-size:0.7rem;color:#7A7265;font-family:'Outfit',sans-serif;margin-bottom:2px;">Arrivée</div>
                                        <div style="font-family:'Cormorant Garamond',serif;font-size:1rem;font-weight:600;color:#162B19;">
                                            <?= date('d/m/Y', strtotime($reservation['reser_dateDebut'])) ?>
                                        </div>
                                        <div style="font-size:0.7rem;color:#7A7265;font-family:'Outfit',sans-serif;">
                                            <?= date('H:i', strtotime($reservation['reser_dateDebut'])) ?>
                                        </div>
                                    </div>
                                    <div style="display:flex;align-items:center;color:#C9B07A;">
                                        <i class="bi bi-arrow-right"></i>
                                    </div>
                                    <div style="flex:1;background:#EDE8DC;border-radius:8px;padding:0.75rem;text-align:center;">
                                        <div style="font-size:0.7rem;color:#7A7265;font-family:'Outfit',sans-serif;margin-bottom:2px;">Départ</div>
                                        <div style="font-family:'Cormorant Garamond',serif;font-size:1rem;font-weight:600;color:#162B19;">
                                            <?= date('d/m/Y', strtotime($reservation['reser_dateFin'])) ?>
                                        </div>
                                        <div style="font-size:0.7rem;color:#7A7265;font-family:'Outfit',sans-serif;">
                                            <?= date('H:i', strtotime($reservation['reser_dateFin'])) ?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Pension -->
                            <div style="margin-bottom:1.25rem;padding-bottom:1.25rem;border-bottom:1px solid #EDE8DC;display:flex;align-items:center;gap:8px;">
                                <div style="width:32px;height:32px;background:#EDE8DC;border-radius:8px;display:flex;align-items:center;justify-content:center;color:#C9B07A;font-size:0.85rem;flex-shrink:0;">
                                    <i class="bi bi-cup-hot"></i>
                                </div>
                                <div>
                                    <div style="font-family:'Outfit',sans-serif;font-size:0.72rem;color:#7A7265;letter-spacing:0.06em;text-transform:uppercase;margin-bottom:0.3rem;">Pension</div>
                                    <?= pensionBadgeMesRes($reservation['type_pension'] ?? 'sans_pension') ?>
                                </div>
                            </div>

                            <!-- Price & Status -->
                            <div style="display:flex;align-items:center;justify-content:space-between;">
                                <span class="badge <?= $statutClass ?>"
                                      style="font-family:'Outfit',sans-serif;font-size:0.75rem;font-weight:600;padding:0.4rem 0.9rem;border-radius:50px;letter-spacing:0.06em;">
                                    <i class="bi <?= $icone ?> me-1"></i><?= $statut ?>
                                </span>
                                <?php if (!empty($reservation['prix_total'])): ?>
                                <div style="text-align:right;">
                                    <div style="font-family:'Outfit',sans-serif;font-size:0.7rem;color:#7A7265;text-transform:uppercase;letter-spacing:0.06em;">Prix total</div>
                                    <div style="font-family:'Cormorant Garamond',serif;font-size:1.15rem;font-weight:700;color:#162B19;">
                                        <?= number_format($reservation['prix_total'], 2, ',', ' ') ?> €
                                    </div>
                                    <?php if (!empty($reservation['prix_unitaire_nuit'])): ?>
                                    <div style="font-family:'Outfit',sans-serif;font-size:0.7rem;color:#7A7265;">
                                        <?= number_format($reservation['prix_unitaire_nuit'], 2, ',', ' ') ?> €/nuit
                                    </div>
                                    <?php endif; ?>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Card footer -->
                        <div style="padding:1rem 1.5rem;background:#EDE8DC;border-top:1px solid #DDD8CD;display:flex;justify-content:space-between;align-items:center;gap:0.5rem;">
                            <a href="<?= base_url('chambre/' . $reservation['chamb_id']) ?>"
                               style="
                                    display:inline-flex;align-items:center;gap:5px;
                                    background:transparent;border:1.5px solid #DDD8CD;
                                    color:#7A7265;font-family:'Outfit',sans-serif;font-size:0.8rem;font-weight:500;
                                    padding:0.45rem 0.9rem;border-radius:6px;text-decoration:none;transition:all 0.3s;
                               "
                               onmouseover="this.style.background='#F8F5EE';this.style.color='#2C2416'"
                               onmouseout="this.style.background='transparent';this.style.color='#7A7265'">
                                <i class="bi bi-eye"></i>Voir la chambre
                            </a>
                            <?php if ($dateDebut > $maintenant): ?>
                            <button class="d-flex align-items-center gap-1"
                                    style="
                                        background:transparent;border:1.5px solid #f0b0b0;
                                        color:#c0392b;font-family:'Outfit',sans-serif;font-size:0.8rem;font-weight:500;
                                        padding:0.45rem 0.9rem;border-radius:6px;cursor:pointer;transition:all 0.3s;
                                    "
                                    data-bs-toggle="modal"
                                    data-bs-target="#annulerModal<?= $reservation['reser_id'] ?>"
                                    onmouseover="this.style.background='#fff0f0'"
                                    onmouseout="this.style.background='transparent'">
                                <i class="bi bi-x-circle"></i>Annuler
                            </button>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Cancellation modal -->
                <?php if ($dateDebut > $maintenant): ?>
                <div class="modal fade" id="annulerModal<?= $reservation['reser_id'] ?>" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-sm">
                        <div class="modal-content">
                            <div class="modal-header" style="background:linear-gradient(135deg,#5a1a1a,#8b2525);">
                                <h5 class="modal-title">
                                    <i class="bi bi-exclamation-triangle me-2"></i>Confirmer l'annulation
                                </h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body text-center py-3">
                                <p style="font-family:'Outfit',sans-serif;font-size:0.9rem;color:#5A5248;margin-bottom:0.5rem;">
                                    Voulez-vous annuler la réservation de la
                                </p>
                                <p style="font-family:'Cormorant Garamond',serif;font-size:1.2rem;font-weight:700;color:#162B19;margin-bottom:0.35rem;">
                                    Chambre <?= esc($reservation['chamb_numero']) ?>
                                </p>
                                <p style="font-family:'Outfit',sans-serif;font-size:0.82rem;color:#7A7265;margin:0;">
                                    <?= date('d/m/Y', strtotime($reservation['reser_dateDebut'])) ?> →
                                    <?= date('d/m/Y', strtotime($reservation['reser_dateFin'])) ?>
                                </p>
                            </div>
                            <div class="modal-footer justify-content-center">
                                <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">
                                    Conserver
                                </button>
                                <form method="post" action="<?= base_url('mes-reservations/annuler/' . $reservation['reser_id']) ?>">
                                    <?= csrf_field() ?>
                                    <button type="submit"
                                            style="
                                                display:inline-flex;align-items:center;gap:5px;
                                                background:#c0392b;border:none;
                                                color:#fff;font-family:'Outfit',sans-serif;font-size:0.82rem;font-weight:600;
                                                padding:0.45rem 1rem;border-radius:6px;cursor:pointer;
                                            ">
                                        <i class="bi bi-x-circle"></i>Oui, annuler
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>

            <?php endforeach; ?>
        </div>

        <!-- Statistics -->
        <?php
        $maintenant2 = new DateTime();
        $aVenir = 0;
        $totalNuits = 0;
        $totalDepense = 0;
        foreach ($reservations as $r) {
            $d1 = new DateTime($r['reser_dateDebut']);
            $d2 = new DateTime($r['reser_dateFin']);
            if ($d2 >= $maintenant2) $aVenir++;
            $totalNuits += $d1->diff($d2)->days;
            if (!empty($r['prix_total'])) $totalDepense += $r['prix_total'];
        }
        ?>
        <div class="row g-3 mt-4">
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-value"><?= count($reservations) ?></div>
                    <div class="stat-label">
                        Réservation<?= count($reservations) > 1 ? 's' : '' ?> totale<?= count($reservations) > 1 ? 's' : '' ?>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-value" style="color:#3A6341;"><?= $aVenir ?></div>
                    <div class="stat-label">À venir / en cours</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-value" style="color:#B8860B;"><?= $totalNuits ?></div>
                    <div class="stat-label">
                        Nuit<?= $totalNuits > 1 ? 's' : '' ?> réservée<?= $totalNuits > 1 ? 's' : '' ?>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-value" style="color:#6B4226;"><?= number_format($totalDepense, 2, ',', ' ') ?> €</div>
                    <div class="stat-label">Total dépensé</div>
                </div>
            </div>
        </div>

        <div class="text-center mt-4">
            <a href="<?= base_url('reservation') ?>"
               style="
                    display:inline-flex;align-items:center;gap:8px;
                    background:linear-gradient(135deg,#2A4A2E,#3A6341);
                    color:#fff;font-family:'Outfit',sans-serif;font-weight:600;font-size:0.9rem;
                    padding:0.85rem 2rem;border-radius:8px;text-decoration:none;
                    box-shadow:0 6px 20px rgba(22,43,25,0.2);transition:all 0.3s;
               "
               onmouseover="this.style.background='linear-gradient(135deg,#162B19,#2A4A2E)';this.style.color='#E8D8A8'"
               onmouseout="this.style.background='linear-gradient(135deg,#2A4A2E,#3A6341)';this.style.color='#fff'">
                <i class="bi bi-plus-circle"></i>
                Nouvelle réservation
            </a>
        </div>

        <?php endif; ?>
    </div>
</div>

<?= $this->endSection() ?>
