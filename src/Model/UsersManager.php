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

    public function validate_user($username, $email, $password)
    {
        ini_set('SMTP', 'mail.infomaniak.com');
        $password = password_hash($password, PASSWORD_DEFAULT);
        $validation_code = substr(md5(mt_rand()),0,30);

        $db = $this->connection_to_db();
        $req_add_unchecked_user = "INSERT INTO unchecked_utilisateur (pseudo_unchecked_utilisateur, email_unchecked_utilisateur, password_unchecked_utilisateur, validation_code) VALUES (:username, :email, :password, :validation_code)";
        $query = $db->prepare($req_add_unchecked_user);
        $query->bindParam(':username', $username, PDO::PARAM_STR);
        $query->bindParam(':email', $email, PDO::PARAM_STR);
        $query->bindParam(':password', $password, PDO::PARAM_STR);
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
        $mail->Password = 'document.readyfunction';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('info@rosoam.ch', 'localhost!');
        $mail->addAddress($email, $username);

        $mail->isHTML(true);
        $mail->Subject = "Lien de validation de votre enregistrement " . $username . " :)";
        $mail->Body    = "Merci de votre enregistrement! Naviguez jusqu'à ce lien pour valider votre enregistrement! -> <a href='http://localhost/validate_user/" . $last_id . "/" . $validation_code . "/'>http://localhost/validate_user/" . $last_id . "/" . $validation_code . "/ </a>";
        $mail->AltBody = 'Ceci est le alt body';

        $mail->send();


        //mail($to_email, $sujet, $message, $header);
        echo "Mail envoyé! Veuillez s'il vous-plaît vérifier votre boîte mail.";
    }

    public function check_valid_user($id, $validation_code)
    {
        $db = $this->connection_to_db();
        $req_check_unchecked_user = "SELECT * FROM unchecked_utilisateur AS uncu WHERE uncu.id_unchecked_utilisateur=:id_unchecked_utilisateur AND uncu.validation_code=:validation_code";
        $query = $db->prepare($req_check_unchecked_user);
        $query->bindParam(':id_unchecked_utilisateur',$id, PDO::PARAM_INT);
        $query->bindParam(':validation_code',$validation_code, PDO::PARAM_STR);
        $query->execute();

        if($query->rowCount() === 1)
        {
            $fetch_unchecked_user = $query->fetchAll();

            foreach($fetch_unchecked_user as $unchecked_user)
            {
                $this->subscribe($unchecked_user['pseudo_unchecked_utilisateur'], $unchecked_user['email_unchecked_utilisateur'], $unchecked_user['password_unchecked_utilisateur']);
                echo 'Merci, votre compte est bien validé.';
            }
            $query->closeCursor();

            $req_delete_checked_user = "DELETE * FROM unchecked_utilisateur AS uncu WHERE uncu.id_unchecked_utilisateur=:id";
            $query = $db->prepare($req_delete_checked_user);
            $query->binParam(':id',$id,PDO::PARAM_INT);
            $query->execute();
            $query->closeCursor();
        }
        else
        {
            throw new Exception("Vous ne vous êtes pas pré-inscrit");
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

    private function subscribe($username, $email, $psswd)
    {
        $db = $this->connection_to_db();
        $req_add_user = "INSERT INTO t_utilisateur(pseudo_utilisateur, email_utilisateur, password_utilisateur) VALUES(:username, :email, :user_password)";
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