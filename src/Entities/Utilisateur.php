<?php
/**
 * Created by PhpStorm.
 * User: rso
 * Date: 28.05.2018
 * Time: 14:24
 */

namespace App\Entities;


class Utilisateur
{
    private $_id;
    private $_pseudo;
    private $_email;
    private $_password;
    private $_nom;
    private $_nomFamille;
    private $_valid;
    private $_validationCode;
    private $_imageProfil;


    public function __construct($datas)
    {
        $this->_id =                $datas['id_utilisateur'];
        $this->_pseudo =            $datas['pseudo_utilisateur'];
        $this->_email =             $datas['email_utilisateur'];
        $this->_password =          $datas['password_utilisateur'];
        $this->_nom =               $datas['nom_utilisateur'];
        $this->_nomFamille =        $datas['nom_famille_utilisateur'];
        $this->_valid =             $datas['valid_utilisateur'];
        $this->_validationCode =    $datas['validation_code_utilisateur'];
        $this->_imageProfil =       $datas['image_profil_utilisateur'];
    }

    // FUNCTIONS GETTERS
    public function getId()
    {
        return $this->_id;
    }

    public function getPseudo()
    {
        return $this->_pseudo;
    }

    public function getEmail()
    {
        return $this->_email;
    }

    public function getPassword()
    {
        return $this->_password;
    }

    public function getNom()
    {
        return $this->_nom;
    }

    public function getNomFamille()
    {
        return $this->_nomFamille;
    }

    public function getValid()
    {
        return $this->_valid;
    }

    public function getValidationCode()
    {
        return $this->_validationCode;
    }

    public function getImageProfil()
    {
        return $this->_imageProfil;
    }

    // FUNCTIONS SETTERS
    public function setId($id)
    {
        $id = (int) $id;
        if($id > 0)
        {
            $this->_id = $id;
        }
    }

    public function setPseudo($pseudo)
    {
        $pseudo = (string) $pseudo;
        $this->_pseudo = $pseudo;
    }

    public function setEmail($email)
    {
        $email = (string) $email;
        $this->_email = $email;
    }

    public function setPassword($password)
    {
        $password = (string) $password;
        $this->_password = $password;
    }

    public function setNom($nom)
    {
        $nom = (string) $nom;
        $this->_nom = $nom;
    }

    public function setNomFamille($nomFamille)
    {
        $nomFamille = (string) $nomFamille;
        $this->_nomFamille = $nomFamille;
    }

    public function setValid($valid)
    {
        $valid = (bool) $valid;
        $this->_valid = $valid;
    }

    public function setValidationCode($validationCode)
    {
        $validationCode = (string) $validationCode;
        $this->_validationCode = $validationCode;
    }

    public function setImageProfil($imageProfil)
    {
        $imageProfil = (string) $imageProfil;
        $this->_imageProfil = $imageProfil;
    }
}