<?php

namespace App\Models;

use CodeIgniter\Model;

class ChambreModel extends Model
{
    protected $table = 'Chambre';
    protected $primaryKey = 'chamb_id';
    protected $allowedFields = ['chamb_emplacement', 'chamb_numero', 'chamb_remarque', 'type_id'];
    protected $returnType = 'array';

    // Fonction pour récupérer les chambres avec leur type (Jointure)
    public function getChambresAvecType()
    {
        return $this->select('Chambre.*, Type_Chambre.type_libelle, Type_Chambre.type_desc')
                    ->join('Type_Chambre', 'Type_Chambre.type_id = Chambre.type_id')
                    ->findAll();
    }

    public function getChambreDetail($id)
    {
        return $this->select('Chambre.*, Type_Chambre.type_libelle, Type_Chambre.type_desc')
                    ->join('Type_Chambre', 'Type_Chambre.type_id = Chambre.type_id')
                    ->where('chamb_id', $id)
                    ->first();
    }

    // Récupérer tous les types de chambres distincts
    public function getTypesChambres()
    {
        return $this->db->table('Type_Chambre')
                        ->select('type_id, type_libelle, type_desc')
                        ->get()
                        ->getResultArray();
    }

    // Compter le nombre de chambres par type
    public function countChambresParType($typeId)
    {
        return $this->where('type_id', $typeId)->countAllResults();
    }

    // Récupérer les chambres disponibles d'un certain type pour une période donnée
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