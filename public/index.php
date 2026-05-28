<?php
# public/index.php


/*
 * Front Controller de la gestion du livre d'or
 */

/*
 * Chargement des dépendances
 */
// chargement de configuration
require_once "../config.php";
// chargement du modèle de la table guestbook
require_once URL_BASE . "/model/guestbookModel.php";

$feedback = '';
$feedbackClass = '';
$pagination = '';
$page = 1;

/*
 * Connexion à la base de données en utilisant PDO
 * Avec un try catch pour gérer les erreurs de connexion
 * Utilisez les constantes de config.php
 * Activez le mode d'erreur de PDO à Exception et
 * le mode fetch à tableau associatif
 */

try {
    $db = new PDO(
        dsn: MARIA_DSN, 
        username: DB_LOGIN, 
        password:  DB_PWD, 
        // options, on active les erreurs pour ne pas avoir de pages blanches en cas de désaxtivation (optionnel depuis PHP 8.0)
        options:[
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            ]
    );

    // option, on peut les ajouter après la connexion (donc en dehors de options:), sauf pour la connexion permanente, ici il s'agit du format de récupération php tableaux associatifs
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (Exception $e) {
    // arrêt et affichage de l'erreur (ev dev)
    die($e->getMessage());
}

// on a envoyé le formulaire 

if(isset($_POST['firstname'],$_POST['lastname'],$_POST['postcode'],$_POST['phone'],$_POST['usermail'],$_POST['message'])){
   
// envoi de nos var nécessaires à l'insertion 
    $isAdded = addGuestbook(
            $db,
            $_POST['firstname'],
            $_POST['lastname'],
            $_POST['usermail'],
            $_POST['phone'],
            $_POST['postcode'],
            $_POST['message']
        );
    if ($isAdded) {
        $feedback = 'Merci pour votre nouveau message';
        $feedbackClass = 'success';
        $_POST = [];
    } else {
        $feedback = "Problème lors de l'envoi du message";
        $feedbackClass = 'error';
    }
} else {
    $feedback = 'Tous les champs du formulaire sont obligatoires';
    $feedbackClass = 'error';
}


$comments=getAllGuestbook($db);
/*
 * Si le formulaire a été soumis
 */

// on appelle la fonction d'insertion dans la DB (addGuestbook())

// si l'insertion a réussi

// on redirige vers la page actuelle (ou on affiche un message de succès)


// sinon, on affiche un message d'erreur

/*
 * On récupère les messages du livre d'or
 */

// on appelle la fonction de récupération de la DB (getAllGuestbook())

/*********************
 * Ou Bonus Pagination
 *********************/

// on vérifie sur quelle page on est (et que c'est un string qui contient que des numériques sans "." ni "-" => ctype_digit) en utilisant la variable $_GET et les constantes de config.php

# on compte le nombre total de messages (SQL)

# on récupère la pagination

# pour obtenir le $offset pour les messages (calcul)

# on veut récupérer les messages de la page courante



if (!isset($_GET['p'])){
    // // nous sommes dans l'accueil
    // include URL_BASE . "/view/guestbookView.php";
}elseif(in_array($_GET['p'],ARRAY_VALID_PAGES)){

    // si il existe la variable de pagination
    if(isset($_GET[PAGINATION_GET]) && ctype_digit($_GET[PAGINATION_GET])){
        $page = (int) $_GET[PAGINATION_GET];
    }else{
        $page = 1;
    }


    // récupération de $comments en utilisant la fonction de pagination

    
    // création de la pagination en html avec les variables get nécessaires  

        $countComments = getNbTotalGuestbook($db);
        $comments = getGuestbookPagination($db, $page, PAGINATION_NB);
        $pagination = pagination($countComments, '?', PAGINATION_GET, $page, PAGINATION_NB);
    }else {

    $db=null;
}
include URL_BASE . "/view/guestbookView.php";

/**************************
 * Fin du Bonus Pagination
 **************************/