<?= $this->extend('hotel/layout') ?>
<?= $this->section('content') ?>

<!-- ── Page header ──────────────────────────────────────────── -->
<div class="page-header">
    <div class="container">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
            <div>
                <span class="section-label" style="color:#C9B07A;">Administration</span>
                <h1><i class="bi bi-people me-2"></i>Gestion des utilisateurs</h1>
                <p class="lead">Consultez, modifiez ou supprimez les comptes utilisateurs</p>
            </div>
            <a href="<?= base_url('admin/reservations') ?>"
               style="
                    display:inline-flex;align-items:center;gap:8px;
                    background:rgba(255,255,255,0.1);
                    border:1.5px solid rgba(201,176,122,0.4);
                    color:rgba(255,255,255,0.88);font-family:'Outfit',sans-serif;font-weight:500;
                    font-size:0.875rem;padding:0.6rem 1.25rem;border-radius:6px;text-decoration:none;
                    transition:all 0.3s;
               "
               onmouseover="this.style.background='rgba(201,176,122,0.15)';this.style.borderColor='rgba(201,176,122,0.7)'"
               onmouseout="this.style.background='rgba(255,255,255,0.1)';this.style.borderColor='rgba(201,176,122,0.4)'">
                <i class="bi bi-calendar-check"></i>Réservations
            </a>
        </div>
    </div>
</div>

<!-- ── Content ───────────────────────────────────────────────── -->
<div style="background-color:#EDE8DC;padding:3rem 0;min-height:60vh;">
    <div class="container">

        <!-- Stats rapides -->
        <?php
        $total = count($users);
        $admins = count(array_filter($users, fn($u) => ($u['user_role'] ?? '') === 'administrateur'));
        $clients = $total - $admins;
        ?>
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <div style="background:#F8F5EE;border:1px solid #DDD8CD;border-radius:12px;padding:1.25rem 1.5rem;display:flex;align-items:center;gap:1rem;box-shadow:0 2px 8px rgba(22,43,25,0.06);">
                    <div style="width:44px;height:44px;background:linear-gradient(135deg,#2A4A2E,#3A6341);border-radius:10px;display:flex;align-items:center;justify-content:center;color:#E8D8A8;font-size:1.1rem;flex-shrink:0;">
                        <i class="bi bi-people"></i>
                    </div>
                    <div>
                        <div style="font-family:'Cormorant Garamond',serif;font-size:1.8rem;font-weight:700;color:#162B19;line-height:1;"><?= $total ?></div>
                        <div style="font-family:'Outfit',sans-serif;font-size:0.75rem;color:#7A7265;text-transform:uppercase;letter-spacing:0.06em;">Utilisateurs</div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div style="background:#F8F5EE;border:1px solid #DDD8CD;border-radius:12px;padding:1.25rem 1.5rem;display:flex;align-items:center;gap:1rem;box-shadow:0 2px 8px rgba(22,43,25,0.06);">
                    <div style="width:44px;height:44px;background:linear-gradient(135deg,#C9B07A,#B8860B);border-radius:10px;display:flex;align-items:center;justify-content:center;color:#162B19;font-size:1.1rem;flex-shrink:0;">
                        <i class="bi bi-shield-lock"></i>
                    </div>
                    <div>
                        <div style="font-family:'Cormorant Garamond',serif;font-size:1.8rem;font-weight:700;color:#162B19;line-height:1;"><?= $admins ?></div>
                        <div style="font-family:'Outfit',sans-serif;font-size:0.75rem;color:#7A7265;text-transform:uppercase;letter-spacing:0.06em;">Administrateurs</div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div style="background:#F8F5EE;border:1px solid #DDD8CD;border-radius:12px;padding:1.25rem 1.5rem;display:flex;align-items:center;gap:1rem;box-shadow:0 2px 8px rgba(22,43,25,0.06);">
                    <div style="width:44px;height:44px;background:linear-gradient(135deg,#4E8A5A,#3A6341);border-radius:10px;display:flex;align-items:center;justify-content:center;color:#E8D8A8;font-size:1.1rem;flex-shrink:0;">
                        <i class="bi bi-person-check"></i>
                    </div>
                    <div>
                        <div style="font-family:'Cormorant Garamond',serif;font-size:1.8rem;font-weight:700;color:#162B19;line-height:1;"><?= $clients ?></div>
                        <div style="font-family:'Outfit',sans-serif;font-size:0.75rem;color:#7A7265;text-transform:uppercase;letter-spacing:0.06em;">Clients</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tableau -->
        <div style="background:#F8F5EE;border:1px solid #DDD8CD;border-radius:14px;overflow:hidden;box-shadow:0 2px 8px rgba(22,43,25,0.08);">

            <!-- En-tête tableau -->
            <div style="background:linear-gradient(135deg,#162B19,#2A4A2E);padding:0;">
                <div style="display:grid;grid-template-columns:90px 130px 1fr 1fr 1.6fr 130px 110px 110px;gap:0;align-items:center;padding:0.875rem 1.5rem;">
                    <div style="font-family:'Outfit',sans-serif;font-size:0.68rem;font-weight:600;color:rgba(201,176,122,0.8);text-transform:uppercase;letter-spacing:0.1em;">ID</div>
                    <div style="font-family:'Outfit',sans-serif;font-size:0.68rem;font-weight:600;color:rgba(201,176,122,0.8);text-transform:uppercase;letter-spacing:0.1em;">Login</div>
                    <div style="font-family:'Outfit',sans-serif;font-size:0.68rem;font-weight:600;color:rgba(201,176,122,0.8);text-transform:uppercase;letter-spacing:0.1em;">Nom</div>
                    <div style="font-family:'Outfit',sans-serif;font-size:0.68rem;font-weight:600;color:rgba(201,176,122,0.8);text-transform:uppercase;letter-spacing:0.1em;">Prénom</div>
                    <div style="font-family:'Outfit',sans-serif;font-size:0.68rem;font-weight:600;color:rgba(201,176,122,0.8);text-transform:uppercase;letter-spacing:0.1em;">Email</div>
                    <div style="font-family:'Outfit',sans-serif;font-size:0.68rem;font-weight:600;color:rgba(201,176,122,0.8);text-transform:uppercase;letter-spacing:0.1em;">Téléphone</div>
                    <div style="font-family:'Outfit',sans-serif;font-size:0.68rem;font-weight:600;color:rgba(201,176,122,0.8);text-transform:uppercase;letter-spacing:0.1em;">Rôle</div>
                    <div style="font-family:'Outfit',sans-serif;font-size:0.68rem;font-weight:600;color:rgba(201,176,122,0.8);text-transform:uppercase;letter-spacing:0.1em;text-align:center;">Actions</div>
                </div>
            </div>

            <!-- Lignes -->
            <?php foreach ($users as $i => $user): ?>
            <div style="
                display:grid;
                grid-template-columns:90px 130px 1fr 1fr 1.6fr 130px 110px 110px;
                gap:0;align-items:center;
                padding:1rem 1.5rem;
                background:<?= $i % 2 === 0 ? '#F8F5EE' : '#FAF8F3' ?>;
                border-bottom:1px solid #EDE8DC;
                transition:background 0.2s;
            "
            onmouseover="this.style.background='#EDE8DC'"
            onmouseout="this.style.background='<?= $i % 2 === 0 ? '#F8F5EE' : '#FAF8F3' ?>'">

                <!-- ID -->
                <div>
                    <span style="font-family:'Outfit',sans-serif;font-size:0.75rem;font-weight:600;color:#C9B07A;background:rgba(201,176,122,0.12);border:1px solid rgba(201,176,122,0.3);border-radius:4px;padding:0.2rem 0.45rem;">
                        <?= esc($user['user_id']) ?>
                    </span>
                </div>

                <!-- Login -->
                <div style="font-family:'Outfit',sans-serif;font-size:0.875rem;color:#2C2416;font-weight:500;">
                    <?= esc($user['user_login']) ?>
                </div>

                <!-- Nom -->
                <div style="font-family:'Outfit',sans-serif;font-size:0.875rem;color:#2C2416;">
                    <?= esc($user['user_nom']) ?>
                </div>

                <!-- Prénom -->
                <div style="font-family:'Outfit',sans-serif;font-size:0.875rem;color:#2C2416;">
                    <?= esc($user['user_prenom']) ?>
                </div>

                <!-- Email -->
                <div style="font-family:'Outfit',sans-serif;font-size:0.82rem;color:#7A7265;">
                    <?= esc($user['user_mail']) ?>
                </div>

                <!-- Téléphone -->
                <div style="font-family:'Outfit',sans-serif;font-size:0.82rem;color:#7A7265;">
                    <?= esc($user['user_telephone']) ?>
                </div>

                <!-- Rôle -->
                <div>
                    <?php if (($user['user_role'] ?? '') === 'administrateur'): ?>
                        <span style="
                            font-family:'Outfit',sans-serif;font-size:0.68rem;font-weight:600;
                            letter-spacing:0.05em;text-transform:uppercase;
                            background:rgba(184,134,11,0.12);color:#6B4226;
                            border:1px solid rgba(201,176,122,0.5);
                            border-radius:50px;padding:0.25rem 0.65rem;
                        ">
                            <i class="bi bi-shield-lock me-1"></i>Admin
                        </span>
                    <?php else: ?>
                        <span style="
                            font-family:'Outfit',sans-serif;font-size:0.68rem;font-weight:600;
                            letter-spacing:0.05em;text-transform:uppercase;
                            background:rgba(122,114,101,0.1);color:#7A7265;
                            border:1px solid #DDD8CD;
                            border-radius:50px;padding:0.25rem 0.65rem;
                        ">
                            <i class="bi bi-person me-1"></i>Client
                        </span>
                    <?php endif; ?>
                </div>

                <!-- Actions -->
                <div style="display:flex;align-items:center;justify-content:center;gap:0.4rem;">
                    <a href="<?= base_url('admin/users/edit/' . $user['user_id']) ?>"
                       style="
                            display:inline-flex;align-items:center;justify-content:center;
                            width:32px;height:32px;border-radius:6px;
                            background:rgba(42,74,46,0.08);border:1px solid rgba(42,74,46,0.2);
                            color:#2A4A2E;transition:all 0.25s;text-decoration:none;
                       "
                       title="Modifier"
                       onmouseover="this.style.background='#2A4A2E';this.style.color='#E8D8A8'"
                       onmouseout="this.style.background='rgba(42,74,46,0.08)';this.style.color='#2A4A2E'">
                        <i class="bi bi-pencil" style="font-size:0.8rem;"></i>
                    </a>
                    <?php if ($user['user_id'] !== session()->get('user_id')): ?>
                    <form method="post"
                          action="<?= base_url('admin/users/delete/' . $user['user_id']) ?>"
                          class="d-inline"
                          onsubmit="return confirm('Supprimer « <?= esc($user['user_login']) ?> » et toutes ses réservations ?')">
                        <?= csrf_field() ?>
                        <button type="submit"
                                style="
                                    display:inline-flex;align-items:center;justify-content:center;
                                    width:32px;height:32px;border-radius:6px;
                                    background:rgba(192,57,43,0.08);border:1px solid rgba(192,57,43,0.2);
                                    color:#c0392b;transition:all 0.25s;cursor:pointer;
                                "
                                title="Supprimer"
                                onmouseover="this.style.background='#c0392b';this.style.color='#fff'"
                                onmouseout="this.style.background='rgba(192,57,43,0.08)';this.style.color='#c0392b'">
                            <i class="bi bi-trash" style="font-size:0.8rem;"></i>
                        </button>
                    </form>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; ?>

            <?php if (empty($users)): ?>
            <div style="padding:4rem;text-align:center;">
                <i class="bi bi-people" style="font-size:2.5rem;color:#DDD8CD;display:block;margin-bottom:1rem;"></i>
                <p style="font-family:'Outfit',sans-serif;color:#7A7265;margin:0;">Aucun utilisateur trouvé.</p>
            </div>
            <?php endif; ?>
        </div>

    </div>
</div>

<?= $this->endSection() ?>
