<?= $this->extend('hotel/layout') ?>

<?= $this->section('content') ?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 text-center">
            <div class="card border-0 shadow-lg" style="border-radius: 15px; overflow: hidden;">
                <div class="card-body py-5 px-4">
                    <div class="mb-4">
                        <i class="bi bi-check-circle-fill text-success" style="font-size: 4rem;"></i>
                    </div>
                    <h2 class="fw-bold mb-3">Réservation Confirmée !</h2>
                    <p class="text-muted mb-4">
                        Votre demande a bien été enregistrée.<br>
                        Vous recevrez une confirmation à votre adresse email.
                    </p>
                    <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
                        <a href="<?= base_url('mes-reservations') ?>" class="btn btn-primary px-4">
                            <i class="bi bi-calendar-check"></i> Mes réservations
                        </a>
                        <a href="<?= base_url('/') ?>" class="btn btn-outline-secondary px-4">
                            <i class="bi bi-house"></i> Accueil
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
