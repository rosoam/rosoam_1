<?php
/**
 * Created by PhpStorm.
 * User: rso
 * Date: 28.05.2018
 * Time: 14:46
 */

namespace App\Entities;


class Categorie
{
    private $_id;
    private $_nom;
    private $_slug;

    public function __construct($datas)
    {
        $this->setId($datas['id_categorie']);
        $this->setNom($datas['nom_categorie']);
        $this->setSlug($datas['slug_categorie']);
    }

    // FUNCTIONS GETTERS
    public function getId()
    {
        return $this->_id;
    }

    public function getNom(){
        return $this->_nom;
    }

    public function getSlug()
    {
        return $this->_slug;
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

    public function setNom($nom)
    {
        $nom = (string) $nom;
        $this->_nom = $nom;
    }

    public function setSlug($slug)
    {
        $slug = (string) $slug;
        $this->_slug = $slug;
    }
}