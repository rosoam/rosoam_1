<?php
/**
 * Created by PhpStorm.
 * User: romar
 * Date: 30.04.2018
 * Time: 15:40
 */

namespace App\Model;

use \PDO;

class PostsManager extends Manager
{
    public function posts($order_by, $limit, $personal)
    {
        if( $personal === true )
        {
            // articles personnels
        }
        else
        {
            $db = $this->connection_to_db();
            $req_all_posts = "SELECT * FROM t_article ORDER BY :order ASC LIMIT :limit";
            $query = $db->prepare($req_all_posts);
            $query->bindParam(':order', $order_by, PDO::PARAM_STR);
            $query->bindParam(':limit', $limit, PDO::PARAM_INT);
            $query->execute();

            return $query;
        }
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
}