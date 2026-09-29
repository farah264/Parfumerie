<?php

session_start();
unset(
    $_SESSION['utilisateur'],
    $_SESSION['utilisateur_id'],
    $_SESSION['client_nom'],
    $_SESSION['client_email'],
    $_SESSION['client_telephone'],
    $_SESSION['client_adresse'],
    $_SESSION['client_ville']
);


header("Location: index.php");
exit;

?>
