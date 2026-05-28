<?php
/** @var int $countComments */
/** @var array $comments */
/** @var string $messageTitle */
/** @var string $messageTitle */
/** @var string $messageTitle */
# view/guestbookView.php

    function displayDateFr(string $date): string
    {
        $timestamp = strtotime($date);
        return date('d/m/Y à H\hi', $timestamp);
    }

    function oldValue(string $name): string
    {
        return htmlspecialchars($_POST[$name] ?? '', ENT_QUOTES, 'UTF-8');
    }
    $countComments = count($comments);
    $messageTitle = '';
    if ($countComments === 0) {
        $messageTitle = 'pas encore de message';
    } elseif ($countComments === 1) {
        $messageTitle = 'Il y a 1 message';
    } else {
        $messageTitle = 'Il y a ' . $countComments . ' messages';
    }

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
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>
<body>
<main class="page">
    <header class="header-card">
        <img class="logo" src="img/favicon.png" alt="Logo du livre d'or">
        <div class="header-text">
            <h1>Livre d'Or</h1>
            <p>Laissez une trace de votre passage !</p>
        </div>
        <button type="button" id="toggle-theme" class="theme-button">🌙 Dark Mode</button>
    </header>

    <section class="top-section">
        <div class="illustration" aria-hidden="true">📖</div>

        <form id="guestbookForm" class="form-card" method="post" action="" novalidate>
            <h2>Votre message</h2>

            <div id="messages" class="message-box <?= $feedbackClass ?>">
                <?= htmlspecialchars($feedback, ENT_QUOTES, 'UTF-8') ?>
            </div>

            <div class="field">
                <label for="firstname">Prénom</label>
                <input type="text" id="firstname" name="firstname" placeholder="Ex: John" value="<?= oldValue('firstname') ?>" required>
            </div>

            <div class="field">
                <label for="lastname">Nom</label>
                <input type="text" id="lastname" name="lastname" placeholder="Ex: David" value="<?= oldValue('lastname') ?>" required>
            </div>

            <div class="field">
                <label for="usermail">E-mail</label>
                <input type="email" id="usermail" name="usermail" placeholder="johndavid@example.com" value="<?= oldValue('usermail') ?>" required>
            </div>

            <div class="field">
                <label for="postcode">Code postal</label>
                <input type="text" id="postcode" name="postcode" placeholder="Ex: 1000" value="<?= oldValue('postcode') ?>" required>
            </div>

            <div class="field">
                <label for="phone">Téléphone</label>
                <input type="text" id="phone" name="phone" placeholder="Ex: 0032498150882" value="<?= oldValue('phone') ?>" required>
            </div>

            <div class="field">
                <label for="message">Message</label>
                <textarea id="message" name="message" maxlength="300" rows="6" placeholder="Un petit mot..." required><?= oldValue('message') ?></textarea>
            </div>

            <p id="counter" class="counter">0 / 300 caractères</p>

            <button class="submit-button" type="submit">Envoyer le message</button>
        </form>
    </section>

    <section class="comments-section">
        <h2>Messages récents - <?= htmlspecialchars($messageTitle, ENT_QUOTES, 'UTF-8') ?></h2>
        <?= $pagination ?>

        <?php if (empty($comments)): ?>
            <article class="comment-card">
                <p>Aucun message à afficher pour le moment.</p>
            </article>
            <!-- Liste des messages -->
        <?php else: ?>
            <?php foreach ($comments as $comment): ?>
                <article class="comment-card">
                    <div class="comment-head">
                        <p>
                            <strong><?= $comment['firstname'] ?> <?= $comment['lastname'] ?></strong>
                            <span><?= $comment['usermail'] ?></span>
                        </p>
                        <time datetime="<?= $comment['datemessage'] ?>">
                            Le ( <?= displayDateFr($comment['datemessage']) ?> )
                        </time>
                    </div>
                    <p class="comment-message"><?= nl2br($comment['message']) ?></p>
                </article>
            <?php endforeach; ?>
        <?php endif; ?>

        <?= $pagination ?>
    </section>
</main>

<!-- Pagination (BONUS) -->
<?php
// À commenter quand on a fini de tester
// echo "<h3>Nos var_dump() pour le débugage</h3>";
// echo '<p>$_POST</p>';
// var_dump($_POST);
// echo '<p>$_GET</p>';
// var_dump($_GET);
?>

<script src="js/validation.js"></script>
</body>
</html>

