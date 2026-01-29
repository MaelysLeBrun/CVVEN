<?php

namespace App\Models;

use CodeIgniter\Model;

/**
 * Modèle pour la gestion des réservations
 * 
 * Gère les opérations sur la table Reserve avec une clé primaire composite (user_id, chamb_id).
 * Note: CodeIgniter 4 gère mieux les clés primaires simples, mais l'insertion fonctionne correctement.
 * 
 * @package App\Models
 * @author  CVVEN
 * @version 1.0.0
 */
class ReserveModel extends Model
{
    /**
     * Nom de la table dans la base de données
     * @var string
     */
    protected $table = 'Reserve';
    
    /**
     * Clé primaire de la table (composite : user_id + chamb_id)
     * @var string
     */
    protected $primaryKey = 'user_id';
    
    /**
     * Champs autorisés pour l'insertion et la mise à jour
     * @var array<string>
     */
    protected $allowedFields = ['user_id', 'chamb_id', 'reser_dateDebut', 'reser_dateFin'];

    /**
     * Règles de validation pour sécuriser les données
     * @var array<string,string>
     */
    protected $validationRules = [
        'reser_dateDebut' => 'required|valid_date',
        'reser_dateFin'   => 'required|valid_date',
    ];
}