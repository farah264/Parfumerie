<?php

session_start();

/* Détruire toutes les informations de connexion */
unset(
    $_SESSION['utilisateur'],
    $_SESSION['utilisateur_id'],
    $_SESSION['client_nom'],
    $_SESSION['client_email'],
    $_SESSION['client_telephone'],
    $_SESSION['client_adresse'],
    $_SESSION['client_ville']
);

/* Retourner à la page d'accueil */
header("Location: index.php");
exit;

?>