<?= $this->extend('hotel/layout') ?>
<?= $this->section('content') ?>

<!-- ═══════════════════════════════════════════════════════════════
     HERO — Plein écran
═══════════════════════════════════════════════════════════════ -->
<section class="hero-section" style="
    position: relative;
    min-height: 92vh;
    display: flex;
    align-items: center;
    background-image:
        linear-gradient(
            160deg,
            rgba(22, 43, 25, 0.72) 0%,
            rgba(42, 74, 46, 0.55) 50%,
            rgba(22, 43, 25, 0.80) 100%
        ),
        url('<?= base_url('assets/images/hotel/hotelImage.png') ?>');
    background-size: cover;
    background-position: center;
    overflow: hidden;
">
    <!-- Grain overlay -->
    <div style="
        position: absolute; inset: 0;
        background-image: url('data:image/svg+xml,<svg xmlns=\'http://www.w3.org/2000/svg\' width=\'300\' height=\'300\'><filter id=\'n\'><feTurbulence type=\'fractalNoise\' baseFrequency=\'0.9\' numOctaves=\'4\' stitchTiles=\'stitch\'/><feColorMatrix type=\'saturate\' values=\'0\'/></filter><rect width=\'300\' height=\'300\' filter=\'url(%23n)\' opacity=\'0.04\'/></svg>');
        pointer-events: none; z-index: 1;
    "></div>

    <!-- Decorative mountain silhouette bottom -->
    <div style="position:absolute;bottom:0;left:0;right:0;z-index:2;line-height:0;">
        <svg viewBox="0 0 1440 90" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none" style="width:100%;height:90px;fill:#EDE8DC;">
            <path d="M0,90 L0,65 L120,30 L240,55 L360,15 L480,48 L560,5 L650,40 L740,10 L840,45 L940,8 L1050,42 L1150,18 L1260,50 L1360,25 L1440,48 L1440,90 Z"/>
        </svg>
    </div>

    <div class="container position-relative" style="z-index: 3;">
        <div class="row align-items-center">
            <div class="col-lg-7">

                <!-- Label -->
                <div class="d-flex align-items-center gap-2 mb-4">
                    <div style="width:40px;height:2px;background:linear-gradient(90deg,#C9B07A,#B8860B);border-radius:2px;"></div>
                    <span style="font-family:'Outfit',sans-serif;font-size:0.72rem;font-weight:600;letter-spacing:0.16em;text-transform:uppercase;color:#C9B07A;">
                        Éducation Nationale
                    </span>
                </div>

                <h1 style="
                    font-family:'Cormorant Garamond',Georgia,serif;
                    font-size: clamp(2.8rem, 7vw, 5rem);
                    font-weight: 700;
                    color: #F8F5EE;
                    line-height: 1.08;
                    margin-bottom: 1.25rem;
                    text-shadow: 0 2px 20px rgba(0,0,0,0.3);
                ">
                    Villages de Vacances<br>
                    <em style="font-style:italic;color:#E8D8A8;">en montagne</em>
                </h1>

                <p style="
                    font-family:'Outfit',sans-serif;
                    font-size: 1.05rem;
                    font-weight: 300;
                    color: rgba(255,255,255,0.78);
                    max-width: 500px;
                    line-height: 1.8;
                    margin-bottom: 2.5rem;
                ">
                    Le CVVEN vous offre des séjours d'exception dans nos chalets alpins.
                    Réservez votre hébergement parmi nos différents types de chambres.
                </p>

                <div class="d-flex flex-wrap gap-3">
                    <a href="#types-section"
                       style="
                            display:inline-flex;align-items:center;gap:8px;
                            background:linear-gradient(135deg,#C9B07A,#B8860B);
                            color:#162B19;font-family:'Outfit',sans-serif;font-weight:600;
                            font-size:0.9rem;letter-spacing:0.05em;
                            padding:0.85rem 2rem;border-radius:6px;text-decoration:none;
                            box-shadow:0 6px 20px rgba(184,134,11,0.35);
                            transition:all 0.3s;
                       "
                       onmouseover="this.style.transform='translateY(-2px)';this.style.boxShadow='0 10px 28px rgba(184,134,11,0.45)'"
                       onmouseout="this.style.transform='';this.style.boxShadow='0 6px 20px rgba(184,134,11,0.35)'">
                        <i class="bi bi-grid-3x3-gap"></i>
                        Découvrir nos hébergements
                    </a>
                    <?php if (!session()->get('isLoggedIn')): ?>
                    <a href="<?= base_url('login') ?>"
                       style="
                            display:inline-flex;align-items:center;gap:8px;
                            background:transparent;
                            border:1.5px solid rgba(255,255,255,0.4);
                            color:rgba(255,255,255,0.88);font-family:'Outfit',sans-serif;font-weight:500;
                            font-size:0.9rem;letter-spacing:0.05em;
                            padding:0.85rem 1.75rem;border-radius:6px;text-decoration:none;
                            transition:all 0.3s;
                       "
                       onmouseover="this.style.background='rgba(255,255,255,0.1)';this.style.borderColor='rgba(255,255,255,0.7)'"
                       onmouseout="this.style.background='transparent';this.style.borderColor='rgba(255,255,255,0.4)'">
                        <i class="bi bi-box-arrow-in-right"></i>
                        Se connecter
                    </a>
                    <?php endif; ?>
                </div>

            </div>

            <!-- Stats bubble (right side) -->
            <div class="col-lg-4 offset-lg-1 d-none d-lg-block">
                <div style="
                    background:rgba(248,245,238,0.07);
                    backdrop-filter:blur(12px);
                    border:1px solid rgba(201,176,122,0.25);
                    border-radius:16px;
                    padding:2rem;
                ">
                    <div style="
                        width:48px;height:48px;
                        background:linear-gradient(135deg,#C9B07A,#B8860B);
                        border-radius:10px;
                        display:flex;align-items:center;justify-content:center;
                        font-size:1.4rem;color:#162B19;
                        margin-bottom:1.25rem;
                    ">🏔️</div>
                    <p style="font-family:'Cormorant Garamond',serif;font-size:1.5rem;font-weight:600;color:#E8D8A8;line-height:1.3;margin-bottom:1rem;">
                        Un cadre naturel<br>exceptionnel
                    </p>
                    <div style="display:flex;flex-direction:column;gap:0.75rem;">
                        <?php
                        $items = [
                            ['bi-snow', 'Chalets & hébergements alpins'],
                            ['bi-tree', 'Au cœur des forêts de montagne'],
                            ['bi-stars', 'Réservé aux agents de l\'Éducation Nationale'],
                        ];
                        foreach ($items as $item): ?>
                        <div style="display:flex;align-items:center;gap:10px;">
                            <div style="
                                width:28px;height:28px;
                                background:rgba(201,176,122,0.15);
                                border-radius:6px;
                                display:flex;align-items:center;justify-content:center;
                                color:#C9B07A;font-size:0.8rem;flex-shrink:0;
                            ">
                                <i class="bi <?= $item[0] ?>"></i>
                            </div>
                            <span style="font-size:0.82rem;color:rgba(255,255,255,0.7);font-family:'Outfit',sans-serif;">
                                <?= $item[1] ?>
                            </span>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════════════
     TYPES DE CHAMBRES
═══════════════════════════════════════════════════════════════ -->
<section id="types-section" style="background-color:#EDE8DC;padding:5rem 0;">
    <div class="container">

        <!-- Section header -->
        <div class="text-center mb-5">
            <span style="font-family:'Outfit',sans-serif;font-size:0.72rem;font-weight:600;letter-spacing:0.16em;text-transform:uppercase;color:#C9B07A;display:block;margin-bottom:0.5rem;">
                Nos hébergements
            </span>
            <h2 style="font-family:'Cormorant Garamond',serif;font-size:clamp(2rem,4vw,3rem);font-weight:700;color:#162B19;margin-bottom:0.5rem;">
                Types de chambres disponibles
            </h2>
            <div style="width:52px;height:2px;background:linear-gradient(90deg,#C9B07A,#B8860B);border-radius:2px;margin:0.75rem auto 1rem;"></div>
            <p style="color:#7A7265;font-family:'Outfit',sans-serif;font-weight:300;font-size:1rem;max-width:500px;margin:0 auto;">
                Choisissez le type d'hébergement adapté à votre séjour et vérifiez la disponibilité
            </p>
        </div>

        <!-- Cards grid -->
        <?php if (!empty($types)): ?>
        <div class="row g-4">
            <?php foreach ($types as $index => $type): ?>
                <?php
                $imagePath = '';
                $extensions = ['jpg', 'jpeg', 'png', 'webp'];
                foreach ($extensions as $ext) {
                    $checkPath = FCPATH . 'assets/images/chambres/type' . $type['type_id'] . '.' . $ext;
                    if (file_exists($checkPath)) {
                        $imagePath = base_url('assets/images/chambres/type' . $type['type_id'] . '.' . $ext);
                        break;
                    }
                }
                if (empty($imagePath)) {
                    $imagePath = 'https://placehold.co/640x400/2A4A2E/E8D8A8?text=' . urlencode($type['type_libelle']);
                }
                ?>
                <div class="col-md-6 col-lg-4">
                    <div class="card card-lift h-100"
                         style="border:1px solid #DDD8CD;border-radius:14px;overflow:hidden;background:#F8F5EE;box-shadow:0 2px 8px rgba(22,43,25,0.08);transition:all 0.35s cubic-bezier(0.4,0,0.2,1);"
                         onmouseover="this.style.transform='translateY(-6px)';this.style.boxShadow='0 16px 40px rgba(22,43,25,0.16)'"
                         onmouseout="this.style.transform='';this.style.boxShadow='0 2px 8px rgba(22,43,25,0.08)'">

                        <!-- Image -->
                        <div style="position:relative;overflow:hidden;height:220px;">
                            <img src="<?= $imagePath ?>"
                                 alt="<?= esc($type['type_libelle']) ?>"
                                 style="width:100%;height:100%;object-fit:cover;transition:transform 0.5s ease;"
                                 onmouseover="this.style.transform='scale(1.06)'"
                                 onmouseout="this.style.transform='scale(1)'">
                            <!-- Type badge -->
                            <div style="position:absolute;top:14px;left:14px;">
                                <span style="
                                    background:rgba(22,43,25,0.82);
                                    backdrop-filter:blur(8px);
                                    color:#E8D8A8;
                                    font-family:'Outfit',sans-serif;
                                    font-size:0.68rem;font-weight:600;
                                    letter-spacing:0.1em;text-transform:uppercase;
                                    padding:0.3rem 0.75rem;border-radius:50px;
                                    border:1px solid rgba(201,176,122,0.3);
                                ">
                                    <?= esc($type['type_libelle']) ?>
                                </span>
                            </div>
                        </div>

                        <!-- Content -->
                        <div style="padding:1.5rem 1.75rem 1.75rem;display:flex;flex-direction:column;flex:1;">
                            <h3 style="font-family:'Cormorant Garamond',serif;font-size:1.5rem;font-weight:700;color:#162B19;margin-bottom:0.6rem;line-height:1.2;">
                                <?= esc($type['type_libelle']) ?>
                            </h3>
                            <p style="font-family:'Outfit',sans-serif;font-size:0.875rem;color:#7A7265;font-weight:300;line-height:1.7;flex:1;margin-bottom:1.5rem;">
                                <?= esc($type['type_desc']) ?>
                            </p>
                            <button type="button"
                                    data-bs-toggle="modal"
                                    data-bs-target="#dateModal<?= $type['type_id'] ?>"
                                    style="
                                        display:flex;align-items:center;justify-content:center;gap:8px;
                                        width:100%;
                                        background:linear-gradient(135deg,#2A4A2E,#3A6341);
                                        border:none;
                                        color:#fff;
                                        font-family:'Outfit',sans-serif;font-weight:500;
                                        font-size:0.875rem;letter-spacing:0.04em;
                                        padding:0.75rem;border-radius:8px;
                                        cursor:pointer;
                                        transition:all 0.3s;
                                    "
                                    onmouseover="this.style.background='linear-gradient(135deg,#162B19,#2A4A2E)';this.style.color='#E8D8A8'"
                                    onmouseout="this.style.background='linear-gradient(135deg,#2A4A2E,#3A6341)';this.style.color='#fff'">
                                <i class="bi bi-calendar-check"></i>
                                Vérifier la disponibilité
                            </button>
                        </div>

                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <?php else: ?>
        <div class="text-center py-5">
            <i class="bi bi-house-door" style="font-size:3rem;color:#DDD8CD;display:block;margin-bottom:1rem;"></i>
            <p style="color:#7A7265;">Aucun type de chambre disponible pour le moment.</p>
        </div>
        <?php endif; ?>

    </div>
</section>


<!-- ═══════════════════════════════════════════════════════════════
     MODALS — Sélection des dates par type
═══════════════════════════════════════════════════════════════ -->
<?php foreach ($types as $type): ?>
<div class="modal fade" id="dateModal<?= $type['type_id'] ?>" tabindex="-1"
     aria-labelledby="dateModalLabel<?= $type['type_id'] ?>" aria-hidden="true"
     x-data="{
         dateDebut: '',
         dateFin: '',
         get nuits() {
             if (!this.dateDebut || !this.dateFin) return 0;
             const d1 = new Date(this.dateDebut);
             const d2 = new Date(this.dateFin);
             return Math.max(0, Math.ceil((d2 - d1) / (1000 * 60 * 60 * 24)));
         },
         get isValid() { return this.dateDebut && this.dateFin && this.nuits > 0; }
     }">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="dateModalLabel<?= $type['type_id'] ?>">
                    <i class="bi bi-calendar-check me-2"></i><?= esc($type['type_libelle']) ?>
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?= base_url('disponibilite/' . $type['type_id']) ?>" method="get">
                <div class="modal-body">
                    <p style="color:#7A7265;font-size:0.875rem;margin-bottom:1.5rem;">
                        <?= esc($type['type_desc']) ?>
                    </p>

                    <div class="mb-3">
                        <label for="date_debut<?= $type['type_id'] ?>" class="form-label">
                            <i class="bi bi-calendar-event me-1"></i>Date d'arrivée
                        </label>
                        <input type="date"
                               class="form-control"
                               id="date_debut<?= $type['type_id'] ?>"
                               name="date_debut"
                               x-model="dateDebut"
                               min="<?= date('Y-m-d') ?>"
                               required>
                    </div>

                    <div class="mb-3">
                        <label for="date_fin<?= $type['type_id'] ?>" class="form-label">
                            <i class="bi bi-calendar-check me-1"></i>Date de départ
                        </label>
                        <input type="date"
                               class="form-control"
                               id="date_fin<?= $type['type_id'] ?>"
                               name="date_fin"
                               x-model="dateFin"
                               :min="dateDebut || '<?= date('Y-m-d', strtotime('+1 day')) ?>'"
                               required>
                    </div>

                    <div x-show="nuits > 0" x-transition class="alert alert-success">
                        <i class="bi bi-moon-stars me-2"></i>
                        <strong x-text="nuits"></strong>
                        <span x-text="nuits > 1 ? ' nuits sélectionnées' : ' nuit sélectionnée'"></span>
                    </div>

                    <div class="alert alert-info">
                        <i class="bi bi-info-circle me-2"></i>
                        Sélectionnez vos dates pour voir les hébergements disponibles
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        Annuler
                    </button>
                    <button type="submit" class="btn btn-primary px-4" :disabled="!isValid">
                        <span x-show="isValid">
                            <i class="bi bi-search me-1"></i>Rechercher
                        </span>
                        <span x-show="!isValid">Sélectionnez les dates</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php endforeach; ?>


<!-- ═══════════════════════════════════════════════════════════════
     ATOUTS
═══════════════════════════════════════════════════════════════ -->
<section style="background:linear-gradient(135deg,#162B19 0%,#2A4A2E 100%);padding:5rem 0;position:relative;overflow:hidden;">
    <!-- Decorative dots -->
    <div style="position:absolute;top:-40px;right:-40px;width:200px;height:200px;border-radius:50%;background:rgba(201,176,122,0.06);pointer-events:none;"></div>
    <div style="position:absolute;bottom:-60px;left:-30px;width:250px;height:250px;border-radius:50%;background:rgba(201,176,122,0.04);pointer-events:none;"></div>

    <div class="container position-relative">

        <div class="text-center mb-5">
            <span style="font-family:'Outfit',sans-serif;font-size:0.72rem;font-weight:600;letter-spacing:0.16em;text-transform:uppercase;color:#C9B07A;display:block;margin-bottom:0.5rem;">
                Pourquoi nous choisir
            </span>
            <h2 style="font-family:'Cormorant Garamond',serif;font-size:clamp(1.8rem,3.5vw,2.8rem);font-weight:700;color:#F8F5EE;margin-bottom:0;">
                L'expérience CVVEN
            </h2>
        </div>

        <div class="row g-4" x-data="{ active: null }">
            <?php
            $features = [
                ['bi-house-heart',   'Hébergements d\'exception',   'Chalets authentiques et confortables, décorés avec soin dans un style montagnard raffiné.'],
                ['bi-tree',          'Cadre naturel préservé',      'Niché au cœur des forêts alpines, loin du tumulte, pour un ressourcement complet.'],
                ['bi-snow2',         'Activités toutes saisons',    'Ski, randonnée, spa de montagne — des activités pour chaque saison et chaque âge.'],
                ['bi-shield-check',  'Réservé à l\'Éducation',      'Un service exclusif pour les agents de l\'Éducation Nationale et leurs familles.'],
            ];
            foreach ($features as $i => $f):
            ?>
            <div class="col-md-6 col-lg-3"
                 x-on:mouseenter="active = <?= $i ?>"
                 x-on:mouseleave="active = null">
                <div style="
                    background:rgba(248,245,238,0.05);
                    border:1px solid rgba(201,176,122,0.18);
                    border-radius:12px;
                    padding:1.75rem;
                    transition:all 0.35s;
                    height:100%;
                " :style="active === <?= $i ?> ? 'background:rgba(201,176,122,0.1);border-color:rgba(201,176,122,0.4);transform:translateY(-4px);' : ''">
                    <div style="
                        width:48px;height:48px;
                        background:linear-gradient(135deg,rgba(201,176,122,0.2),rgba(184,134,11,0.15));
                        border:1px solid rgba(201,176,122,0.3);
                        border-radius:10px;
                        display:flex;align-items:center;justify-content:center;
                        font-size:1.25rem;color:#C9B07A;
                        margin-bottom:1.25rem;
                        transition:all 0.35s;
                    " :style="active === <?= $i ?> ? 'background:linear-gradient(135deg,#C9B07A,#B8860B);color:#162B19;border-color:transparent;' : ''">
                        <i class="bi <?= $f[0] ?>"></i>
                    </div>
                    <h5 style="font-family:'Cormorant Garamond',serif;font-size:1.2rem;font-weight:600;color:#E8D8A8;margin-bottom:0.6rem;">
                        <?= $f[1] ?>
                    </h5>
                    <p style="font-family:'Outfit',sans-serif;font-size:0.845rem;color:rgba(255,255,255,0.55);font-weight:300;line-height:1.7;margin:0;">
                        <?= $f[2] ?>
                    </p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>


<!-- ═══════════════════════════════════════════════════════════════
     CTA
═══════════════════════════════════════════════════════════════ -->
<section style="background-color:#F8F5EE;padding:5rem 0;">
    <div class="container">
        <div style="
            background:linear-gradient(135deg,#2A4A2E 0%,#3A6341 100%);
            border-radius:20px;
            padding:4rem;
            text-align:center;
            position:relative;
            overflow:hidden;
            box-shadow:0 20px 60px rgba(22,43,25,0.2);
        ">
            <!-- Decorative -->
            <div style="position:absolute;top:-30px;left:-30px;width:180px;height:180px;border-radius:50%;background:rgba(255,255,255,0.04);pointer-events:none;"></div>
            <div style="position:absolute;bottom:-40px;right:-20px;width:220px;height:220px;border-radius:50%;background:rgba(201,176,122,0.08);pointer-events:none;"></div>

            <div style="position:relative;z-index:1;">
                <span style="font-family:'Outfit',sans-serif;font-size:0.72rem;font-weight:600;letter-spacing:0.16em;text-transform:uppercase;color:#C9B07A;display:block;margin-bottom:0.75rem;">
                    Prêt pour l'aventure ?
                </span>
                <h2 style="font-family:'Cormorant Garamond',serif;font-size:clamp(1.8rem,4vw,3rem);font-weight:700;color:#F8F5EE;margin-bottom:1rem;line-height:1.2;">
                    Réservez votre séjour alpin
                </h2>
                <p style="font-family:'Outfit',sans-serif;font-size:0.95rem;color:rgba(255,255,255,0.65);font-weight:300;max-width:480px;margin:0 auto 2rem;line-height:1.8;">
                    Connectez-vous pour accéder à nos hébergements et profiter de tarifs préférentiels réservés aux agents de l'Éducation Nationale.
                </p>
                <div class="d-flex justify-content-center flex-wrap gap-3">
                    <?php if (!session()->get('isLoggedIn')): ?>
                    <a href="<?= base_url('login') ?>"
                       style="
                            display:inline-flex;align-items:center;gap:8px;
                            background:linear-gradient(135deg,#C9B07A,#B8860B);
                            color:#162B19;font-family:'Outfit',sans-serif;font-weight:600;
                            font-size:0.9rem;letter-spacing:0.05em;
                            padding:0.85rem 2rem;border-radius:6px;text-decoration:none;
                            box-shadow:0 6px 20px rgba(184,134,11,0.35);
                            transition:all 0.3s;
                       "
                       onmouseover="this.style.transform='translateY(-2px)'"
                       onmouseout="this.style.transform=''">
                        <i class="bi bi-box-arrow-in-right"></i>
                        Me connecter
                    </a>
                    <?php else: ?>
                    <a href="<?= base_url('reservation') ?>"
                       style="
                            display:inline-flex;align-items:center;gap:8px;
                            background:linear-gradient(135deg,#C9B07A,#B8860B);
                            color:#162B19;font-family:'Outfit',sans-serif;font-weight:600;
                            font-size:0.9rem;letter-spacing:0.05em;
                            padding:0.85rem 2rem;border-radius:6px;text-decoration:none;
                            box-shadow:0 6px 20px rgba(184,134,11,0.35);
                            transition:all 0.3s;
                       "
                       onmouseover="this.style.transform='translateY(-2px)'"
                       onmouseout="this.style.transform=''">
                        <i class="bi bi-calendar-plus"></i>
                        Faire une réservation
                    </a>
                    <?php endif; ?>
                    <a href="#types-section"
                       style="
                            display:inline-flex;align-items:center;gap:8px;
                            background:transparent;
                            border:1.5px solid rgba(255,255,255,0.35);
                            color:rgba(255,255,255,0.85);font-family:'Outfit',sans-serif;font-weight:500;
                            font-size:0.9rem;letter-spacing:0.04em;
                            padding:0.85rem 1.75rem;border-radius:6px;text-decoration:none;
                            transition:all 0.3s;
                       "
                       onmouseover="this.style.background='rgba(255,255,255,0.08)';this.style.borderColor='rgba(255,255,255,0.6)'"
                       onmouseout="this.style.background='transparent';this.style.borderColor='rgba(255,255,255,0.35)'">
                        <i class="bi bi-grid-3x3-gap"></i>
                        Voir les hébergements
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection() ?>
