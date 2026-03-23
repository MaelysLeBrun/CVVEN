<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription — CVVEN Villages de Vacances</title>
    <link rel="icon" type="image/png" href="<?= base_url('assets/images/hotel/hotelLogo.png') ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="<?= base_url('assets/css/register.css') ?>" rel="stylesheet">
</head>
<body>

<div class="register-container">

    <!-- Header -->
    <div class="text-center mb-4">
        <div style="width:48px;height:48px;background:linear-gradient(135deg,#2A4A2E,#3A6341);border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:1.3rem;color:#E8D8A8;margin:0 auto 1rem;">
            🏔️
        </div>
        <h3>Créer un compte</h3>
        <p class="subtitle">Rejoignez CVVEN — Villages de Vacances de l'Éducation Nationale</p>
    </div>

    <!-- Flash messages -->
    <?php if (session()->getFlashdata('message')): ?>
    <div class="alert alert-info">
        <i class="bi bi-info-circle me-2"></i><?= session()->getFlashdata('message') ?>
    </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger">
        <i class="bi bi-exclamation-triangle me-2"></i><?= session()->getFlashdata('error') ?>
    </div>
    <?php endif; ?>

    <?php $errors = session()->getFlashdata('errors'); ?>
    <?php if (!empty($errors)): ?>
    <div class="alert alert-danger">
        <strong><i class="bi bi-exclamation-circle me-1"></i>Erreurs :</strong>
        <ul style="margin:0.5rem 0 0;padding-left:1.2rem;">
            <?php foreach ($errors as $err): ?>
                <li><?= esc($err) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
    <?php endif; ?>

    <!-- Registration form -->
    <form method="post" action="<?= site_url('register') ?>"
          x-data="{
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

        <!-- Name row -->
        <div class="row">
            <div class="col mb-3">
                <label class="form-label">Prénom</label>
                <input type="text" name="user_prenom" class="form-control"
                       value="<?= old('user_prenom') ?>"
                       placeholder="Jean" required autofocus>
            </div>
            <div class="col mb-3">
                <label class="form-label">Nom</label>
                <input type="text" name="user_nom" class="form-control"
                       value="<?= old('user_nom') ?>"
                       placeholder="Dupont" required>
            </div>
        </div>

        <!-- Email -->
        <div class="mb-3">
            <label class="form-label">Adresse email</label>
            <input type="email" name="user_mail" class="form-control"
                   value="<?= old('user_mail') ?>"
                   placeholder="jean.dupont@ac-exemple.fr" required>
        </div>

        <!-- Phone -->
        <div class="mb-3">
            <label class="form-label">Téléphone</label>
            <input type="text" name="user_telephone" class="form-control"
                   value="<?= old('user_telephone') ?>"
                   placeholder="06 XX XX XX XX" required>
        </div>

        <!-- Password -->
        <div class="mb-3">
            <label class="form-label">Mot de passe</label>
            <div class="position-relative">
                <input :type="showPassword ? 'text' : 'password'"
                       name="user_mdp"
                       x-model="password"
                       class="form-control"
                       placeholder="Minimum 6 caractères"
                       required
                       style="padding-right:3rem;">
                <button type="button"
                        @click="showPassword = !showPassword"
                        class="btn btn-link position-absolute"
                        style="right:10px;top:50%;transform:translateY(-50%);text-decoration:none;color:#7A7265;padding:0.25rem;border:none;background:transparent;cursor:pointer;">
                    <i :class="showPassword ? 'bi bi-eye-slash' : 'bi bi-eye'"></i>
                </button>
            </div>
            <!-- Password strength indicator -->
            <div x-show="password.length > 0" class="mt-2">
                <div class="progress">
                    <div class="progress-bar"
                         :class="{
                             'bg-danger':  passwordStrength === 1,
                             'bg-warning': passwordStrength === 2,
                             'bg-success': passwordStrength === 3
                         }"
                         :style="'width: ' + (passwordStrength * 33.33) + '%'"></div>
                </div>
                <small :class="{
                           'text-danger':  passwordStrength === 1,
                           'text-warning': passwordStrength === 2,
                           'text-success': passwordStrength === 3
                       }"
                       x-text="passwordStrength === 1 ? 'Mot de passe faible' : passwordStrength === 2 ? 'Mot de passe moyen' : 'Mot de passe fort'"
                       style="font-family:'Outfit',sans-serif;font-size:0.78rem;">
                </small>
            </div>
        </div>

        <!-- Confirm password -->
        <div class="mb-4">
            <label class="form-label">Confirmer le mot de passe</label>
            <div class="position-relative">
                <input :type="showConfirmPassword ? 'text' : 'password'"
                       name="user_mdp_confirm"
                       x-model="confirmPassword"
                       class="form-control"
                       placeholder="Répétez votre mot de passe"
                       required
                       style="padding-right:3rem;">
                <button type="button"
                        @click="showConfirmPassword = !showConfirmPassword"
                        class="btn btn-link position-absolute"
                        style="right:10px;top:50%;transform:translateY(-50%);text-decoration:none;color:#7A7265;padding:0.25rem;border:none;background:transparent;cursor:pointer;">
                    <i :class="showConfirmPassword ? 'bi bi-eye-slash' : 'bi bi-eye'"></i>
                </button>
            </div>
            <small x-show="confirmPassword.length > 0"
                   :class="passwordsMatch ? 'text-success' : 'text-danger'"
                   x-text="passwordsMatch ? '✓ Les mots de passe correspondent' : '✗ Les mots de passe ne correspondent pas'"
                   style="font-family:'Outfit',sans-serif;font-size:0.78rem;">
            </small>
        </div>

        <!-- Submit -->
        <button class="btn-register" :disabled="loading || !passwordsMatch">
            <span x-show="!loading">
                <i class="bi bi-person-plus me-1"></i>Créer mon compte
            </span>
            <span x-show="loading">
                <span class="spinner-border spinner-border-sm me-2"></span>
                Inscription…
            </span>
        </button>

    </form>

    <!-- Login link -->
    <div class="divider">Déjà un compte ?</div>

    <div class="text-center">
        <a href="<?= base_url('login') ?>" class="login-link">
            <i class="bi bi-box-arrow-in-right me-1"></i>Me connecter
        </a>
    </div>

    <div class="text-center mt-3">
        <a href="<?= base_url('/') ?>"
           style="color:#7A7265;font-size:0.8rem;font-family:'Outfit',sans-serif;text-decoration:none;transition:color 0.3s;"
           onmouseover="this.style.color='#2A4A2E'"
           onmouseout="this.style.color='#7A7265'">
            <i class="bi bi-arrow-left" style="font-size:0.7rem;"></i> Retour à l'accueil
        </a>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
