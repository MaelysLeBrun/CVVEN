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
        <div class="card">
            <div class="card-header bg-success text-white">Réserver maintenant</div>
            <div class="card-body">
                
                <?php if (session()->has('error')): ?>
                    <div class="alert alert-danger"><?= session('error') ?></div>
                <?php endif; ?>
                <?php if (session()->has('errors')): ?>
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                        <?php foreach (session('errors') as $error): ?>
                            <li><?= esc($error) ?></li>
                        <?php endforeach ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <form action="<?= base_url('reserver') ?>" method="post">
                    <?= csrf_field() ?>
                    <input type="hidden" name="chamb_id" value="<?= esc($chambre['chamb_id']) ?>">

                    <h5 class="text-primary mt-2">Vos Coordonnées</h5>
                    <div class="row">
                        <div class="col-6 mb-3">
                            <label class="form-label">Nom</label>
                            <input type="text" name="user_nom" class="form-control" required value="<?= old('user_nom') ?>">
                        </div>
                        <div class="col-6 mb-3">
                            <label class="form-label">Prénom</label>
                            <input type="text" name="user_prenom" class="form-control" required value="<?= old('user_prenom') ?>">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="user_mail" class="form-control" required value="<?= old('user_mail') ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Téléphone</label>
                        <input type="text" name="user_telephone" class="form-control" required value="<?= old('user_telephone') ?>">
                    </div>

                    <h5 class="text-primary mt-4">Dates du séjour</h5>
                    <div class="row">
                        <div class="col-6 mb-3">
                            <label class="form-label">Arrivée</label>
                            <input type="date" name="date_debut" class="form-control" required value="<?= old('date_debut') ?>">
                        </div>
                        <div class="col-6 mb-3">
                            <label class="form-label">Départ</label>
                            <input type="date" name="date_fin" class="form-control" required value="<?= old('date_fin') ?>">
                        </div>
                    </div>

                    <button type="submit" class="btn btn-success w-100 btn-lg mt-3">Confirmer</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>