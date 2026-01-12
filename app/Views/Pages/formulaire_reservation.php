<!DOCTYPE html>
<html>
<head>
    <title>Réservation de Chambre</title>
    <meta charset="UTF-8">
</head>
<body>
    <!-- En-tête de la page -->
    <h1>Réservation de Chambre</h1>

    <!-- Affichage des messages d'erreur généraux -->
    <?php if (session()->getFlashdata('erreur')): ?>
        <div style="color: red;">
            <?= session()->getFlashdata('erreur') ?>
        </div>
    <?php endif; ?>

    <!-- Affichage des erreurs de validation -->
    <?php if (session()->getFlashdata('erreurs')): ?>
        <div style="color: red;">
            <?php foreach (session()->getFlashdata('erreurs') as $erreur): ?>
                <p><?= $erreur ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <!-- Formulaire de réservation -->
    <form method="post" action="<?= site_url('reservation/reserver') ?>">
        
        <!-- Sélection de la chambre -->
        <div>
            <label for="chamb_id">Chambre :</label>
            <select name="chamb_id" id="chamb_id" required>
                <option value="">Sélectionnez une chambre</option>
                <?php foreach ($chambres as $chambre): ?>
                    <option value="<?= $chambre['chamb_id'] ?>">
                        Chambre <?= $chambre['chamb_numero'] ?> - 
                        <?= $chambre['type_libelle'] ?> - 
                        <?= $chambre['chamb_emplacement'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Date de début -->
        <div>
            <label for="reser_dateDebut">Date de début :</label>
            <input type="datetime-local" name="reser_dateDebut" id="reser_dateDebut" required>
        </div>

        <!-- Date de fin -->
        <div>
            <label for="reser_dateFin">Date de fin :</label>
            <input type="datetime-local" name="reser_dateFin" id="reser_dateFin" required>
        </div>

        <!-- Bouton de soumission -->
        <div>
            <button type="submit">Réserver la chambre</button>
        </div>
    </form>

    <!-- Liste des chambres disponibles -->
    <h2>Liste des Chambres Disponibles</h2>
    <table border="1">
        <thead>
            <tr>
                <th>Numéro</th>
                <th>Type</th>
                <th>Emplacement</th>
                <th>Description</th>
                <th>Remarques</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($chambres)): ?>
                <?php foreach ($chambres as $chambre): ?>
                    <tr>
                        <td><?= $chambre['chamb_numero'] ?></td>
                        <td><?= $chambre['type_libelle'] ?></td>
                        <td><?= $chambre['chamb_emplacement'] ?></td>
                        <td><?= $chambre['type_desc'] ?></td>
                        <td><?= $chambre['chamb_remarque'] ?? 'Aucune remarque' ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5">Aucune chambre disponible actuellement</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>