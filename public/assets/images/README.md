# Images de l'Hôtel CVVEN

## Structure des dossiers

- **chambres/** - Images des chambres (photos individuelles des chambres)
- **hotel/** - Images générales de l'hôtel (façade, lobby, restaurant, piscine, etc.)

## Utilisation

Pour afficher une image dans vos vues CodeIgniter :

```php
<!-- Image de chambre -->
<img src="<?= base_url('assets/images/chambres/chambre1.jpg') ?>" alt="Chambre 1">

<!-- Image de l'hôtel -->
<img src="<?= base_url('assets/images/hotel/facade.jpg') ?>" alt="Façade de l'hôtel">
```

## Formats recommandés

- Format : JPG, PNG, WebP
- Résolution : 1920x1080 pour les grandes images, 800x600 pour les vignettes
- Optimisation : Compresser les images pour améliorer les performances
