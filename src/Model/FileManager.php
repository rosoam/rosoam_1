<?php
/**
 * Created by PhpStorm.
 * User: romar
 * Date: 05.05.2018
 * Time: 12:08
 */

namespace App\Model;

use Exception;

class FileManager
{

    public function send_img()
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

                    move_uploaded_file($_FILES['file']['tmp_name'], $_SERVER['DOCUMENT_ROOT'].'/src/public/uploads/'. basename($_FILES['file']['name']));
                    echo "L'envoi a bien été effectué !";

                }
                else
                {
                    throw new Exception("Extension du fichier invalide");
                }

            }
            else
            {
                throw new Exception("Erreur: fichier trop volumineux");
            }
        }
        else {
            throw new Exception("Erreur durant l'envoi du fichier");
        }
    }

}