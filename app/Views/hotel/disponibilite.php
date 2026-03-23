<?= $this->extend('hotel/layout') ?>
<?= $this->section('content') ?>

<!-- Page header -->
<div class="page-header">
    <div class="container">
        <a href="<?= base_url('/') ?>"
           style="display:inline-flex;align-items:center;gap:6px;color:rgba(255,255,255,0.6);font-size:0.85rem;font-family:'Outfit',sans-serif;text-decoration:none;margin-bottom:1rem;transition:color 0.3s;"
           onmouseover="this.style.color='#E8D8A8'"
           onmouseout="this.style.color='rgba(255,255,255,0.6)'">
            <i class="bi bi-arrow-left"></i> Retour à l'accueil
        </a>
        <div style="display:flex;align-items:flex-start;justify-content:space-between;flex-wrap:wrap;gap:1rem;">
            <div>
                <h1><?= esc($type['type_libelle']) ?></h1>
                <p class="lead"><?= esc($type['type_desc']) ?></p>
            </div>
            <div>
                <button type="button"
                        class="btn btn-outline-light btn-sm"
                        data-bs-toggle="modal" data-bs-target="#changeDateModal">
                    <i class="bi bi-pencil me-1"></i>Modifier les dates
                </button>
            </div>
        </div>
    </div>
</div>

<div style="background-color:#EDE8DC;padding:3rem 0;min-height:60vh;">
    <div class="container">

        <!-- Search period banner -->
        <?php if ($dateDebut && $dateFin): ?>
        <div style="
            background:#F8F5EE;border:1px solid #DDD8CD;border-left:4px solid #C9B07A;
            border-radius:10px;padding:1.25rem 1.5rem;
            display:flex;align-items:center;justify-content:space-between;
            flex-wrap:wrap;gap:1rem;margin-bottom:2rem;
        ">
            <div style="display:flex;align-items:center;gap:12px;">
                <div style="width:40px;height:40px;background:rgba(201,176,122,0.15);border-radius:8px;display:flex;align-items:center;justify-content:center;color:#C9B07A;font-size:1.1rem;">
                    <i class="bi bi-calendar-range"></i>
                </div>
                <div>
                    <div style="font-family:'Outfit',sans-serif;font-size:0.72rem;font-weight:600;letter-spacing:0.1em;text-transform:uppercase;color:#7A7265;">
                        Période de recherche
                    </div>
                    <div style="font-family:'Cormorant Garamond',serif;font-size:1.1rem;font-weight:600;color:#162B19;">
                        Du <?= date('d/m/Y', strtotime($dateDebut)) ?> au <?= date('d/m/Y', strtotime($dateFin)) ?>
                    </div>
                </div>
            </div>
            <button type="button"
                    class="btn btn-outline-secondary btn-sm"
                    data-bs-toggle="modal" data-bs-target="#changeDateModal">
                <i class="bi bi-pencil me-1"></i>Modifier
            </button>
        </div>
        <?php endif; ?>

        <!-- Other types comparison -->
        <?php if (!empty($allTypes) && count($allTypes) > 1): ?>
        <div style="background:#F8F5EE;border:1px solid #DDD8CD;border-radius:12px;padding:1.5rem;margin-bottom:2rem;">
            <div style="font-family:'Outfit',sans-serif;font-size:0.72rem;font-weight:600;letter-spacing:0.1em;text-transform:uppercase;color:#7A7265;margin-bottom:0.75rem;">
                <i class="bi bi-arrow-left-right me-2"></i>Comparer avec d'autres types
            </div>
            <div style="display:flex;flex-wrap:wrap;gap:0.5rem;">
                <?php foreach ($allTypes as $t): ?>
                    <?php if ($t['type_id'] != $type['type_id']): ?>
                        <a href="<?= base_url('disponibilite/' . $t['type_id']) ?><?= $dateDebut && $dateFin ? '?date_debut=' . $dateDebut . '&date_fin=' . $dateFin : '' ?>"
                           style="
                                display:inline-flex;align-items:center;gap:6px;
                                background:transparent;border:1.5px solid #DDD8CD;
                                color:#2A4A2E;font-family:'Outfit',sans-serif;font-size:0.85rem;font-weight:500;
                                padding:0.45rem 1rem;border-radius:50px;text-decoration:none;
                                transition:all 0.3s;
                           "
                           onmouseover="this.style.background='#2A4A2E';this.style.color='#E8D8A8';this.style.borderColor='#2A4A2E'"
                           onmouseout="this.style.background='transparent';this.style.color='#2A4A2E';this.style.borderColor='#DDD8CD'">
                            <i class="bi bi-house"></i>
                            <?= esc($t['type_libelle']) ?>
                        </a>
                    <?php else: ?>
                        <span style="
                            display:inline-flex;align-items:center;gap:6px;
                            background:#2A4A2E;border:1.5px solid #2A4A2E;
                            color:#E8D8A8;font-family:'Outfit',sans-serif;font-size:0.85rem;font-weight:500;
                            padding:0.45rem 1rem;border-radius:50px;
                        ">
                            <i class="bi bi-check-circle-fill"></i>
                            <?= esc($t['type_libelle']) ?>
                        </span>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>

        <!-- Availability summary -->
        <div style="
            background:<?= $nombreDisponible > 0 ? 'linear-gradient(135deg,#2A4A2E,#3A6341)' : 'linear-gradient(135deg,#5a1a1a,#8b2525)' ?>;
            border-radius:14px;padding:2rem 2.5rem;
            display:flex;align-items:center;justify-content:space-between;
            flex-wrap:wrap;gap:1.5rem;
            margin-bottom:2.5rem;
            box-shadow:0 8px 28px rgba(22,43,25,0.2);
        ">
            <div>
                <div style="font-family:'Outfit',sans-serif;font-size:0.72rem;font-weight:600;letter-spacing:0.14em;text-transform:uppercase;color:rgba(255,255,255,0.55);margin-bottom:0.3rem;">
                    Résultat de la recherche
                </div>
                <div style="font-family:'Cormorant Garamond',serif;font-size:2rem;font-weight:700;color:#F8F5EE;line-height:1;">
                    <?= $nombreDisponible ?>
                    <?= $nombreDisponible > 1 ? 'hébergements disponibles' : ($nombreDisponible === 1 ? 'hébergement disponible' : 'hébergement disponible') ?>
                </div>
                <div style="font-family:'Outfit',sans-serif;font-size:0.875rem;color:rgba(255,255,255,0.65);margin-top:0.35rem;">
                    <?= $nombreDisponible > 0
                        ? 'Des chambres sont disponibles pour votre séjour'
                        : 'Aucune chambre disponible pour cette période' ?>
                </div>
            </div>
            <div style="
                width:64px;height:64px;
                background:rgba(255,255,255,0.1);
                border-radius:50%;
                display:flex;align-items:center;justify-content:center;
                font-size:1.8rem;
                color:<?= $nombreDisponible > 0 ? '#E8D8A8' : '#ffaaaa' ?>;
            ">
                <i class="bi bi-<?= $nombreDisponible > 0 ? 'check-lg' : 'x-lg' ?>"></i>
            </div>
        </div>

        <!-- Available rooms grid -->
        <?php if ($nombreDisponible > 0): ?>
            <div style="margin-bottom:1.5rem;">
                <h2 style="font-family:'Cormorant Garamond',serif;font-size:1.75rem;font-weight:700;color:#162B19;margin-bottom:0.25rem;">
                    Hébergements disponibles
                </h2>
                <div style="width:40px;height:2px;background:linear-gradient(90deg,#C9B07A,#B8860B);border-radius:2px;margin-bottom:1.5rem;"></div>
            </div>

            <div class="row g-4">
                <?php foreach ($chambres as $chambre): ?>
                    <?php
                    $imagePath = '';
                    $extensions = ['jpg', 'jpeg', 'png', 'webp'];
                    foreach ($extensions as $ext) {
                        $checkPath = FCPATH . 'assets/images/chambres/type' . $chambre['type_id'] . '.' . $ext;
                        if (file_exists($checkPath)) {
                            $imagePath = base_url('assets/images/chambres/type' . $chambre['type_id'] . '.' . $ext);
                            break;
                        }
                    }
                    if (empty($imagePath)) {
                        $imagePath = 'https://placehold.co/640x420/2A4A2E/E8D8A8?text=' . urlencode($chambre['type_libelle']);
                    }
                    ?>
                    <div class="col-md-6 col-lg-4">
                        <div style="
                            background:#F8F5EE;border:1px solid #DDD8CD;border-radius:14px;
                            overflow:hidden;
                            box-shadow:0 2px 8px rgba(22,43,25,0.08);
                            display:flex;flex-direction:column;height:100%;
                            transition:all 0.35s;
                        "
                        onmouseover="this.style.transform='translateY(-6px)';this.style.boxShadow='0 16px 40px rgba(22,43,25,0.16)'"
                        onmouseout="this.style.transform='';this.style.boxShadow='0 2px 8px rgba(22,43,25,0.08)'">

                            <!-- Image -->
                            <div style="position:relative;overflow:hidden;height:220px;">
                                <img src="<?= $imagePath ?>"
                                     alt="Chambre <?= esc($chambre['chamb_numero']) ?>"
                                     style="width:100%;height:100%;object-fit:cover;transition:transform 0.5s;">
                                <div style="position:absolute;top:12px;right:12px;">
                                    <span style="
                                        background:rgba(78,138,90,0.9);backdrop-filter:blur(6px);
                                        color:#fff;font-family:'Outfit',sans-serif;
                                        font-size:0.7rem;font-weight:600;letter-spacing:0.08em;
                                        padding:0.3rem 0.7rem;border-radius:50px;
                                    ">
                                        <i class="bi bi-check-circle me-1"></i>Disponible
                                    </span>
                                </div>
                            </div>

                            <!-- Content -->
                            <div style="padding:1.25rem 1.5rem 1.5rem;display:flex;flex-direction:column;flex:1;">
                                <h5 style="font-family:'Cormorant Garamond',serif;font-size:1.3rem;font-weight:700;color:#162B19;margin-bottom:0.5rem;">
                                    Chambre N°<?= esc($chambre['chamb_numero']) ?>
                                </h5>
                                <div style="display:flex;align-items:center;gap:6px;margin-bottom:0.75rem;">
                                    <i class="bi bi-geo-alt" style="color:#C9B07A;font-size:0.8rem;"></i>
                                    <span style="font-family:'Outfit',sans-serif;font-size:0.8rem;color:#7A7265;">
                                        <?= esc($chambre['chamb_emplacement']) ?>
                                    </span>
                                </div>
                                <p style="font-family:'Outfit',sans-serif;font-size:0.84rem;color:#7A7265;line-height:1.65;flex:1;margin-bottom:1.25rem;font-weight:300;">
                                    <?= esc($chambre['type_desc']) ?>
                                </p>
                                <a href="<?= base_url('reservation?chamb_id=' . $chambre['chamb_id'] . ($dateDebut && $dateFin ? '&date_debut=' . $dateDebut . '&date_fin=' . $dateFin : '')) ?>"
                                   style="
                                        display:flex;align-items:center;justify-content:center;gap:6px;
                                        width:100%;background:linear-gradient(135deg,#2A4A2E,#3A6341);
                                        color:#fff;font-family:'Outfit',sans-serif;font-weight:500;font-size:0.875rem;
                                        letter-spacing:0.04em;padding:0.7rem;border-radius:8px;
                                        text-decoration:none;transition:all 0.3s;
                                   "
                                   onmouseover="this.style.background='linear-gradient(135deg,#162B19,#2A4A2E)';this.style.color='#E8D8A8'"
                                   onmouseout="this.style.background='linear-gradient(135deg,#2A4A2E,#3A6341)';this.style.color='#fff'">
                                    <i class="bi bi-calendar-plus"></i>
                                    Réserver cette chambre
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

        <?php else: ?>
            <!-- No availability -->
            <div style="background:#F8F5EE;border:1px solid #DDD8CD;border-radius:14px;padding:3.5rem;text-align:center;box-shadow:0 2px 8px rgba(22,43,25,0.06);">
                <div style="width:72px;height:72px;background:#EDE8DC;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:1.8rem;color:#DDD8CD;margin:0 auto 1.5rem;">
                    <i class="bi bi-calendar-x"></i>
                </div>
                <h4 style="font-family:'Cormorant Garamond',serif;font-size:1.6rem;font-weight:700;color:#162B19;margin-bottom:0.75rem;">
                    Aucun hébergement disponible
                </h4>
                <p style="font-family:'Outfit',sans-serif;font-size:0.9rem;color:#7A7265;line-height:1.75;max-width:420px;margin:0 auto 2rem;">
                    Aucune chambre de ce type n'est disponible pour la période sélectionnée.
                    Essayez de modifier vos dates ou de consulter d'autres types d'hébergements.
                </p>
                <div style="display:flex;justify-content:center;gap:0.75rem;flex-wrap:wrap;">
                    <button type="button"
                            data-bs-toggle="modal" data-bs-target="#changeDateModal"
                            style="
                                display:inline-flex;align-items:center;gap:6px;
                                background:linear-gradient(135deg,#2A4A2E,#3A6341);border:none;
                                color:#fff;font-family:'Outfit',sans-serif;font-weight:500;font-size:0.875rem;
                                padding:0.75rem 1.5rem;border-radius:8px;cursor:pointer;transition:all 0.3s;
                            "
                            onmouseover="this.style.background='linear-gradient(135deg,#162B19,#2A4A2E)'"
                            onmouseout="this.style.background='linear-gradient(135deg,#2A4A2E,#3A6341)'">
                        <i class="bi bi-pencil"></i>Modifier les dates
                    </button>
                    <a href="<?= base_url('/') ?>"
                       style="
                            display:inline-flex;align-items:center;gap:6px;
                            background:transparent;border:1.5px solid #DDD8CD;
                            color:#7A7265;font-family:'Outfit',sans-serif;font-weight:500;font-size:0.875rem;
                            padding:0.75rem 1.5rem;border-radius:8px;text-decoration:none;transition:all 0.3s;
                       "
                       onmouseover="this.style.background='#EDE8DC'"
                       onmouseout="this.style.background='transparent'">
                        <i class="bi bi-grid-3x3-gap"></i>Voir tous les types
                    </a>
                </div>
            </div>
        <?php endif; ?>

    </div>
</div>

<!-- Modal — Modifier les dates -->
<div class="modal fade" id="changeDateModal" tabindex="-1" aria-labelledby="changeDateModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="changeDateModalLabel">
                    <i class="bi bi-pencil me-2"></i>Modifier les dates
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?= base_url('disponibilite/' . $type['type_id']) ?>" method="get">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="date_debut" class="form-label">Date d'arrivée</label>
                        <input type="date" class="form-control" id="date_debut" name="date_debut"
                               value="<?= $dateDebut ?>" min="<?= date('Y-m-d') ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="date_fin" class="form-label">Date de départ</label>
                        <input type="date" class="form-control" id="date_fin" name="date_fin"
                               value="<?= $dateFin ?>" min="<?= date('Y-m-d', strtotime('+1 day')) ?>" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-search me-1"></i>Rechercher
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
