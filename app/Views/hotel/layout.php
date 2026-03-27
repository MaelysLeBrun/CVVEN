<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CVVEN — Villages de Vacances</title>
    <link rel="icon" type="image/png" href="<?= base_url('assets/images/hotel/hotelLogo.png') ?>">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- CVVEN Theme -->
    <link href="<?= base_url('assets/css/layout.css') ?>" rel="stylesheet">
</head>
<body>

    <!-- ═══════════════════════════════════════════════════════════
         NAVIGATION
    ═══════════════════════════════════════════════════════════ -->
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark">
            <div class="container">

                <!-- Brand -->
                <a class="navbar-brand" href="<?= base_url('/') ?>">
                    <div class="brand-icon">
                        <i class="bi bi-house-heart"></i>
                    </div>
                    <div class="brand-text">
                        <span class="brand-abbr">CVVEN</span>
                        <span class="brand-full">Villages de Vacances · Éducation Nationale</span>
                    </div>
                </a>

                <!-- Toggler -->
                <button class="navbar-toggler border-0" type="button"
                        data-bs-toggle="collapse" data-bs-target="#navbarNav"
                        aria-controls="navbarNav" aria-expanded="false" aria-label="Navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <!-- Links -->
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-1">
                        <?php if (session()->get('isLoggedIn')): ?>
                            <li class="nav-item">
                                <span class="nav-link nav-user-name">
                                    <i class="bi bi-person-circle me-1"></i><?= esc(session()->get('user_login')) ?>
                                </span>
                            </li>
                            <?php if (session()->get('user_role') === 'administrateur'): ?>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button"
                                   data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-shield-lock me-1"></i>Admin
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <a class="dropdown-item" href="<?= base_url('admin/users') ?>">
                                            <i class="bi bi-people me-2"></i>Utilisateurs
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="<?= base_url('admin/reservations') ?>">
                                            <i class="bi bi-calendar-check me-2"></i>Réservations
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <?php endif; ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?= base_url('reservation') ?>">
                                    <i class="bi bi-calendar-plus me-1"></i>Réserver
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?= base_url('mes-reservations') ?>">
                                    <i class="bi bi-calendar-check me-1"></i>Mes réservations
                                </a>
                            </li>
                            <li class="nav-item ms-lg-2">
                                <a class="nav-link btn btn-outline-light btn-sm px-3 py-2"
                                   href="<?= base_url('logout') ?>">
                                    <i class="bi bi-box-arrow-right me-1"></i>Déconnexion
                                </a>
                            </li>
                        <?php else: ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?= base_url('/') ?>">
                                    <i class="bi bi-house me-1"></i>Accueil
                                </a>
                            </li>
                            <li class="nav-item ms-lg-2">
                                <a class="nav-link btn btn-outline-light btn-sm px-3 py-2"
                                   href="<?= base_url('login') ?>">
                                    <i class="bi bi-box-arrow-in-right me-1"></i>Connexion
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>

            </div>
        </nav>
    </header>

    <!-- ═══════════════════════════════════════════════════════════
         FLASH MESSAGES
    ═══════════════════════════════════════════════════════════ -->
    <?php if (session()->getFlashdata('success') || session()->getFlashdata('erreur') || session()->getFlashdata('message')): ?>
    <div class="container mt-3">
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-2"></i><?= session()->getFlashdata('success') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('erreur')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle me-2"></i><?= session()->getFlashdata('erreur') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('message')): ?>
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                <i class="bi bi-info-circle me-2"></i><?= session()->getFlashdata('message') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
    </div>
    <?php endif; ?>

    <!-- ═══════════════════════════════════════════════════════════
         MAIN CONTENT
    ═══════════════════════════════════════════════════════════ -->
    <main>
        <?= $this->renderSection('content') ?>
    </main>

    <!-- ═══════════════════════════════════════════════════════════
         FOOTER
    ═══════════════════════════════════════════════════════════ -->
    <footer class="mt-auto">
        <!-- Mountain silhouette decoration -->
        <svg class="footer-mountain" viewBox="0 0 1440 80" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
            <path d="M0,80 L0,55 L80,28 L160,50 L240,18 L320,42 L400,8 L480,38 L560,5 L640,35 L720,12 L800,40 L880,6 L960,38 L1040,15 L1120,44 L1200,22 L1280,48 L1360,20 L1440,45 L1440,80 Z" fill="currentColor"/>
        </svg>

        <div class="container py-5 position-relative">
            <div class="row g-4">

                <!-- Brand column -->
                <div class="col-md-4">
                    <div class="d-flex align-items-center gap-2 mb-3">
                        <div class="brand-icon" style="width:36px;height:36px;background:linear-gradient(135deg,#C9B07A,#B8860B);border-radius:8px;display:flex;align-items:center;justify-content:center;color:#162B19;font-size:1rem;">
                            <i class="bi bi-house-heart"></i>
                        </div>
                        <span style="font-family:'Cormorant Garamond',serif;font-size:1.4rem;font-weight:700;color:#E8D8A8;">CVVEN</span>
                    </div>
                    <p style="color:rgba(255,255,255,0.5);font-size:0.82rem;line-height:1.7;max-width:240px;">
                        Comité pour les Villages de Vacances de l'Éducation Nationale — Des séjours montagne d'exception.
                    </p>
                </div>

                <!-- Navigation -->
                <div class="col-md-4">
                    <h5>Navigation</h5>
                    <ul class="list-unstyled">
                        <li class="mb-1">
                            <a href="<?= base_url('/') ?>">
                                <i class="bi bi-house me-2" style="font-size:0.7rem;"></i>Accueil
                            </a>
                        </li>
                        <?php if (session()->get('isLoggedIn')): ?>
                            <li class="mb-1">
                                <a href="<?= base_url('reservation') ?>">
                                    <i class="bi bi-calendar-plus me-2" style="font-size:0.7rem;"></i>Réserver
                                </a>
                            </li>
                            <li class="mb-1">
                                <a href="<?= base_url('mes-reservations') ?>">
                                    <i class="bi bi-calendar-check me-2" style="font-size:0.7rem;"></i>Mes réservations
                                </a>
                            </li>
                        <?php else: ?>
                            <li class="mb-1">
                                <a href="<?= base_url('login') ?>">
                                    <i class="bi bi-box-arrow-in-right me-2" style="font-size:0.7rem;"></i>Connexion
                                </a>
                            </li>
                            <li class="mb-1">
                                <a href="<?= base_url('register') ?>">
                                    <i class="bi bi-person-plus me-2" style="font-size:0.7rem;"></i>Créer un compte
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>

                <!-- Contact -->
                <div class="col-md-4">
                    <h5>Contact</h5>
                    <ul class="list-unstyled" style="color:rgba(255,255,255,0.5);font-size:0.875rem;">
                        <li class="mb-2">
                            <i class="bi bi-envelope me-2" style="color:#C9B07A;"></i>
                            <a href="mailto:info@cvven.fr">info@cvven.fr</a>
                        </li>
                        <li class="mb-2">
                            <i class="bi bi-telephone me-2" style="color:#C9B07A;"></i>
                            +33 1 23 45 67 89
                        </li>
                        <li>
                            <i class="bi bi-geo-alt me-2" style="color:#C9B07A;"></i>
                            Villages des Alpes, France
                        </li>
                    </ul>
                </div>

            </div>

            <hr>

            <div class="text-center footer-bottom">
                &copy; <?= date('Y') ?> CVVEN — Comité pour les Villages de Vacances de l'Éducation Nationale.
                Tous droits réservés.
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url('assets/js/app.js') ?>"></script>

</body>
</html>
