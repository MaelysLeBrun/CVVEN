<?php

namespace App\Controllers;

use App\Models\ChambreModel;
use App\Models\ReservationModel;

/**
 * Contrôleur pour la gestion des réservations
 * 
 * Gère l'affichage du formulaire de réservation, la vérification de disponibilité
 * des chambres et le traitement des réservations.
 * 
 * @package App\Controllers
 * @author  CVVEN
 * @version 1.0.0
 */
class ReservationController extends BaseController
{
    /**
     * Affiche le formulaire de réservation avec la liste des chambres disponibles
     * 
     * Récupère toutes les chambres disponibles et affiche le formulaire
     * de réservation.
     * 
     * @return string Vue du formulaire de réservation
     */
    public function index()
    {
        // Instancier le modèle des chambres
        $modeleChambre = new ChambreModel();
        
        // Récupérer toutes les chambres disponibles
        $donnees['chambres'] = $modeleChambre->getChambresDisponibles();
        
        // Afficher le formulaire de réservation
        return view('Pages/formulaire_reservation', $donnees);
    }

    /**
     * Traite la réservation d'une chambre
     * 
     * Valide les données du formulaire, vérifie la disponibilité de la chambre
     * pour les dates sélectionnées, et enregistre la réservation si valide.
     * L'utilisateur doit être connecté (user_id en session).
     * 
     * @return \CodeIgniter\HTTP\RedirectResponse Redirection vers la page de succès ou retour avec erreurs
     */
    public function reserver()
    {
        // Vérifier si le formulaire a été soumis via POST
        if ($this->request->getMethod() === 'post') {
            
            // Définir les règles de validation
            $regles = [
                'chamb_id' => 'required',
                'reser_dateDebut' => 'required|valid_date',
                'reser_dateFin' => 'required|valid_date'
            ];

            // Valider les données du formulaire
            if ($this->validate($regles)) {
                // Instancier le modèle de réservation
                $modeleReservation = new ReservationModel();
                
                // Préparer les données pour l'insertion
                $donneesReservation = [
                    'user_id' => session()->get('user_id'), // ID de l'utilisateur connecté
                    'chamb_id' => $this->request->getPost('chamb_id'),
                    'reser_dateDebut' => $this->request->getPost('reser_dateDebut'),
                    'reser_dateFin' => $this->request->getPost('reser_dateFin')
                ];

                // Vérifier si la chambre est disponible pour ces dates
                $estDisponible = $modeleReservation->verifierDisponibilite(
                    $donneesReservation['chamb_id'],
                    $donneesReservation['reser_dateDebut'],
                    $donneesReservation['reser_dateFin']
                );

                if ($estDisponible) {
                    // Insérer la réservation dans la base de données
                    if ($modeleReservation->insert($donneesReservation)) {
                        // Rediriger vers la page de succès
                        return redirect()->to('/reservation/succes');
                    } else {
                        // Erreur lors de l'insertion
                        return redirect()->back()->with('erreur', 'Erreur lors de l\'enregistrement de la réservation');
                    }
                } else {
                    // Chambre non disponible pour ces dates
                    return redirect()->back()->with('erreur', 'Cette chambre n\'est pas disponible pour les dates sélectionnées');
                }
            } else {
                // Données invalides - retourner avec les erreurs
                return redirect()->back()->withInput()->with('erreurs', $this->validator->getErrors());
            }
        }
        
        // Si pas POST, rediriger vers le formulaire
        return redirect()->to('/reservation');
    }

    /**
     * Affiche la page de confirmation de réservation
     * 
     * Page affichée après une réservation réussie.
     * 
     * @return string Vue de confirmation
     */
    public function succes()
    {
        return view('reservation_succes');
    }
}