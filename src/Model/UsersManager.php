<?php
/**
 * Created by PhpStorm.
 * User: romar
 * Date: 30.04.2018
 * Time: 15:40
 */

namespace App\Model;

use \PDO;
use Exception;

class UsersManager extends Manager
{

    public function login_check_user($user)
    {
        $db = $this->connection_to_db();
        $req_check_if_user_exist = "SELECT pseudo_utilisateur FROM t_utilisateur WHERE pseudo_utilisateur=:user OR email_utilisateur=:user";
        $query = $db->prepare($req_check_if_user_exist);
        $query->bindParam(':user', $user, PDO::PARAM_STR);
        $query->execute();
        $count = $query->rowCount();
        $query->closeCursor();
        if($count === 1)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function log_in($user, $passwd)
    {
        $db = $this->connection_to_db();
        $req_log_in = "SELECT id_utilisateur, pseudo_utilisateur, nom_utilisateur, nom_famille_utilisateur, email_utilisateur, password_utilisateur FROM t_utilisateur WHERE pseudo_utilisateur=:user OR email_utilisateur=:user";
        $query = $db->prepare($req_log_in);
        $query->bindParam(':user',$user, PDO::PARAM_STR);
        $query->execute();
        $user = $query->fetch();

        $check_password = password_verify($passwd, $user['password_utilisateur']);

        if($check_password) // mot de passe valide, connection validée
        {
            $_SESSION['user_id'] = $user['id_utilisateur'];
            $_SESSION['username'] = $user['pseudo_utilisateur'];
            $_SESSION['name'] = $user['nom_utilisateur'];
            $_SESSION['family_name'] = $user['nom_famille_utilisateur'];
            $_SESSION['email'] = $user['email_utilisateur'];
            $query->closeCursor();
        }
        else
        {
            throw new Exception('Mot de passe invalide');
        }
    }

    public function check_subscribed_user($username, $email)
    {
        $db = $this->connection_to_db();
        $req_check_user = "SELECT pseudo_utilisateur, email_utilisateur FROM t_utilisateur WHERE pseudo_utilisateur=:username OR email_utilisateur=:email";
        $query = $db->prepare($req_check_user);
        $query->bindParam(':username', $username, PDO::PARAM_STR);
        $query->bindParam(':email', $email, PDO::PARAM_STR);
        $query->execute();
        $users_count = $query->rowCount();

        if($users_count > 0)
        {
            return false;
        }
        else
        {
            return true;
        }
    }

    public function subscribe($username, $email, $psswd)
    {
        $hashed_password = password_hash($psswd, PASSWORD_DEFAULT);
        $db = $this->connection_to_db();
        $req_add_user = "INSERT INTO t_utilisateur(pseudo_utilisateur, email_utilisateur, password_utilisateur) VALUES(:username, :email, :user_password)";
        $query = $db->prepare($req_add_user);
        $query->bindParam(':username', $username, PDO::PARAM_STR);
        $query->bindParam(':email', $email, PDO::PARAM_STR);
        $query->bindParam(':user_password', $hashed_password, PDO::PARAM_STR);
        $query->execute();
    }

    public function log_out(){
        session_unset();
        session_destroy();
    }
}