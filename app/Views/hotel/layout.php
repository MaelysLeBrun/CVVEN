<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Réservation Hôtel CVVEN</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <nav class="navbar navbar-dark bg-primary mb-4">
        <div class="container">
            <a class="navbar-brand" href="<?= base_url('/') ?>">CVVEN Réservation</a>
        </div>
    </nav>
    <div class="container">
        <?= $this->renderSection('content') ?>
    </div>
</body>
</html>