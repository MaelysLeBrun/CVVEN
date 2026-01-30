<?= $this->extend('hotel/layout') ?>

<?= $this->section('content') ?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card border-0 shadow-lg text-center">
                <div class="card-body p-5">
                    <!-- Icône de succès animée -->
                    <div class="mb-4" style="animation: bounce 1s ease-in-out;">
                        <i class="bi bi-check-circle-fill text-success" style="font-size: 5rem;"></i>
                    </div>
                    
                    <h1 class="fw-bold text-success mb-3">Réservation Confirmée !</h1>
                    <p class="lead text-muted mb-4">
                        Votre réservation a été enregistrée avec succès. 
                        Vous recevrez une confirmation par email sous peu.
                    </p>

                    <!-- Informations supplémentaires -->
                    <div class="alert alert-info mb-4">
                        <i class="bi bi-info-circle"></i> 
                        Un email de confirmation vous a été envoyé avec tous les détails de votre réservation.
                    </div>

                    <!-- Boutons d'action -->
                    <div class="d-grid gap-3">
                        <a href="<?= base_url('/mes-reservations') ?>" class="btn btn-primary btn-lg">
                            <i class="bi bi-list-check"></i> Voir mes réservations
                        </a>
                        <a href="<?= base_url('/') ?>" class="btn btn-outline-secondary btn-lg">
                            <i class="bi bi-house"></i> Retour à l'accueil
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
@keyframes bounce {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.1); }
}
</style>

<?= $this->endSection() ?>
