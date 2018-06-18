# Sobreira Romario - 104 - D1 - 2018 - BLOG

## MODE D'EMPLOI DU PROJET

1. Avoir une connection internet (**j'utilise des fonctions qui nécessitent une connection**)
2. Lancer votre logiciel de serveur local (MAMP, WAMP, LAMP etc..)
3. **Configurer la racine du serveur à la racine du dossier /!\ important**
4. Visiter votre page localhost avec le port correspondant à celui que vous avez configuré.

## Configuration de la connection avec la base de donnée

1. La fonction créée pour faire chaque connection avec la base de donnée se trouve dans **Manager.php**
2. Chemin depuis la racine du dossier - src/Model/Manager.php

**Vous aurez besoin de toucher à la fonction se trouvant sur ce fichier si votre port n'est pas mis sur le port 80!**

## Corrections apportées
* Correction des noms des tables de reliaisons
* Correction des noms des tables de relisaisons dans le fichier des requêtes

# Une fois que tout est bon!

## Les différentes pages
* [localhost](http://localhost/) C'est la homepage du site, il y a un petit texte de présentation ainsi qu'un apercu des derniers articles postés sur celui-ci.
* [localhost/posts](http://localhost/posts) C'est la page des articles! Vous trouverez une liste de tous les articles publiés ainsi que la possibilité de les filtrer avec les actions proposés sur la barre de droite de cette page.
* [localhost/admin](http://localhost/admin) Si vous n'êtes pas connecté, cette page contient le formulaire de connection (**les identifiants déjà enregistré vous sont indiqués sur cette page, afin que vous puissiez tester la gestion des articles!**). Par contre si vous êtes connecté, celle-ci ouvrira votre page de gestion des articles. C'est **ici** que vous pouvez **créer, supprimer, actualiser** vos articles!
* [localhost/subscribe](http://localhost/subscribe) Si vous avez envie de vous créer un nouvelle utilisateur, vous pourrez le faire via cette page. En remplissant le formulaire d'inscription et en validant celle-ci via le mail que vous recevrez, vous pourrez ensuite publier vos propres articles en vous connectant avec vos nouveaux identifiants.