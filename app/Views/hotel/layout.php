<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réservation Hôtel CVVEN</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        main {
            flex: 1;
        }
        footer {
            background-color: #f8f9fa;
            border-top: 1px solid #dee2e6;
            margin-top: 40px;
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
                        <?php if (session()->get('isLoggedIn')): ?>
                            <li class="nav-item">
                                <span class="nav-link text-white">
                                    Bienvenue, <strong><?= esc(session()->get('user_login')) ?></strong>
                                </span>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link btn btn-outline-light btn-sm ms-2" href="<?= base_url('/logout') ?>">
                                    Déconnexion
                                </a>
                            </li>
                        <?php else: ?>
                            <li class="nav-item">
                                <a class="nav-link btn btn-outline-light btn-sm" href="<?= base_url('/login') ?>">
                                    Connexion
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <!-- MAIN CONTENT -->
    <main class="py-4">
        <div class="container">
            <?= $this->renderSection('content') ?>
        </div>
    </main>

    <!-- FOOTER -->
    <footer class="mt-auto">
        <div class="container py-4">
            <div class="row">
                <div class="col-md-4 mb-3">
                    <h5>CVVEN Hôtel</h5>
                    <p class="text-muted small">Votre hôtel de confiance pour vos séjours.</p>
                </div>
                <div class="col-md-4 mb-3">
                    <h5>Navigation</h5>
                    <ul class="list-unstyled small">
                        <li><a href="<?= base_url('/') ?>" class="text-decoration-none">Accueil</a></li>
                        <li><a href="<?= base_url('/login') ?>" class="text-decoration-none">Connexion</a></li>
                    </ul>
                </div>
                <div class="col-md-4 mb-3">
                    <h5>Contact</h5>
                    <p class="text-muted small">
                        Email: info@cvven.fr<br>
                        Téléphone: +33 1 23 45 67 89
                    </p>
                </div>
            </div>
            <hr>
            <div class="text-center text-muted small">
                <p>&copy; 2026 CVVEN Hôtel. Tous droits réservés.</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>