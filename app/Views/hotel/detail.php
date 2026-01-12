<?= $this->extend('hotel/layout') ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-md-5">
        <img src="https://placehold.co/600x400?text=Chambre+<?= $chambre['chamb_numero'] ?>" class="img-fluid rounded shadow mb-3">
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