<?php

namespace App\Controllers;

use App\Models\ChambreModel;
use App\Models\ReserveModel;
use App\Models\UserModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Hotel extends BaseController
{
    public function index()
    {
        $model = new ChambreModel();
        // On récupère les chambres avec le libellé du type (grâce à la jointure dans le modèle)
        $data['chambres'] = $model->getChambresAvecType();
        // Récupérer les types de chambres pour le carrousel
        $data['types'] = $model->getTypesChambres();
        
        return view('hotel/index', $data);
    }

    public function disponibilite($typeId = null)
    {
        $model = new ChambreModel();
        
        // Récupérer les dates de la requête
        $dateDebut = $this->request->getGet('date_debut');
        $dateFin = $this->request->getGet('date_fin');
        
        // Récupérer toutes les chambres disponibles de ce type pour la période
        $chambresDisponibles = $model->getChambresDisponiblesParType($typeId, $dateDebut, $dateFin);
        
        // Récupérer les infos du type
        $typeInfo = $model->db->table('Type_Chambre')
                              ->where('type_id', $typeId)
                              ->get()
                              ->getRowArray();
        
        $data = [
            'chambres' => $chambresDisponibles,
            'type' => $typeInfo,
            'dateDebut' => $dateDebut,
            'dateFin' => $dateFin,
            'nombreDisponible' => count($chambresDisponibles)
        ];
        
        return view('hotel/disponibilite', $data);
    }

    public function detail($id)
    {
        // Vérifier si l'utilisateur est connecté
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login')->with('message', 'Veuillez vous connecter pour réserver une chambre');
        }

        $model = new ChambreModel();
        $chambre = $model->getChambreDetail($id);

        if (!$chambre) {
            throw PageNotFoundException::forPageNotFound("Chambre introuvable : " . $id);
        }

        return view('hotel/detail', ['chambre' => $chambre]);
    }

    public function reserver()
    {
        // Chargement des helpers et services
        $validation = \Config\Services::validation();

        // 1. Définition des règles de validation (Sécurité)
        $rules = [
            'chamb_id'      => 'required',
            'user_nom'      => 'required|min_length[2]',
            'user_prenom'   => 'required|min_length[2]',
            'user_mail'     => 'required|valid_email', // Email unique normalement, à gérer
            'user_telephone'=> 'required|min_length[10]',
            'date_debut'    => 'required|valid_date',
            'date_fin'      => 'required|valid_date',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        // Récupération des données POST
        $post = $this->request->getPost();

        // Vérification logique : Date fin > Date début
        if ($post['date_fin'] <= $post['date_debut']) {
            return redirect()->back()->withInput()->with('error', 'La date de départ doit être après l\'arrivée.');
        }

        // --- ETAPE A : Création de l'utilisateur (Prospect) ---
        // On génère un ID unique car ta BDD utilise des Varchar (ex: USR001)
        // Ici on utilise uniqid pour faire simple, ou on peut faire une logique d'incrément.
        $userId = 'USR' . strtoupper(substr(uniqid(), -5)); 
        
        // On génère un login (ex: prenom.nom)
        $userLogin = strtolower($post['user_prenom'] . '.' . $post['user_nom'] . rand(10,99));

        $userModel = new UserModel();
        
        // Vérif si email existe déjà (Optionnel : si auth arrive après, on peut juste vérifier l'email)
        $existingUser = $userModel->where('user_mail', $post['user_mail'])->first();
        
        if ($existingUser) {
            // Si l'utilisateur existe déjà, on prend son ID (Pour éviter l'erreur Duplicate entry)
            $userId = $existingUser['user_id'];
        } else {
            // Sinon on le crée
            $userModel->insert([
                'user_id'        => $userId,
                'user_login'     => $userLogin,
                'user_nom'       => $post['user_nom'],
                'user_prenom'    => $post['user_prenom'],
                'user_mail'      => $post['user_mail'],
                'user_telephone' => $post['user_telephone']
            ]);
        }

        // --- ETAPE B : Création de la Réservation ---
        $reserveModel = new ReserveModel();

        $dataReservation = [
            'user_id'         => $userId,
            'chamb_id'        => $post['chamb_id'],
            'reser_dateDebut' => $post['date_debut'],
            'reser_dateFin'   => $post['date_fin']
        ];

        // Tentative d'insertion
        try {
            $reserveModel->insert($dataReservation);
            return view('hotel/success');
        } catch (\Exception $e) {
            // Gestion des erreurs SQL (ex: l'utilisateur a déjà réservé CETTE chambre -> clé primaire composite)
            return redirect()->back()->withInput()->with('error', 'Erreur : Cette réservation existe déjà ou conflit technique.');
        }
    }
}