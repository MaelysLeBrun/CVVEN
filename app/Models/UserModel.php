<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'Utilisateur';
    protected $primaryKey = 'user_id';

    protected $allowedFields = [
        'user_login',
        'user_mdp',
        'user_nom',
        'user_prenom',
        'user_mail',
        'user_telephone'
    ];

    protected $returnType = 'array';
}
