<?php
/**
 * Created by PhpStorm.
 * User: romar
 * Date: 05.05.2018
 * Time: 13:27
 */

namespace App\Controller;

use App\Model\FileManager;

class FileController
{

    static function send_file()
    {
        $file = new FileManager();
        $file->send_img();
    }

}