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

    static function login_user($username, $password)
    {
        if(!isset($_SESSION['username']))
        {
            if(!empty($username) && !empty($password))
            {
                $user = new UsersManager();
                if($user->login_check_user($username))
                {
                    $user->log_in($username, $password);
                    echo 'Bonjour ' . $_SESSION['username'] . '!';
                }
                else
                {
                    throw new Exception("Vos informations ne sont pas valides");
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