<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - CVVEN Hôtel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { display: flex; flex-direction: column; min-height: 100vh; }
        main { flex: 1; display:flex; align-items:center; justify-content:center; }
        footer { background-color: #f8f9fa; border-top: 1px solid #dee2e6; }
    </style>
</head>
<body class="bg-light">
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
            <div class="container">
                <a class="navbar-brand fw-bold" href="<?= base_url('/') ?>">CVVEN Hôtel</a>
            </div>
        </nav>
    </header>

    <main>
        <div class="card shadow p-4" style="width: 420px;">
            <h3 class="text-center mb-4">Inscription</h3>

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

            <?php $errors = session()->getFlashdata('errors'); ?>
            <?php if (!empty($errors)) : ?>
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        <?php foreach ($errors as $err) : ?>
                            <li><?= esc($err) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form method="post" action="<?= site_url('register') ?>">
                <?= csrf_field() ?>

                <div class="mb-3">
                    <label class="form-label">Login</label>
                    <input type="text" name="user_login" class="form-control" value="<?= old('user_login') ?>" required autofocus>
                </div>

                <div class="row">
                    <div class="col mb-3">
                        <label class="form-label">Prénom</label>
                        <input type="text" name="user_prenom" class="form-control" value="<?= old('user_prenom') ?>" required>
                    </div>
                    <div class="col mb-3">
                        <label class="form-label">Nom</label>
                        <input type="text" name="user_nom" class="form-control" value="<?= old('user_nom') ?>" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="user_mail" class="form-control" value="<?= old('user_mail') ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Téléphone </label>
                    <input type="text" name="user_telephone" class="form-control" value="<?= old('user_telephone') ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Mot de passe</label>
                    <input type="password" name="user_mdp" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Confirmer le mot de passe</label>
                    <input type="password" name="user_mdp_confirm" class="form-control" required>
                </div>

                <button class="btn btn-primary w-100">S'inscrire</button>
            </form>

            <hr>
            <p class="text-center text-muted small">
                <a href="<?= base_url('login') ?>" class="text-decoration-none">Déjà un compte ? Se connecter</a>
            </p>
        </div>
    </main>

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
