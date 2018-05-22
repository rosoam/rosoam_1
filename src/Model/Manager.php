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
        $db = new PDO('mysql:host=localhost;dbname=sobreira_romario_104_d1_2018;charset=utf8', 'root','root', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
        return $db;
    }

    protected function bindParamArray($prefix, $values, &$bindArray)
    {
        $str = "";
        foreach($values as $index => $value){
            $str .= "'$value'" . ',';
            $bindArray[$prefix.$index] = $value;
        }
        return rtrim($str,",");
    }
}