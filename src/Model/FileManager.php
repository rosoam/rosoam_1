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

    public function send_img()
    {
        move_uploaded_file($_FILES['file']['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . '/src/public/uploads/' . basename($_FILES['file']['name']));
        echo "L'envoi a bien été effectué !";
    }
}