<?php
# model/guestbookModel.php
/********************************
 * Model de la page livre d'or
 *******************************/

// INSERTION d'un message dans le livre d'or

/**
 * @param PDO $db
 * @param string $firstname
 * @param string $lastname
 * @param string $usermail
 * @param string $phone
 * @param string $postcode
 * @param string $message
 * @return bool
 * Fonction qui insère un message dans la base de données 'ti2web2026' et sa table 'guestbook'
 * Renvoie true si l'insertion a réussi, false sinon
 * Une requête préparée est utilisée pour éviter les injections SQL
 * Les données sont échappées pour éviter les injections XSS (protection backend)
 */
function addGuestbook(PDO $db,
                    string $firstname,
                    string $lastname,
                    string $usermail,
                    string $phone,
                    string $postcode,
                    string $message
): bool
{
    // traitement des données backend (SECURITE)
    $usermail=filter_var($usermail,FILTER_VALIDATE_EMAIL);
    $message=htmlspecialchars(trim(strip_tags($message)));
    $firstname = htmlspecialchars(trim(strip_tags($firstname)));
    $lastname = htmlspecialchars(trim(strip_tags($lastname)));
    $phone = htmlspecialchars(trim(strip_tags($phone)));
    $postcode = htmlspecialchars(trim(strip_tags($postcode)));

    // si pas de données complètes ou ne correspondant pas à nos attentes, on renvoie false
    if($usermail===false             ||
    strlen($usermail)>120            ||
    empty($firstname)            ||
    strlen($firstname)<5         ||
    strlen($firstname)>120        ||
    empty($lastname)                 ||
    strlen($lastname)<5              ||
    strlen($lastname)>120           ||
    empty($message)          ||
    strlen($message)<5       ||
    strlen($message)>300        ||
    empty($phone)          ||
    strlen($phone)<10      ||
    strlen($phone)>20     ||
    empty($postcode)          ||
    strlen($postcode)!=4       
    ) return false;
    
    // requête préparée obligatoire !
    $prepare = $db->prepare("
    INSERT INTO `guestbook`(`firstname`,`lastname`,`usermail`,`phone`,`postcode`,`message` )
    VALUES(:firstname,:lastname,:usermail,:phone,:postcode,:message); 
    ");

    // si l'insertion a réussi
    $prepare->bindValue(':firstname',$firstname);
    $prepare->bindValue(':lastname',$lastname);
    $prepare->bindValue(':usermail',$usermail);
    $prepare->bindValue(':phone',$phone);
    $prepare->bindValue(':postcode',$postcode);
    $prepare->bindValue(':message',$message);
    // on renvoie true
    $retour=$prepare->execute();
    return $retour;
    // sinon, on renvoie false

}
 
    
    # on met nos val dans 

    # on exécute la requete
    // true en cas de réussite, false en cas d'échec

//   var_dump($db,$mail,$message);


/***************************
 * Sans le Bonus Pagination
 **************************/

// SELECTION de messages dans le livre d'or par ordre de date croissante
/**
 * @param PDO $db
 * @return array
 * Fonction qui récupère tous les messages du livre d'or par ordre de date croissante
 * venant de la base de données 'ti2web2026' et de la table 'guestbook'
 * Si pas de message, renvoie un tableau vide
 */
function getAllGuestbook(PDO $db): array
{
    try {
        $sql = "SELECT * FROM `guestbook` ORDER BY `datemessage` DESC";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $messages = $stmt->fetchAll();
        $stmt->closeCursor();
        return $messages;
    } catch (Exception $e) {
        die($e->getMessage());
    }
    // try catch
    // si la requête a réussi,
    // bonne pratique, fermez le curseur
    // renvoyer le tableau de(s) message(s)
    // return [];
}



/**************************
 * Pour le Bonus Pagination
 **************************/

// SELECTION du nombre total de messages
/**
 * @param PDO $db
 * @return int
 * Fonction qui compte le nombre total de messages dans la table 'guestbook'
 */
function getNbTotalGuestbook(PDO $db): int
{
    try {
        $stmt = $db->prepare("SELECT COUNT(*) AS total FROM `guestbook`");
        $stmt->execute();
        $result = $stmt->fetch();
        $stmt->closeCursor();
        return (int) $result['total'];
    } catch (Exception $e) {
        die($e->getMessage());
    }

    // bonne pratique, fermez le curseur,
    // renvoyez le nombre total de messages
    // return 0;

}
// SELECTION de messages dans le livre d'or par ordre de date croissante
// en lien avec la pagination
/**
 * @param PDO $db
 * @param int $pageActu = 1
 * @param int $limit = 5
 * @return array
 * Fonction qui récupère les messages du livre d'or par ordre de date croissante
 * venant de la base de données 'ti2web2026' et de la table 'guestbook'
 * en utilisant une requête préparée (injection SQL), n'affiche que les messages
 * de la page courante
 */
function getGuestbookPagination(PDO $db, int $pageActu=1, int $limit=5,): array
{
    try {
        if ($pageActu < 1) {
            $pageActu = 1;
        }

        $offset = ($pageActu - 1) * $limit;

        $sql = "SELECT * FROM `guestbook`
                ORDER BY `datemessage` DESC
                LIMIT :limit OFFSET :offset";

        $stmt = $db->prepare($sql);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();

        $messages = $stmt->fetchAll();
        $stmt->closeCursor();
        return $messages;
    } catch (Exception $e) {
        die($e->getMessage());
    }
    // en paramètres de la requête préparée en tant qu'entiers !
    // si la requête a réussi,
    // bonne pratique, fermez le curseur
    // renvoyer le tableau de(s) message(s) (vide si pas de résultats)
    // return [];
}

 // pour touver l'offset (départ)

    // préparation de la requête
    // on passe les variables à lar requêtes, ! ils doivent passer au format integer !

# Pour afficher la pagination dans la vue
// FONCTION de pagination
/**
 * @param int $nbtotalMessage
 * @param string $url
 * @param string $get
 * @param int $pageActu
 * @param int $perPage
 * @return string
 * Fonction qui génère le code HTML de la pagination
 * si le nombre de pages est supérieur à une.
 */
function pagination(int $nbtotalMessage, string $url="./?", string $get="page", int $pageActu=1, int $perPage=5 ): string
{
    $sortie = "";
    if ($nbtotalMessage === 0) return "";
    $nbPages = ceil($nbtotalMessage / $perPage);
    if ($nbPages == 1) return "";
    $sortie .= "<p>";
    for ($i = 1; $i <= $nbPages; $i++) {
        if ($i === 1) {
            if ($pageActu === 1) {
                $sortie .= "<< < 1 |";
            } elseif ($pageActu === 2) {
                $sortie .= " <a href='$url'><<</a> <a href='$url'><</a> <a href='$url'>1</a> |";
            } else {
                $sortie .= " <a href='$url'><<</a> <a href='$url&$get=" . ($pageActu - 1) . "'><</a> <a href='$url'>1</a> |";
            }
        } elseif ($i < $nbPages) {
            if ($i === $pageActu) {
                $sortie .= "  $i |";
            } else {
                $sortie .= "  <a href='$url&$get=$i'>$i</a> |";
            }
        } else {
            if ($pageActu >= $nbPages) {
                $sortie .= "  $nbPages > >>";
            } else {
                $sortie .= "  <a href='$url&$get=$nbPages'>$nbPages</a> <a href='$url&$get=" . ($pageActu + 1) . "'>></a> <a href='$url&$get=$nbPages'>>></a>";
            }
        }
    }
    $sortie .= "</p>";
    return $sortie;

}