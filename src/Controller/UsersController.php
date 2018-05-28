<?php
/**
 * Created by PhpStorm.
 * User: romar
 * Date: 03.05.2018
 * Time: 15:06
 */

namespace App\Controller;

use App\Model\SecurityManager;
use App\Model\UsersManager;
use Exception;

class UsersController
{
    private $_security;
    private $_user;

    public function __construct()
    {
        $this->_security = new SecurityManager();
        $this->_user = new UsersManager();
    }

    public function validate_user($username, $email, $password, $confirm_password)
    {
        if(!$this->_security->section_active())
        {
            if($this->_security->check_empty($_POST))
            {
                if($password === $confirm_password)
                {
                    if($this->_user->check_subscribed_user($username,$email))
                    {
                        $this->_user->validate_user($username,$email,$password);
                    }
                    else
                    {
                        throw new Exception("Username ou email déjà enregistré");
                    }
                }
                else
                {
                    throw new Exception("Mots de passe, pas identiques");
                }
            }
            else
            {
                throw new Exception("Tous les champs ne sont pas remplis");
            }
        }
        else
        {
            throw new Exception("Vous êtes déjà connecté");
        }
    }

    /**
     * @param $username -> username ou email envoyé en $_POST via le formulaire
     * @param $password -> mot de passe envoyé en $_POST via le formulaire
     * @throws Exception -> Exceptions en cas d'erreur!
     *
     * Toutes les étapes nécessaires au login de l'utilisateur sont testé dans cette fonction
     * Si l'user passe toutes les étapes demandées, les CONSTANTES de session seront alors initialisées
     */
    public function login_user($username, $password)
    {
        if(!$this->_security->section_active()) // check d'abord si un user n'est pas déjà connecté..
        {
            if($this->_security->check_empty($_POST)) // check si les valeurs envoyées ne sont pas vides
            {
                if($this->_user->check_registered_user($username)) // check si l'username ou l'email envoyé est déjà enregistré
                {
                    if($this->_user->check_password($username,$password)) // check si le mot de passe correspond
                    {
                        // INITIALISATION DES CONSTANTES DE SESSION
                        $this->_user->login($username);
                    }
                    else
                    {
                        throw new Exception("Mot de passe invalide!");
                    }
                }
                else
                {
                    throw new Exception("Pseudo ou e-mail invalide");
                }

            }
            else
            {
                throw new Exception("Tous les champs ne sont pas remplis");
            }
        }
        else
        {
            throw new Exception("Vous êtes déjà connecté");
        }
    }

    /**
     * @throws Exception
     */
    public function logout()
    {
        if($this->_security->section_active())
        {
            $this->_user->log_out();
            echo 'Vous êtes bien déconnnecté';
        }
        else
        {
            throw new Exception("Vous n'êtes pas connecté");
        }
    }

}