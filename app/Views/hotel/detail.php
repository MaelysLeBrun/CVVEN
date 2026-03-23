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
        <h1><?= esc($chambre['type_libelle']) ?></h1>
        <p class="lead">Chambre N°<?= esc($chambre['chamb_numero']) ?> — <?= esc($chambre['chamb_emplacement']) ?></p>
    </div>
</div>

<div style="background-color:#EDE8DC;padding:3rem 0;min-height:60vh;">
    <div class="container">
        <div class="row g-5 align-items-start">

            <!-- Images -->
            <div class="col-lg-6">
                <?php
                $images = [];
                $extensions = ['jpg', 'jpeg', 'png', 'webp'];

                foreach ($extensions as $ext) {
                    $mainPath = FCPATH . 'assets/images/chambres/type' . $chambre['type_id'] . '.' . $ext;
                    if (file_exists($mainPath)) {
                        $images[] = [
                            'url' => base_url('assets/images/chambres/type' . $chambre['type_id'] . '.' . $ext),
                            'alt' => $chambre['type_libelle']
                        ];
                        break;
                    }
                }

                foreach ($extensions as $ext) {
                    $detailPath = FCPATH . 'assets/images/chambres/type' . $chambre['type_id'] . 'details.' . $ext;
                    if (file_exists($detailPath)) {
                        $images[] = [
                            'url' => base_url('assets/images/chambres/type' . $chambre['type_id'] . 'details.' . $ext),
                            'alt' => $chambre['type_libelle'] . ' — Détails'
                        ];
                        break;
                    }
                }

                if (empty($images)) {
                    $images[] = [
                        'url' => 'https://placehold.co/700x480/2A4A2E/E8D8A8?text=' . urlencode($chambre['type_libelle']),
                        'alt' => 'Chambre ' . $chambre['chamb_numero']
                    ];
                }
                ?>

                <?php if (count($images) > 1): ?>
                <div id="chambreCarousel" class="carousel slide" data-bs-ride="carousel" style="border-radius:14px;overflow:hidden;box-shadow:0 12px 40px rgba(22,43,25,0.2);">
                    <div class="carousel-indicators">
                        <?php foreach ($images as $index => $img): ?>
                        <button type="button" data-bs-target="#chambreCarousel"
                                data-bs-slide-to="<?= $index ?>"
                                class="<?= $index === 0 ? 'active' : '' ?>"
                                style="width:8px;height:8px;border-radius:50%;background:#C9B07A;border:none;opacity:0.5;"
                                aria-current="<?= $index === 0 ? 'true' : 'false' ?>"></button>
                        <?php endforeach; ?>
                    </div>
                    <div class="carousel-inner">
                        <?php foreach ($images as $index => $img): ?>
                        <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                            <img src="<?= $img['url'] ?>"
                                 class="d-block w-100"
                                 alt="<?= esc($img['alt']) ?>"
                                 style="height:420px;object-fit:cover;">
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#chambreCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon"></span>
                        <span class="visually-hidden">Précédent</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#chambreCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon"></span>
                        <span class="visually-hidden">Suivant</span>
                    </button>
                </div>
                <?php else: ?>
                <div style="border-radius:14px;overflow:hidden;box-shadow:0 12px 40px rgba(22,43,25,0.2);">
                    <img src="<?= $images[0]['url'] ?>"
                         alt="<?= esc($images[0]['alt']) ?>"
                         style="width:100%;height:420px;object-fit:cover;display:block;">
                </div>
                <?php endif; ?>

                <!-- Description under image -->
                <?php if ($chambre['chamb_remarque']): ?>
                <div class="alert alert-info mt-3" style="border-radius:10px;">
                    <i class="bi bi-star me-2"></i><?= esc($chambre['chamb_remarque']) ?>
                </div>
                <?php endif; ?>

                <div style="background:#F8F5EE;border:1px solid #DDD8CD;border-radius:12px;padding:1.5rem;margin-top:1rem;">
                    <h6 style="font-family:'Outfit',sans-serif;font-size:0.72rem;font-weight:600;letter-spacing:0.1em;text-transform:uppercase;color:#7A7265;margin-bottom:0.75rem;">
                        Description
                    </h6>
                    <p style="font-family:'Outfit',sans-serif;font-size:0.9rem;color:#5A5248;line-height:1.75;margin:0;">
                        <?= esc($chambre['type_desc']) ?>
                    </p>
                </div>
            </div>

            <!-- Booking card -->
            <div class="col-lg-6">
                <div style="position:sticky;top:24px;">
                    <div style="background:#F8F5EE;border:1px solid #DDD8CD;border-radius:16px;overflow:hidden;box-shadow:0 8px 28px rgba(22,43,25,0.12);">

                        <!-- Card header -->
                        <div style="background:linear-gradient(135deg,#162B19,#2A4A2E);padding:1.5rem 2rem;border-bottom:2px solid rgba(201,176,122,0.3);">
                            <div style="display:flex;align-items:center;gap:10px;">
                                <div style="width:38px;height:38px;background:rgba(201,176,122,0.2);border:1px solid rgba(201,176,122,0.4);border-radius:8px;display:flex;align-items:center;justify-content:center;color:#C9B07A;">
                                    <i class="bi bi-calendar-plus"></i>
                                </div>
                                <div>
                                    <div style="font-family:'Cormorant Garamond',serif;font-size:1.2rem;font-weight:600;color:#F8F5EE;">
                                        Réserver cet hébergement
                                    </div>
                                    <div style="font-family:'Outfit',sans-serif;font-size:0.75rem;color:rgba(255,255,255,0.5);letter-spacing:0.04em;">
                                        Confirmation immédiate
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div style="padding:2rem;">

                            <!-- Room details -->
                            <div style="background:#EDE8DC;border-radius:10px;padding:1.25rem;margin-bottom:1.5rem;">
                                <div style="font-family:'Outfit',sans-serif;font-size:0.72rem;font-weight:600;letter-spacing:0.1em;text-transform:uppercase;color:#7A7265;margin-bottom:0.75rem;">
                                    Récapitulatif
                                </div>
                                <div style="display:flex;flex-direction:column;gap:0.5rem;">
                                    <div style="display:flex;justify-content:space-between;font-size:0.875rem;">
                                        <span style="color:#7A7265;font-family:'Outfit',sans-serif;">Type</span>
                                        <span style="color:#2C2416;font-weight:500;font-family:'Outfit',sans-serif;"><?= esc($chambre['type_libelle']) ?></span>
                                    </div>
                                    <div style="display:flex;justify-content:space-between;font-size:0.875rem;">
                                        <span style="color:#7A7265;font-family:'Outfit',sans-serif;">Chambre N°</span>
                                        <span style="color:#2C2416;font-weight:500;font-family:'Outfit',sans-serif;"><?= esc($chambre['chamb_numero']) ?></span>
                                    </div>
                                    <div style="display:flex;justify-content:space-between;font-size:0.875rem;">
                                        <span style="color:#7A7265;font-family:'Outfit',sans-serif;">Emplacement</span>
                                        <span style="color:#2C2416;font-weight:500;font-family:'Outfit',sans-serif;"><?= esc($chambre['chamb_emplacement']) ?></span>
                                    </div>
                                </div>
                            </div>

                            <?php if ($dateDebut && $dateFin): ?>
                            <div class="alert alert-success mb-4">
                                <i class="bi bi-calendar-check me-2"></i>
                                <strong>Période sélectionnée :</strong><br>
                                <span style="font-size:0.875rem;">
                                    Du <?= date('d/m/Y', strtotime($dateDebut)) ?>
                                    au <?= date('d/m/Y', strtotime($dateFin)) ?>
                                </span>
                            </div>
                            <?php endif; ?>

                            <p style="font-family:'Outfit',sans-serif;font-size:0.84rem;color:#7A7265;margin-bottom:1.5rem;line-height:1.6;">
                                <i class="bi bi-person-check me-1" style="color:#C9B07A;"></i>
                                Vos informations personnelles seront pré-remplies depuis votre compte.
                            </p>

                            <a href="<?= base_url('reservation?chamb_id=' . $chambre['chamb_id'] . ($dateDebut && $dateFin ? '&date_debut=' . $dateDebut . '&date_fin=' . $dateFin : '')) ?>"
                               style="
                                    display:flex;align-items:center;justify-content:center;gap:8px;
                                    width:100%;
                                    background:linear-gradient(135deg,#2A4A2E,#3A6341);
                                    color:#fff;font-family:'Outfit',sans-serif;font-weight:600;
                                    font-size:0.95rem;letter-spacing:0.04em;
                                    padding:0.9rem;border-radius:8px;text-decoration:none;
                                    box-shadow:0 6px 20px rgba(22,43,25,0.25);
                                    transition:all 0.3s;margin-bottom:0.75rem;
                               "
                               onmouseover="this.style.background='linear-gradient(135deg,#162B19,#2A4A2E)';this.style.color='#E8D8A8';this.style.transform='translateY(-2px)'"
                               onmouseout="this.style.background='linear-gradient(135deg,#2A4A2E,#3A6341)';this.style.color='#fff';this.style.transform=''">
                                <i class="bi bi-arrow-right-circle"></i>
                                Aller au formulaire de réservation
                            </a>

                            <a href="<?= base_url('/') ?>"
                               style="
                                    display:flex;align-items:center;justify-content:center;gap:8px;
                                    width:100%;
                                    background:transparent;border:1.5px solid #DDD8CD;
                                    color:#7A7265;font-family:'Outfit',sans-serif;font-weight:500;
                                    font-size:0.875rem;
                                    padding:0.75rem;border-radius:8px;text-decoration:none;
                                    transition:all 0.3s;
                               "
                               onmouseover="this.style.background='#EDE8DC';this.style.color='#2C2416'"
                               onmouseout="this.style.background='transparent';this.style.color='#7A7265'">
                                <i class="bi bi-arrow-left"></i>
                                Voir d'autres hébergements
                            </a>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<?= $this->endSection() ?>
