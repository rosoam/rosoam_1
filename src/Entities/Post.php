<?php
/**
 * Created by PhpStorm.
 * User: rso
 * Date: 28.05.2018
 * Time: 08:50
 */

namespace App\Entities;


class Post
{
    private $_id;
    private $_titre;
    private $_auteur;
    private $_extrait;
    private $_contenu;
    private $_publication;
    private $_couverture;
    private $_slug;
    private $_likes;

    public function __construct($datas)
    {
        $this->_id =            $datas['id_article'];
        $this->_titre =         $datas['titre_article'];
        $this->_auteur =        $datas['auteur_article'];
        $this->_extrait =       $datas['extrait_article'];
        $this->_contenu =       $datas['contenu_article'];
        $this->_publication =   $datas['publication_article'];
        $this->_couverture =    $datas['couverture_article'];
        $this->_slug =          $datas['slug_article'];
        $this->_likes =         $datas['likes_article'];
    }

    // FUNCTIONS GETTERS
    public function getId()
    {
        return $this->_id;
    }

    public function getTitre()
    {
        return $this->_titre;
    }

    public function getAuteur()
    {
        return $this->_auteur;
    }

    public function getExtrait()
    {
        return $this->_extrait;
    }

    public function getContenu()
    {
        return $this->_contenu;
    }

    public function getPublication()
    {
        return $this->_publication;
    }

    public function getCouverture()
    {
        return $this->_couverture;
    }

    public function getSlug()
    {
        return $this->_slug;
    }

    public function getLikes()
    {
        return $this->_likes;
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

    public function setTitre($titre)
    {
        $titre = (string) $titre;
        $this->_titre = $titre;
    }

    public function setAuteur($auteur)
    {
        $auteur = (string) $auteur;
        $this->_auteur = $auteur;
    }

    public function setExtrait($extrait)
    {
        $extrait = (string) $extrait;
        $this->_extrait = $extrait;
    }

    public function setContenu($contenu)
    {
        $contenu = (string) $contenu;
        $this->_contenu = $contenu;
    }

    public function setPublication($publication)
    {
        $publication = (string) $publication;
        $this->_publication = $publication;
    }

    public function setCouverture($couverture)
    {
        $couverture = (string) $couverture;
        $this->_couverture = $couverture;
    }

    public function setSlug($slug)
    {
        $slug = (string) $slug;
        $this->_slug = $slug;
    }

    public function setLikes($likes)
    {
        $likes = (int) $likes;
        if($likes >= 0)
        {
            $this->_likes = $likes;
        }
    }

}