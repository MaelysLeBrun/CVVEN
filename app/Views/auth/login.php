<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion — CVVEN Villages de Vacances</title>
    <link rel="icon" type="image/png" href="<?= base_url('assets/images/hotel/hotelLogo.png') ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="<?= base_url('assets/css/login.css') ?>" rel="stylesheet">
</head>
<body>

<div class="login-container">

    <!-- Left panel — Mountain atmosphere -->
    <div class="login-image">
        <div class="login-image-ornament"></div>
        <div class="login-image-content">
            <div class="brand-logo">🏔️</div>
            <div class="brand">CVVEN</div>
            <div class="brand-tag">Villages de Vacances · Éducation Nationale</div>
            <p class="brand-desc">
                Votre espace de réservation sécurisé. Accédez à nos hébergements alpins exclusivement réservés aux agents de l'Éducation Nationale.
            </p>
        </div>
    </div>

    <!-- Right panel — Login form -->
    <div class="login-form">

        <h3>Connexion</h3>
        <p class="subtitle">Accédez à votre espace personnel</p>

        <?php if (session()->getFlashdata('message')): ?>
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            <i class="bi bi-info-circle me-2"></i><?= session()->getFlashdata('message') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle me-2"></i><?= session()->getFlashdata('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php endif; ?>

        <form method="post" action="<?= site_url('login') ?>"
              x-data="{ loading: false }" @submit="loading = true">
            <?= csrf_field() ?>

            <div class="mb-3">
                <label class="form-label">Identifiant</label>
                <input type="text" name="user_login" class="form-control"
                       placeholder="Votre identifiant de connexion" required autofocus>
            </div>

            <div class="mb-4" x-data="{ showPassword: false }">
                <label class="form-label">Mot de passe</label>
                <div class="position-relative">
                    <input :type="showPassword ? 'text' : 'password'"
                           name="user_mdp" class="form-control"
                           placeholder="••••••••" required
                           style="padding-right:3rem;">
                    <button type="button"
                            @click="showPassword = !showPassword"
                            class="btn btn-link position-absolute"
                            style="right:10px;top:50%;transform:translateY(-50%);text-decoration:none;color:#7A7265;padding:0.25rem;">
                        <i :class="showPassword ? 'bi bi-eye-slash' : 'bi bi-eye'"></i>
                    </button>
                </div>
            </div>

            <button class="btn-login mb-3" :disabled="loading">
                <span x-show="!loading">
                    <i class="bi bi-box-arrow-in-right me-1"></i>Se connecter
                </span>
                <span x-show="loading">
                    <span class="spinner-border spinner-border-sm me-2" style="width:0.9rem;height:0.9rem;border-width:0.15em;"></span>
                    Connexion…
                </span>
            </button>
        </form>

        <div class="divider">ou</div>

        <a href="<?= base_url('register') ?>" class="btn-register">
            Créer un compte
        </a>

        <div class="text-center mt-4">
            <a href="<?= base_url('/') ?>" class="back-link">
                <i class="bi bi-arrow-left" style="font-size:0.75rem;"></i>
                Retour à l'accueil
            </a>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
