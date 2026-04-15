<?php

namespace App\Controllers;

use App\Models\ChambreModel;
use App\Models\ReserveModel;
use App\Models\UserModel;
use CodeIgniter\Controller;

class Reservation extends Controller
{
    protected $reserveModel;
    protected $userModel;

    public function __construct()
    {
        $this->reserveModel = new ReserveModel();
        $this->userModel = new UserModel();
    }

    /**
     * Affiche le formulaire de réservation
     * Requiert que l'utilisateur soit connecté
     */
    public function formulaire()
    {
        // Vérifier si l'utilisateur est connecté
        if (!session()->get('isLoggedIn')) {
            return redirect()->to(base_url('login'))
                ->with('erreur', 'Vous devez être connecté pour faire une réservation.');
        }

        $userId = session()->get('user_id');
        
        // Récupérer les infos utilisateur
        $user = $this->userModel->find($userId);

        if (!$user) {
            return redirect()->to(base_url('login'))
                ->with('erreur', 'Utilisateur introuvable.');
        }

        // Récupérer les paramètres GET (compatibles avec les deux formats de noms)
        $dateDebut         = $this->request->getGet('dateDebut') ?? $this->request->getGet('date_debut') ?? '';
        $dateFin           = $this->request->getGet('dateFin')   ?? $this->request->getGet('date_fin')   ?? '';
        $chambreSelectionnee = $this->request->getGet('chamb_id') ?? '';

        // Convertir Y-m-d → Y-m-dTHH:MM pour les champs datetime-local
        if ($dateDebut && strlen($dateDebut) === 10) {
            $dateDebut = $dateDebut . 'T14:00';
        }
        if ($dateFin && strlen($dateFin) === 10) {
            $dateFin = $dateFin . 'T10:00';
        }

        // Récupérer toutes les chambres
        $chambres = $this->reserveModel->getAllChambres();

        return view('Pages/formulaire_reservation', [
            'chambres'            => $chambres,
            'user'                => $user,
            'dateDebut'           => $dateDebut,
            'dateFin'             => $dateFin,
            'chambreSelectionnee' => $chambreSelectionnee,
        ]);
    }

    /**
     * Traite la soumission du formulaire de réservation
     */
    public function reserver()
    {
        // Vérifier si l'utilisateur est connecté
        if (!session()->get('isLoggedIn')) {
            return redirect()->to(base_url('login'))
                ->with('erreur', 'Vous devez être connecté pour faire une réservation.');
        }

        // Validation des données
        $rules = [
            'chamb_id' => 'required|string',
            'reser_dateDebut' => 'required',
            'reser_dateFin' => 'required'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('erreurs', $this->validator->getErrors());
        }

        $chamb_id = $this->request->getPost('chamb_id');
        $reser_dateDebut = $this->request->getPost('reser_dateDebut');
        $reser_dateFin = $this->request->getPost('reser_dateFin');
        $user_id = session()->get('user_id');

        // Validation métier
        try {
            $dateDebut = new \DateTime($reser_dateDebut);
            $dateFin = new \DateTime($reser_dateFin);
            $now = new \DateTime();
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('erreur', 'Format de date invalide.');
        }

        if ($dateFin <= $dateDebut) {
            return redirect()->back()
                ->with('erreur', 'La date de départ doit être après la date d\'arrivée.');
        }

        if ($dateDebut < $now) {
            return redirect()->back()
                ->with('erreur', 'La date d\'arrivée ne peut pas être dans le passé.');
        }

        // Vérifier la disponibilité
        if (!$this->reserveModel->isChambreDisponible($chamb_id, $reser_dateDebut, $reser_dateFin)) {
            return redirect()->back()
                ->with('erreur', 'Cette chambre n\'est pas disponible pour les dates sélectionnées.');
        }

        // Calculer le prix total
        $chambreModel = new ChambreModel();
        $chambre = $chambreModel->getChambreWithType($chamb_id);
        $nuits = $dateDebut->diff($dateFin)->days;
        $prix_total = ($chambre && isset($chambre['prix_unitaire_nuit']))
            ? round($chambre['prix_unitaire_nuit'] * $nuits, 2)
            : null;

        // Créer la réservation
        try {
            if ($this->reserveModel->creerReservation($user_id, $chamb_id, $reser_dateDebut, $reser_dateFin, $prix_total)) {
                return redirect()->to(base_url('mes-reservations'))
                    ->with('success', 'Votre réservation a été confirmée avec succès !');
            }
            return redirect()->back()
                ->with('erreur', 'Une erreur s\'est produite lors de la réservation.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('erreur', 'Erreur base de données : ' . $e->getMessage());
        }
    }

    /**
     * Vérifie la disponibilité d'une chambre via AJAX
     */
    public function checkDisponibilite()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(403);
        }

        $chamb_id = $this->request->getPost('chamb_id');
        $dateDebut = $this->request->getPost('dateDebut');
        $dateFin = $this->request->getPost('dateFin');

        $disponible = $this->reserveModel->isChambreDisponible($chamb_id, $dateDebut, $dateFin);

        return $this->response->setJSON(['disponible' => $disponible]);
    }
}
