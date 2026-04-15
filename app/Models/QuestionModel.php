<?php

namespace App\Models;

use CodeIgniter\Model;

class QuestionModel extends Model
{
    protected $table = 'Lot_Questions';
    protected $primaryKey = 'id_question';
    protected $allowedFields = ['libelle_question'];
}
