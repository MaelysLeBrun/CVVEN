<?php

namespace App\Controllers;

use App\Models\UserModel;

/**
 * Contrôleur pour l'authentification des utilisateurs
 * 
 * Gère la connexion, l'inscription et la déconnexion des utilisateurs.
 * Utilise les sessions pour maintenir l'état de connexion.
 * 
 * @package App\Controllers
 * @author  CVVEN
 * @version 1.0.0
 */
class LoginController extends BaseController
{
    /**
     * Affiche le formulaire de connexion
     * 
     * @return string Vue du formulaire de connexion
     */
    public function login()
    {
        // juste pour tester la vue, sans session ni POST
        return view('auth/login');
    }

    /**
     * Traite la tentative de connexion
     * 
     * Vérifie les identifiants de l'utilisateur (login et mot de passe).
     * Si valides, crée une session avec les informations de l'utilisateur.
     * Sinon, redirige vers le formulaire avec un message d'erreur.
     * 
     * @return \CodeIgniter\HTTP\RedirectResponse Redirection vers l'accueil ou retour au formulaire
     */
    public function attemptLogin()
    {
        $session = session();
        $model = new UserModel();

        $login = $this->request->getPost('user_login');
        $password = $this->request->getPost('user_mdp');

        $user = $model->where('user_login', $login)->first();

        if (!$user || !password_verify($password, $user['user_mdp'])) {
            return redirect()->back()->with('error', 'Identifiants incorrects');
        }

        $session->set([
            'user_id'    => $user['user_id'],
            'user_login' => $user['user_login'],
            'isLoggedIn' => true
        ]);

        return redirect()->to('/'); // index de Hotel
    }

    /**
     * Affiche le formulaire d'inscription
     */
    public function showRegister()
    {
        return view('auth/register');
    }

    /**
     * Traite l'inscription d'un nouvel utilisateur
     * 
     * Valide les données du formulaire (login unique, email unique, mot de passe confirmé),
     * hache le mot de passe et crée l'utilisateur en base de données.
     * Connecte automatiquement l'utilisateur après inscription réussie.
     * 
     * @return \CodeIgniter\HTTP\RedirectResponse Redirection vers l'accueil ou retour au formulaire avec erreurs
     */
    public function register()
    {
        $session = session();
        $model = new UserModel();

        $rules = [
            'user_login' => 'required|alpha_numeric_space|min_length[3]|is_unique[Utilisateur.user_login]',
            'user_mdp' => 'required|min_length[6]',
            'user_mdp_confirm' => 'matches[user_mdp]',
            'user_mail' => 'required|valid_email|is_unique[Utilisateur.user_mail]',
            'user_nom' => 'required',
            'user_prenom' => 'required'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'user_login' => $this->request->getPost('user_login'),
            'user_mdp' => password_hash($this->request->getPost('user_mdp'), PASSWORD_DEFAULT),
            'user_nom' => $this->request->getPost('user_nom'),
            'user_prenom' => $this->request->getPost('user_prenom'),
            'user_mail' => $this->request->getPost('user_mail'),
            'user_telephone' => $this->request->getPost('user_telephone')
        ];

        $model->insert($data);
        $id = $model->getInsertID();
        $user = $model->find($id);

        $session->set([
            'user_id'    => $user['user_id'],
            'user_login' => $user['user_login'],
            'isLoggedIn' => true
        ]);

        return redirect()->to('/');
    }
    /**
     * Déconnecte l'utilisateur
     * 
     * Détruit la session et redirige vers la page de connexion.
     * 
     * @return \CodeIgniter\HTTP\RedirectResponse Redirection vers la page de connexion
     */
    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}
