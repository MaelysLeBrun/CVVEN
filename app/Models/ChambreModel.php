<?php

namespace App\Models;

use CodeIgniter\Model;

/**
 * Modèle pour la gestion des chambres d'hôtel
 * 
 * Gère les opérations CRUD sur la table Chambre et ses relations avec Type_Chambre
 * 
 * @package App\Models
 * @author  CVVEN
 * @version 1.0.0
 */
class ChambreModel extends Model
{
    /**
     * Nom de la table dans la base de données
     * @var string
     */
    protected $table = 'Chambre';
    
    /**
     * Clé primaire de la table
     * @var string
     */
    protected $primaryKey = 'chamb_id';
    
    /**
     * Champs autorisés pour l'insertion et la mise à jour
     * @var array<string>
     */
    protected $allowedFields = ['chamb_emplacement', 'chamb_numero', 'chamb_remarque', 'type_id'];
    
    /**
     * Type de retour des résultats
     * @var string
     */
    protected $returnType = 'array';

    /**
     * Récupère toutes les chambres avec leurs informations de type
     * 
     * Effectue une jointure avec la table Type_Chambre pour récupérer
     * le libellé et la description du type de chambre
     * 
     * @return array<array<string,mixed>> Liste des chambres avec leurs types
     */
    public function getChambresAvecType()
    {
        return $this->select('Chambre.*, Type_Chambre.type_libelle, Type_Chambre.type_desc')
                    ->join('Type_Chambre', 'Type_Chambre.type_id = Chambre.type_id')
                    ->findAll();
    }

    /**
     * Récupère les détails d'une chambre spécifique avec son type
     * 
     * @param int|string $id Identifiant de la chambre
     * @return array<string,mixed>|null Détails de la chambre ou null si non trouvée
     */
    public function getChambreDetail($id)
    {
        return $this->select('Chambre.*, Type_Chambre.type_libelle, Type_Chambre.type_desc')
                    ->join('Type_Chambre', 'Type_Chambre.type_id = Chambre.type_id')
                    ->where('chamb_id', $id)
                    ->first();
    }

    /**
     * Récupère tous les types de chambres disponibles
     * 
     * @return array<array<string,mixed>> Liste de tous les types de chambres
     */
    public function getTypesChambres()
    {
        return $this->db->table('Type_Chambre')
                        ->select('type_id, type_libelle, type_desc')
                        ->get()
                        ->getResultArray();
    }

    /**
     * Compte le nombre de chambres d'un type spécifique
     * 
     * @param int|string $typeId Identifiant du type de chambre
     * @return int Nombre de chambres du type spécifié
     */
    public function countChambresParType($typeId)
    {
        return $this->where('type_id', $typeId)->countAllResults();
    }

    /**
     * Récupère les chambres disponibles pour un type et une période donnés
     * 
     * Si des dates sont fournies, exclut les chambres déjà réservées durant cette période.
     * La disponibilité est vérifiée en excluant les chambres avec des réservations qui 
     * chevauchent la période demandée.
     * 
     * @param int|string      $typeId     Identifiant du type de chambre
     * @param string|null     $dateDebut  Date de début de la période (format Y-m-d)
     * @param string|null     $dateFin    Date de fin de la période (format Y-m-d)
     * @return array<array<string,mixed>> Liste des chambres disponibles
     */
    public function getChambresDisponiblesParType($typeId, $dateDebut = null, $dateFin = null)
    {
        $builder = $this->select('Chambre.*, Type_Chambre.type_libelle, Type_Chambre.type_desc')
                        ->join('Type_Chambre', 'Type_Chambre.type_id = Chambre.type_id')
                        ->where('Chambre.type_id', $typeId);

        // Si des dates sont fournies, exclure les chambres déjà réservées pour cette période
        if ($dateDebut && $dateFin) {
            $builder->whereNotIn('Chambre.chamb_id', function($builder) use ($dateDebut, $dateFin) {
                return $builder->select('chamb_id')
                               ->from('Reserve')
                               ->groupStart()
                                   ->where('reser_dateDebut <=', $dateFin)
                                   ->where('reser_dateFin >=', $dateDebut)
                               ->groupEnd();
            });
        }

        return $builder->findAll();
    }
}