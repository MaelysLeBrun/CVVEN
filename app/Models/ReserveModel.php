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
     * Clé primaire de la table
     * @var string
     */
    protected $primaryKey = 'reser_id';

    /**
     * Clé primaire auto-incrémentée
     * @var bool
     */
    protected $useAutoIncrement = true;

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

    /**
     * Vérifie si une chambre est disponible pour les dates données
     */
    public function isChambreDisponible($chamb_id, $dateDebut, $dateFin)
    {
        $count = $this->db->table('Reserve')
            ->where('chamb_id', $chamb_id)
            ->where('reser_dateDebut <', $dateFin)
            ->where('reser_dateFin >', $dateDebut)
            ->countAllResults();

        return $count === 0;
    }

    /**
     * Crée une nouvelle réservation
     */
    public function creerReservation($user_id, $chamb_id, $dateDebut, $dateFin)
    {
        return $this->insert([
            'user_id' => $user_id,
            'chamb_id' => $chamb_id,
            'reser_dateDebut' => $dateDebut,
            'reser_dateFin' => $dateFin
        ]);
    }

    /**
     * Annule une réservation (vérifie que l'utilisateur en est bien le propriétaire)
     */
    public function annulerReservation($reservationId, $userId)
    {
        $reservation = $this->where('reser_id', $reservationId)
                            ->where('user_id', $userId)
                            ->first();

        if (!$reservation) {
            return false;
        }

        if (new \DateTime($reservation['reser_dateDebut']) <= new \DateTime()) {
            return false;
        }

        return $this->delete($reservationId);
    }

    /**
     * Récupère toutes les chambres avec leurs types
     */
    public function getAllChambres()
    {
        return $this->db->table('Chambre c')
            ->select('c.chamb_id, c.chamb_numero, c.chamb_emplacement, c.chamb_remarque, t.type_id, t.type_libelle, t.type_desc')
            ->join('Type_Chambre t', 't.type_id = c.type_id')
            ->orderBy('c.chamb_numero', 'ASC')
            ->get()
            ->getResultArray();
    }
}