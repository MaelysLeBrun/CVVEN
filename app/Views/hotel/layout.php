<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CVVEN Hôtel</title>
    <link rel="icon" type="image/png" href="<?= base_url('assets/images/hotel/hotelLogo.png') ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="<?= base_url('assets/css/layout.css') ?>" rel="stylesheet">
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
                    <ul class="navbar-nav ms-auto align-items-lg-center">
                        <?php if (session()->get('isLoggedIn')): ?>
                            <li class="nav-item">
                                <span class="nav-link text-white opacity-75">
                                    <i class="bi bi-person-circle"></i> <strong><?= esc(session()->get('user_login')) ?></strong>
                                </span>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?= base_url('reservation') ?>">
                                    <i class="bi bi-calendar-plus"></i> Réserver
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?= base_url('mes-reservations') ?>">
                                    <i class="bi bi-calendar-check"></i> Mes réservations
                                </a>
                            </li>
                            <li class="nav-item ms-2">
                                <a class="nav-link btn btn-outline-light btn-sm px-3" href="<?= base_url('logout') ?>">
                                    <i class="bi bi-box-arrow-right"></i> Déconnexion
                                </a>
                            </li>
                        <?php else: ?>
                            <li class="nav-item">
                                <a class="nav-link btn btn-outline-light btn-sm px-3" href="<?= base_url('login') ?>">
                                    <i class="bi bi-box-arrow-in-right"></i> Connexion
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <!-- FLASH MESSAGES GLOBAUX -->
    <?php if (session()->getFlashdata('success') || session()->getFlashdata('erreur') || session()->getFlashdata('message')): ?>
    <div class="container mt-3">
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle"></i> <?= session()->getFlashdata('success') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('erreur')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle"></i> <?= session()->getFlashdata('erreur') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('message')): ?>
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                <i class="bi bi-info-circle"></i> <?= session()->getFlashdata('message') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
    </div>
    <?php endif; ?>

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
                        <?php if (session()->get('isLoggedIn')): ?>
                            <li><a href="<?= base_url('reservation') ?>" class="text-decoration-none">Réserver</a></li>
                            <li><a href="<?= base_url('mes-reservations') ?>" class="text-decoration-none">Mes réservations</a></li>
                        <?php else: ?>
                            <li><a href="<?= base_url('login') ?>" class="text-decoration-none">Connexion</a></li>
                            <li><a href="<?= base_url('register') ?>" class="text-decoration-none">Inscription</a></li>
                        <?php endif; ?>
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
    <script src="<?= base_url('assets/js/app.js') ?>"></script>
</body>
</html>
