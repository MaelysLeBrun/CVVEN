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
}