<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - CVVEN Hôtel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="<?= base_url('assets/css/register.css') ?>" rel="stylesheet">
</head>
<body>
    <div class="register-container">
        <h3 class="text-center">Inscription</h3>
        <p class="subtitle text-center">Créez votre compte CVVEN Hôtel</p>

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

            <form method="post" action="<?= site_url('register') ?>" x-data="{
                loading: false,
                password: '',
                confirmPassword: '',
                showPassword: false,
                showConfirmPassword: false,
                get passwordsMatch() { return this.password === this.confirmPassword && this.password.length > 0; },
                get passwordStrength() {
                    if (this.password.length === 0) return 0;
                    if (this.password.length < 6) return 1;
                    if (this.password.length < 10) return 2;
                    return 3;
                }
            }" @submit="loading = true">
                <?= csrf_field() ?>

                <div class="row">
                    <div class="col mb-3">
                        <label class="form-label">Prénom</label>
                        <input type="text" name="user_prenom" class="form-control" value="<?= old('user_prenom') ?>" required autofocus>
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
                    <div class="position-relative">
                        <input :type="showPassword ? 'text' : 'password'" name="user_mdp" x-model="password" class="form-control" required>
                        <button type="button" @click="showPassword = !showPassword" class="btn btn-link position-absolute" style="right: 5px; top: 50%; transform: translateY(-50%); text-decoration: none;">
                            <i :class="showPassword ? 'bi bi-eye-slash' : 'bi bi-eye'"></i>
                        </button>
                    </div>
                    <!-- Indicateur de force du mot de passe -->
                    <div x-show="password.length > 0" class="mt-2">
                        <div class="progress" style="height: 5px;">
                            <div class="progress-bar" :class="{
                                'bg-danger': passwordStrength === 1,
                                'bg-warning': passwordStrength === 2,
                                'bg-success': passwordStrength === 3
                            }" :style="'width: ' + (passwordStrength * 33.33) + '%'"></div>
                        </div>
                        <small x-text="passwordStrength === 1 ? 'Faible' : passwordStrength === 2 ? 'Moyen' : 'Fort'" :class="{
                            'text-danger': passwordStrength === 1,
                            'text-warning': passwordStrength === 2,
                            'text-success': passwordStrength === 3
                        }"></small>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Confirmer le mot de passe</label>
                    <div class="position-relative">
                        <input :type="showConfirmPassword ? 'text' : 'password'" name="user_mdp_confirm" x-model="confirmPassword" class="form-control" required>
                        <button type="button" @click="showConfirmPassword = !showConfirmPassword" class="btn btn-link position-absolute" style="right: 5px; top: 50%; transform: translateY(-50%); text-decoration: none;">
                            <i :class="showConfirmPassword ? 'bi bi-eye-slash' : 'bi bi-eye'"></i>
                        </button>
                    </div>
                    <small x-show="confirmPassword.length > 0" :class="passwordsMatch ? 'text-success' : 'text-danger'" x-text="passwordsMatch ? '✓ Les mots de passe correspondent' : '✗ Les mots de passe ne correspondent pas'"></small>
                </div>

                <button class="btn btn-register w-100" :disabled="loading || !passwordsMatch">
                    <span x-show="!loading">S'inscrire</span>
                    <span x-show="loading" class="spinner-border spinner-border-sm me-2"></span>
                    <span x-show="loading">Inscription...</span>
                </button>
            </form>

            <div class="divider">
                <p class="mb-0">Déjà un compte ?</p>
            </div>
            
            <div class="text-center">
                <a href="<?= base_url('login') ?>" class="text-decoration-none" style="color: var(--accent-color); font-weight: 600;">Se connecter</a>
            </div>
        </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url('assets/js/app.js') ?>"></script>
</body>
</html>
