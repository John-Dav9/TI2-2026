<?php
# view/guestbookView.php
?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>TI2 | Livre d'or</title>
    <link rel="icon" type="image/png" href="img/favicon.png">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<h1>TI2 | Livre d'or</h1>
<!-- Formulaire d'ajout d'un message -->
 <form id="contactForm" class="form-card" novalidate method="post">

  <div class="field">
    <label for="firstname">Nom</label>
    <input type="text" id="firstname" name="firstname" placeholder="John" value="<?= ($_POST['firstname'] ?? '') ?>">
    <small class="field-error"></small>
  </div>

  <div class="field">
    <label for="lastname">Prénom</label>
    <input type="text" id="lastname" name="lastname" placeholder="David" value="<?= ($_POST['lastname'] ?? '') ?>">
    <small class="field-error"></small>
  </div>

  <div class="field">
    <label for="usermail">Email</label>
    <input type="email" id="usermail" name="usermail" placeholder="johndavid@email.com" value="<?= ($_POST['usermail'] ?? '') ?>">
    <small class="field-error"></small>
  </div>

  <div class="field">
    <label for="phone">Téléphone</label>
    <input type="text" id="phone" name="phone" placeholder="+32471234567" value="<?= ($_POST['phone'] ?? '') ?>">
    <small class="field-error"></small>
  </div>

  <div class="field">
    <label for="postcode">Code Postal</label>
    <input type="text" id="postcode" name="postcode" value="<?= ($_POST['postcode'] ?? '') ?>">
    <small class="field-error"></small>
  </div>

   <div class="field">
    <label for="commentaire">message</label>
    <textarea id="commentaire" name="commentaire" rows="6"><?= ($_POST['message'] ?? '') ?></textarea>
    <small class="field-error"><?= ($errors['commentaire'] ?? '') ?></small>
  </div>

  <button class="btn" type="submit">Envoyer</button>
</form>
<!-- Si pas de message -->
<h3>Pas encore de message</h3>
<!-- Si 1 message -->
<h3>Il y a 1 message</h3>
<!-- Si plusieurs messages -->
<h3>Il y a X messages</h3>
<div>
    <section class="section_wrapper">
        <section class="comments_section"> 
            <?php
                $nbComment = $countComments;
                if (empty($nbComment)):
            ?>
            <h2>Il n'y a pas encore de messages</h2>
            <?php
                // il y a au mois un message
                else:
                    // preparation du pluriel si on a plus d'un message
                    $pluriel = $nbComment > 1 ? "s" : "";
                
                // affichage de la pagination    
                echo $pagination; 
            ?>
            
        </section>
         <section class="comments_section">
         <h2>Message<?= $pluriel ?> récent<?= $pluriel ?> (<?= $nbComment ?>)</h2>
        <?php
            foreach ($comments as $comment):
        ?>
        <div class="comments_card">
            <div class="comment_avatar">
                <?= strtoupper(substr($comment['email'], 0, 2)) ?>
            </div>
            <div class="comment_body">
                <div class="comment_meta">
                    <span class="write_by"><?= htmlspecialchars($comment['email']) ?></span>
                    <span class="comment_date"><?= $comment['post_date'] ?></span>
                </div>
                <p><?= nl2br(htmlspecialchars($comment['text_comment'])) ?></p>
            </div>
        </div>
        <?php
            endforeach;
            // affichage de la pagination    
                echo $pagination; 
            endif;
        ?>
    </div>

<!-- Liste des messages -->
<ul>
    <li>
        <p><strong>firstname lastname</strong></p>
        <p><em>datemessage</em></p>
        <p>message</p>
    </li>
    <!-- Autres messages -->
    <li>
        <p><strong>firstname lastname</strong></p>
        <p><em>datemessage</em></p>
        <p>message</p>
    </li>
</ul>
etc ...
<!-- Pagination (BONUS) -->
<?php
// À commenter quand on a fini de tester
echo "<h3>Nos var_dump() pour le débugage</h3>";
echo '<p>$_POST</p>';
var_dump($_POST);
echo '<p>$_GET</p>';
var_dump($_GET);
?>

<script src="js/validation.js"></script>
</body>
</html>

