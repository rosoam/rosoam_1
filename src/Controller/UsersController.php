<?php
/**
 * Created by PhpStorm.
 * User: romar
 * Date: 03.05.2018
 * Time: 15:06
 */

namespace App\Controller;

use App\Model\UsersManager;
use Exception;

class UsersController
{

    static function subscribe_user($username, $email, $password, $confirm_password)
    {
        if(!isset($_SESSION['username']))
        {
            if(!empty($username) && !empty($email) && !empty($password) && !empty($confirm_password))
            {
                if($password === $confirm_password)
                {
                    $user = new UsersManager();
                    if($user->check_subscribed_user($username,$email))
                    {
                        $user->subscribe($username, $email, $password);
                        echo "Merci de votre inscription";
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

    static function validate_user($username, $email, $password, $confirm_password)
    {
        if(!isset($_SESSION['username']))
        {
            if(!empty($username) && !empty($email) && !empty($password) && !empty($confirm_password))
            {
                if($password === $confirm_password)
                {
                    $user = new UsersManager();
                    if($user->check_subscribed_user($username,$email))
                    {
                        $send_mail = new UsersManager();
                        $send_mail->validate_user($username,$email, $password);
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
     *
     * Toutes les étapes nécessaires au login de l'utilisateur sont testé dans cette fonction
     * Si l'user passe toutes les étapes demandées, les CONSTANTES de session seront alors initialisées
     */
    static function login_user($username, $password)
    {
        if(!isset($_SESSION['username'])) // check d'abord si un user n'est pas déjà connecté..
        {
            if(!empty($username) && !empty($password)) // check si les valeurs envoyées ne sont pas vides
            {
                $user = new UsersManager();
                if($user->check_registered_user($username)) // check si l'username ou l'email envoyé est déjà enregistré
                {
                    if($user->check_password($username,$password)) // check si le mot de passe correspond
                    {
                        // INITIALISATION DES CONSTANTES DE SESSION
                        $user->login($username);
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

    static function logout()
    {
        if(isset($_SESSION['username']))
        {
            $user = new UsersManager();
            $user->log_out();
            echo 'Vous êtes bien déconnnecté';
        }
        else
        {
            throw new Exception("Vous n'êtes pas connecté");
        }
    }

}