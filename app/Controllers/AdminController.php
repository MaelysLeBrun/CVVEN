<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\ReserveModel;
use App\Models\ChambreModel;

class AdminController extends BaseController
{
    // ─── Utilisateurs ────────────────────────────────────────────────

    public function users()
    {
        $model = new UserModel();
        $users = $model->orderBy('user_id', 'ASC')->findAll();

        return view('admin/users', ['users' => $users]);
    }

    public function editUser(string $id)
    {
        $model = new UserModel();
        $user  = $model->find($id);

        if (!$user) {
            return redirect()->to('/admin/users')->with('erreur', 'Utilisateur introuvable.');
        }

        return view('admin/edit_user', ['user' => $user]);
    }

    public function updateUser(string $id)
    {
        $model = new UserModel();
        $user  = $model->find($id);

        if (!$user) {
            return redirect()->to('/admin/users')->with('erreur', 'Utilisateur introuvable.');
        }

        $data = [
            'user_nom'       => $this->request->getPost('user_nom'),
            'user_prenom'    => $this->request->getPost('user_prenom'),
            'user_mail'      => $this->request->getPost('user_mail'),
            'user_telephone' => $this->request->getPost('user_telephone'),
            'user_role'      => $this->request->getPost('user_role'),
        ];

        $newPassword = $this->request->getPost('user_mdp');
        if (!empty($newPassword)) {
            $data['user_mdp'] = password_hash($newPassword, PASSWORD_DEFAULT);
        }

        $model->update($id, $data);

        return redirect()->to('/admin/users')->with('success', 'Utilisateur mis à jour.');
    }

    public function deleteUser(string $id)
    {
        // Empêcher la suppression de son propre compte
        if ($id === session()->get('user_id')) {
            return redirect()->to('/admin/users')->with('erreur', 'Vous ne pouvez pas supprimer votre propre compte.');
        }

        $model = new UserModel();
        $user  = $model->find($id);

        if (!$user) {
            return redirect()->to('/admin/users')->with('erreur', 'Utilisateur introuvable.');
        }

        // Supprimer les réservations liées
        $db = \Config\Database::connect();
        $db->table('Reserve')->where('user_id', $id)->delete();

        $model->delete($id);

        return redirect()->to('/admin/users')->with('success', 'Utilisateur supprimé.');
    }

    // ─── Réservations ────────────────────────────────────────────────

    public function reservations()
    {
        $db = \Config\Database::connect();

        $reservations = $db->table('Reserve r')
            ->select('r.reser_id, r.reser_dateDebut, r.reser_dateFin, r.prix_total,
                      u.user_id, u.user_nom, u.user_prenom, u.user_login,
                      c.chamb_id, c.chamb_numero, c.chamb_emplacement,
                      t.type_libelle')
            ->join('Utilisateur u', 'u.user_id = r.user_id')
            ->join('Chambre c', 'c.chamb_id = r.chamb_id')
            ->join('Type_Chambre t', 't.type_id = c.type_id')
            ->orderBy('r.reser_dateDebut', 'DESC')
            ->get()
            ->getResultArray();

        return view('admin/reservations', ['reservations' => $reservations]);
    }

    public function editReservation(int $id)
    {
        $db = \Config\Database::connect();

        $reservation = $db->table('Reserve r')
            ->select('r.reser_id, r.reser_dateDebut, r.reser_dateFin,
                      u.user_id, u.user_nom, u.user_prenom, u.user_login,
                      c.chamb_id, c.chamb_numero, c.chamb_emplacement,
                      t.type_libelle')
            ->join('Utilisateur u', 'u.user_id = r.user_id')
            ->join('Chambre c', 'c.chamb_id = r.chamb_id')
            ->join('Type_Chambre t', 't.type_id = c.type_id')
            ->where('r.reser_id', $id)
            ->get()
            ->getRowArray();

        if (!$reservation) {
            return redirect()->to('/admin/reservations')->with('erreur', 'Réservation introuvable.');
        }

        $chambres = $db->table('Chambre c')
            ->select('c.chamb_id, c.chamb_numero, c.chamb_emplacement, t.type_libelle')
            ->join('Type_Chambre t', 't.type_id = c.type_id')
            ->orderBy('c.chamb_numero', 'ASC')
            ->get()
            ->getResultArray();

        return view('admin/edit_reservation', [
            'reservation' => $reservation,
            'chambres'    => $chambres,
        ]);
    }

    public function updateReservation(int $id)
    {
        $db = \Config\Database::connect();

        $reservation = $db->table('Reserve')->where('reser_id', $id)->get()->getRowArray();

        if (!$reservation) {
            return redirect()->to('/admin/reservations')->with('erreur', 'Réservation introuvable.');
        }

        $dateDebut = $this->request->getPost('reser_dateDebut');
        $dateFin   = $this->request->getPost('reser_dateFin');
        $chambId   = $this->request->getPost('chamb_id');

        if ($dateDebut >= $dateFin) {
            return redirect()->back()->withInput()->with('erreur', 'La date de départ doit être postérieure à la date d\'arrivée.');
        }

        $db->table('Reserve')->where('reser_id', $id)->update([
            'reser_dateDebut' => $dateDebut,
            'reser_dateFin'   => $dateFin,
            'chamb_id'        => $chambId,
        ]);

        return redirect()->to('/admin/reservations')->with('success', 'Réservation mise à jour.');
    }

    public function deleteReservation(int $id)
    {
        $db = \Config\Database::connect();
        $db->table('Reserve')->where('reser_id', $id)->delete();

        return redirect()->to('/admin/reservations')->with('success', 'Réservation supprimée.');
    }
}
