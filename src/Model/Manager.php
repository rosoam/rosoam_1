<?php
/**
 * Created by PhpStorm.
 * User: romar
 * Date: 30.04.2018
 * Time: 15:38
 */

namespace App\Model;

use \PDO;

class Manager
{
    protected function connection_to_db()
    {
        $db = new PDO('mysql:host=localhost;dbname=sobreira_romario_info1d_104_2018;charset=utf8', 'root','root', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

        // SI VOUS AVEZ BESOIN DE CONFIGURER UN PORT DIFFERENT UTILISER PLUTOT CETTE DECLARATION
        //$db = new PDO('mysql:host=localhost;port=VOTRE PORT ICI;dbname=sobreira_romario_info1d_104_2018;charset=utf8', 'root','root', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

        return $db;
    }

    protected function bindParamArray($values)
    {
        $str = "";
        foreach($values as $index => $value){
            $str .= "'$value'" . ',';
        }
        return rtrim($str,",");
    }
}