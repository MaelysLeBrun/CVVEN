<?php

namespace App\Controllers;

use App\Models\UserModel;

class LoginController extends BaseController
{
    public function login()
    {
        // juste pour tester la vue, sans session ni POST
        return view('auth/login');
    }

    public function attemptLogin()
    {
        $session = session();
        $model = new UserModel();

        $login = $this->request->getPost('user_login');
        $password = $this->request->getPost('user_mdp');

        $user = $model->where('user_login', $login)->first();

        //if (!$user || !password_verify($password, $user['user_mdp'])) {
        if (!$user || $password !== $user['user_mdp']) {
            return redirect()->back()->with('error', 'Identifiants incorrects');
        }

        $session->set([
            'user_id'    => $user['user_id'],
            'user_login' => $user['user_login'],
            'isLoggedIn' => true
        ]);

        return redirect()->to('/'); // index de Hotel
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}
