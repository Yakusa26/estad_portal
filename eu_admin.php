<?php
// Démarrer la session
session_start();

// Vérifier si les variables de session existent et les afficher
if(isset($_SESSION['nom']) && isset($_SESSION['prenom'])) {
    echo 'Bienvenue ' . $_SESSION['prenom'] . ' ' . $_SESSION['nom'] . '<br>';
} else {
    echo 'Les variables de session ne sont pas définies.';
}
?>