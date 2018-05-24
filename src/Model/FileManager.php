<?php
/**
 * Created by PhpStorm.
 * User: romar
 * Date: 05.05.2018
 * Time: 12:08
 */

namespace App\Model;

class FileManager
{

    public function downdload_couverture_article($file)
    {
        $destination = $_SERVER['DOCUMENT_ROOT'] . '/src/public/uploads/couvertures-articles/' . basename($file['name']);
        move_uploaded_file($file['tmp_name'], $destination);

        return '/src/public/uploads/couvertures-articles/' . basename($file['name']);
    }
}