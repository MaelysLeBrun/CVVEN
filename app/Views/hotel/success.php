<?= $this->extend('hotel/layout') ?>
<?= $this->section('content') ?>

<div style="background-color:#EDE8DC;padding:5rem 0;min-height:80vh;display:flex;align-items:center;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div style="background:#F8F5EE;border:1px solid #DDD8CD;border-radius:20px;overflow:hidden;box-shadow:0 16px 50px rgba(22,43,25,0.15);text-align:center;">

                    <!-- Top gradient band -->
                    <div style="background:linear-gradient(135deg,#2A4A2E,#3A6341);padding:2.5rem 2rem;">
                        <!-- Animated check -->
                        <div style="
                            width:80px;height:80px;
                            background:rgba(232,216,168,0.2);
                            border:2px solid rgba(201,176,122,0.4);
                            border-radius:50%;
                            display:flex;align-items:center;justify-content:center;
                            margin:0 auto;
                            font-size:2.2rem;color:#E8D8A8;
                            animation:checkPulse 2s ease-in-out infinite;
                        ">
                            <i class="bi bi-check-lg"></i>
                        </div>
                    </div>

                    <div style="padding:2.5rem 2rem 2rem;">
                        <h2 style="font-family:'Cormorant Garamond',serif;font-size:2rem;font-weight:700;color:#162B19;margin-bottom:0.75rem;line-height:1.2;">
                            Réservation confirmée !
                        </h2>

                        <div style="width:40px;height:2px;background:linear-gradient(90deg,#C9B07A,#B8860B);border-radius:2px;margin:0.75rem auto 1.25rem;"></div>

                        <p style="font-family:'Outfit',sans-serif;font-size:0.9rem;color:#7A7265;line-height:1.75;margin-bottom:0.5rem;">
                            Votre demande de réservation a bien été enregistrée.
                        </p>
                        <p style="font-family:'Outfit',sans-serif;font-size:0.875rem;color:#7A7265;line-height:1.65;margin-bottom:2rem;">
                            <i class="bi bi-envelope me-1" style="color:#C9B07A;"></i>
                            Une confirmation vous sera envoyée à votre adresse email.
                        </p>

                        <div style="display:flex;flex-direction:column;gap:0.65rem;">
                            <a href="<?= base_url('mes-reservations') ?>"
                               style="
                                    display:flex;align-items:center;justify-content:center;gap:8px;
                                    background:linear-gradient(135deg,#2A4A2E,#3A6341);
                                    color:#fff;font-family:'Outfit',sans-serif;font-weight:600;font-size:0.9rem;
                                    padding:0.85rem;border-radius:8px;text-decoration:none;
                                    transition:all 0.3s;
                               "
                               onmouseover="this.style.background='linear-gradient(135deg,#162B19,#2A4A2E)';this.style.color='#E8D8A8'"
                               onmouseout="this.style.background='linear-gradient(135deg,#2A4A2E,#3A6341)';this.style.color='#fff'">
                                <i class="bi bi-calendar-check"></i>
                                Voir mes réservations
                            </a>
                            <a href="<?= base_url('/') ?>"
                               style="
                                    display:flex;align-items:center;justify-content:center;gap:8px;
                                    background:transparent;border:1.5px solid #DDD8CD;
                                    color:#7A7265;font-family:'Outfit',sans-serif;font-weight:500;font-size:0.875rem;
                                    padding:0.75rem;border-radius:8px;text-decoration:none;
                                    transition:all 0.3s;
                               "
                               onmouseover="this.style.background='#EDE8DC';this.style.color='#2C2416'"
                               onmouseout="this.style.background='transparent';this.style.color='#7A7265'">
                                <i class="bi bi-house"></i>
                                Retour à l'accueil
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
@keyframes checkPulse {
    0%, 100% { transform: scale(1); box-shadow: 0 0 0 0 rgba(201,176,122,0.3); }
    50%       { transform: scale(1.05); box-shadow: 0 0 0 12px rgba(201,176,122,0); }
}
</style>

<?= $this->endSection() ?>
