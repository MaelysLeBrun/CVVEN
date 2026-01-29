<?php

namespace App\Controllers;

use App\Models\ChambreModel;
use App\Models\ReserveModel;
use App\Models\UserModel;
use CodeIgniter\Exceptions\PageNotFoundException;

/**
 * Contrôleur pour la gestion des chambres d'hôtel
 * 
 * Gère l'affichage des chambres, la vérification de disponibilité,
 * les réservations et la gestion des réservations utilisateur.
 * 
 * @package App\Controllers
 * @author  CVVEN
 * @version 1.0.0
 */
class Hotel extends BaseController
{
    /**
     * Affiche la liste de toutes les chambres avec leurs types
     * 
     * Récupère toutes les chambres avec jointure sur Type_Chambre
     * et affiche la vue principale de l'hôtel avec un carrousel des types.
     * 
     * @return string Vue de l'index de l'hôtel
     */
    public function index()
    {
        $model = new ChambreModel();
        // On récupère les chambres avec le libellé du type (grâce à la jointure dans le modèle)
        $data['chambres'] = $model->getChambresAvecType();
        // Récupérer les types de chambres pour le carrousel
        $data['types'] = $model->getTypesChambres();
        
        return view('hotel/index', $data);
    }

    /**
     * Affiche les chambres disponibles pour un type et une période
     * 
     * Vérifie la disponibilité des chambres d'un type spécifique pour une période donnée.
     * Les dates sont passées en paramètres GET (date_debut et date_fin).
     * 
     * @param int|string|null $typeId Identifiant du type de chambre
     * @return string Vue affichant les chambres disponibles
     */
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
        
        // Récupérer tous les types de chambres pour permettre le changement
        $allTypes = $model->getTypesChambres();
        
        $data = [
            'chambres' => $chambresDisponibles,
            'type' => $typeInfo,
            'allTypes' => $allTypes,
            'dateDebut' => $dateDebut,
            'dateFin' => $dateFin,
            'nombreDisponible' => count($chambresDisponibles)
        ];
        
        return view('hotel/disponibilite', $data);
    }

    /**
     * Affiche les détails d'une chambre spécifique
     * 
     * Vérifie que l'utilisateur est connecté avant d'afficher les détails.
     * Redirige vers la page de connexion si non connecté.
     * 
     * @param int|string $id Identifiant de la chambre
     * @return \CodeIgniter\HTTP\RedirectResponse|string Vue des détails ou redirection
     * @throws PageNotFoundException Si la chambre n'existe pas
     */
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

    /**
     * Traite la réservation d'une chambre
     * 
     * Processus en deux étapes :
     * 1. Création ou récupération de l'utilisateur (prospect)
     * 2. Création de la réservation
     * 
     * Effectue des validations complètes des données du formulaire,
     * vérifie que la date de fin est postérieure à la date de début,
     * et gère les utilisateurs existants pour éviter les doublons.
     * 
     * @return \CodeIgniter\HTTP\RedirectResponse|string Vue de succès ou redirection avec erreurs
     */
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

    /**
     * Affiche la liste des réservations de l'utilisateur connecté
     * 
     * Vérifie que l'utilisateur est connecté et récupère toutes ses réservations
     * avec les détails des chambres associées, triées par date de début décroissante.
     * 
     * @return \CodeIgniter\HTTP\RedirectResponse|string Vue des réservations ou redirection vers login
     */
    public function mesReservations()
    {
        // Vérifier si l'utilisateur est connecté
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login')->with('message', 'Veuillez vous connecter pour voir vos réservations');
        }

        $userId = session()->get('user_id');
        $reserveModel = new ReserveModel();

        // Récupérer les réservations avec les détails de la chambre
        $reservations = $reserveModel->select('Reserve.*, Chambre.chamb_numero, Chambre.chamb_emplacement, Type_Chambre.type_libelle, Type_Chambre.type_desc')
                                    ->join('Chambre', 'Chambre.chamb_id = Reserve.chamb_id')
                                    ->join('Type_Chambre', 'Type_Chambre.type_id = Chambre.type_id')
                                    ->where('Reserve.user_id', $userId)
                                    ->orderBy('Reserve.reser_dateDebut', 'DESC')
                                    ->findAll();

        $data = [
            'reservations' => $reservations
        ];

        return view('hotel/mes_reservations', $data);
    }
}