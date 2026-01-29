<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CVVEN</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #6B5344;
            --primary-dark: #4a3a31;
            --primary-light: #8B6F47;
            --secondary-color: #4A7C59;
            --accent-color: #D4A574;
            --nature-green: #5A9D7A;
        }

        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            background-color: #faf7f2;
        }

        .bg-light {
            background-color: #faf7f2 !important;
        }

        main {
            flex: 1;
        }
        footer {
            background-color: var(--primary-color);
            border-top: 3px solid var(--accent-color);
            margin-top: 40px;
            color: white;
        }

        footer h5 {
            color: var(--accent-color);
            font-weight: 600;
        }

        footer p {
            color: rgba(255, 255, 255, 0.9);
        }

        footer a {
            color: var(--accent-color);
            transition: color 0.3s ease;
        }

        footer a:hover {
            color: white;
            text-decoration: underline;
        }

        footer .text-muted {
            color: rgba(255, 255, 255, 0.8) !important;
        }

        footer hr {
            border-color: rgba(255, 255, 255, 0.2);
        }

        /* Override Bootstrap primary */
        .navbar-dark.bg-primary {
            background-color: var(--primary-color) !important;
        }

        .bg-primary {
            background-color: var(--primary-color) !important;
        }

        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            color: white;
        }

        .btn-primary:hover {
            background-color: var(--primary-dark);
            border-color: var(--primary-dark);
            color: white;
        }

        .btn-outline-light {
            border-color: white;
            color: white;
        }

        .btn-outline-light:hover {
            background-color: var(--accent-color);
            border-color: var(--accent-color);
            color: var(--primary-color);
        }

        /* Text colors for good contrast */
        .navbar-dark .navbar-nav .nav-link {
            color: rgba(255, 255, 255, 0.9) !important;
            transition: color 0.3s ease;
        }

        .navbar-dark .navbar-nav .nav-link:hover {
            color: var(--accent-color) !important;
        }

        .navbar-dark .navbar-brand {
            color: white !important;
        }

        /* Card styling */
        .card {
            border-top: 4px solid var(--primary-color);
            box-shadow: 0 4px 12px rgba(107, 83, 68, 0.15);
        }

        .card-header.bg-primary {
            background-color: var(--primary-color) !important;
            color: white;
        }

        /* Headings */
        h1, h2, h3, h4, h5, h6 {
            color: var(--primary-dark);
        }

        /* Links */
        a {
            color: var(--primary-light);
        }

        a:hover {
            color: var(--primary-dark);
        }

        /* Badge colors */
        .badge.bg-primary {
            background-color: var(--primary-color) !important;
            color: white;
        }

        /* Alert styling */
        .alert-info {
            background-color: #e8f4f8;
            border-color: var(--nature-green);
            color: var(--primary-dark);
        }

        .alert-success {
            background-color: #e8f5e9;
            border-color: var(--nature-green);
            color: var(--primary-dark);
        }

        .alert-danger {
            background-color: #ffebee;
            border-color: #c62828;
            color: #b71c1c;
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
                        <?php if (session()->get('isLoggedIn')): ?>
                            <li class="nav-item">
                                <span class="nav-link text-white">
                                    Bienvenue, <strong><?= esc(session()->get('user_login')) ?></strong>
                                </span>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?= base_url('/mes-reservations') ?>">
                                    Mes réservations
                                </a>
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