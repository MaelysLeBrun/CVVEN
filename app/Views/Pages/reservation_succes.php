<!DOCTYPE html>
<html>
<head>
    <title>Réservation Confirmée</title>
    <meta charset="UTF-8">
</head>
<body>
    <!-- Message de confirmation -->
    <h1>Réservation Confirmée !</h1>
    <p>Votre réservation a été enregistrée avec succès.</p>
    
    <!-- Liens de navigation -->
    <div>
        <a href="<?= site_url('reservation') ?>">Faire une nouvelle réservation</a> | 
        <a href="<?= site_url('dashboard') ?>">Retour au tableau de bord</a>
    </div>
</body>
</html>