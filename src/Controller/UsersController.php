<?php
/**
 * Created by PhpStorm.
 * User: romar
 * Date: 03.05.2018
 * Time: 15:06
 */

namespace App\Controller;

class UsersController extends MainController
{

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
                        $this->controllerException("Username ou email déjà enregistré");
                    }
                }
                else
                {
                    $this->controllerException("Mots de passe, pas identiques");
                }
            }
            else
            {
                $this->controllerException("Tous les champs ne sont pas remplis");
            }
        }
        else
        {
            $this->controllerException("Vous êtes déjà connecté");
        }
    }

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
                        $this->controllerException("Mot de passe invalide");
                    }
                }
                else
                {
                    $this->controllerException("Pseudo ou email invalide");
                }
            }
            else
            {
                $this->controllerException("Tous les champs ne sont pas remplis");
            }
        }
        else
        {
            $this->controllerException("Vous êtes déjà connecté");
        }
    }

    public function logout()
    {
        if($this->_security->section_active())
        {
            $this->_user->log_out();
            echo 'Vous êtes bien déconnnecté';
        }
        else
        {
            $this->controllerException("Vous n'êtes pas connecté");
        }
    }

}