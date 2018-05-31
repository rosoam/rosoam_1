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

    public function get_auteur_posts($auteur)
    {
        $db = $this->connection_to_db();
        $req = "SELECT id_article, titre_article, auteur_article, extrait_article, contenu_article, DATE_FORMAT(publication_article, '%d/%m/%Y') AS publication_article, couverture_article, slug_article, likes_article FROM t_article WHERE auteur_article=:auteur_article";
        $query = $db->prepare($req);
        $query->bindParam(':auteur_article',$auteur,PDO::PARAM_STR);
        $query->execute();

        return $query;
    }

    /**
     * @param $user_id
     * @param $article_id
     * @return bool
     */
    public function check_article_rel_user($user_id, $article_id)
    {
        $db = $this->connection_to_db();
        $req = "SELECT art.id_article FROM t_article AS art JOIN rel_utilisateur_article AS ua ON ua.fk_article=art.id_article JOIN t_utilisateur as ut ON ua.fk_utilisateur=ut.id_utilisateur WHERE ua.fk_article=:article_id AND ua.fk_utilisateur=:user_id";
        $query = $db->prepare($req);
        $query->bindParam(':user_id',$user_id,PDO::PARAM_INT);
        $query->bindParam(':article_id',$article_id, PDO::PARAM_INT);
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

    public function delete_article($article_id)
    {
        $db = $this->connection_to_db();
        $req = "DELETE FROM t_article WHERE t_article.id_article=:article_id";
        $query = $db->prepare($req);
        $query->bindParam(':article_id',$article_id, PDO::PARAM_INT);
        $query->execute();

        $query->closeCursor();
    }

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

    public function add_article($titre_article, $auteur_article,$extrait_article,$contenu_article,$couverture_article, $tags, $categorie, $haveTags, $haveCat)
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

    public function tag_exist($tag)
    {
        $db = $this->connection_to_db();
        $req = "SELECT id_tag FROM t_tag WHERE t_tag.nom_tag=:nom_tag";
        $query = $db->prepare($req);
        $query->bindParam(':nom_tag',$tag, PDO::PARAM_STR);
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

    public function is_cat_unique($cat)
    {
        $db = $this->connection_to_db();
        $req = "SELECT id_categorie FROM t_categorie WHERE t_categorie.nom_categorie=:nomCat";
        $query = $db->prepare($req);
        $query->bindParam(':nomCat',$cat, PDO::PARAM_STR);
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

    public function is_tag_unique($tag)
    {
        $db = $this->connection_to_db();
        $req = "SELECT id_tag FROM t_tag WHERE t_tag.nom_tag=:nomTag";
        $query = $db->prepare($req);
        $query->bindParam(':nomTag',$tag, PDO::PARAM_STR);
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

    public function is_title_unique($title)
    {
        $db = $this->connection_to_db();
        $req = "SELECT id_article FROM t_article WHERE t_article.titre_article=:title";
        $query = $db->prepare($req);
        $query->bindParam(':title',$title, PDO::PARAM_STR);
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

    public function update_article($titre_article, $auteur_article,$extrait_article,$contenu_article,$couverture_article, $article_id)
    {
        $slugify = new Slugify();
        $article_slug = $slugify->slugify($titre_article);

        $db = $this->connection_to_db();
        $req = "UPDATE t_article SET titre_article=:titre_article, auteur_article=:auteur_article, extrait_article=:extrait_article, contenu_article=:contenu_article, couverture_article=:couverture_article, slug_article=:slug_article WHERE id_article=:article_id";
        $query = $db->prepare($req);
        $query->bindParam(':titre_article',$titre_article,PDO::PARAM_STR);
        $query->bindParam(':auteur_article',$auteur_article,PDO::PARAM_STR);
        $query->bindParam(':extrait_article',$extrait_article,PDO::PARAM_STR);
        $query->bindParam(':contenu_article',$contenu_article,PDO::PARAM_STR);
        $query->bindParam(':couverture_article',$couverture_article,PDO::PARAM_STR);
        $query->bindParam(':slug_article',$article_slug,PDO::PARAM_STR);
        $query->bindParam(':article_id',$article_id,PDO::PARAM_INT);
        $query->execute();

        $query->closeCursor();
    }


    public function post($slug)
    {
        $db = $this->connection_to_db();
        $req_post = "SELECT * FROM t_article WHERE slug_article=:slug";
        $query = $db->prepare($req_post);
        $query->bindParam(':slug',$slug, PDO::PARAM_STR);
        $query->execute();

        return $query;
    }

    /*
     * TAGS FUNCTIONS
     * TAGS FUNCTIONS
     * TAGS FUNCTIONS
     */
    // SELECT DISTINCT ar.* FROM t_article AS ar JOIN rel_article_tags AS arta ON arta.fk_article = ar.id_article JOIN t_tag AS ta ON arta.fk_tag = ta.id_tag WHERE ta.nom_tag IN("front-end", "back-end")

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

    public function all_tags()
    {
        $db = $this->connection_to_db();
        $req = "SELECT * FROM t_tag";
        $query = $db->prepare($req);
        $query->execute();

        return $query;
    }

    public function tags($id_article)
    {
        $db = $this->connection_to_db();
        $req_tags = "SELECT * FROM t_tag AS ta JOIN rel_article_tags AS ata ON ata.fk_tag=ta.id_tag JOIN t_article AS ar ON ata.fk_article=ar.id_article WHERE ata.fk_article=:id_article";
        $query = $db->prepare($req_tags);
        $query->bindParam(':id_article',$id_article, PDO::PARAM_INT);
        $query->execute();

        return $query;
    }

    public function get_tags_article($nom_tag)
    {
        $db = $this->connection_to_db();
        $req_get_articles = "SELECT ar.* FROM t_article AS ar JOIN rel_article_tags AS arta ON arta.fk_article=ar.id_article JOIN t_tag AS ta ON arta.fk_tag=ta.id_tag WHERE ta.nom_tag=:nom_tag";
        $query = $db->prepare($req_get_articles);
        $query->bindParam(':nom_tag',$nom_tag, PDO::PARAM_INT);
        $query->execute();

        return $query;
    }

    /*
     * CATEGORIES FUNCTIONS
     * CATEGORIES FUNCTIONS
     * CATEGORIES FUNCTIONS
     */

    public function all_categories()
    {
        $db = $this->connection_to_db();
        $req = "SELECT * FROM t_categorie";
        $query = $db->prepare($req);
        $query->execute();

        return $query;
    }

    public function categories($id_article)
    {
        $db = $this->connection_to_db();
        $req_categories = "SELECT * FROM t_categorie AS ca JOIN rel_article_categorie as aca ON aca.fk_categorie=ca.id_categorie JOIN t_article AS ar ON aca.fk_article= ar.id_article WHERE aca.fk_article=:id_article";
        $query = $db->prepare($req_categories);
        $query->bindParam(':id_article',$id_article, PDO::PARAM_INT);
        $query->execute();

        return $query;
    }

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