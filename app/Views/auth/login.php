<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - CVVEN Hôtel</title>
    <link rel="icon" type="image/png" href="<?= base_url('assets/images/hotel/hotelLogo.png') ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="<?= base_url('assets/css/login.css') ?>" rel="stylesheet">
</head>
<body>
    <div class="login-container">
        <!-- Image section -->
        <div class="login-image">
            <div class="login-image-content">
                <h1>CVVEN Hôtel</h1>
                <p>Bienvenue dans votre espace de réservation. Connectez-vous pour accéder à nos services exclusifs et gérer vos réservations en toute simplicité.</p>
            </div>
        </div>
        
        <!-- Form section -->
        <div class="login-form">
            <h3>Connexion</h3>
            <p class="subtitle">Accédez à votre espace personnel</p>

            <?php if (session()->getFlashdata('message')) : ?>
                <div class="alert alert-info alert-dismissible fade show" role="alert">
                    <?= session()->getFlashdata('message') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('error')) : ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?= session()->getFlashdata('error') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <form method="post" action="<?= site_url('login') ?>" x-data="{ loading: false }" @submit="loading = true">
                <?= csrf_field() ?>

                <div class="mb-3">
                    <label class="form-label">Login</label>
                    <input type="text" name="user_login" class="form-control" placeholder="Votre identifiant" required autofocus>
                </div>

                <div class="mb-4" x-data="{ showPassword: false }">
                    <label class="form-label">Mot de passe</label>
                    <div class="position-relative">
                        <input :type="showPassword ? 'text' : 'password'" name="user_mdp" class="form-control" placeholder="Votre mot de passe" required>
                        <button type="button" @click="showPassword = !showPassword" class="btn btn-link position-absolute" style="right: 5px; top: 50%; transform: translateY(-50%); text-decoration: none;">
                            <i :class="showPassword ? 'bi bi-eye-slash' : 'bi bi-eye'"></i>
                        </button>
                    </div>
                </div>

                <button class="btn btn-login w-100 mb-3" :disabled="loading">
                    <span x-show="!loading">Se connecter</span>
                    <span x-show="loading" class="spinner-border spinner-border-sm me-2"></span>
                    <span x-show="loading">Connexion...</span>
                </button>
            </form>

            <div class="divider">OU</div>

            <a href="<?= base_url('register') ?>" class="btn btn-register w-100">Créer un compte</a>
            
            <div class="text-center mt-4">
                <a href="<?= base_url('/') ?>" class="text-decoration-none" style="color: var(--accent-color); font-weight: 500;">← Retour à l'accueil</a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url('assets/js/app.js') ?>"></script>
</body>
</html>
