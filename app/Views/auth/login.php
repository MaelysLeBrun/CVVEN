<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - CVVEN Hôtel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        main {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        footer {
            background-color: #f8f9fa;
            border-top: 1px solid #dee2e6;
        }
    </style>
</head>
<body class="bg-light">
    <!-- HEADER -->
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
            <div class="container">
                <a class="navbar-brand fw-bold" href="<?= base_url('/') ?>">
                    <i class="bi bi-hotel"></i> CVVEN Hôtel
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('/') ?>">Accueil</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <!-- MAIN CONTENT -->
    <main>
        <div class="card shadow p-4" style="width: 350px;">
            <h3 class="text-center mb-4">Connexion</h3>

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

            <form method="post" action="<?= site_url('login') ?>">
                <?= csrf_field() ?>

                <div class="mb-3">
                    <label class="form-label">Login</label>
                    <input type="text" name="user_login" class="form-control" required autofocus>
                </div>

                <div class="mb-3">
                    <label class="form-label">Mot de passe</label>
                    <input type="password" name="user_mdp" class="form-control" required>
                </div>

                <button class="btn btn-primary w-100">Se connecter</button>
            </form>

            <div class="d-grid gap-2 mt-3">
                <a href="<?= base_url('register') ?>" class="btn btn-outline-secondary">Créer un compte</a>
            </div>

            <hr>
            <p class="text-center text-muted small">
                <a href="<?= base_url('/') ?>" class="text-decoration-none">Retour à l'accueil</a>
            </p>
        </div>
    </main>

    <!-- FOOTER -->
    <footer class="mt-auto">
        <div class="container py-3">
            <div class="text-center text-muted small">
                <p>&copy; 2026 CVVEN Hôtel. Tous droits réservés.</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
