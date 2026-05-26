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
     <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">


  <div class="field">
    <label for="firstname">Nom</label>
    <input type="text" id="firstname" name="firstname" placeholder="John" value="<?= e($_POST['firstname'] ?? '') ?>">
    <small class="field-error"></small>
  </div>

  <div class="field">
    <label for="lastname">Prénom</label>
    <input type="text" id="lastname" name="lastname" placeholder="David" value="<?= e($_POST['lastname'] ?? '') ?>">
    <small class="field-error"></small>
  </div>

  <div class="field">
    <label for="usermail">Email</label>
    <input type="email" id="usermail" name="usermail" placeholder="johndavid@email.com" value="<?= e($_POST['usermail'] ?? '') ?>">
    <small class="field-error"></small>
  </div>

  <div class="field">
    <label for="phone">Téléphone</label>
    <input type="text" id="phone" name="phone" placeholder="+32471234567" value="<?= e($_POST['phone'] ?? '') ?>">
    <small class="field-error"></small>
  </div>

  <div class="field">
    <label for="postcode">Code Postal</label>
    <input type="text" id="postcode" name="postcode" value="<?= e($_POST['postcode'] ?? '') ?>">
    <small class="field-error"></small>
  </div>

   <div class="field">
    <label for="commentaire">message</label>
    <textarea id="commentaire" name="commentaire" rows="6"><?= e($_POST['message'] ?? '') ?></textarea>
    <small class="field-error"><?= e($errors['commentaire'] ?? '') ?></small>
  </div>

  <button class="btn" type="submit">Envoyer</button>
</form>
<h2>Ici le formulaire</h2>
<!-- Si pas de message -->
<h3>Pas encore de message</h3>
<!-- Si 1 message -->
<h3>Il y a 1 message</h3>
<!-- Si plusieurs messages -->
<h3>Il y a X messages</h3>

<!-- Pagination (BONUS) -->

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

