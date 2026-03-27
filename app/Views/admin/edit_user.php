<?= $this->extend('hotel/layout') ?>
<?= $this->section('content') ?>

<!-- ── Page header ──────────────────────────────────────────── -->
<div class="page-header">
    <div class="container">
        <a href="<?= base_url('admin/users') ?>"
           style="display:inline-flex;align-items:center;gap:6px;color:rgba(255,255,255,0.6);font-size:0.85rem;font-family:'Outfit',sans-serif;text-decoration:none;margin-bottom:1rem;transition:color 0.3s;"
           onmouseover="this.style.color='#E8D8A8'"
           onmouseout="this.style.color='rgba(255,255,255,0.6)'">
            <i class="bi bi-arrow-left"></i> Retour aux utilisateurs
        </a>
        <span class="section-label" style="color:#C9B07A;">Administration</span>
        <h1><i class="bi bi-person-gear me-2"></i>Modifier l'utilisateur</h1>
        <p class="lead">
            <?= esc($user['user_prenom'] . ' ' . $user['user_nom']) ?>
            <span style="opacity:0.5;margin:0 0.5rem;">·</span>
            <span style="font-family:'Outfit',sans-serif;font-size:0.9rem;"><?= esc($user['user_login']) ?></span>
        </p>
    </div>
</div>

<!-- ── Content ───────────────────────────────────────────────── -->
<div style="background-color:#EDE8DC;padding:3rem 0;min-height:60vh;">
    <div class="container" style="max-width:680px;">

        <div style="background:#F8F5EE;border:1px solid #DDD8CD;border-radius:14px;overflow:hidden;box-shadow:0 2px 8px rgba(22,43,25,0.08);">

            <!-- Card header -->
            <div style="background:linear-gradient(135deg,#162B19,#2A4A2E);padding:1.25rem 1.75rem;display:flex;align-items:center;gap:0.85rem;">
                <div style="width:40px;height:40px;background:rgba(201,176,122,0.2);border:1px solid rgba(201,176,122,0.35);border-radius:10px;display:flex;align-items:center;justify-content:center;color:#C9B07A;font-size:1rem;flex-shrink:0;">
                    <i class="bi bi-person-lines-fill"></i>
                </div>
                <div>
                    <div style="font-family:'Cormorant Garamond',serif;font-size:1.15rem;font-weight:600;color:#F8F5EE;line-height:1.2;">
                        Informations du compte
                    </div>
                    <div style="font-family:'Outfit',sans-serif;font-size:0.75rem;color:rgba(255,255,255,0.5);margin-top:2px;">
                        ID : <code style="color:#C9B07A;"><?= esc($user['user_id']) ?></code>
                    </div>
                </div>
            </div>

            <!-- Form -->
            <form method="post" action="<?= base_url('admin/users/update/' . $user['user_id']) ?>">
                <?= csrf_field() ?>

                <div style="padding:1.75rem;">
                    <div class="row g-3">

                        <div class="col-md-6">
                            <label class="form-label">Nom</label>
                            <input type="text" name="user_nom" class="form-control"
                                   value="<?= esc($user['user_nom']) ?>" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Prénom</label>
                            <input type="text" name="user_prenom" class="form-control"
                                   value="<?= esc($user['user_prenom']) ?>" required>
                        </div>

                        <div class="col-12">
                            <label class="form-label">Adresse email</label>
                            <input type="email" name="user_mail" class="form-control"
                                   value="<?= esc($user['user_mail']) ?>" required>
                        </div>

                        <div class="col-12">
                            <label class="form-label">Téléphone</label>
                            <input type="text" name="user_telephone" class="form-control"
                                   value="<?= esc($user['user_telephone']) ?>">
                        </div>

                        <!-- Séparateur -->
                        <div class="col-12">
                            <div style="border-top:1px solid #EDE8DC;padding-top:1.25rem;margin-top:0.25rem;">
                                <div style="display:flex;align-items:center;gap:6px;margin-bottom:0.75rem;">
                                    <div style="width:22px;height:22px;background:rgba(201,176,122,0.15);border-radius:5px;display:flex;align-items:center;justify-content:center;color:#C9B07A;font-size:0.75rem;">
                                        <i class="bi bi-shield-lock"></i>
                                    </div>
                                    <span style="font-family:'Outfit',sans-serif;font-size:0.78rem;font-weight:600;color:#7A7265;text-transform:uppercase;letter-spacing:0.06em;">Rôle & accès</span>
                                </div>
                                <select name="user_role" class="form-select">
                                    <option value="client"
                                        <?= (($user['user_role'] ?? 'client') === 'client') ? 'selected' : '' ?>>
                                        Client
                                    </option>
                                    <option value="administrateur"
                                        <?= (($user['user_role'] ?? '') === 'administrateur') ? 'selected' : '' ?>>
                                        Administrateur
                                    </option>
                                </select>
                            </div>
                        </div>

                        <!-- Séparateur -->
                        <div class="col-12">
                            <div style="border-top:1px solid #EDE8DC;padding-top:1.25rem;margin-top:0.25rem;">
                                <div style="display:flex;align-items:center;gap:6px;margin-bottom:0.75rem;">
                                    <div style="width:22px;height:22px;background:rgba(201,176,122,0.15);border-radius:5px;display:flex;align-items:center;justify-content:center;color:#C9B07A;font-size:0.75rem;">
                                        <i class="bi bi-key"></i>
                                    </div>
                                    <span style="font-family:'Outfit',sans-serif;font-size:0.78rem;font-weight:600;color:#7A7265;text-transform:uppercase;letter-spacing:0.06em;">Mot de passe</span>
                                </div>
                                <input type="password" name="user_mdp" class="form-control"
                                       placeholder="Laisser vide pour ne pas modifier"
                                       autocomplete="new-password">
                                <div style="font-family:'Outfit',sans-serif;font-size:0.75rem;color:#7A7265;margin-top:0.4rem;">
                                    <i class="bi bi-info-circle me-1"></i>Minimum 6 caractères si renseigné
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Footer -->
                <div style="padding:1.25rem 1.75rem;background:#EDE8DC;border-top:1px solid #DDD8CD;display:flex;justify-content:space-between;align-items:center;gap:0.75rem;">
                    <a href="<?= base_url('admin/users') ?>"
                       style="
                            display:inline-flex;align-items:center;gap:5px;
                            background:transparent;border:1.5px solid #DDD8CD;
                            color:#7A7265;font-family:'Outfit',sans-serif;font-size:0.85rem;font-weight:500;
                            padding:0.55rem 1.1rem;border-radius:6px;text-decoration:none;transition:all 0.3s;
                       "
                       onmouseover="this.style.background='#F8F5EE';this.style.color='#2C2416'"
                       onmouseout="this.style.background='transparent';this.style.color='#7A7265'">
                        <i class="bi bi-x"></i>Annuler
                    </a>
                    <button type="submit"
                            style="
                                display:inline-flex;align-items:center;gap:6px;
                                background:linear-gradient(135deg,#2A4A2E,#3A6341);
                                border:none;color:#fff;
                                font-family:'Outfit',sans-serif;font-size:0.875rem;font-weight:600;
                                padding:0.6rem 1.5rem;border-radius:6px;cursor:pointer;
                                box-shadow:0 4px 14px rgba(22,43,25,0.2);
                                transition:all 0.3s;
                            "
                            onmouseover="this.style.background='linear-gradient(135deg,#162B19,#2A4A2E)';this.style.color='#E8D8A8'"
                            onmouseout="this.style.background='linear-gradient(135deg,#2A4A2E,#3A6341)';this.style.color='#fff'">
                        <i class="bi bi-check-lg"></i>Enregistrer les modifications
                    </button>
                </div>

            </form>
        </div>

    </div>
</div>

<?= $this->endSection() ?>
