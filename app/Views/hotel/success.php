<?= $this->extend('hotel/layout') ?>

<?= $this->section('content') ?>
<div class="card text-center mt-5 border-success">
    <div class="card-body">
        <h3 class="text-success">Réservation Confirmée !</h3>
        <p class="lead">Votre demande a bien été enregistrée dans notre base de données.</p>
        <a href="<?= base_url('/') ?>" class="btn btn-primary">Retour à l'accueil</a>
    </div>
</div>
<?= $this->endSection() ?>