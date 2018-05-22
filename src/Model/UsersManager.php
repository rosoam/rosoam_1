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
use PHPMailer\PHPMailer\PHPMailer;

class UsersManager extends Manager
{

    /**
     * @param $user
     * @return bool
     */
    public function check_registered_user($user)
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

    /**
     * @param $user
     * @param $password
     * @return bool
     */
    public function check_password($user, $password)
    {
        $db = $this->connection_to_db();
        $req_check_password = "SELECT password_utilisateur FROM t_utilisateur WHERE pseudo_utilisateur=:user OR email_utilisateur=:user";
        $query = $db->prepare($req_check_password);
        $query->bindParam(':user',$user, PDO::PARAM_STR);
        $query->execute();

        $user = $query->fetch();

        $check_password = password_verify($password, $user['password_utilisateur']);

        $query->closeCursor();

        if($check_password === true)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    /**
     * @param $username
     * @return bool
     */
    public function check_confirmed_user($username)
    {
        $db = $this->connection_to_db();
        $req_check_confirmed_user = "SELECT valid_utilisateur FROM t_utilisateur WHERE pseudo_utilisateur=:user OR email_utilisateur=:user";
        $query = $db->prepare($req_check_confirmed_user);
        $query->bindParam(':user', $username, PDO::PARAM_STR);
        $query->execute();

        $user = $query->fetch();

        $query->closeCursor();

        if($user['valid_utilisateur'] === 1)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    /**
     * @param $user
     */
    public function login($user)
    {
        $db = $this->connection_to_db();
        $req_user_infos = "SELECT id_utilisateur, pseudo_utilisateur, nom_utilisateur, nom_famille_utilisateur, email_utilisateur FROM t_utilisateur WHERE pseudo_utilisateur=:user OR email_utilisateur=:user";
        $query = $db->prepare($req_user_infos);
        $query->bindParam(':user', $user, PDO::PARAM_STR);
        $query->execute();

        $user = $query->fetch();

        $query->closeCursor();

        $_SESSION['user_id'] = $user['id_utilisateur'];
        $_SESSION['username'] = $user['pseudo_utilisateur'];
        $_SESSION['name'] = $user['nom_utilisateur'];
        $_SESSION['family_name'] = $user['nom_famille_utilisateur'];
        $_SESSION['email'] = $user['email_utilisateur'];
        $_SESSION['image_profil'] = $user['image_profil_utilisateur'];
    }

    /**
     * @param $username
     * @param $email
     * @param $password
     * @throws \PHPMailer\PHPMailer\Exception
     */
    public function validate_user($username, $email, $password)
    {
        $password = password_hash($password, PASSWORD_DEFAULT);
        $validation_code = substr(md5(mt_rand()),0,30);

        $db = $this->connection_to_db();
        $req_add_unchecked_user = "INSERT INTO t_utilisateur (pseudo_utilisateur, email_utilisateur, password_utilisateur, validation_code_utilisateur) VALUES (:username , :email, :password_ut, :validation_code)";
        $query = $db->prepare($req_add_unchecked_user);
        $query->bindParam(':username', $username, PDO::PARAM_STR);
        $query->bindParam(':email', $email, PDO::PARAM_STR);
        $query->bindParam(':password_ut', $password, PDO::PARAM_STR);
        $query->bindParam(':validation_code',$validation_code, PDO::PARAM_STR);
        $query->execute();
        $query->closeCursor();

        // email preparation
        $last_id = $db->lastInsertId();

        $mail = new PHPMailer(true);
        $mail->SMTPDebug = 2;
        $mail->isSMTP();
        $mail->Host = 'mail.infomaniak.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'info@rosoam.ch';
        $mail->Password = 'd';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('info@rosoam.ch', 'localhost!');
        $mail->addAddress($email, $username);

        $mail->charSet = 'UTF-8';
        $mail->isHTML(true);
        $mail->Subject = "Lien de validation de votre enregistrement " . $username . " :)";
        $mail->Body    = "Merci de votre enregistrement! Naviguez jusqu'à ce lien pour valider votre enregistrement! -> <a href='http://localhost/validate_user/" . $last_id . "/" . $validation_code . "/'>http://localhost/validate_user/" . $last_id . "/" . $validation_code . "/ </a>";
        $mail->AltBody = 'Ceci est le alt body';

        $mail->send();


        //mail($to_email, $sujet, $message, $header);
        //echo "Mail envoyé! Veuillez s'il vous-plaît vérifier votre boîte mail.";
    }

    /**
     * @param $id
     * @param $validation_code
     * @return bool
     * @throws Exception
     */
    public function confirm_user_validation($id, $validation_code)
    {
        $db = $this->connection_to_db();
        $req_check_unchecked_user = "SELECT id_utilisateur, validation_code_utilisateur FROM t_utilisateur WHERE id_utilisateur=:id_unchecked_utilisateur AND validation_code_utilisateur=:validation_code";
        $query = $db->prepare($req_check_unchecked_user);
        $query->bindParam(':id_unchecked_utilisateur',$id, PDO::PARAM_INT);
        $query->bindParam(':validation_code',$validation_code, PDO::PARAM_STR);
        $query->execute();

        $query->closeCursor();

        if($query->rowCount() === 1)
        {
            $req_change_validation_of_user = "UPDATE t_utilisateur SET valid_utilisateur=1 WHERE t_utilisateur.id_utilisateur=:id";
            $query = $db->prepare($req_change_validation_of_user);
            $query->bindParam(':id',$id, PDO::PARAM_INT);
            $query->execute();
            $query->closeCursor();
            return true;
        }
        else
        {
            return false;
        }
    }

    /**
     * @param $username
     * @param $email
     * @return bool
     */
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

    /**
     * @param $username
     * @param $email
     * @param $psswd
     */
    public function subscribe($username, $email, $psswd)
    {
        $psswd = password_hash($psswd, PASSWORD_DEFAULT);
        $db = $this->connection_to_db();
        $req_add_user = 'INSERT INTO `t_utilisateur`(`pseudo_utilisateur`, `email_utilisateur`, `password_utilisateur`) VALUES(:username, :email, :user_password)';
        $query = $db->prepare($req_add_user);
        $query->bindParam(':username', $username, PDO::PARAM_STR);
        $query->bindParam(':email', $email, PDO::PARAM_STR);
        $query->bindParam(':user_password', $psswd, PDO::PARAM_STR);
        $query->execute();
    }

    public function log_out(){
        session_unset();
        session_destroy();
    }
}