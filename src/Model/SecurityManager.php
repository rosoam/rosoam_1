<?php
/**
 * Created by PhpStorm.
 * User: rso
 * Date: 28.05.2018
 * Time: 17:48
 */

namespace App\Model;


class SecurityManager
{
    public function section_active()
    {
        if(isset($_SESSION['username']))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function check_empty($array)
    {
        foreach($array as $element)
        {
            if(empty($element))
            {
                return false;
            }
        }
        return true;
    }
}