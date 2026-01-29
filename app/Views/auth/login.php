<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - CVVEN Hôtel</title>
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
            --bg-light: #e8e3d8;
        }
        
        body {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .login-container {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            display: flex;
            max-width: 1000px;
            width: 90%;
            min-height: 600px;
        }
        
        .login-image {
            flex: 1;
            background: url('https://images.unsplash.com/photo-1566073771259-6a8506099945?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80') center/cover;
            position: relative;
        }
        
        .login-image::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, rgba(47, 82, 51, 0.85), rgba(90, 157, 122, 0.7));
        }
        
        .login-image-content {
            position: relative;
            z-index: 1;
            color: white;
            padding: 60px 40px;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        
        .login-image-content h1 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 20px;
        }
        
        .login-image-content p {
            font-size: 1.1rem;
            opacity: 0.95;
        }
        
        .login-form {
            flex: 1;
            padding: 60px 50px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        
        .login-form h3 {
            color: var(--primary-color);
            font-weight: 700;
            margin-bottom: 10px;
        }
        
        .login-form .subtitle {
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
        
        .btn-login {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            border: none;
            padding: 12px;
            border-radius: 10px;
            font-weight: 600;
            color: white;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(47, 82, 51, 0.3);
            background: var(--primary-dark);
            color: var(--primary-color);
        }
        
        .btn-register {
            border: 2px solid var(--accent-color);
            color: var(--primary-color);
            padding: 12px;
            border-radius: 10px;
            font-weight: 600;
            transition: all 0.3s;
        }
        
        .btn-register:hover {
            background: var(--accent-color);
            color: var(--primary-color);
        }
        
        .divider {
            text-align: center;
            margin: 25px 0;
            color: #94a3b8;
            position: relative;
        }
        
        .divider::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            width: 45%;
            height: 1px;
            background: #e2e8f0;
        }
        
        .divider::after {
            content: '';
            position: absolute;
            right: 0;
            top: 50%;
            width: 45%;
            height: 1px;
            background: #e2e8f0;
        }
        
        @media (max-width: 768px) {
            .login-image {
                display: none;
            }
            .login-container {
                max-width: 500px;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <!-- Image section -->
        <div class="login-image">
            <div class="login-image-content">
                <h1>🏨 CVVEN Hôtel</h1>
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

            <form method="post" action="<?= site_url('login') ?>">
                <?= csrf_field() ?>

                <div class="mb-3">
                    <label class="form-label">Login</label>
                    <input type="text" name="user_login" class="form-control" placeholder="Votre identifiant" required autofocus>
                </div>

                <div class="mb-4">
                    <label class="form-label">Mot de passe</label>
                    <input type="password" name="user_mdp" class="form-control" placeholder="Votre mot de passe" required>
                </div>

                <button class="btn btn-login w-100 mb-3">Se connecter</button>
            </form>

            <div class="divider">OU</div>

            <a href="<?= base_url('register') ?>" class="btn btn-register w-100">Créer un compte</a>
            
            <div class="text-center mt-4">
                <a href="<?= base_url('/') ?>" class="text-decoration-none" style="color: var(--accent-color); font-weight: 500;">← Retour à l'accueil</a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
