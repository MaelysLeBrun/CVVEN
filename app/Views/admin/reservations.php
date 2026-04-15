<?= $this->extend('hotel/layout') ?>
<?= $this->section('content') ?>

<!-- ── Page header ──────────────────────────────────────────── -->
<div class="page-header">
    <div class="container">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
            <div>
                <span class="section-label" style="color:#C9B07A;">Administration</span>
                <h1><i class="bi bi-calendar-check me-2"></i>Gestion des réservations</h1>
                <p class="lead">Consultez et supprimez toutes les réservations</p>
            </div>
            <a href="<?= base_url('admin/users') ?>"
               style="
                    display:inline-flex;align-items:center;gap:8px;
                    background:rgba(255,255,255,0.1);
                    border:1.5px solid rgba(201,176,122,0.4);
                    color:rgba(255,255,255,0.88);font-family:'Outfit',sans-serif;font-weight:500;
                    font-size:0.875rem;padding:0.6rem 1.25rem;border-radius:6px;text-decoration:none;
                    transition:all 0.3s;
               "
               onmouseover="this.style.background='rgba(201,176,122,0.15)';this.style.borderColor='rgba(201,176,122,0.7)'"
               onmouseout="this.style.background='rgba(255,255,255,0.1)';this.style.borderColor='rgba(201,176,122,0.4)'">
                <i class="bi bi-people"></i>Utilisateurs
            </a>
        </div>
    </div>
</div>

<!-- ── Content ───────────────────────────────────────────────── -->
<div style="background-color:#EDE8DC;padding:3rem 0;min-height:60vh;">
    <div class="container">

        <!-- Stats rapides -->
        <?php
        $now    = new DateTime();
        $aVenir = 0; $enCours = 0; $passees = 0;
        foreach ($reservations as $r) {
            $d1 = new DateTime($r['reser_dateDebut']);
            $d2 = new DateTime($r['reser_dateFin']);
            if ($now > $d2)               $passees++;
            elseif ($now >= $d1)          $enCours++;
            else                          $aVenir++;
        }
        ?>
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <div style="background:#F8F5EE;border:1px solid #DDD8CD;border-radius:12px;padding:1.25rem 1.5rem;display:flex;align-items:center;gap:1rem;box-shadow:0 2px 8px rgba(22,43,25,0.06);">
                    <div style="width:44px;height:44px;background:rgba(201,176,122,0.18);border:1px solid rgba(201,176,122,0.4);border-radius:10px;display:flex;align-items:center;justify-content:center;color:#6B4226;font-size:1.1rem;flex-shrink:0;">
                        <i class="bi bi-calendar-event"></i>
                    </div>
                    <div>
                        <div style="font-family:'Cormorant Garamond',serif;font-size:1.8rem;font-weight:700;color:#162B19;line-height:1;"><?= $aVenir ?></div>
                        <div style="font-family:'Outfit',sans-serif;font-size:0.75rem;color:#7A7265;text-transform:uppercase;letter-spacing:0.06em;">À venir</div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div style="background:#F8F5EE;border:1px solid #DDD8CD;border-radius:12px;padding:1.25rem 1.5rem;display:flex;align-items:center;gap:1rem;box-shadow:0 2px 8px rgba(22,43,25,0.06);">
                    <div style="width:44px;height:44px;background:rgba(78,138,90,0.15);border:1px solid rgba(78,138,90,0.3);border-radius:10px;display:flex;align-items:center;justify-content:center;color:#2A4A2E;font-size:1.1rem;flex-shrink:0;">
                        <i class="bi bi-house-door"></i>
                    </div>
                    <div>
                        <div style="font-family:'Cormorant Garamond',serif;font-size:1.8rem;font-weight:700;color:#162B19;line-height:1;"><?= $enCours ?></div>
                        <div style="font-family:'Outfit',sans-serif;font-size:0.75rem;color:#7A7265;text-transform:uppercase;letter-spacing:0.06em;">En cours</div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div style="background:#F8F5EE;border:1px solid #DDD8CD;border-radius:12px;padding:1.25rem 1.5rem;display:flex;align-items:center;gap:1rem;box-shadow:0 2px 8px rgba(22,43,25,0.06);">
                    <div style="width:44px;height:44px;background:rgba(122,114,101,0.1);border:1px solid #DDD8CD;border-radius:10px;display:flex;align-items:center;justify-content:center;color:#7A7265;font-size:1.1rem;flex-shrink:0;">
                        <i class="bi bi-check-circle"></i>
                    </div>
                    <div>
                        <div style="font-family:'Cormorant Garamond',serif;font-size:1.8rem;font-weight:700;color:#162B19;line-height:1;"><?= $passees ?></div>
                        <div style="font-family:'Outfit',sans-serif;font-size:0.75rem;color:#7A7265;text-transform:uppercase;letter-spacing:0.06em;">Terminées</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tableau -->
        <div style="background:#F8F5EE;border:1px solid #DDD8CD;border-radius:14px;overflow:hidden;box-shadow:0 2px 8px rgba(22,43,25,0.08);">

            <!-- En-tête -->
            <div style="background:linear-gradient(135deg,#162B19,#2A4A2E);">
                <div style="display:grid;grid-template-columns:60px 1.4fr 120px 1fr 130px 130px 110px 110px 90px;gap:0;align-items:center;padding:0.875rem 1.5rem;">
                    <div style="font-family:'Outfit',sans-serif;font-size:0.68rem;font-weight:600;color:rgba(201,176,122,0.8);text-transform:uppercase;letter-spacing:0.1em;">#</div>
                    <div style="font-family:'Outfit',sans-serif;font-size:0.68rem;font-weight:600;color:rgba(201,176,122,0.8);text-transform:uppercase;letter-spacing:0.1em;">Utilisateur</div>
                    <div style="font-family:'Outfit',sans-serif;font-size:0.68rem;font-weight:600;color:rgba(201,176,122,0.8);text-transform:uppercase;letter-spacing:0.1em;">Chambre</div>
                    <div style="font-family:'Outfit',sans-serif;font-size:0.68rem;font-weight:600;color:rgba(201,176,122,0.8);text-transform:uppercase;letter-spacing:0.1em;">Type</div>
                    <div style="font-family:'Outfit',sans-serif;font-size:0.68rem;font-weight:600;color:rgba(201,176,122,0.8);text-transform:uppercase;letter-spacing:0.1em;">Arrivée</div>
                    <div style="font-family:'Outfit',sans-serif;font-size:0.68rem;font-weight:600;color:rgba(201,176,122,0.8);text-transform:uppercase;letter-spacing:0.1em;">Départ</div>
                    <div style="font-family:'Outfit',sans-serif;font-size:0.68rem;font-weight:600;color:rgba(201,176,122,0.8);text-transform:uppercase;letter-spacing:0.1em;">Prix total</div>
                    <div style="font-family:'Outfit',sans-serif;font-size:0.68rem;font-weight:600;color:rgba(201,176,122,0.8);text-transform:uppercase;letter-spacing:0.1em;">Statut</div>
                    <div style="font-family:'Outfit',sans-serif;font-size:0.68rem;font-weight:600;color:rgba(201,176,122,0.8);text-transform:uppercase;letter-spacing:0.1em;text-align:center;">Actions</div>
                </div>
            </div>

            <!-- Lignes -->
            <?php foreach ($reservations as $i => $r):
                $d1       = new DateTime($r['reser_dateDebut']);
                $d2       = new DateTime($r['reser_dateFin']);
                $nuits    = $d1->diff($d2)->days;
                $passee   = ($now > $d2);
                $enCours2 = (!$passee && $now >= $d1);
            ?>
            <div style="
                display:grid;
                grid-template-columns:60px 1.4fr 120px 1fr 130px 130px 110px 110px 90px;
                gap:0;align-items:center;
                padding:1rem 1.5rem;
                background:<?= $i % 2 === 0 ? '#F8F5EE' : '#FAF8F3' ?>;
                border-bottom:1px solid #EDE8DC;
                transition:background 0.2s;
            "
            onmouseover="this.style.background='#EDE8DC'"
            onmouseout="this.style.background='<?= $i % 2 === 0 ? '#F8F5EE' : '#FAF8F3' ?>'">

                <!-- ID -->
                <div style="font-family:'Outfit',sans-serif;font-size:0.75rem;color:#7A7265;">#<?= $r['reser_id'] ?></div>

                <!-- Utilisateur -->
                <div>
                    <div style="font-family:'Outfit',sans-serif;font-size:0.875rem;font-weight:500;color:#2C2416;">
                        <?= esc($r['user_prenom'] . ' ' . $r['user_nom']) ?>
                    </div>
                    <div style="font-family:'Outfit',sans-serif;font-size:0.75rem;color:#7A7265;">
                        <?= esc($r['user_login']) ?>
                    </div>
                </div>

                <!-- Chambre -->
                <div>
                    <div style="font-family:'Cormorant Garamond',serif;font-size:1rem;font-weight:600;color:#162B19;">
                        N°<?= esc($r['chamb_numero']) ?>
                    </div>
                    <div style="font-family:'Outfit',sans-serif;font-size:0.72rem;color:#7A7265;">
                        <?= esc($r['chamb_emplacement']) ?>
                    </div>
                </div>

                <!-- Type -->
                <div style="font-family:'Outfit',sans-serif;font-size:0.82rem;color:#2C2416;">
                    <?= esc($r['type_libelle']) ?>
                </div>

                <!-- Arrivée -->
                <div>
                    <div style="font-family:'Cormorant Garamond',serif;font-size:0.95rem;font-weight:600;color:#162B19;">
                        <?= date('d/m/Y', strtotime($r['reser_dateDebut'])) ?>
                    </div>
                </div>

                <!-- Départ -->
                <div>
                    <div style="font-family:'Cormorant Garamond',serif;font-size:0.95rem;font-weight:600;color:#162B19;">
                        <?= date('d/m/Y', strtotime($r['reser_dateFin'])) ?>
                    </div>
                    <div style="font-family:'Outfit',sans-serif;font-size:0.7rem;color:#7A7265;">
                        <?= $nuits ?> nuit<?= $nuits > 1 ? 's' : '' ?>
                    </div>
                </div>

                <!-- Prix total -->
                <div>
                    <?php if (!empty($r['prix_total'])): ?>
                        <div style="font-family:'Cormorant Garamond',serif;font-size:0.95rem;font-weight:600;color:#162B19;">
                            <?= number_format($r['prix_total'], 2, ',', ' ') ?> €
                        </div>
                    <?php else: ?>
                        <div style="font-family:'Outfit',sans-serif;font-size:0.75rem;color:#DDD8CD;">—</div>
                    <?php endif; ?>
                </div>

                <!-- Statut -->
                <div>
                    <?php if ($passee): ?>
                        <span class="badge badge-terminee">
                            <i class="bi bi-check-circle me-1"></i>Terminée
                        </span>
                    <?php elseif ($enCours2): ?>
                        <span class="badge badge-encours">
                            <i class="bi bi-house-door me-1"></i>En cours
                        </span>
                    <?php else: ?>
                        <span class="badge badge-avenir">
                            <i class="bi bi-calendar-event me-1"></i>À venir
                        </span>
                    <?php endif; ?>
                </div>

                <!-- Actions -->
                <div style="display:flex;align-items:center;justify-content:center;gap:0.4rem;">
                    <a href="<?= base_url('admin/reservations/edit/' . $r['reser_id']) ?>"
                       style="
                            display:inline-flex;align-items:center;justify-content:center;
                            width:32px;height:32px;border-radius:6px;
                            background:rgba(42,74,46,0.08);border:1px solid rgba(42,74,46,0.2);
                            color:#2A4A2E;transition:all 0.25s;text-decoration:none;
                       "
                       title="Modifier"
                       onmouseover="this.style.background='#2A4A2E';this.style.color='#E8D8A8'"
                       onmouseout="this.style.background='rgba(42,74,46,0.08)';this.style.color='#2A4A2E'">
                        <i class="bi bi-pencil" style="font-size:0.8rem;"></i>
                    </a>
                    <form method="post"
                          action="<?= base_url('admin/reservations/delete/' . $r['reser_id']) ?>"
                          class="d-inline"
                          onsubmit="return confirm('Supprimer la réservation #<?= $r['reser_id'] ?> ?')">
                        <?= csrf_field() ?>
                        <button type="submit"
                                style="
                                    display:inline-flex;align-items:center;justify-content:center;
                                    width:32px;height:32px;border-radius:6px;
                                    background:rgba(192,57,43,0.08);border:1px solid rgba(192,57,43,0.2);
                                    color:#c0392b;transition:all 0.25s;cursor:pointer;
                                "
                                title="Supprimer"
                                onmouseover="this.style.background='#c0392b';this.style.color='#fff'"
                                onmouseout="this.style.background='rgba(192,57,43,0.08)';this.style.color='#c0392b'">
                            <i class="bi bi-trash" style="font-size:0.8rem;"></i>
                        </button>
                    </form>
                </div>
            </div>
            <?php endforeach; ?>

            <?php if (empty($reservations)): ?>
            <div style="padding:4rem;text-align:center;">
                <i class="bi bi-calendar-x" style="font-size:2.5rem;color:#DDD8CD;display:block;margin-bottom:1rem;"></i>
                <p style="font-family:'Outfit',sans-serif;color:#7A7265;margin:0;">Aucune réservation trouvée.</p>
            </div>
            <?php endif; ?>
        </div>

    </div>
</div>

<?= $this->endSection() ?>
