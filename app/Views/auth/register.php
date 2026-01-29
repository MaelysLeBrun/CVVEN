<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - CVVEN Hôtel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #2F5233;
            --primary-dark: #ebc98b;
            --primary-light: #4A7C59;
            --secondary-color: #3D5A40;
            --accent-color: #C9B382;
            --nature-green: #5A9D7A;
            --dark-color: #1e293b;
        }
        
        body {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .register-container {
            background: white;
            border-radius: 20px;
            padding: 50px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            max-width: 600px;
            width: 100%;
        }
        
        .register-container h3 {
            color: var(--primary-color);
            font-weight: 700;
            margin-bottom: 10px;
        }
        
        .register-container .subtitle {
            color: #64748b;
            margin-bottom: 30px;
        }
        
        .form-control {
            padding: 12px 15px;
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            transition: all 0.3s;
        }
        
        .form-control:focus {
            border-color: var(--secondary-color);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }
        
        .form-label {
            font-weight: 600;
            color: var(--dark-color);
            margin-bottom: 8px;
        }
        
        .btn-register {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            border: none;
            padding: 12px;
            border-radius: 10px;
            font-weight: 600;
            color: white;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        
        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(47, 82, 51, 0.3);
            background: var(--primary-dark);
            color: var(--primary-color);
        }
        
        .divider {
            margin: 25px 0;
            text-align: center;
            color: #94a3b8;
        }
        
        .alert {
            border-radius: 10px;
        }
    </style>
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

            <form method="post" action="<?= site_url('register') ?>">
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
                    <input type="password" name="user_mdp" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Confirmer le mot de passe</label>
                    <input type="password" name="user_mdp_confirm" class="form-control" required>
                </div>

                <button class="btn btn-register w-100">S'inscrire</button>
            </form>

            <div class="divider">
                <p class="mb-0">Déjà un compte ?</p>
            </div>
            
            <div class="text-center">
                <a href="<?= base_url('login') ?>" class="text-decoration-none" style="color: var(--accent-color); font-weight: 600;">Se connecter</a>
            </div>
        </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
