<?php
/**
 * Created by PhpStorm.
 * User: romar
 * Date: 05.05.2018
 * Time: 13:27
 */

namespace App\Controller;

use App\Model\FileManager;
use Exception;

class FileController
{

    static function send_file()
    {
        if(isset($_SESSION['username']))
        {
            // Testons si le fichier a bien été envoyé et s'il n'y a pas d'erreur
            if (isset($_FILES['file']) AND $_FILES['file']['error'] == 0)
            {
                // Testons si le fichier n'est pas trop gros
                if ($_FILES['file']['size'] <= 1000000)
                {
                    // Testons si l'extension est autorisée
                    $infosfichier = pathinfo($_FILES['file']['name']);
                    $extension_upload = $infosfichier['extension'];
                    $extensions_autorisees = array('jpg', 'jpeg', 'gif', 'png');

                    if (in_array($extension_upload, $extensions_autorisees))
                    {
                        // On peut valider le fichier et le stocker définitivement
                        $file = new FileManager();
                        $file->send_img();
                    }
                    else
                    {
                        throw new Exception("Erreur: extension du fichier invalide");
                    }
                }
                else
                {
                    throw new Exception("Erreur: fichier trop volumineux");
                }
            }
            else
            {
                throw new Exception("Erreur, votre fichier n'est pas compatible");
            }
        }
        else
        {
            throw new Exception("Erreur: vous devez être connecté!");
        }
    }

}