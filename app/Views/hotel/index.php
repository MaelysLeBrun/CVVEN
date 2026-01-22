<?= $this->extend('hotel/layout') ?>

<?= $this->section('content') ?>
<h2 class="mb-4">Nos Chambres Disponibles</h2>
<div class="row">
    <?php foreach ($chambres as $chambre): ?>
        <div class="col-md-4 mb-4">
            <div class="card h-100 shadow-sm">
                <?php // Affiche une image dédiée pour les chambres 'double' sans passer par une route de type view/hotel/image
                if (isset($chambre['type_libelle']) && stripos($chambre['type_libelle'], 'double') !== false): ?>
                    <img src="<?= base_url('public/assets/images/chambre_double.png') ?>" class="card-img-top" alt="Chambre double">
                <?php else: ?>
                    <img src="https://placehold.co/600x400?text=Chambre+<?= esc($chambre['chamb_numero']) ?>" class="card-img-top" alt="Chambre">
                <?php endif; ?>
                <div class="card-body">
                    <h5 class="card-title"><?= esc($chambre['type_libelle']) ?></h5>
                    <p class="card-text">
                        <strong>Numéro :</strong> <?= esc($chambre['chamb_numero']) ?><br>
                        <strong>Emplacement :</strong> <?= esc($chambre['chamb_emplacement']) ?>
                    </p>
                    <p class="text-muted small"><?= esc($chambre['type_desc']) ?></p>
                    <a href="<?= base_url('chambre/' . $chambre['chamb_id']) ?>" class="btn btn-primary w-100">Voir & Réserver</a>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>
<?= $this->endSection() ?>