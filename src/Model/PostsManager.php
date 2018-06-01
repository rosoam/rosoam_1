<?php
/**
 * Created by PhpStorm.
 * User: romar
 * Date: 30.04.2018
 * Time: 15:40
 */

namespace App\Model;

use \PDO;
use Cocur\Slugify\Slugify;

class PostsManager extends Manager
{


    /**
     * @return int -> fonction qui compte combien il y a d'articles enregistrés
     */
    public function count_posts()
    {
        $db = $this->connection_to_db();
        $req = "SELECT id_article FROM t_article";
        $query = $db->prepare($req);
        $query->execute();
        $count = $query->rowCount();
        $query->closeCursor();

        return $count;
    }


    /**
     * @param $order_by -> retourne tous les posts // personnels ou non personnels, avec ordre et limite en paramètre
     * @param $limit
     * @param $personal
     * @return bool|\PDOStatement
     */
    public function posts($order_by, $limit, $personal)
    {
        if( $personal === true )
        {
            $db = $this->connection_to_db();
            $req_all_posts = "SELECT id_article, titre_article, auteur_article, extrait_article, contenu_article, DATE_FORMAT(publication_article, '%d/%m/%Y') AS publication_article, couverture_article, slug_article, likes_article FROM t_article AS a JOIN rel_utilisateur_article AS ua ON ua.fk_article=a.id_article JOIN t_utilisateur AS u ON ua.fk_utilisateur=u.id_utilisateur WHERE ua.fk_utilisateur=:id_utilisateur ORDER BY $order_by DESC LIMIT :limit";
            $query = $db->prepare($req_all_posts);
            $query->bindParam(':limit', $limit, PDO::PARAM_INT);
            $query->bindParam(':id_utilisateur',$_SESSION['user_id'], PDO::PARAM_INT);
            $query->execute();

        }
        else
        {
            $db = $this->connection_to_db();
            $req_all_posts = "SELECT id_article, titre_article, auteur_article, extrait_article, contenu_article, DATE_FORMAT(publication_article, '%d/%m/%Y') AS publication_article, couverture_article, slug_article, likes_article FROM t_article ORDER BY $order_by DESC LIMIT :limit";
            $query = $db->prepare($req_all_posts);
            $query->bindParam(':limit', $limit, PDO::PARAM_INT);
            $query->execute();
        }
        return $query;
    }


    /**
     * @param $auteur_article -> retourne tous les article d'un auteur, via auteur_article
     * @return bool|\PDOStatement
     */
    public function get_auteur_posts($auteur_article)
    {
        $db = $this->connection_to_db();
        $req = "SELECT id_article, titre_article, auteur_article, extrait_article, contenu_article, DATE_FORMAT(publication_article, '%d/%m/%Y') AS publication_article, couverture_article, slug_article, likes_article FROM t_article WHERE auteur_article=:auteur_article";
        $query = $db->prepare($req);
        $query->bindParam(':auteur_article',$auteur_article,PDO::PARAM_STR);
        $query->execute();

        return $query;
    }

    /**
     * @param $id_utilisateur
     * @param $id_article
     * @return bool
     */
    public function check_article_rel_user($id_utilisateur, $id_article)
    {
        $db = $this->connection_to_db();
        $req = "SELECT art.id_article FROM t_article AS art JOIN rel_utilisateur_article AS ua ON ua.fk_article=art.id_article JOIN t_utilisateur as ut ON ua.fk_utilisateur=ut.id_utilisateur WHERE ua.fk_article=:id_article AND ua.fk_utilisateur=:id_utilisateur";
        $query = $db->prepare($req);
        $query->bindParam(':id_utilisateur',$id_utilisateur,PDO::PARAM_INT);
        $query->bindParam(':id_article',$id_article, PDO::PARAM_INT);
        $query->execute();

        $query->closeCursor();

        if($query->rowCount() === 1)
        {
            return true;
        }
        else
        {
            return false;
        }
    }


    /**
     * @param $id_article -> delete d'un article via son id_article
     */
    public function delete_article($id_article)
    {
        $db = $this->connection_to_db();
        $req = "DELETE FROM t_article WHERE t_article.id_article=:id_article";
        $query = $db->prepare($req);
        $query->bindParam(':id_article',$id_article, PDO::PARAM_INT);
        $query->execute();

        $query->closeCursor();
    }


    /**
     * @param $id_article -> check si l'article appartient à un utilisateur, via leur id respectifs
     * @param $id_utilisateur
     * @return bool
     */
    public function is_utilisateur_article($id_article, $id_utilisateur)
    {
        $db = $this->connection_to_db();
        $req = "SELECT id_article FROM t_article AS ar JOIN rel_utilisateur_article AS utar ON utar.fk_article=ar.id_article JOIN t_utilisateur AS ut ON utar.fk_utilisateur=ut.id_utilisateur WHERE utar.fk_article=:id_article AND utar.fk_utilisateur=:id_utilisateur";
        $query = $db->prepare($req);
        $query->bindParam(':id_article',$id_article,PDO::PARAM_INT);
        $query->bindParam(':id_utilisateur',$id_utilisateur,PDO::PARAM_INT);
        $query->execute();
        $query->closeCursor();

        if($query->rowCount() === 1)
        {
            return true;
        }
        else
        {
            return false;
        }
    }


    /**
     *
     * FONCTION DE CREATION D'UN ARTICLE
     *
     * @param $titre_article
     * @param $auteur_article
     * @param $extrait_article
     * @param $contenu_article
     * @param $couverture_article
     * @param $tags
     * @param $categorie
     * @param $haveTags
     * @param $haveCat
     */
    public function add_article($titre_article, $auteur_article, $extrait_article, $contenu_article, $couverture_article, $tags, $categorie, $haveTags, $haveCat)
    {
        $slugify = new Slugify();
        $article_slug = $slugify->slugify($titre_article);

        $db = $this->connection_to_db();
        $req = "INSERT INTO t_article (titre_article, auteur_article, extrait_article, contenu_article, publication_article, couverture_article, slug_article) VALUES (:titre_article, :auteur_article, :extrait_article, :contenu_article, NOW(), :couverture_article, :slug_article)";
        $query = $db->prepare($req);
        $query->bindParam(':titre_article',$titre_article,PDO::PARAM_STR);
        $query->bindParam(':auteur_article',$auteur_article,PDO::PARAM_STR);
        $query->bindParam(':extrait_article',$extrait_article,PDO::PARAM_STR);
        $query->bindParam(':contenu_article',$contenu_article,PDO::PARAM_STR);
        $query->bindParam(':couverture_article',$couverture_article,PDO::PARAM_STR);
        $query->bindParam(':slug_article',$article_slug,PDO::PARAM_STR);
        $query->execute();

        $query->closeCursor();

        $last_id = $db->lastInsertId();

        $this->make_utilisateur_article_relation($last_id, $_SESSION['user_id']);

        if($haveTags === true)
        {
            // relier le tags à l'article (dernier id)
            foreach($tags as $tag)
            {

                if(!$this->tag_exist($tag))
                {
                    $this->create_tag($tag);
                }
                $this->make_tag_article_relation($tag, $last_id);
            }
        }

        if($haveCat === true)
        {
            // relier la catégorie à l'article (dernier id)
            $this->make_categorie_article_relation($categorie, $last_id);
        }
    }


    /**
     * @param $tag -> création d'un tag via son nom_tag
     */
    public function create_tag($tag)
    {
        $slugify = new Slugify();
        $slug_tag = $slugify->slugify($tag);

        $db = $this->connection_to_db();
        $req = "INSERT INTO t_tag (nom_tag, slug_tag) VALUES (:nom_tag, :slug_tag)";
        $query = $db->prepare($req);
        $query->bindParam(':nom_tag',$tag, PDO::PARAM_STR);
        $query->bindParam(':slug_tag',$slug_tag, PDO::PARAM_STR);
        $query->execute();

        $query->closeCursor();
    }


    /**
     * @param $nom_tag -> check si un tag existe deja, via son nom_tag
     * @return bool
     */
    public function tag_exist($nom_tag)
    {
        $db = $this->connection_to_db();
        $req = "SELECT id_tag FROM t_tag WHERE t_tag.nom_tag=:nom_tag";
        $query = $db->prepare($req);
        $query->bindParam(':nom_tag',$nom_tag, PDO::PARAM_STR);
        $query->execute();

        if($query->rowCount() === 1)
        {
            return true;
        }
        else
        {
            return false;
        }

        $query->closeCursor();
    }


    /**
     * @param $nom_categorie -> crée une liaison entre une catégorie et un article via leur id respectif
     * @param $id_article
     */
    public function make_categorie_article_relation($nom_categorie, $id_article)
    {
        $db = $this->connection_to_db();
        $req = "INSERT INTO rel_article_categorie (fk_article, fk_categorie) VALUES (:id_article, (SELECT id_categorie FROM t_categorie WHERE t_categorie.nom_categorie=:nom_categorie))";
        $query = $db->prepare($req);
        $query->bindParam(':nom_categorie',$nom_categorie, PDO::PARAM_STR);
        $query->bindParam(':id_article',$id_article, PDO::PARAM_INT);
        $query->execute();

        $query->closeCursor();
    }


    /**
     * @param $nom_tag -> crée une liaison entre tag et article via leur id respectif
     * @param $id_article
     */
    public function make_tag_article_relation($nom_tag, $id_article)
    {
        $db = $this->connection_to_db();
        $req = "INSERT INTO rel_article_tags (fk_article, fk_tag) VALUES (:id_article, (SELECT id_tag FROM t_tag WHERE t_tag.nom_tag=:nom_tag))";
        $query = $db->prepare($req);
        $query->bindParam(':nom_tag',$nom_tag, PDO::PARAM_STR);
        $query->bindParam(':id_article',$id_article, PDO::PARAM_INT);
        $query->execute();

        $query->closeCursor();
    }


    /**
     * @param $id_article -> crée une liaison entre utilisateur et article avec leur id respectif
     * @param $id_utilisateur
     */
    private function make_utilisateur_article_relation($id_article, $id_utilisateur)
    {
        $db = $this->connection_to_db();
        $req = "INSERT INTO rel_utilisateur_article (fk_article, fk_utilisateur) VALUES (:id_article, :id_utilisateur)";
        $query = $db->prepare($req);
        $query->bindParam(':id_article',$id_article, PDO::PARAM_INT);
        $query->bindParam(':id_utilisateur',$id_utilisateur,PDO::PARAM_INT);
        $query->execute();

        $query->closeCursor();
    }


    /**
     * @param $nom_categorie -> check si la catégorie est unique via son nom_categorie
     * @return bool
     */
    public function is_cat_unique($nom_categorie)
    {
        $db = $this->connection_to_db();
        $req = "SELECT id_categorie FROM t_categorie WHERE t_categorie.nom_categorie=:nom_categorie";
        $query = $db->prepare($req);
        $query->bindParam(':nom_categorie',$nom_categorie, PDO::PARAM_STR);
        $query->execute();
        $query->closeCursor();

        if($query->rowCount() > 0)
        {
            return false;
        }
        else
        {
            return true;
        }
    }

    /**
     * @param $nom_tag -> check si le tag est unique via son nom_tag
     * @return bool
     */
    public function is_tag_unique($nom_tag)
    {
        $db = $this->connection_to_db();
        $req = "SELECT id_tag FROM t_tag WHERE t_tag.nom_tag=:nom_tag";
        $query = $db->prepare($req);
        $query->bindParam(':nom_tag',$nom_tag, PDO::PARAM_STR);
        $query->execute();
        $query->closeCursor();

        if($query->rowCount() > 0)
        {
            return false;
        }
        else
        {
            return true;
        }
    }

    /**
     * @param $titre_article -> check si l'article est unique, via son titre_article
     * @return bool
     */
    public function is_title_unique($titre_article)
    {
        $db = $this->connection_to_db();
        $req = "SELECT id_article FROM t_article WHERE t_article.titre_article=:titre_article";
        $query = $db->prepare($req);
        $query->bindParam(':titre_article',$titre_article, PDO::PARAM_STR);
        $query->execute();
        $query->closeCursor();

        if($query->rowCount() > 0)
        {
            return false;
        }
        else
        {
            return true;
        }
    }

    /**
     * @param $slug -> Cette fonction retourne le contenu d'un post via son slug (url)
     * @return bool|\PDOStatement
     */
    public function post($slug)
    {
        $db = $this->connection_to_db();
        $req_post = "SELECT * FROM t_article WHERE slug_article=:slug";
        $query = $db->prepare($req_post);
        $query->bindParam(':slug',$slug, PDO::PARAM_STR);
        $query->execute();

        return $query;
    }


    /**
     * FONCTION UPDATE D'UN ARTICLE
     *
     * @param $titre_article
     * @param $auteur_article
     * @param $extrait_article
     * @param $contenu_article
     * @param $couverture_article
     * @param $id_article
     */
    public function update_article($titre_article, $auteur_article, $extrait_article, $contenu_article, $couverture_article, $id_article)
    {
        $slugify = new Slugify();
        $article_slug = $slugify->slugify($titre_article);

        $db = $this->connection_to_db();
        $req = "UPDATE t_article SET titre_article=:titre_article, auteur_article=:auteur_article, extrait_article=:extrait_article, contenu_article=:contenu_article, couverture_article=:couverture_article, slug_article=:slug_article WHERE id_article=:id_article";
        $query = $db->prepare($req);
        $query->bindParam(':titre_article',$titre_article,PDO::PARAM_STR);
        $query->bindParam(':auteur_article',$auteur_article,PDO::PARAM_STR);
        $query->bindParam(':extrait_article',$extrait_article,PDO::PARAM_STR);
        $query->bindParam(':contenu_article',$contenu_article,PDO::PARAM_STR);
        $query->bindParam(':couverture_article',$couverture_article,PDO::PARAM_STR);
        $query->bindParam(':slug_article',$article_slug,PDO::PARAM_STR);
        $query->bindParam(':id_article',$id_article,PDO::PARAM_INT);
        $query->execute();

        $query->closeCursor();
    }


    /**
     * @param $id_article -> Cette fonction retourne le contenu d'un post via son id
     * @return bool|\PDOStatement
     */
    public function post_by_id($id_article)
    {
        $db = $this->connection_to_db();
        $req_post = "SELECT * FROM t_article WHERE id_article=:id_article";
        $query = $db->prepare($req_post);
        $query->bindParam(':id_article',$id_article, PDO::PARAM_INT);
        $query->execute();

        return $query;
    }

    /*
     * TAGS FUNCTIONS
     * TAGS FUNCTIONS
     * TAGS FUNCTIONS
     */


    /**
     * @param $tags -> cette fonctions retourne les articles reliés aux tags envoyé en paramètre
     * @return bool|\PDOStatement
     *
     * @function bindParamArray viens de la classe parente -> Manager, cette fonction permet de préparer les
     * éléments du tableau (en paramètre) pour les ajuster correctement à la requête ( ils vont dans le IN() )
     */
    public function get_tags_articles($tags)
    {
        $db = $this->connection_to_db();
        $bindString = $this->bindParamArray($tags);
        $searchIn = " IN($bindString)";
        $req = "SELECT DISTINCT id_article, titre_article, auteur_article, extrait_article, contenu_article, DATE_FORMAT(publication_article, '%d/%m/%Y') AS publication_article, couverture_article, slug_article, likes_article FROM t_article AS ar JOIN rel_article_tags AS arta ON arta.fk_article = ar.id_article JOIN t_tag AS ta ON arta.fk_tag = ta.id_tag WHERE ta.nom_tag" . $searchIn;
        $query = $db->prepare($req);
        $query->execute();

        return $query;
    }


    /**
     * Cette fonction nous retourne tous les tags, sans distinction
     * @return bool|\PDOStatement
     */
    public function all_tags()
    {
        $db = $this->connection_to_db();
        $req = "SELECT * FROM t_tag";
        $query = $db->prepare($req);
        $query->execute();

        return $query;
    }


    /**
     * @param $id_article -> Cette fonction nous retourne les tags d'un article (via id_article)
     * @return bool|\PDOStatement
     */
    public function tags($id_article)
    {
        $db = $this->connection_to_db();
        $req_tags = "SELECT * FROM t_tag AS ta JOIN rel_article_tags AS ata ON ata.fk_tag=ta.id_tag JOIN t_article AS ar ON ata.fk_article=ar.id_article WHERE ata.fk_article=:id_article";
        $query = $db->prepare($req_tags);
        $query->bindParam(':id_article',$id_article, PDO::PARAM_INT);
        $query->execute();

        return $query;
    }


    /**
     * @param $nom_tag ->
     * @return bool|\PDOStatement

    public function get_tags_article($nom_tag)
    {
        $db = $this->connection_to_db();
        $req_get_articles = "SELECT ar.* FROM t_article AS ar JOIN rel_article_tags AS arta ON arta.fk_article=ar.id_article JOIN t_tag AS ta ON arta.fk_tag=ta.id_tag WHERE ta.nom_tag=:nom_tag";
        $query = $db->prepare($req_get_articles);
        $query->bindParam(':nom_tag',$nom_tag, PDO::PARAM_INT);
        $query->execute();

        return $query;
    }
     */

    /*
     * CATEGORIES FUNCTIONS
     * CATEGORIES FUNCTIONS
     * CATEGORIES FUNCTIONS
     */

    /**
     * Cette function retourne toutes les catégories sans distinction
     * @return bool|\PDOStatement
     */
    public function all_categories()
    {
        $db = $this->connection_to_db();
        $req = "SELECT * FROM t_categorie";
        $query = $db->prepare($req);
        $query->execute();

        return $query;
    }


    /**
     * @param $id_article -> Cette fonction retourne les catégories reliées à un article (via id_article)
     * @return bool|\PDOStatement
     */
    public function categories($id_article)
    {
        $db = $this->connection_to_db();
        $req_categories = "SELECT * FROM t_categorie AS ca JOIN rel_article_categorie as aca ON aca.fk_categorie=ca.id_categorie JOIN t_article AS ar ON aca.fk_article= ar.id_article WHERE aca.fk_article=:id_article";
        $query = $db->prepare($req_categories);
        $query->bindParam(':id_article',$id_article, PDO::PARAM_INT);
        $query->execute();

        return $query;
    }


    /**
     * @param $nom_categorie -> Cette fonctionre retourne tous les articles reliés à une catégorie (via nom_categorie)
     * @return bool|\PDOStatement
     */
    public function get_categorie_articles($nom_categorie)
    {
        $db = $this->connection_to_db();
        $req_get_articles = "SELECT id_article, titre_article, auteur_article, extrait_article, contenu_article, DATE_FORMAT(publication_article, '%d/%m/%Y') AS publication_article, couverture_article, slug_article, likes_article FROM t_article AS a JOIN rel_article_categorie AS aca ON aca.fk_article=a.id_article JOIN t_categorie as ca ON aca.fk_categorie=ca.id_categorie WHERE ca.nom_categorie=:nom_categorie";
        $query = $db->prepare($req_get_articles);
        $query->bindParam(':nom_categorie',$nom_categorie, PDO::PARAM_STR);
        $query->execute();

        return $query;
    }
}