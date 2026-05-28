/* ============================================================================
   TRAVAIL D'INTÉGRATION JAVASCRIPT / jQuery
   Gestion d'un formulaire de contact + Dark Mode
   ============================================================================

   OBJECTIF GÉNÉRAL
   ----------------
   Créer une page contenant un formulaire de contact validé côté client en
   jQuery, avec un système de bascule entre mode clair et mode sombre.
   L'envoi final est géré par PHP qui affiche un message de retour.

   ============================================================================
   PARTIE 1 — STRUCTURE HTML À PRÉVOIR
   ============================================================================

   Vous devez créer un formulaire contenant AU MINIMUM les champs suivants :

     - Nom               (input text)
     - Prénom            (input text)
     - Email             (input email)
     - Code postal belge (input text)
     - Numéro de téléphone belge (input text)
     - Message           (textarea)
     - Bouton d'envoi    (button submit)

   Prévoir également :
     - Une zone <div id="messages"></div> en HAUT du formulaire pour afficher
       les messages d'erreur (rouge) ou de succès (vert).
     - Un bouton <button id="toggle-theme"></button> pour basculer le thème.

   ============================================================================
   PARTIE 2 — VALIDATION JAVASCRIPT (jQuery OBLIGATOIRE)
   ============================================================================

   Au clic sur le bouton d'envoi, vérifier CHAQUE champ.
   Si un champ ne respecte pas sa condition, afficher un message EN ROUGE
   en haut du formulaire, dans la zone #messages.
   Si TOUS les champs sont valides, afficher un message EN VERT et envoyer
   le formulaire (qui sera traité par PHP — voir partie 3).

   --- RÈGLES DE VALIDATION ---

   1) Nom et Prénom
      - Champs obligatoires (non vides)
      - Au moins 2 caractères

   2) Email
      - Champ obligatoire
      - Doit respecter le format d'une adresse email valide
        (utiliser une expression régulière — regex)

   3) Code postal belge
      - 4 chiffres exactement
      - Compris entre 1000 et 9999

   4) Numéro de téléphone belge
      - Doit accepter les formats suivants :
          • 0470123456
          • 0470 12 34 56
          • +32 470 12 34 56
          • 0032470123456
      - Indice : nettoyer la chaîne (enlever espaces, tirets, points)
        AVANT de tester avec une regex

   5) Message
      - Champ obligatoire
      - Au moins 10 caractères

   --- AFFICHAGE DES MESSAGES ---

   - Tous les messages d'erreur s'affichent dans la zone #messages,
     en haut du formulaire.
   - Couleur rouge pour les erreurs, couleur verte pour le succès.
   - Vider la zone à chaque nouvelle tentative d'envoi.

   ============================================================================
   PARTIE 3 — TRAITEMENT CÔTÉ PHP
   ============================================================================

   Si tous les champs sont valides, le formulaire est envoyé à un script PHP.
   Ce script doit afficher :

     - "Merci pour votre nouveau message" en VERT si l'envoi a réussi.
     - "Problème lors de l'envoi du message" en ROUGE si l'envoi a échoué.

   Note : pour cet exercice, le PHP peut simuler la réussite/échec
   (par exemple, vérifier que les variables $_POST sont bien remplies).

   ============================================================================
   PARTIE 4 — DARK MODE
   ============================================================================

   Créer un bouton qui permet de basculer entre deux thèmes :

     ☀️ Mode clair  → body avec fond BLANC
     🌙 Mode sombre → body avec fond NOIR

   COMPORTEMENT DU BOUTON :
   - Le texte du bouton change dynamiquement :
       • "🌙 Dark Mode"  quand on est en mode clair (clic = passer en sombre)
       • "☀️ White Mode" quand on est en mode sombre (clic = passer en clair)
   - L'icône doit correspondre au mode vers lequel on bascule.


   IMPLÉMENTATION SUGGÉRÉE :
   - Utiliser une classe CSS (ex : .dark-mode) sur le <body>.
   - Faire le toggle de cette classe en jQuery avec .toggleClass().
   - Mettre à jour le texte du bouton après chaque toggle.

   ============================================================================
   PARTIE 5 — BONUS
   ============================================================================

   Sur le champ "Message", limiter dynamiquement à 300 caractères MAXIMUM.

   Suggestions :
   - Utiliser l'attribut HTML maxlength="300" (rapide mais peu visuel)
   - OU mieux : afficher un compteur en temps réel sous le champ,
     du type "143 / 300 caractères", qui se met à jour à chaque frappe.
   - Bonus du bonus : passer le compteur en rouge quand il approche
     de la limite (par exemple à partir de 280 caractères).

   ============================================================================
   CRITÈRES D'ÉVALUATION
   ============================================================================

   - Utilisation correcte de jQuery (sélecteurs, événements, manipulation DOM)
   - Validation rigoureuse de tous les champs avec les bonnes regex
   - Affichage clair des messages d'erreur et de succès
   - Dark mode fonctionnel avec changement dynamique du texte/icône
   - Code propre, indenté et commenté
   - HTML sémantique et CSS soigné
   - Bonus implémenté (compteur de caractères)

   ============================================================================
   À RENDRE
   ============================================================================

   - script.js   (toute la logique jQuery)
   - traitement.php

   Bon travail !
   ========================================================================= */
// -definition des variable et importation
const form = document.getElementById('guestbookForm');
const messages = document.getElementById('messages');
const firstname = document.getElementById('firstname');
const lastname = document.getElementById('lastname');
const usermail = document.getElementById('usermail');
const postcode = document.getElementById('postcode');
const phone = document.getElementById('phone');
const message = document.getElementById('message');
const counter = document.getElementById('counter');
const toggleTheme = document.getElementById('toggle-theme');

// 2- fonctuon pour afficher le message

function showMessage(text, type) {
    messages.textContent = text;
    messages.className = 'message-box ' + type;
}

// 3- fontion pour le compteur de message

function updateCounter() {
    counter.textContent = message.value.length + ' / 300 caractères';

    if (message.value.length >= 280) {
        counter.classList.add('danger');
    } else {
        counter.classList.remove('danger');
    }
}

message.addEventListener('input', updateCounter);
updateCounter();

// 4 - Validation des regex pour le formulaire

form.addEventListener('submit', function (event) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    const postcodeRegex = /^[0-9]{4}$/;
    const phoneRegex = /^(?:\+32|0)\s?4(?:\d\s?){8}$/;

    

    const firstValue = firstname.value.trim();
    const lastValue = lastname.value.trim();
    const emailValue = usermail.value.trim();
    const postcodeValue = postcode.value.trim();
    const phoneValue = phone.value.trim();
    const messageValue = message.value.trim();

    if (firstValue === '' || lastValue === '' || emailValue === '' || postcodeValue === '' || phoneValue === '' || messageValue === '') {
        event.preventDefault();
        showMessage('Tous les champs sont obligatoires ❌', 'error');
        return;
    }

    if (!emailRegex.test(emailValue)) {
        event.preventDefault();
        showMessage('Adresse e-mail invalide ❌', 'error');
        return;
    }

    if (!postcodeRegex.test(postcodeValue)) {
        event.preventDefault();
        showMessage('Le code postal belge doit contenir exactement 4 chiffres ❌', 'error');
        return;
    }

    if (!phoneRegex.test(phoneValue)) {
        event.preventDefault();
        showMessage('Le numéro belge doit commencer par 04 et contenir 10 chiffres ❌', 'error');
        return;
    }

    if (messageValue.length > 300) {
        event.preventDefault();
        showMessage('Le message ne peut pas dépasser 300 caractères ❌', 'error');
        return;
    }

    showMessage('Toutes les informations sont valides ✅', 'success');
});

// 5 - le dark-mode/white-mode

toggleTheme.addEventListener('click', function () {
    document.body.classList.toggle('dark-mode');

    if (document.body.classList.contains('dark-mode')) {
        toggleTheme.textContent = '☀️ White Mode';
    } else {
        toggleTheme.textContent = '🌙 Dark Mode';
    }
});