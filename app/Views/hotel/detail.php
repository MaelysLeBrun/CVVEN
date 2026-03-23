<?= $this->extend('hotel/layout') ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-md-5">
        <!-- Carrousel d'images de la chambre -->
        <?php
        // Préparer les images pour le carrousel
        $images = [];
        $extensions = ['jpg', 'jpeg', 'png', 'webp'];
        
        // Chercher l'image principale du type
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
        
        // Chercher l'image détails
        foreach ($extensions as $ext) {
            $detailPath = FCPATH . 'assets/images/chambres/type' . $chambre['type_id'] . 'details.' . $ext;
            if (file_exists($detailPath)) {
                $images[] = [
                    'url' => base_url('assets/images/chambres/type' . $chambre['type_id'] . 'details.' . $ext),
                    'alt' => $chambre['type_libelle'] . ' - Détails'
                ];
                break;
            }
        }
        
        // Si aucune image trouvée, utiliser un placeholder
        if (empty($images)) {
            $images[] = [
                'url' => 'https://placehold.co/600x400/0d6efd/white?text=Chambre+' . $chambre['chamb_numero'],
                'alt' => 'Chambre ' . $chambre['chamb_numero']
            ];
        }
        ?>
        
        <?php if (count($images) > 1): ?>
            <!-- Carrousel avec plusieurs images -->
            <div id="chambreCarousel" class="carousel slide mb-3" data-bs-ride="carousel">
                <div class="carousel-indicators">
                    <?php foreach ($images as $index => $img): ?>
                        <button type="button" data-bs-target="#chambreCarousel" data-bs-slide-to="<?= $index ?>" 
                                class="<?= $index === 0 ? 'active' : '' ?>" 
                                aria-current="<?= $index === 0 ? 'true' : 'false' ?>"></button>
                    <?php endforeach; ?>
                </div>
                <div class="carousel-inner rounded shadow">
                    <?php foreach ($images as $index => $img): ?>
                        <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                            <img src="<?= $img['url'] ?>" 
                                 class="d-block w-100" 
                                 alt="<?= esc($img['alt']) ?>"
                                 style="height: 400px; object-fit: cover;">
                        </div>
                    <?php endforeach; ?>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#chambreCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Précédent</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#chambreCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Suivant</span>
                </button>
            </div>
        <?php else: ?>
            <!-- Image unique -->
            <img src="<?= $images[0]['url'] ?>" 
                 class="img-fluid rounded shadow mb-3" 
                 alt="<?= esc($images[0]['alt']) ?>"
                 style="height: 400px; width: 100%; object-fit: cover;">
        <?php endif; ?>
        
        <h4><?= esc($chambre['type_libelle']) ?> (N°<?= esc($chambre['chamb_numero']) ?>)</h4>
        <p><?= esc($chambre['type_desc']) ?></p>
        <?php if($chambre['chamb_remarque']): ?>
            <div class="alert alert-info"><?= esc($chambre['chamb_remarque']) ?></div>
        <?php endif; ?>
    </div>

    <div class="col-md-7">
        <div class="card border-0 shadow">
            <div class="card-header bg-primary text-white py-3">
                <h5 class="mb-0"><i class="bi bi-calendar-plus"></i> Réserver cette chambre</h5>
            </div>
            <div class="card-body p-4">
                <!-- Récapitulatif de la chambre -->
                <div class="mb-4 p-3 rounded" style="background: rgba(47,82,51,0.07); border-left: 4px solid var(--primary-color);">
                    <p class="mb-1"><strong>Type :</strong> <?= esc($chambre['type_libelle']) ?></p>
                    <p class="mb-1"><strong>Chambre N° :</strong> <?= esc($chambre['chamb_numero']) ?></p>
                    <p class="mb-0"><strong>Emplacement :</strong> <?= esc($chambre['chamb_emplacement']) ?></p>
                </div>

                <?php if ($dateDebut && $dateFin): ?>
                    <div class="alert alert-success mb-4">
                        <i class="bi bi-calendar-check"></i>
                        <strong>Période sélectionnée :</strong>
                        Du <?= date('d/m/Y', strtotime($dateDebut)) ?> au <?= date('d/m/Y', strtotime($dateFin)) ?>
                    </div>
                <?php endif; ?>

                <p class="text-muted mb-4">
                    Vos informations personnelles seront pré-remplies automatiquement depuis votre compte.
                </p>

                <a href="<?= base_url('reservation?chamb_id=' . $chambre['chamb_id'] . ($dateDebut && $dateFin ? '&date_debut=' . $dateDebut . '&date_fin=' . $dateFin : '')) ?>"
                   class="btn btn-primary btn-lg w-100">
                    <i class="bi bi-arrow-right-circle"></i> Aller au formulaire de réservation
                </a>

                <a href="<?= base_url('/') ?>" class="btn btn-outline-secondary w-100 mt-2">
                    <i class="bi bi-arrow-left"></i> Voir d'autres chambres
                </a>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>