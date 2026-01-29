<?php

namespace App\Models;

use CodeIgniter\Model;

/**
 * Modèle pour la gestion des utilisateurs
 * 
 * Gère les opérations CRUD sur la table Utilisateur, incluant l'authentification
 * et la gestion des informations personnelles des utilisateurs.
 * 
 * @package App\Models
 * @author  CVVEN
 * @version 1.0.0
 */
class UserModel extends Model
{
    /**
     * Nom de la table dans la base de données
     * @var string
     */
    protected $table = 'Utilisateur';
    
    /**
     * Clé primaire de la table
     * @var string
     */
    protected $primaryKey = 'user_id';

    /**
     * Champs autorisés pour l'insertion et la mise à jour
     * @var array<string>
     */
    protected $allowedFields = [
        'user_login',
        'user_mdp',
        'user_nom',
        'user_prenom',
        'user_mail',
        'user_telephone'
    ];

    /**
     * Type de retour des résultats
     * @var string
     */
    protected $returnType = 'array';
}
