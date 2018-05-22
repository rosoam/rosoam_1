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
            $req_all_posts = "SELECT a.* FROM t_article AS a JOIN rel_utilisateur_article AS ua ON ua.fk_article=a.id_article JOIN t_utilisateur AS u ON ua.fk_utilisateur=u.id_utilisateur WHERE ua.fk_utilisateur=:id_utilisateur ORDER BY :order ASC LIMIT :limit";
            $query = $db->prepare($req_all_posts);
            $query->bindParam(':order', $order_by, PDO::PARAM_STR);
            $query->bindParam(':limit', $limit, PDO::PARAM_INT);
            $query->bindParam(':id_utilisateur',$_SESSION['user_id'], PDO::PARAM_INT);
            $query->execute();

        }
        else
        {
            $db = $this->connection_to_db();
            $req_all_posts = "SELECT id_article, titre_article, auteur_article, extrait_article, contenu_article, DATE_FORMAT(publication_article, '%d/%m/%Y') AS article_publication, couverture_article, slug FROM t_article ORDER BY :order ASC LIMIT :limit";
            $query = $db->prepare($req_all_posts);
            $query->bindParam(':order', $order_by, PDO::PARAM_STR);
            $query->bindParam(':limit', $limit, PDO::PARAM_INT);
            $query->execute();

        }
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

    public function add_article($titre_article, $auteur_article,$extrait_article,$contenu_article,$couverture_article)
    {
        $slugify = new Slugify();
        $article_slug = $slugify->slugify($titre_article);

        $db = $this->connection_to_db();
        $req = "INSERT INTO t_article (titre_article, auteur_article, extrait_article, contenu_article, publication_article, couverture_article, slug) VALUES (:titre_article, :auteur_article, :extrait_article, :contenu_article, NOW(), :couverture_article, :slug_article)";
        $query = $db->prepare($req);
        $query->bindParam(':titre_article',$titre_article,PDO::PARAM_STR);
        $query->bindParam(':auteur_article',$auteur_article,PDO::PARAM_STR);
        $query->bindParam(':extrait_article',$extrait_article,PDO::PARAM_STR);
        $query->bindParam(':contenu_article',$contenu_article,PDO::PARAM_STR);
        $query->bindParam(':couverture_article',$couverture_article,PDO::PARAM_STR);
        $query->bindParam(':slug_article',$article_slug,PDO::PARAM_STR);
        $query->execute();

        $query->closeCursor();
    }

    public function update_article($titre_article, $auteur_article,$extrait_article,$contenu_article,$couverture_article, $article_id)
    {
        $slugify = new Slugify();
        $article_slug = $slugify->slugify($titre_article);

        $db = $this->connection_to_db();
        $req = "UPDATE t_article SET titre_article=:titre_article, auteur_article=:auteur_article, extrait_article=:extrait_article, contenu_article=:contenu_article, couverture_article=:couverture_article, slug=:slug_article WHERE id_article=:article_id";
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
        $req_post = "SELECT * FROM t_article WHERE slug=:slug";
        $query = $db->prepare($req_post);
        $query->bindParam(':slug',$slug, PDO::PARAM_STR);
        $query->execute();

        return $query;
    }

    public function tags($id_article)
    {
        $db = $this->connection_to_db();
        $req_tags = "SELECT ta.nom_tag FROM t_tag AS ta JOIN rel_article_tags AS ata ON ata.fk_tag=ta.id_tag JOIN t_article AS ar ON ata.fk_article=ar.id_article WHERE ata.fk_article=:id_article";
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

    public function all_categories()
    {
        $db = $this->connection_to_db();
        $req = "SELECT nom_categorie FROM t_categorie";
        $query = $db->prepare($req);
        $query->execute();

        return $query;
    }

    public function categories($id_article)
    {
        $db = $this->connection_to_db();
        $req_categories = "SELECT ca.nom_categorie FROM t_categorie AS ca JOIN rel_article_categorie as aca ON aca.fk_categorie=ca.id_categorie JOIN t_article AS ar ON aca.fk_article= ar.id_article WHERE aca.fk_article=:id_article";
        $query = $db->prepare($req_categories);
        $query->bindParam(':id_article',$id_article, PDO::PARAM_INT);
        $query->execute();

        return $query;
    }

    // -> ajax fonction
    public function get_categorie_articles($nom_categorie)
    {
        $db = $this->connection_to_db();
        $req_get_articles = "SELECT a.* FROM t_article AS a JOIN rel_article_categorie AS aca ON aca.fk_article=a.id_article JOIN t_categorie as ca ON aca.fk_categorie=ca.id_categorie WHERE ca.nom_categorie=:nom_categorie";
        $query = $db->prepare($req_get_articles);
        $query->bindParam(':nom_categorie',$nom_categorie, PDO::PARAM_STR);
        $query->execute();

        return $query;
    }
}