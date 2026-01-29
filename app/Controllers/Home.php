<?php

namespace App\Controllers;

/**
 * Contrôleur de la page d'accueil
 * 
 * Gère l'affichage de la page d'accueil de l'application
 * 
 * @package App\Controllers
 * @author  CVVEN
 * @version 1.0.0
 */
class Home extends BaseController
{
    /**
     * Affiche la page d'accueil
     * 
     * @return string Vue de la page d'accueil
     */
    public function index(): string
    {
        return view('welcome_message');
    }
}
