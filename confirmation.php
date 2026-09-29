<?php

session_start();

$nom = $_SESSION['client_nom'] ?? '';
$email = $_SESSION['client_email'] ?? '';
$telephone = $_SESSION['client_telephone'] ?? '';
$adresse = $_SESSION['client_adresse'] ?? '';
$ville = $_SESSION['client_ville'] ?? '';

$commande_id = $_SESSION['commande_id'] ?? null;
$total = $_SESSION['commande_total'] ?? 0;

if (!$commande_id) {

    header("Location: index.php");
    exit;

}

?>

<!DOCTYPE html>

<html lang="fr">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Commande validée</title>

    <link rel="stylesheet" href="css/style.css">

</head>


<body
    style="
        background-image: url('images/commande.png');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        background-attachment: fixed;
    "
>


<div class="commande-validee">

    <div class="icone-validation">
        ✓
    </div>

    <h1>
        Commande validée !
    </h1>

    <p class="merci">

        Merci

        <strong>
            <?php
            echo htmlspecialchars(
                $nom,
                ENT_QUOTES,
                'UTF-8'
            );
            ?>
        </strong>

        pour votre commande 🌸

    </p>


    <div class="details-commande">


        <h2>
            ✨ Informations de votre commande
        </h2>

        <p>

            📦 <strong>Numéro de commande :</strong>

            #<?php
            echo (int) $commande_id;
            ?>

        </p>

        <p>

            📧 <strong>Email :</strong>

            <?php
            echo htmlspecialchars(
                $email,
                ENT_QUOTES,
                'UTF-8'
            );
            ?>

        </p>

        <p>

            📱 <strong>Téléphone :</strong>

            <?php
            echo htmlspecialchars(
                $telephone,
                ENT_QUOTES,
                'UTF-8'
            );
            ?>

        </p>

        <p>

            🏠 <strong>Adresse :</strong>

            <?php
            echo htmlspecialchars(
                $adresse,
                ENT_QUOTES,
                'UTF-8'
            );
            ?>

        </p>

        <p>

            🏙️ <strong>Ville :</strong>

            <?php
            echo htmlspecialchars(
                $ville,
                ENT_QUOTES,
                'UTF-8'
            );
            ?>

        </p>


        <p>

            💰 <strong>Total :</strong>

            <?php
            echo number_format(
                (float) $total,
                2,
                ',',
                ' '
            );
            ?>

            DT

        </p>

        <p>

            📦 <strong>Statut :</strong>

            <span class="statut en-attente">
                En attente
            </span>

        </p>


    </div>

    <p class="message-final">

        Votre commande a été enregistrée
        avec succès. 💗

    </p>

    <a
        href="index.php"
        class="retour-accueil"
    >
        🌸 Retour à la parfumerie
    </a>


</div>


</body>

</html>
