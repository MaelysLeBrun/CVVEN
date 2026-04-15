<?= $this->extend('hotel/layout') ?>
<?= $this->section('content') ?>

<!-- Page header -->
<div class="page-header">
    <div class="container">
        <a href="<?= base_url('/') ?>"
           style="display:inline-flex;align-items:center;gap:6px;color:rgba(255,255,255,0.6);font-size:0.85rem;font-family:'Outfit',sans-serif;text-decoration:none;margin-bottom:1rem;transition:color 0.3s;"
           onmouseover="this.style.color='#E8D8A8'"
           onmouseout="this.style.color='rgba(255,255,255,0.6)'">
            <i class="bi bi-arrow-left"></i> Retour à l'accueil
        </a>
        <h1>Formulaire de Réservation</h1>
        <p class="lead">Complétez les informations pour finaliser votre séjour</p>
    </div>
</div>

<div style="background-color:#EDE8DC;padding:3rem 0;min-height:60vh;">
    <div class="container">

        <!-- Error messages -->
        <?php if (session()->getFlashdata('erreur')): ?>
        <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
            <i class="bi bi-exclamation-triangle me-2"></i><?= session()->getFlashdata('erreur') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('erreurs')): ?>
        <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
            <strong><i class="bi bi-exclamation-circle me-2"></i>Erreurs :</strong>
            <ul class="mb-0 mt-2">
                <?php foreach (session()->getFlashdata('erreurs') as $erreur): ?>
                    <li><?= esc($erreur) ?></li>
                <?php endforeach; ?>
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php endif; ?>

        <?php
        $chambresPrix = [];
        foreach ($chambres as $c) {
            $chambresPrix[$c['chamb_id']] = (float)($c['prix_unitaire_nuit'] ?? 0);
        }
        ?>
        <div class="row g-4" x-data="{
            dateDebut: '<?= esc($dateDebut ?? '') ?>',
            dateFin: '<?= esc($dateFin ?? '') ?>',
            chambreId: '<?= esc($chambreSelectionnee ?? '') ?>',
            chambresPrix: <?= json_encode($chambresPrix) ?>,
            typePension: 'sans_pension',
            pensionPrix: { 'pension_complete': 100, 'demi_pension': 50, 'sans_pension': 0 },
            disponible: null,
            checking: false,
            get nuits() {
                if (!this.dateDebut || !this.dateFin) return 0;
                const d1 = new Date(this.dateDebut);
                const d2 = new Date(this.dateFin);
                return Math.max(0, Math.ceil((d2 - d1) / (1000 * 60 * 60 * 24)));
            },
            get prixUnitaire() {
                return this.chambreId ? (this.chambresPrix[this.chambreId] || 0) : 0;
            },
            get prixPension() {
                return this.pensionPrix[this.typePension] || 0;
            },
            get prixTotal() {
                return (this.prixUnitaire + this.prixPension) * this.nuits;
            },
            async checkDisponibilite() {
                if (!this.chambreId || !this.dateDebut || !this.dateFin) {
                    this.disponible = null; return;
                }
                this.checking = true;
                try {
                    const response = await fetch('<?= site_url('reservation/checkDisponibilite') ?>', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/x-www-form-urlencoded', 'X-Requested-With': 'XMLHttpRequest' },
                        body: new URLSearchParams({ chamb_id: this.chambreId, dateDebut: this.dateDebut, dateFin: this.dateFin })
                    });
                    const data = await response.json();
                    this.disponible = data.disponible;
                } catch (error) {
                    this.disponible = false;
                } finally {
                    this.checking = false;
                }
            }
        }" @change="checkDisponibilite()"
           x-init="if (chambreId && dateDebut && dateFin) checkDisponibilite()">

            <!-- Main form -->
            <div class="col-lg-8">
                <div style="background:#F8F5EE;border:1px solid #DDD8CD;border-radius:16px;overflow:hidden;box-shadow:0 4px 16px rgba(22,43,25,0.08);">

                    <!-- Form header -->
                    <div style="background:linear-gradient(135deg,#162B19,#2A4A2E);padding:1.5rem 2rem;border-bottom:2px solid rgba(201,176,122,0.3);">
                        <div style="display:flex;align-items:center;gap:10px;">
                            <div style="width:38px;height:38px;background:rgba(201,176,122,0.2);border:1px solid rgba(201,176,122,0.4);border-radius:8px;display:flex;align-items:center;justify-content:center;color:#C9B07A;">
                                <i class="bi bi-calendar-plus"></i>
                            </div>
                            <div>
                                <div style="font-family:'Cormorant Garamond',serif;font-size:1.2rem;font-weight:600;color:#F8F5EE;">Votre Réservation</div>
                                <div style="font-family:'Outfit',sans-serif;font-size:0.72rem;color:rgba(255,255,255,0.5);letter-spacing:0.04em;">Tous les champs sont requis</div>
                            </div>
                        </div>
                    </div>

                    <div style="padding:2rem;">
                        <form method="post" action="<?= site_url('reservation/reserver') ?>">
                            <?= csrf_field() ?>

                            <!-- Coordonnées -->
                            <div style="font-family:'Outfit',sans-serif;font-size:0.72rem;font-weight:600;letter-spacing:0.12em;text-transform:uppercase;color:#7A7265;display:flex;align-items:center;gap:8px;margin-bottom:1rem;">
                                <div style="width:24px;height:24px;background:#EDE8DC;border-radius:6px;display:flex;align-items:center;justify-content:center;color:#C9B07A;font-size:0.75rem;">
                                    <i class="bi bi-person"></i>
                                </div>
                                Vos coordonnées
                            </div>

                            <div class="row g-3 mb-4">
                                <div class="col-md-6">
                                    <label class="form-label">Nom</label>
                                    <input type="text" class="form-control"
                                           value="<?= esc($user['user_nom'] ?? '') ?>" disabled
                                           style="background:#EDE8DC;cursor:not-allowed;">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Prénom</label>
                                    <input type="text" class="form-control"
                                           value="<?= esc($user['user_prenom'] ?? '') ?>" disabled
                                           style="background:#EDE8DC;cursor:not-allowed;">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Email</label>
                                    <input type="email" class="form-control"
                                           value="<?= esc($user['user_mail'] ?? '') ?>" disabled
                                           style="background:#EDE8DC;cursor:not-allowed;">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Téléphone</label>
                                    <input type="tel" class="form-control"
                                           value="<?= esc($user['user_telephone'] ?? '') ?>" disabled
                                           style="background:#EDE8DC;cursor:not-allowed;">
                                </div>
                            </div>

                            <hr style="border-color:#EDE8DC;margin:1.75rem 0;">

                            <!-- Dates -->
                            <div style="font-family:'Outfit',sans-serif;font-size:0.72rem;font-weight:600;letter-spacing:0.12em;text-transform:uppercase;color:#7A7265;display:flex;align-items:center;gap:8px;margin-bottom:1rem;">
                                <div style="width:24px;height:24px;background:#EDE8DC;border-radius:6px;display:flex;align-items:center;justify-content:center;color:#C9B07A;font-size:0.75rem;">
                                    <i class="bi bi-calendar3"></i>
                                </div>
                                Dates du séjour
                            </div>

                            <div class="row g-3 mb-3">
                                <div class="col-md-6">
                                    <label for="reser_dateDebut" class="form-label">Arrivée</label>
                                    <input type="datetime-local"
                                           name="reser_dateDebut"
                                           id="reser_dateDebut"
                                           class="form-control"
                                           x-model="dateDebut"
                                           min="<?= date('Y-m-d\TH:i') ?>"
                                           required>
                                </div>
                                <div class="col-md-6">
                                    <label for="reser_dateFin" class="form-label">Départ</label>
                                    <input type="datetime-local"
                                           name="reser_dateFin"
                                           id="reser_dateFin"
                                           class="form-control"
                                           x-model="dateFin"
                                           :min="dateDebut || '<?= date('Y-m-d\TH:i', strtotime('+1 day')) ?>'"
                                           required>
                                </div>
                            </div>

                            <div x-show="nuits > 0" x-transition
                                 style="background:rgba(201,176,122,0.12);border:1px solid #C9B07A;border-left:4px solid #C9B07A;border-radius:8px;padding:0.85rem 1rem;margin-bottom:1.25rem;font-family:'Outfit',sans-serif;font-size:0.875rem;color:#6B4226;">
                                <i class="bi bi-moon-stars me-2"></i>
                                <strong>Durée du séjour :</strong>
                                <span x-text="nuits"></span>
                                <span x-text="nuits > 1 ? ' nuits' : ' nuit'"></span>
                            </div>

                            <hr style="border-color:#EDE8DC;margin:1.75rem 0;">

                            <!-- Room selection -->
                            <div style="font-family:'Outfit',sans-serif;font-size:0.72rem;font-weight:600;letter-spacing:0.12em;text-transform:uppercase;color:#7A7265;display:flex;align-items:center;gap:8px;margin-bottom:1rem;">
                                <div style="width:24px;height:24px;background:#EDE8DC;border-radius:6px;display:flex;align-items:center;justify-content:center;color:#C9B07A;font-size:0.75rem;">
                                    <i class="bi bi-house"></i>
                                </div>
                                Choix de la chambre
                            </div>

                            <select name="chamb_id"
                                    id="chamb_id"
                                    class="form-select mb-3"
                                    x-model="chambreId"
                                    required>
                                <option value="">— Choisissez une chambre —</option>
                                <?php foreach ($chambres as $chambre): ?>
                                    <option value="<?= esc($chambre['chamb_id']) ?>"
                                        <?= ($chambreSelectionnee ?? '') === $chambre['chamb_id'] ? 'selected' : '' ?>>
                                        Chambre <?= esc($chambre['chamb_numero']) ?> — <?= esc($chambre['type_libelle']) ?> — <?= esc($chambre['chamb_emplacement']) ?><?= !empty($chambre['prix_unitaire_nuit']) ? ' — ' . number_format($chambre['prix_unitaire_nuit'], 2, ',', ' ') . ' €/nuit' : '' ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>

                            <hr style="border-color:#EDE8DC;margin:1.75rem 0;">

                            <!-- Pension -->
                            <div style="font-family:'Outfit',sans-serif;font-size:0.72rem;font-weight:600;letter-spacing:0.12em;text-transform:uppercase;color:#7A7265;display:flex;align-items:center;gap:8px;margin-bottom:1rem;">
                                <div style="width:24px;height:24px;background:#EDE8DC;border-radius:6px;display:flex;align-items:center;justify-content:center;color:#C9B07A;font-size:0.75rem;">
                                    <i class="bi bi-cup-hot"></i>
                                </div>
                                Type de pension
                            </div>

                            <div class="row g-2 mb-3">
                                <?php
                                $pensions = [
                                    'sans_pension'     => ['label' => 'Sans pension',     'sub' => 'Repas non inclus',              'prix' => '0 €/nuit',   'icon' => 'bi-slash-circle',    'color' => '#7A7265', 'bg' => 'rgba(122,114,101,0.08)', 'border' => '#DDD8CD'],
                                    'demi_pension'     => ['label' => 'Demi-pension',      'sub' => 'Petit-déjeuner + dîner inclus', 'prix' => '+ 50 €/nuit','icon' => 'bi-cup-straw',       'color' => '#1e5a7a', 'bg' => 'rgba(44,110,138,0.08)',  'border' => 'rgba(44,110,138,0.35)'],
                                    'pension_complete' => ['label' => 'Pension complète',  'sub' => 'Tous les repas inclus',         'prix' => '+ 100 €/nuit','icon'=> 'bi-brightness-high', 'color' => '#6B4226', 'bg' => 'rgba(184,134,11,0.08)',  'border' => 'rgba(201,176,122,0.5)'],
                                ];
                                foreach ($pensions as $val => $p): ?>
                                <div class="col-md-4">
                                    <label style="display:block;cursor:pointer;position:relative;">
                                        <input type="radio" name="type_pension" value="<?= $val ?>"
                                               x-model="typePension"
                                               style="position:absolute;opacity:0;width:0;height:0;">
                                        <div style="border-radius:10px;padding:0.85rem 0.9rem;transition:all 0.2s;position:relative;"
                                             :style="{
                                                 border:      typePension === '<?= $val ?>' ? '2px solid <?= $p['color'] ?>' : '2px solid <?= $p['border'] ?>',
                                                 background:  typePension === '<?= $val ?>' ? '<?= $p['bg'] ?>'              : 'transparent',
                                                 'box-shadow': typePension === '<?= $val ?>' ? '0 0 0 3px <?= $p['bg'] ?>'   : 'none'
                                             }">
                                            <!-- Checkmark -->
                                            <div x-show="typePension === '<?= $val ?>'"
                                                 style="position:absolute;top:-9px;right:-9px;width:20px;height:20px;
                                                        background:<?= $p['color'] ?>;border-radius:50%;
                                                        display:flex;align-items:center;justify-content:center;
                                                        border:2px solid #F8F5EE;">
                                                <i class="bi bi-check" style="color:#fff;font-size:0.7rem;line-height:1;"></i>
                                            </div>
                                            <div style="display:flex;align-items:center;gap:7px;margin-bottom:0.3rem;">
                                                <i class="bi <?= $p['icon'] ?>" style="color:<?= $p['color'] ?>;font-size:0.9rem;"></i>
                                                <span style="font-family:'Outfit',sans-serif;font-size:0.82rem;font-weight:600;color:#2C2416;">
                                                    <?= $p['label'] ?>
                                                </span>
                                            </div>
                                            <div style="font-family:'Outfit',sans-serif;font-size:0.7rem;color:#7A7265;margin-bottom:0.3rem;">
                                                <?= $p['sub'] ?>
                                            </div>
                                            <div style="font-family:'Cormorant Garamond',serif;font-size:0.9rem;font-weight:700;color:<?= $p['color'] ?>;">
                                                <?= $p['prix'] ?>
                                            </div>
                                        </div>
                                    </label>
                                </div>
                                <?php endforeach; ?>
                            </div>

                            <!-- Price summary -->
                            <div x-show="prixUnitaire > 0" x-transition
                                 style="background:#F8F5EE;border:2px solid #C9B07A;border-radius:10px;padding:1.1rem 1.25rem;margin-bottom:1rem;display:flex;justify-content:space-between;align-items:center;gap:1rem;">
                                <div>
                                    <div style="font-family:'Outfit',sans-serif;font-size:0.7rem;font-weight:600;letter-spacing:0.1em;text-transform:uppercase;color:#7A7265;margin-bottom:0.35rem;">
                                        <i class="bi bi-tag me-1" style="color:#C9B07A;"></i>Prix estimé
                                    </div>
                                    <div style="font-family:'Outfit',sans-serif;font-size:0.78rem;color:#5A5248;line-height:1.6;">
                                        <span x-text="prixUnitaire.toFixed(2).replace('.',',') + ' € chambre'"></span><br>
                                        <span x-show="prixPension > 0" x-text="'+ ' + prixPension.toFixed(2).replace('.',',') + ' € pension'"></span>
                                        <span x-show="nuits > 0" x-text="' × ' + nuits + (nuits > 1 ? ' nuits' : ' nuit')"></span>
                                    </div>
                                </div>
                                <div style="text-align:right;flex-shrink:0;">
                                    <template x-if="nuits > 0">
                                        <div>
                                            <div style="font-family:'Cormorant Garamond',serif;font-size:2rem;font-weight:700;color:#162B19;line-height:1;"
                                                 x-text="prixTotal.toFixed(2).replace('.',',') + ' €'"></div>
                                            <div style="font-family:'Outfit',sans-serif;font-size:0.7rem;color:#7A7265;">Total TTC</div>
                                        </div>
                                    </template>
                                    <template x-if="nuits === 0">
                                        <div style="font-family:'Outfit',sans-serif;font-size:0.75rem;color:#7A7265;font-style:italic;">
                                            Sélectionnez des dates
                                        </div>
                                    </template>
                                </div>
                            </div>

                            <!-- Availability indicator -->
                            <div x-show="disponible !== null && chambreId && dateDebut && dateFin"
                                 x-transition>
                                <div :class="disponible ? 'alert alert-success' : 'alert alert-danger'">
                                    <span x-show="checking">
                                        <span class="spinner-border spinner-border-sm me-2"></span>
                                        Vérification en cours…
                                    </span>
                                    <span x-show="!checking">
                                        <i :class="disponible ? 'bi bi-check-circle-fill' : 'bi bi-x-circle-fill'" class="me-2"></i>
                                        <span x-text="disponible ? 'Chambre disponible pour ces dates' : 'Chambre non disponible pour ces dates'"></span>
                                    </span>
                                </div>
                            </div>

                            <!-- Submit -->
                            <div class="mt-4">
                                <button type="submit"
                                        class="w-100"
                                        :disabled="!disponible || checking"
                                        style="
                                            display:flex;align-items:center;justify-content:center;gap:8px;
                                            background:linear-gradient(135deg,#2A4A2E,#3A6341);border:none;
                                            color:#fff;font-family:'Outfit',sans-serif;font-weight:600;font-size:1rem;
                                            letter-spacing:0.04em;padding:1rem;border-radius:8px;cursor:pointer;
                                            transition:all 0.3s;box-shadow:0 6px 20px rgba(22,43,25,0.25);
                                        "
                                        onmouseover="if(!this.disabled){this.style.background='linear-gradient(135deg,#162B19,#2A4A2E)';this.style.color='#E8D8A8'}"
                                        onmouseout="this.style.background='linear-gradient(135deg,#2A4A2E,#3A6341)';this.style.color='#fff'"
                                        x-bind:style="(!disponible || checking) ? 'opacity:0.5;cursor:not-allowed;' : ''">
                                    <i class="bi bi-check-circle"></i>
                                    Confirmer la réservation
                                </button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <div style="position:sticky;top:24px;background:#F8F5EE;border:1px solid #DDD8CD;border-radius:16px;overflow:hidden;box-shadow:0 4px 16px rgba(22,43,25,0.08);">

                    <div style="background:linear-gradient(135deg,#162B19,#2A4A2E);padding:1.25rem 1.5rem;border-bottom:2px solid rgba(201,176,122,0.3);">
                        <div style="font-family:'Cormorant Garamond',serif;font-size:1.1rem;font-weight:600;color:#F8F5EE;display:flex;align-items:center;gap:8px;">
                            <i class="bi bi-list-check" style="color:#C9B07A;"></i>
                            Nos hébergements
                        </div>
                    </div>

                    <div style="max-height:520px;overflow-y:auto;">
                        <?php if (!empty($chambres)): ?>
                            <?php foreach ($chambres as $chambre): ?>
                            <div style="padding:1.1rem 1.4rem;border-bottom:1px solid #EDE8DC;transition:background 0.2s;"
                                 onmouseover="this.style.background='#EDE8DC'"
                                 onmouseout="this.style.background='transparent'">
                                <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:0.3rem;">
                                    <div style="font-family:'Cormorant Garamond',serif;font-size:1rem;font-weight:600;color:#162B19;">
                                        Chambre <?= esc($chambre['chamb_numero']) ?>
                                    </div>
                                    <span style="background:#EDE8DC;color:#2A4A2E;font-family:'Outfit',sans-serif;font-size:0.68rem;font-weight:600;letter-spacing:0.06em;padding:0.2rem 0.55rem;border-radius:50px;border:1px solid #DDD8CD;">
                                        <?= esc($chambre['type_libelle']) ?>
                                    </span>
                                </div>
                                <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:0.25rem;">
                                    <div style="display:flex;align-items:center;gap:5px;">
                                        <i class="bi bi-geo-alt" style="color:#C9B07A;font-size:0.72rem;"></i>
                                        <span style="font-family:'Outfit',sans-serif;font-size:0.78rem;color:#7A7265;">
                                            <?= esc($chambre['chamb_emplacement']) ?>
                                        </span>
                                    </div>
                                    <?php if (!empty($chambre['prix_unitaire_nuit'])): ?>
                                    <span style="font-family:'Cormorant Garamond',serif;font-size:0.95rem;font-weight:700;color:#162B19;white-space:nowrap;">
                                        <?= number_format($chambre['prix_unitaire_nuit'], 2, ',', ' ') ?> €<span style="font-family:'Outfit',sans-serif;font-size:0.65rem;font-weight:400;color:#7A7265;">/nuit</span>
                                    </span>
                                    <?php endif; ?>
                                </div>
                                <?php if ($chambre['chamb_remarque']): ?>
                                <div style="font-family:'Outfit',sans-serif;font-size:0.75rem;color:#4E8A5A;display:flex;align-items:center;gap:5px;">
                                    <i class="bi bi-star-fill" style="font-size:0.65rem;"></i>
                                    <?= esc($chambre['chamb_remarque']) ?>
                                </div>
                                <?php endif; ?>
                            </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                        <div style="text-align:center;padding:3rem 1.5rem;color:#7A7265;">
                            <i class="bi bi-inbox" style="font-size:2rem;display:block;margin-bottom:0.75rem;color:#DDD8CD;"></i>
                            <p style="font-family:'Outfit',sans-serif;font-size:0.875rem;margin:0;">Aucune chambre disponible</p>
                        </div>
                        <?php endif; ?>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>

<?= $this->endSection() ?>
