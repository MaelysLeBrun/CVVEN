<?php

namespace App\Models;

use CodeIgniter\Model;

class ReserveModel extends Model
{
    protected $table = 'Reserve';
    // Attention : ta table a une clé primaire composite (user_id + chamb_id). 
    // CI4 gère mieux les clés simples, mais pour l'insert ça ira.
    protected $primaryKey = 'user_id'; 
    protected $allowedFields = ['user_id', 'chamb_id', 'reser_dateDebut', 'reser_dateFin'];

    // Règles de validation pour sécuriser l'entrée
    protected $validationRules = [
        'reser_dateDebut' => 'required|valid_date',
        'reser_dateFin'   => 'required|valid_date',
    ];
}